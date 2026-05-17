<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    /**
     * Toggle watch status for an auction.
     */
    public function toggle(Auction $auction): RedirectResponse
    {
        $user = Auth::user();

        if ($user->isWatching($auction)) {
            $user->watchlist()->detach($auction->id);
            $message = 'Removed "' . $auction->title . '" from your watchlist.';
        } else {
            $user->watchlist()->attach($auction->id);
            $message = 'Added "' . $auction->title . '" to your watchlist.';
        }

        return redirect()->back()->with('success', $message);
    }
}
