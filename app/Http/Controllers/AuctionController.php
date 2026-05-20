<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuctionController extends Controller
{
    public function index(): View
    {
        $auctions = Auction::active()
            ->withCount('bids')
            ->with('highestBid')
            ->orderBy('end_time', 'asc')
            ->paginate(12);

        return view('auctions.index', compact('auctions'));
    }

    public function create(): View|RedirectResponse
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized. Only administrators can list new auctions.');
        }
        return view('auctions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized. Only administrators can list new auctions.');
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0.01',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'image' => 'nullable|image|max:2048',
        ]);

        $auction = new Auction();
        $auction->user_id = Auth::id();
        $auction->title = $validated['title'];
        $auction->description = $validated['description'];
        $auction->starting_price = $validated['starting_price'];
        $auction->current_price = $validated['starting_price'];
        $auction->start_time = $validated['start_time'];
        $auction->end_time = $validated['end_time'];
        $auction->status = 'active';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('auction-images', 'public');
            $auction->image = $path;
        }

        $auction->save();

        return redirect()->route('auctions.show', $auction)
            ->with('success', 'Auction created successfully!');
    }

    public function show(Auction $auction): View
    {
        $auction->load(['bids' => function ($query) {
            $query->with('user')->latest('amount')->limit(20);
        }]);

        return view('auctions.show', compact('auction'));
    }

    public function myAuctions(): View|RedirectResponse
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $auctions = Auction::where('user_id', Auth::id())
            ->withCount('bids')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('auctions.my', compact('auctions'));
    }

    public function notifications(): View
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markNotificationAsRead(Notification $notification): RedirectResponse
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification marked as read.');
    }

    public function readAllNotifications(): RedirectResponse
    {
        Auth::user()->notifications()->update(['is_read' => true]);

        return redirect()->route('notifications.index')
            ->with('success', 'All notifications marked as read.');
    }

    public function apiIndex()
    {
        $auctions = Auction::active()
            ->withCount('bids')
            ->orderBy('end_time', 'asc')
            ->get();

        return response()->json($auctions);
    }

    public function apiShow(Auction $auction)
    {
        $auction->load(['bids' => function ($query) {
            $query->with('user')->latest('amount')->limit(20);
        }]);

        return response()->json($auction);
    }
}