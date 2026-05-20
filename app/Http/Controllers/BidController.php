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
    public function store(Request $request, Auction $auction): RedirectResponse
    {
        if ($auction->status !== 'active' || $auction->end_time <= now()) {
            return redirect()->back()->with('error', 'This auction is no longer active.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $highestBid = $auction->bids()->orderBy('amount', 'desc')->first();
        $highestAmount = $highestBid ? $highestBid->amount : $auction->starting_price;

        if ($validated['amount'] <= $highestAmount) {
            return redirect()->back()->with('error', 'Your bid must be higher than the current highest bid of $' . number_format($highestAmount, 2));
        }

        if ($auction->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot bid on your own auction.');
        }

        $bid = new Bid();
        $bid->auction_id = $auction->id;
        $bid->user_id = Auth::id();
        $bid->amount = $validated['amount'];
        $bid->save();

        $auction->current_price = $validated['amount'];
        $auction->save();

        // Notify previous highest bidder they've been outbid
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

        return redirect()->route('auctions.show', $auction)
            ->with('success', 'Bid placed successfully!');
    }

    public function index(Auction $auction)
    {
        $bids = $auction->bids()->with('user')->latest('amount')->paginate(20);

        return view('bids.index', compact('auction', 'bids'));
    }

    public function apiStore(Request $request, Auction $auction): JsonResponse
    {
        try {
            if ($auction->status !== 'active' || $auction->end_time <= now()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This auction is no longer active.'
                ], 422);
            }

            $validated = $request->validate([
                'amount' => 'required|numeric|min:0.01',
            ]);

            $highestBid = $auction->bids()->orderBy('amount', 'desc')->first();
            $highestAmount = $highestBid ? $highestBid->amount : $auction->starting_price;

            if ($validated['amount'] <= $highestAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your bid must be higher than the current highest bid of $' . number_format($highestAmount, 2)
                ], 422);
            }

            if ($auction->user_id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot bid on your own auction.'
                ], 422);
            }

            $bid = new Bid();
            $bid->auction_id = $auction->id;
            $bid->user_id = Auth::id();
            $bid->amount = $validated['amount'];
            $bid->save();

            $auction->current_price = $validated['amount'];
            $auction->save();

            if ($highestBid && $highestBid->user_id !== Auth::id()) {
                try {
                    Notification::create([
                        'user_id' => $highestBid->user_id,
                        'type' => 'outbid',
                        'title' => 'You have been outbid!',
                        'message' => 'Your bid on "' . $auction->title . '" has been outbid by ' . Auth::user()->name,
                        'auction_id' => $auction->id,
                        'is_read' => false,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create outbid notification: ' . $e->getMessage());
                }

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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Bid placement failed: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while placing your bid. Please try again.',
            ], 500);
        }
    }
}