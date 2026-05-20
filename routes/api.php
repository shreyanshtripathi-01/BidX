<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use Illuminate\Support\Facades\Route;

Route::get('/auctions', [AuctionController::class, 'apiIndex']);
Route::get('/auctions/{auction}', [AuctionController::class, 'apiShow']);

// NOTE: The bid POST route is defined in web.php under the 'api' prefix
// to use session-based 'auth' middleware instead of 'auth:sanctum'.
// Do NOT add it here to avoid route conflicts.

//in routes api.php we create our own api and create and we can also apply middlewares on this routes if we want to make it 

//access the api - https://localhost:8000/api/test
//for testing - thunderclient or postman (extension vs code)
//run the api
//role of postman and thunderclient
//status 200 ok means api is working fine

