<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-900 dark:text-zinc-100 leading-tight tracking-tight">
                {{ __('Administrative Command Center') }}
            </h2>
            <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold uppercase tracking-wider bg-amber-50 text-amber-800 dark:bg-[#C5A880]/10 dark:text-[#C5A880]">
                Super Administrator
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Premium Statistics Cards Grid (Perfectly matching the member dashboard sizing!) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm hover:border-gray-250 dark:hover:border-zinc-800 transition duration-150">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Total Platform Users</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ number_format($stats['total_users']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-500">active</span>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm hover:border-gray-250 dark:hover:border-zinc-800 transition duration-150">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Active Lots Open</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-green-600 dark:text-green-400">
                            {{ number_format($stats['active_auctions']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-green-500/80 dark:text-green-550">live</span>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm hover:border-gray-250 dark:hover:border-zinc-800 transition duration-150">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Total Bids Placed</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-amber-600 dark:text-[#C5A880]">
                            {{ number_format($stats['total_bids']) }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-amber-500/80 dark:text-[#C5A880]/80">bids</span>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm hover:border-gray-250 dark:hover:border-zinc-800 transition duration-150">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Dummy Net Revenue</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            ₹{{ number_format($stats['total_revenue']) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Layout: Sidebar & Content Split -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Center / Left Main Admin Content (Col Span 2) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Recently Created Lots Panel -->
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                        <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-zinc-100">Recently Created Auction Lots</h3>
                            <span class="px-2.5 py-0.5 text-xxs font-bold uppercase tracking-wider bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300 rounded-full">Newest</span>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-zinc-900">
                            @forelse($recentAuctions as $auction)
                                <div class="p-6 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-zinc-900/30 transition-colors">
                                    <div class="min-w-0 pr-4 space-y-1">
                                        <p class="text-sm font-bold text-gray-900 dark:text-zinc-200 truncate">{{ $auction->title }}</p>
                                        <p class="text-xs text-gray-400 dark:text-zinc-500">
                                            Listed by <span class="font-semibold text-gray-700 dark:text-zinc-400">{{ $auction->user->name }}</span> · current value: <span class="font-semibold text-amber-600 dark:text-[#C5A880]">₹{{ number_format($auction->current_price) }}</span>
                                        </p>
                                    </div>
                                    <div class="shrink-0 flex items-center space-x-3">
                                        <span class="px-2 py-0.5 text-xxs font-bold rounded-full {{ $auction->status === 'active' ? 'bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400' : 'bg-zinc-100 text-zinc-650 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                            {{ ucfirst($auction->status) }}
                                        </span>
                                        <a href="{{ route('admin.auctions.show', $auction) }}" class="text-xxs font-bold uppercase text-gray-400 hover:text-gray-900 dark:hover:text-zinc-200 tracking-wider transition">Manage</a>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center text-gray-500 dark:text-zinc-550 text-xs">
                                    No auctions listed yet.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Bid Activity Feed -->
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                        <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-zinc-100">Live Bid Placement Feed</h3>
                            <span class="inline-flex items-center w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-zinc-900">
                            @forelse($recentBids as $bid)
                                <div class="p-6 flex items-center justify-between hover:bg-gray-50/50 dark:hover:bg-zinc-900/30 transition-colors">
                                    <div class="min-w-0 pr-4 space-y-1">
                                        <p class="text-sm font-bold text-gray-900 dark:text-zinc-200">{{ $bid->user->name }}</p>
                                        <p class="text-xs text-gray-400 dark:text-zinc-550 truncate">{{ $bid->auction->title }}</p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-sm font-extrabold text-green-600 dark:text-green-400">₹{{ number_format($bid->amount) }}</p>
                                        <p class="text-xxs text-gray-450 dark:text-zinc-550 mt-0.5">{{ $bid->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center text-gray-400 dark:text-zinc-550 text-xs">
                                    No bids placed yet.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

                <!-- Right Sidebar Administrative Actions (Placed at top right, highly prominent!) -->
                <div class="space-y-8">
                    
                    <!-- Quick Actions Widget -->
                    <div class="bg-white dark:bg-[#121212] border-2 border-amber-100/50 dark:border-[#C5A880]/10 rounded-lg p-6 shadow-sm space-y-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-950 dark:text-zinc-100">Quick Administrative Tools</h3>
                            <p class="text-xxs text-gray-400 dark:text-zinc-500 mt-0.5">Direct system shortcuts for quick actions.</p>
                        </div>
                        
                        <div class="space-y-3 pt-2">
                            <!-- Action 1 -->
                            <a href="{{ route('admin.auctions.create') }}" 
                               class="w-full flex items-center justify-between p-3.5 rounded-lg border border-gray-150 dark:border-zinc-900 hover:border-gray-250 dark:hover:border-zinc-850 hover:bg-gray-50/50 dark:hover:bg-zinc-900/30 transition duration-150 group">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 rounded bg-amber-50 dark:bg-[#C5A880]/10 text-amber-600 dark:text-[#C5A880]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-zinc-200">Create System Lot</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-gray-950 dark:group-hover:text-zinc-200 transition transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <!-- Action 2 -->
                            <a href="{{ route('admin.users') }}" 
                               class="w-full flex items-center justify-between p-3.5 rounded-lg border border-gray-150 dark:border-zinc-900 hover:border-gray-250 dark:hover:border-zinc-850 hover:bg-gray-50/50 dark:hover:bg-zinc-900/30 transition duration-150 group">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 rounded bg-green-50 dark:bg-green-950/20 text-green-700 dark:text-green-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-zinc-200">Manage User Accounts</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-gray-950 dark:group-hover:text-zinc-200 transition transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <!-- Action 3 -->
                            <a href="{{ route('admin.reports') }}" 
                               class="w-full flex items-center justify-between p-3.5 rounded-lg border border-gray-150 dark:border-zinc-900 hover:border-gray-250 dark:hover:border-zinc-850 hover:bg-gray-50/50 dark:hover:bg-zinc-900/30 transition duration-150 group">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 rounded bg-blue-50 dark:bg-blue-950/20 text-blue-700 dark:text-blue-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-zinc-200">Platform Analytics</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-gray-950 dark:group-hover:text-zinc-200 transition transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Platform Settings Hint -->
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg p-6 shadow-sm">
                        <h4 class="text-xs font-bold text-gray-900 dark:text-zinc-150 uppercase tracking-wider mb-2">Platform Notice</h4>
                        <p class="text-xxs text-gray-450 dark:text-zinc-500 leading-relaxed">
                            Bidding calculations, payment captures, and real-time email triggers are executed automatically by the background system scheduler.
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>