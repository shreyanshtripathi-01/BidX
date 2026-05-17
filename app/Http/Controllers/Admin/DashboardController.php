<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\User;
use App\Models\Bid;
use App\Models\Payment;
use App\Mail\AuctionWon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_auctions' => Auction::count(),
            'active_auctions' => Auction::where('status', 'active')->count(),
            'ended_auctions' => Auction::where('status', 'ended')->count(),
            'total_bids' => Bid::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
        ];

        $recentAuctions = Auction::latest()->withCount('bids')->take(5)->get();
        $recentBids = Bid::with(['auction', 'user'])->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentAuctions', 'recentBids'));
    }

    /**
     * Show list of all users.
     */
    public function users(): View
    {
        $users = User::withCount('auctions', 'bids')
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Show form to create a new user.
     */
    public function createUser(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(), // Auto-verify seeded/created users for convenience
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully!');
    }

    /**
     * Show reports page.
     */
    public function reports(): View
    {
        $topAuctions = Auction::withCount('bids')
            ->orderBy('bids_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports', compact('topAuctions'));
    }
}