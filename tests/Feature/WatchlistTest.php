<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Auction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WatchlistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test toggling watchlist works perfectly.
     */
    public function test_user_can_toggle_watchlist_for_an_auction(): void
    {
        $seller = User::factory()->create(['email' => 'seller@gmail.com']);
        $user = User::factory()->create(['email' => 'watcher@gmail.com']);

        $auction = Auction::create([
            'user_id' => $seller->id,
            'title' => 'Heritage Silk',
            'description' => 'Beautiful fabric',
            'starting_price' => 5000.00,
            'current_price' => 5000.00,
            'start_time' => now()->subDay(),
            'end_time' => now()->addDay(),
            'status' => 'active',
        ]);

        // 1. Add to watchlist
        $response = $this->actingAs($user)->post("/auctions/{$auction->id}/watch");

        $response->assertRedirect();
        $this->assertTrue($user->isWatching($auction));
        $this->assertDatabaseHas('watchlists', [
            'user_id' => $user->id,
            'auction_id' => $auction->id
        ]);

        // 2. Remove from watchlist
        $response = $this->actingAs($user)->post("/auctions/{$auction->id}/watch");

        $response->assertRedirect();
        $user->refresh();
        $this->assertFalse($user->isWatching($auction));
        $this->assertDatabaseMissing('watchlists', [
            'user_id' => $user->id,
            'auction_id' => $auction->id
        ]);
    }
}
