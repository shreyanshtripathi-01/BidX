<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuctionController as AdminAuctionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page (Landing/Intro)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Browse auctions
Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');

// Auth required routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Standard User Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // My auctions (created by me)
    Route::get('/my-auctions', [AuctionController::class, 'myAuctions'])->name('auctions.my');

    // Auction CRUD
    Route::resource('auctions', AuctionController::class)->except(['index', 'show']);

    // Bidding
    Route::post('/auctions/{auction}/bid', [BidController::class, 'store'])->name('bids.store');
    Route::get('/auctions/{auction}/bids', [BidController::class, 'index'])->name('bids.index');

    // Notifications
    Route::get('/notifications', [AuctionController::class, 'notifications'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [AuctionController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [AuctionController::class, 'readAllNotifications'])->name('notifications.readAll');

    // Payment (dummy)
    Route::get('/auctions/{auction}/payment', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/auctions/{auction}/payment', [PaymentController::class, 'store'])->name('payments.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Wildcard route MUST come after resource routing to avoid route collision with /auctions/create
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');

// Admin panel
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('auctions', AdminAuctionController::class);
    Route::post('/auctions/{auction}/end', [AdminAuctionController::class, 'endAuction'])->name('auctions.end');
    
    // User management (Admin only)
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/users/create', [DashboardController::class, 'createUser'])->name('users.create');
    Route::post('/users', [DashboardController::class, 'storeUser'])->name('users.store');
    
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
});

// API routes
Route::prefix('api')->group(function () {
    Route::get('/auctions', [AuctionController::class, 'apiIndex'])->name('api.auctions.index');
    Route::get('/auctions/{auction}', [AuctionController::class, 'apiShow'])->name('api.auctions.show');
    Route::post('/auctions/{auction}/bid', [BidController::class, 'apiStore'])->middleware('auth:sanctum')->name('api.bids.store');
});

require __DIR__.'/auth.php';