<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuctionController as AdminAuctionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            $stats = [
                'total_users' => \App\Models\User::count(),
                'active_auctions' => \App\Models\Auction::where('status', 'active')->count(),
                'ended_auctions' => \App\Models\Auction::where('status', 'ended')->count(),
                'total_revenue' => \App\Models\Auction::where('status', 'ended')->sum('current_price'),
                'total_bids' => \App\Models\Bid::count(),
                'avg_bid' => \App\Models\Bid::avg('amount') ?? 0,
                'active_bidders' => \App\Models\Bid::distinct('user_id')->count('user_id'),
                'inventory_value' => \App\Models\Auction::where('status', 'active')->sum('current_price'),
            ];

            $recentAuctions = \App\Models\Auction::latest()->withCount('bids')->take(5)->get();
            $recentBids = \App\Models\Bid::with(['auction', 'user'])->latest()->take(10)->get();

            return view('admin.dashboard', compact('stats', 'recentAuctions', 'recentBids'));
        }
        $unpaidWon = \App\Models\Auction::where('status', 'ended')
            ->whereHas('bids', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with(['bids' => function ($q) {
                $q->orderBy('amount', 'desc');
            }])
            ->get()
            ->filter(function ($auction) {
                $winningBid = $auction->bids->first();
                if (!$winningBid || $winningBid->user_id !== auth()->id()) {
                    return false;
                }
                return !\App\Models\Payment::where('auction_id', $auction->id)
                    ->where('status', 'completed')
                    ->exists();
            });

        $watchlist = auth()->user()->watchlist()->with(['bids' => function ($q) {
            $q->orderBy('amount', 'desc');
        }])->get();

        $myListings = \App\Models\Auction::where('user_id', auth()->id())
            ->withCount('bids')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_bids' => auth()->user()->bids()->count(),
            'committed_value' => auth()->user()->bids()->sum('amount') ?? 0,
            'won_count' => \App\Models\Auction::where('status', 'ended')
                ->whereHas('bids', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->get()
                ->filter(function ($auction) {
                    $winningBid = $auction->bids()->orderBy('amount', 'desc')->first();
                    return $winningBid && $winningBid->user_id === auth()->id();
                })
                ->count(),
            'purchases_count' => auth()->user()->payments()->where('status', 'completed')->count(),
        ];

        return view('dashboard', compact('unpaidWon', 'watchlist', 'myListings', 'stats'));
    })->name('dashboard');

    Route::get('/my-auctions', [AuctionController::class, 'myAuctions'])->name('auctions.my');
    Route::resource('auctions', AuctionController::class)->except(['index', 'show']);

    Route::post('/auctions/{auction}/bid', [BidController::class, 'store'])->name('bids.store');
    Route::get('/auctions/{auction}/bids', [BidController::class, 'index'])->name('bids.index');

    Route::get('/notifications', [AuctionController::class, 'notifications'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [AuctionController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [AuctionController::class, 'readAllNotifications'])->name('notifications.readAll');

    Route::get('/api/user/notifications/unread', function () {
        return response()->json(auth()->user()->notifications()->where('is_read', false)->get());
    })->name('api.notifications.unread');

    Route::post('/auctions/{auction}/watch', [WatchlistController::class, 'toggle'])->name('watchlist.toggle');

    Route::get('/auctions/{auction}/payment', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/auctions/{auction}/payment', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function() {
        return redirect()->route('dashboard');
    })->name('dashboard');
    Route::resource('auctions', AdminAuctionController::class);
    Route::post('/auctions/{auction}/end', [AdminAuctionController::class, 'endAuction'])->name('auctions.end');

    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/users/create', [DashboardController::class, 'createUser'])->name('users.create');
    Route::post('/users', [DashboardController::class, 'storeUser'])->name('users.store');

    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
});

Route::prefix('api')->group(function () {
    Route::get('/auctions', [AuctionController::class, 'apiIndex'])->name('api.auctions.index');
    Route::get('/auctions/{auction}', [AuctionController::class, 'apiShow'])->name('api.auctions.show');
    Route::post('/auctions/{auction}/bid', [BidController::class, 'apiStore'])->middleware('auth')->name('api.bids.store');
});

require __DIR__.'/auth.php';