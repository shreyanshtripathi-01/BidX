<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-900 dark:text-zinc-100 leading-tight tracking-tight">
                {{ __('Dashboard') }}
            </h2>
            <span class="text-xs font-semibold text-gray-400 dark:text-zinc-550">
                Administrator
            </span>
        </div>
    </x-slot>

    <div class="space-y-8 pt-2">
        <!-- Metric Cards Layout: 8 Cards in a 4+4 Grid (4 on Row 1, 4 on Row 2) -->
        <div class="space-y-6">
            <!-- Row 1: Core Platform Growth -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Registered Accounts -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Registered Accounts</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ number_format($stats['total_users']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-550">users</span>
                    </div>
                </div>

                <!-- Live Lots -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Live Lots</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ number_format($stats['active_auctions']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-550">active</span>
                    </div>
                </div>

                <!-- Settled Lots -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Settled Lots</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ number_format($stats['ended_auctions']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-550">closed</span>
                    </div>
                </div>

                <!-- Gross Revenue -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Gross Revenue</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            ₹{{ number_format($stats['total_revenue']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-550">INR</span>
                    </div>
                </div>
            </div>

            <!-- Row 2: Bidding & Inventory Analytics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Bids Placed -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Bids Placed</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ number_format($stats['total_bids']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-550">total</span>
                    </div>
                </div>

                <!-- Average Bid -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Average Bid</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            ₹{{ number_format($stats['avg_bid']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-550">avg</span>
                    </div>
                </div>

                <!-- Active Bidders -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Active Bidders</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ number_format($stats['active_bidders']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-550">bidders</span>
                    </div>
                </div>

                <!-- Active Inventory -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Active Inventory</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            ₹{{ number_format($stats['inventory_value']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-550">value</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid split side-by-side like the member view -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left/Center Content: Listings & Bid Feeds (Col Span 2) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Recent Listings -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                    <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                        <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Recent Listings</h3>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-zinc-900">
                        @forelse($recentAuctions as $auction)
                            <div class="p-6 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-[#121212]/30 transition-colors">
                                <div class="min-w-0 pr-4 space-y-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-zinc-200 truncate">{{ $auction->title }}</p>
                                    <p class="text-xs text-gray-450 dark:text-zinc-500">
                                        Seller: <span class="font-medium text-gray-700 dark:text-zinc-400">{{ $auction->user->name }}</span> · Value: <span class="font-bold text-amber-600 dark:text-[#C5A880]">₹{{ number_format($auction->current_price) }}</span>
                                    </p>
                                </div>
                                <div class="shrink-0 flex items-center space-x-4">
                                    <span class="px-2 py-0.5 text-xxs font-semibold rounded-full {{ $auction->status === 'active' ? 'bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400' : 'bg-gray-50 text-gray-500 dark:bg-zinc-800/40 dark:text-zinc-450' }}">
                                        {{ ucfirst($auction->status) }}
                                    </span>
                                    <a href="{{ route('admin.auctions.show', $auction) }}" class="text-xs font-semibold text-amber-600 dark:text-[#C5A880] hover:underline">Manage</a>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-gray-400 dark:text-zinc-500 text-xs">
                                No lots listed yet.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Real-time Bids -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                    <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                        <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Real-time Bids</h3>
                        <span class="inline-flex items-center w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-zinc-900">
                        @forelse($recentBids as $bid)
                            <div class="p-6 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-[#121212]/30 transition-colors">
                                <div class="min-w-0 pr-4 space-y-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-zinc-200">{{ $bid->user->name }}</p>
                                    <p class="text-xs text-gray-455 dark:text-zinc-550 truncate">{{ $bid->auction->title }}</p>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-sm font-extrabold text-green-600 dark:text-green-400">₹{{ number_format($bid->amount) }}</p>
                                    <p class="text-xxs text-gray-400 dark:text-zinc-500 mt-0.5">{{ $bid->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-gray-400 dark:text-zinc-500 text-xs">
                                No bids placed yet.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right Sidebar Column (Premium Quick Actions Center) -->
            <div class="space-y-8">
                
                <!-- Beautiful, Clean Quick Actions (Borders, Chevrons, NO left SVG icons!) -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg p-6 shadow-sm space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-zinc-500">Quick Actions</h3>
                    
                    <div class="space-y-3">
                        <!-- Action 1 -->
                        <a href="{{ route('admin.auctions.create') }}" 
                           class="w-full flex items-center justify-between p-3.5 rounded-lg border border-gray-150 dark:border-zinc-900 hover:border-gray-250 dark:hover:border-zinc-850 hover:bg-gray-50/50 dark:hover:bg-zinc-900/30 transition duration-150 group">
                            <span class="text-xs font-bold text-gray-900 dark:text-zinc-200">Create New Lot</span>
                            <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-gray-950 dark:group-hover:text-zinc-200 transition transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <!-- Action 2 -->
                        <a href="{{ route('admin.users') }}" 
                           class="w-full flex items-center justify-between p-3.5 rounded-lg border border-gray-150 dark:border-zinc-900 hover:border-gray-250 dark:hover:border-zinc-850 hover:bg-gray-50/50 dark:hover:bg-zinc-900/30 transition duration-150 group">
                            <span class="text-xs font-bold text-gray-900 dark:text-zinc-200">Manage Users</span>
                            <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-gray-950 dark:group-hover:text-zinc-200 transition transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <!-- Action 3 -->
                        <a href="{{ route('admin.reports') }}" 
                           class="w-full flex items-center justify-between p-3.5 rounded-lg border border-gray-150 dark:border-zinc-900 hover:border-gray-250 dark:hover:border-zinc-850 hover:bg-gray-50/50 dark:hover:bg-zinc-900/30 transition duration-150 group">
                            <span class="text-xs font-bold text-gray-900 dark:text-zinc-200">View Platform Reports</span>
                            <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-gray-950 dark:group-hover:text-zinc-200 transition transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>