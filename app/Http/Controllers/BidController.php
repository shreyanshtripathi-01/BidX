<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Notification;
use App\Mail\BidOutbid;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BidController extends Controller
{
    /**
     * Place a bid on an auction.
     */
    public function store(Request $request, Auction $auction): RedirectResponse
    {
        // Validate the auction is active
        if ($auction->status !== 'active' || $auction->end_time <= now()) {
            return redirect()->back()->with('error', 'This auction is no longer active.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Get current highest bid
        $highestBid = $auction->bids()->orderBy('amount', 'desc')->first();
        $highestAmount = $highestBid ? $highestBid->amount : $auction->starting_price;

        // Check bid is higher than current highest
        if ($validated['amount'] <= $highestAmount) {
            return redirect()->back()->with('error', 'Your bid must be higher than the current highest bid of $' . number_format($highestAmount, 2));
        }

        // Users cannot bid on their own auctions
        if ($auction->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot bid on your own auction.');
        }

        // Create the bid
        $bid = new Bid();
        $bid->auction_id = $auction->id;
        $bid->user_id = Auth::id();
        $bid->amount = $validated['amount'];
        $bid->save();

        // Update auction current price
        $auction->current_price = $validated['amount'];
        $auction->save();

        // Notify the previous highest bidder that they've been outbid
        if ($highestBid && $highestBid->user_id !== Auth::id()) {
            // In-app notification
            Notification::create([
                'user_id' => $highestBid->user_id,
                'type' => 'outbid',
                'title' => 'You have been outbid!',
                'message' => 'Your bid on "' . $auction->title . '" has been outbid by ' . Auth::user()->name,
                'auction_id' => $auction->id,
                'is_read' => false,
            ]);

            // Email notification
            try {
                Mail::to($highestBid->user->email)->send(new BidOutbid($auction, Auth::user()->name));
            } catch (\Exception $e) {
                // Log error but don't fail the bid
                \Log::error('Failed to send outbid email: ' . $e->getMessage());
            }
        }

        return redirect()->route('auctions.show', $auction)
            ->with('success', 'Bid placed successfully!');
    }

    /**
     * Show bids for an auction.
     */
    public function index(Auction $auction)
    {
        $bids = $auction->bids()->with('user')->latest('amount')->paginate(20);

        return view('bids.index', compact('auction', 'bids'));
    }

    /**
     * API: Place a bid via AJAX.
     */
    public function apiStore(Request $request, Auction $auction): JsonResponse
    {
        // Validate the auction is active
        if ($auction->status !== 'active' || $auction->end_time <= now()) {
            return response()->json([
                'success' => false,
                'message' => 'This auction is no longer active.'
            ], 422);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Get current highest bid
        $highestBid = $auction->bids()->orderBy('amount', 'desc')->first();
        $highestAmount = $highestBid ? $highestBid->amount : $auction->starting_price;

        // Check bid is higher than current highest
        if ($validated['amount'] <= $highestAmount) {
            return response()->json([
                'success' => false,
                'message' => 'Your bid must be higher than the current highest bid of $' . number_format($highestAmount, 2)
            ], 422);
        }

        // Users cannot bid on their own auctions
        if ($auction->user_id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot bid on your own auction.'
            ], 422);
        }

        // Create the bid
        $bid = new Bid();
        $bid->auction_id = $auction->id;
        $bid->user_id = Auth::id();
        $bid->amount = $validated['amount'];
        $bid->save();

        // Update auction current price
        $auction->current_price = $validated['amount'];
        $auction->save();

        // Notify the previous highest bidder
        if ($highestBid && $highestBid->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $highestBid->user_id,
                'type' => 'outbid',
                'title' => 'You have been outbid!',
                'message' => 'Your bid on "' . $auction->title . '" has been outbid by ' . Auth::user()->name,
                'auction_id' => $auction->id,
                'is_read' => false,
            ]);

            try {
                Mail::to($highestBid->user->email)->send(new BidOutbid($auction, Auth::user()->name));
            } catch (\Exception $e) {
                \Log::error('Failed to send outbid email: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Bid placed successfully!',
            'bid' => [
                'id' => $bid->id,
                'amount' => $bid->amount,
                'user_name' => Auth::user()->name,
                'created_at' => $bid->created_at->diffForHumans(),
            ]
        ]);
    }
}