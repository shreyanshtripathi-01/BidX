<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Show the payment page for a won auction.
     */
    public function show(Auction $auction): View
    {
        // Check if user is the winning bidder
        $winningBid = $auction->bids()->orderBy('amount', 'desc')->first();

        if (!$winningBid || $winningBid->user_id !== auth()->id()) {
            abort(403, 'You are not the winning bidder for this auction.');
        }

        return view('payments.show', compact('auction', 'winningBid'));
    }

    /**
     * Process the payment (dummy).
     */
    public function store(Request $request, Auction $auction): RedirectResponse
    {
        $winningBid = $auction->bids()->orderBy('amount', 'desc')->first();

        if (!$winningBid || $winningBid->user_id !== auth()->id()) {
            abort(403, 'You are not the winning bidder for this auction.');
        }

        // Create a dummy payment record
        Payment::create([
            'user_id' => auth()->id(),
            'auction_id' => $auction->id,
            'amount' => $winningBid->amount,
            'status' => 'completed',
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
        ]);

        // Mark auction as ended
        $auction->update(['status' => 'ended']);

        return redirect()->route('auctions.show', $auction)
            ->with('success', 'Payment processed successfully! Thank you for your purchase.');
    }
}