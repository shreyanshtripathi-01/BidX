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
    /**
     * Display a listing of active auctions.
     */
    public function index(): View
    {
        // Get active auctions with their highest bid
        $auctions = Auction::active()
            ->withCount('bids')
            ->with('highestBid')
            ->orderBy('end_time', 'asc')
            ->paginate(12);

        return view('auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new auction.
     */
    public function create(): View|RedirectResponse
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized. Only administrators can list new auctions.');
        }
        return view('auctions.create');
    }

    /**
     * Store a newly created auction in storage.
     */
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
            'image' => 'nullable|image|max:2048', // max 2MB
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

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('auction-images', 'public');
            $auction->image = $path;
        }

        $auction->save();

        return redirect()->route('auctions.show', $auction)
            ->with('success', 'Auction created successfully!');
    }

    /**
     * Display the specified auction.
     */
    public function show(Auction $auction): View
    {
        // Load bids with user info, latest first
        $auction->load(['bids' => function ($query) {
            $query->with('user')->latest('amount')->limit(20);
        }]);
        $auction->loadCount('bids');

        return view('auctions.show', compact('auction'));
    }

    /**
     * Show auctions created by the current user.
     */
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

    /**
     * Show the user's notifications.
     */
    public function notifications(): View
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markNotificationAsRead(Notification $notification): RedirectResponse
    {
        // Ensure user owns this notification
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read.
     */
    public function readAllNotifications(): RedirectResponse
    {
        Auth::user()->notifications()->update(['is_read' => true]);

        return redirect()->route('notifications.index')
            ->with('success', 'All notifications marked as read.');
    }

    /**
     * API: Get all active auctions.
     */
    public function apiIndex()
    {
        $auctions = Auction::active()
            ->withCount('bids')
            ->orderBy('end_time', 'asc')
            ->get();

        return response()->json($auctions);
    }

    /**
     * API: Get a single auction with bids.
     */
    public function apiShow(Auction $auction)
    {
        $auction->load(['bids' => function ($query) {
            $query->with('user')->latest('amount')->limit(20);
        }]);

        return response()->json($auction);
    }
}