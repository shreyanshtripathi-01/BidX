<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BiddingWarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test valid bid placement.
     */
    public function test_user_can_place_valid_bid(): void
    {
        $seller = User::factory()->create(['email' => 'seller@gmail.com']);
        $bidder = User::factory()->create(['email' => 'bidder@gmail.com']);

        $auction = Auction::create([
            'user_id' => $seller->id,
            'title' => 'Vintage Coin',
            'description' => 'Fine details',
            'starting_price' => 100.00,
            'current_price' => 100.00,
            'start_time' => now()->subDay(),
            'end_time' => now()->addDay(),
            'status' => 'active',
        ]);

        $response = $this->actingAs($bidder)->post("/auctions/{$auction->id}/bid", [
            'amount' => 150.00
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bids', [
            'auction_id' => $auction->id,
            'user_id' => $bidder->id,
            'amount' => 150.00
        ]);

        $auction->refresh();
        $this->assertEquals(150.00, $auction->current_price);
        $this->assertTrue($auction->isUserWinning($bidder));
    }

    /**
     * Test user cannot bid on their own auction.
     */
    public function test_user_cannot_bid_on_own_auction(): void
    {
        $seller = User::factory()->create(['email' => 'seller@gmail.com']);

        $auction = Auction::create([
            'user_id' => $seller->id,
            'title' => 'Vintage Coin',
            'description' => 'Fine details',
            'starting_price' => 100.00,
            'current_price' => 100.00,
            'start_time' => now()->subDay(),
            'end_time' => now()->addDay(),
            'status' => 'active',
        ]);

        $response = $this->actingAs($seller)->post("/auctions/{$auction->id}/bid", [
            'amount' => 150.00
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('bids', [
            'auction_id' => $auction->id,
            'user_id' => $seller->id,
        ]);
    }

    /**
     * Test bid must be higher than current price.
     */
    public function test_bid_must_be_higher_than_current_price(): void
    {
        $seller = User::factory()->create(['email' => 'seller@gmail.com']);
        $bidder = User::factory()->create(['email' => 'bidder@gmail.com']);

        $auction = Auction::create([
            'user_id' => $seller->id,
            'title' => 'Vintage Coin',
            'description' => 'Fine details',
            'starting_price' => 100.00,
            'current_price' => 150.00,
            'start_time' => now()->subDay(),
            'end_time' => now()->addDay(),
            'status' => 'active',
        ]);

        $anotherBidder = User::factory()->create(['email' => 'another@gmail.com']);
        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => $anotherBidder->id,
            'amount' => 150.00
        ]);

        $response = $this->actingAs($bidder)->post("/auctions/{$auction->id}/bid", [
            'amount' => 120.00
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('bids', [
            'auction_id' => $auction->id,
            'amount' => 120.00
        ]);
    }
}
