<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\User;
use App\Models\Bid;
use App\Models\Notification;
use App\Models\Payment;
use App\Mail\AuctionWon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class AuctionController extends Controller
{
    public function index(): View
    {
        $auctions = Auction::withCount('bids')
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('admin.auctions.index', compact('auctions'));
    }

    public function create(): View
    {
        return view('admin.auctions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0.01',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
        ]);

        $auction = new Auction();
        $auction->fill($validated);
        $auction->current_price = $validated['starting_price'];
        $auction->status = 'active';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('auction-images', 'public');
            $auction->image = $path;
        }

        $auction->save();

        return redirect()->route('admin.auctions.index')
            ->with('success', 'Auction created successfully!');
    }

    public function show(Auction $auction): View
    {
        $auction->load(['bids' => function ($query) {
            $query->with('user')->latest('amount');
        }, 'user']);

        return view('admin.auctions.show', compact('auction'));
    }

    public function edit(Auction $auction): View
    {
        return view('admin.auctions.edit', compact('auction'));
    }

    public function update(Request $request, Auction $auction): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0.01',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:active,ended,cancelled',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
        ]);

        $auction->fill($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('auction-images', 'public');
            $auction->image = $path;
        }

        $auction->save();

        return redirect()->route('admin.auctions.index')
            ->with('success', 'Auction updated successfully!');
    }

    public function destroy(Auction $auction): RedirectResponse
    {
        $auction->delete();

        return redirect()->route('admin.auctions.index')
            ->with('success', 'Auction deleted successfully!');
    }

    public function endAuction(Auction $auction): RedirectResponse
    {
        $auction->update(['status' => 'ended']);

        $winner = $auction->bids()->orderBy('amount', 'desc')->first();

        if ($winner) {
            Notification::create([
                'user_id' => $winner->user_id,
                'type' => 'won',
                'title' => 'Congratulations, you won!',
                'message' => 'Congratulations! You won the auction for "' . $auction->title . '" with a bid of $' . number_format($winner->amount, 2),
                'auction_id' => $auction->id,
                'is_read' => false,
            ]);

            try {
                Mail::to($winner->user->email)->send(new AuctionWon($auction));
            } catch (\Exception $e) {
                \Log::error('Failed to send auction won email: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.auctions.index')
            ->with('success', 'Auction ended successfully! Winner has been notified.');
    }
}