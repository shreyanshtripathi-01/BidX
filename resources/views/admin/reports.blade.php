<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Reports & Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Title Header -->
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Platform Performance Reports</h3>
                <p class="text-xs text-gray-400 dark:text-zinc-550 mt-1">High-level statistics, engagement, and top performing active lots.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Top Auctions List -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-zinc-100 mb-4">Most Popular Lots by Bid Volume</h3>
                    <div class="space-y-3">
                        @forelse($topAuctions as $auction)
                            <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-zinc-900/30 rounded-lg border border-gray-100 dark:border-zinc-900/50">
                                <div class="min-w-0 pr-4">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-zinc-200 truncate">{{ $auction->title }}</p>
                                    <p class="text-xs text-gray-500 dark:text-zinc-550 mt-0.5">Creator: {{ $auction->user->name }}</p>
                                </div>
                                <span class="text-xs font-extrabold text-amber-600 dark:text-[#C5A880] shrink-0">{{ $auction->bids_count }} bids</span>
                            </div>
                        @empty
                            <p class="text-gray-400 dark:text-zinc-550 text-center py-8 text-xs">No bidding data available.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Static Platform Metrics -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-zinc-100 mb-4">Platform Overview Summary</h3>
                    <div class="divide-y divide-gray-150 dark:divide-zinc-900">
                        <div class="py-4 flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-zinc-400">Total Registered Accounts</span>
                            <span class="text-sm font-extrabold text-gray-900 dark:text-zinc-100">
                                {{ \App\Models\User::count() }}
                            </span>
                        </div>
                        <div class="py-4 flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-zinc-400">Total Created Lots</span>
                            <span class="text-sm font-extrabold text-gray-900 dark:text-zinc-100">
                                {{ \App\Models\Auction::count() }}
                            </span>
                        </div>
                        <div class="py-4 flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-zinc-400">Total Placed Bids</span>
                            <span class="text-sm font-extrabold text-gray-900 dark:text-zinc-100">
                                {{ \App\Models\Bid::count() }}
                            </span>
                        </div>
                        <div class="py-4 flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-zinc-400">Total Traded Volume</span>
                            <span class="text-sm font-extrabold text-gray-900 dark:text-zinc-100">
                                ₹{{ number_format(\App\Models\Auction::where('status', 'ended')->sum('current_price')) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>