@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header Title -->
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100 tracking-tight">Executive Dashboard</h1>
        <p class="text-xs text-gray-500 dark:text-zinc-500 mt-1">Real-time platform metrics, ongoing lot activities, and financial statistics.</p>
    </div>

    <!-- Beautiful Platform Analytics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">
        <!-- Stat Card: Users -->
        <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
            <p class="text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Total Users</p>
            <div class="flex items-baseline mt-2">
                <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                    {{ number_format($stats['total_users']) }}
                </span>
            </div>
        </div>

        <!-- Stat Card: Auctions -->
        <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
            <p class="text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Total Lots</p>
            <div class="flex items-baseline mt-2">
                <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                    {{ number_format($stats['total_auctions']) }}
                </span>
            </div>
        </div>

        <!-- Stat Card: Active -->
        <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
            <p class="text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Active Lots</p>
            <div class="flex items-baseline mt-2">
                <span class="text-2xl font-extrabold text-green-600 dark:text-green-400">
                    {{ number_format($stats['active_auctions']) }}
                </span>
            </div>
        </div>

        <!-- Stat Card: Ended -->
        <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
            <p class="text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Ended Lots</p>
            <div class="flex items-baseline mt-2">
                <span class="text-2xl font-extrabold text-gray-500 dark:text-zinc-400">
                    {{ number_format($stats['ended_auctions']) }}
                </span>
            </div>
        </div>

        <!-- Stat Card: Bids -->
        <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
            <p class="text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Total Bids</p>
            <div class="flex items-baseline mt-2">
                <span class="text-2xl font-extrabold text-amber-600 dark:text-[#C5A880]">
                    {{ number_format($stats['total_bids']) }}
                </span>
            </div>
        </div>

        <!-- Stat Card: Revenue -->
        <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
            <p class="text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Net Revenue</p>
            <div class="flex items-baseline mt-2">
                <span class="text-xl font-extrabold text-gray-900 dark:text-zinc-100 truncate">
                    ₹{{ number_format($stats['total_revenue']) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Data Lists Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Auctions Panel -->
        <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
            <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                <h3 class="text-sm font-bold text-gray-900 dark:text-zinc-100">Recently Created Lots</h3>
                <span class="px-2.5 py-0.5 text-xxs font-bold uppercase tracking-wider bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300 rounded-full">Newest</span>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-zinc-900">
                @forelse($recentAuctions as $auction)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-zinc-900/30 transition-colors">
                        <div class="min-w-0 pr-4">
                            <p class="text-sm font-semibold text-gray-900 dark:text-zinc-200 truncate">{{ $auction->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-zinc-500 mt-0.5">
                                Creator: <span class="font-medium text-gray-700 dark:text-zinc-400">{{ $auction->user->name }}</span> · {{ $auction->bids_count }} bids
                            </p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-xs text-gray-400 dark:text-zinc-500">{{ $auction->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400 dark:text-zinc-550 text-xs">
                        No auctions listed yet.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Bids Panel -->
        <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
            <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                <h3 class="text-sm font-bold text-gray-900 dark:text-zinc-100">Recent Bid Placement Activity</h3>
                <span class="px-2.5 py-0.5 text-xxs font-bold uppercase tracking-wider bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400 rounded-full">Live Feed</span>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-zinc-900">
                @forelse($recentBids as $bid)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-zinc-900/30 transition-colors">
                        <div class="min-w-0 pr-4">
                            <p class="text-sm font-semibold text-gray-900 dark:text-zinc-200 truncate">{{ $bid->user->name }}</p>
                            <p class="text-xs text-gray-400 dark:text-zinc-500 mt-0.5 truncate">{{ $bid->auction->title }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-sm font-extrabold text-green-600 dark:text-green-400">₹{{ number_format($bid->amount) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400 dark:text-zinc-550 text-xs">
                        No bids placed yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Action Section -->
    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg p-6 shadow-sm">
        <h3 class="text-sm font-bold text-gray-900 dark:text-zinc-100 mb-4">Quick Administrative Tools</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.auctions.create') }}"
               class="inline-flex justify-center items-center px-4 py-2.5 text-xs font-bold rounded-md text-white dark:text-black bg-gray-950 dark:bg-[#C5A880] hover:bg-gray-800 dark:hover:bg-[#B3966E] transition duration-150">
                Create Admin Lot
            </a>
            <a href="{{ route('admin.users') }}"
               class="inline-flex justify-center items-center px-4 py-2.5 text-xs font-bold rounded-md border border-gray-250 dark:border-zinc-800 text-gray-700 dark:text-zinc-300 bg-white dark:bg-transparent hover:bg-gray-50 dark:hover:bg-zinc-900 transition duration-150">
                Manage User Accounts
            </a>
            <a href="{{ route('admin.reports') }}"
               class="inline-flex justify-center items-center px-4 py-2.5 text-xs font-bold rounded-md border border-gray-250 dark:border-zinc-800 text-gray-700 dark:text-zinc-300 bg-white dark:bg-transparent hover:bg-gray-50 dark:hover:bg-zinc-900 transition duration-150">
                Generate Reports
            </a>
        </div>
    </div>
</div>
@endsection