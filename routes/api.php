<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use Illuminate\Support\Facades\Route;

Route::get('/auctions', [AuctionController::class, 'apiIndex']);
Route::get('/auctions/{auction}', [AuctionController::class, 'apiShow']);

