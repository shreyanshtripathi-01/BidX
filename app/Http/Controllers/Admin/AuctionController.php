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
    /**
     * Display a listing of all auctions.
     */
    public function index(): View
    {
        $auctions = Auction::withCount('bids')
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('admin.auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new auction.
     */
    public function create(): View
    {
        return view('admin.auctions.create');
    }

    /**
     * Store a newly created auction in storage.
     */
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

    /**
     * Display the specified auction.
     */
    public function show(Auction $auction): View
    {
        $auction->load(['bids' => function ($query) {
            $query->with('user')->latest('amount');
        }, 'user']);

        return view('admin.auctions.show', compact('auction'));
    }

    /**
     * Show the form for editing the specified auction.
     */
    public function edit(Auction $auction): View
    {
        return view('admin.auctions.edit', compact('auction'));
    }

    /**
     * Update the specified auction in storage.
     */
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

    /**
     * Remove the specified auction from storage.
     */
    public function destroy(Auction $auction): RedirectResponse
    {
        $auction->delete();

        return redirect()->route('admin.auctions.index')
            ->with('success', 'Auction deleted successfully!');
    }

    /**
     * End an auction early and notify the winner.
     */
    public function endAuction(Auction $auction): RedirectResponse
    {
        $auction->update(['status' => 'ended']);

        // Find the winner (highest bidder)
        $winner = $auction->bids()->orderBy('amount', 'desc')->first();

        if ($winner) {
            // Send in-app notification
            Notification::create([
                'user_id' => $winner->user_id,
                'type' => 'won',
                'title' => 'Congratulations, you won!',
                'message' => 'Congratulations! You won the auction for "' . $auction->title . '" with a bid of $' . number_format($winner->amount, 2),
                'auction_id' => $auction->id,
                'is_read' => false,
            ]);

            // Send email notification
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