<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-900 dark:text-zinc-100 leading-tight tracking-tight">
                {{ __('Dashboard') }}
            </h2>
            <span class="text-xs font-semibold text-gray-400 dark:text-zinc-500">
                Administrator
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Symmetrical Premium Metrics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Registered Accounts -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Registered Accounts</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ number_format($stats['total_users']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-500">users</span>
                    </div>
                </div>

                <!-- Live Lots -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Live Lots</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ number_format($stats['active_auctions']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-500">active</span>
                    </div>
                </div>

                <!-- Bids Placed -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Bids Placed</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ number_format($stats['total_bids']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-500">total</span>
                    </div>
                </div>

                <!-- Gross Revenue -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Gross Revenue</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            ₹{{ number_format($stats['total_revenue']) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content Grid split side-by-side like the member view -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left/Center Content: Listings & Bid Feeds (Col Span 2) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Recent Listings -->
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                            <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Recent Listings</h3>
                            <span class="px-2.5 py-0.5 text-xxs font-bold uppercase tracking-wider bg-amber-50 text-amber-800 dark:bg-[#C5A880]/10 dark:text-[#C5A880] rounded-full">Overview</span>
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
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                            <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Real-time Bids</h3>
                            <span class="inline-flex items-center w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-zinc-900">
                            @forelse($recentBids as $bid)
                                <div class="p-6 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-[#121212]/30 transition-colors">
                                    <div class="min-w-0 pr-4 space-y-1">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-zinc-200">{{ $bid->user->name }}</p>
                                        <p class="text-xs text-gray-450 dark:text-zinc-550 truncate">{{ $bid->auction->title }}</p>
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

                <!-- Right Sidebar Column (Quick Actions Center at the very top!) -->
                <div class="space-y-8">
                    
                    <!-- Clean, Simple Quick Actions (Banish all SVG icons/colored signs!) -->
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg p-6 shadow-sm">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-zinc-500 mb-4">Quick Actions</h3>
                        
                        <div class="flex flex-col space-y-2">
                            <a href="{{ route('admin.auctions.create') }}" 
                               class="w-full text-center px-4 py-2.5 text-xs font-bold rounded bg-gray-950 dark:bg-[#C5A880] text-white dark:text-black hover:bg-gray-800 dark:hover:bg-[#B3966E] transition duration-150">
                                Create New Lot
                            </a>
                            <a href="{{ route('admin.users') }}" 
                               class="w-full text-center px-4 py-2.5 text-xs font-bold rounded border border-gray-250 dark:border-zinc-800 text-gray-700 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-900 transition duration-150">
                                Manage Users
                            </a>
                            <a href="{{ route('admin.reports') }}" 
                               class="w-full text-center px-4 py-2.5 text-xs font-bold rounded border border-gray-250 dark:border-zinc-800 text-gray-700 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-900 transition duration-150">
                                View Platform Reports
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>