<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Auction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that unauthenticated users are redirected to login.
     */
    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test that a standard logged-in member can access the dashboard.
     */
    public function test_standard_member_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'member@gmail.com'
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewHasAll(['unpaidWon', 'watchlist', 'myListings', 'stats']);
    }

    /**
     * Test that an admin user accesses the administrative command center.
     */
    public function test_admin_accesses_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'shreyansh@bidx.com'
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHasAll(['stats', 'recentAuctions', 'recentBids']);
    }
}
