<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Member Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Member Analytics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Total Bids Placed</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ Auth::user()->bids()->count() }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-500">lots</span>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Committed Bid Value</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            ₹{{ number_format(Auth::user()->bids()->sum('amount')) }}
                        </span>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Auctions Won</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            {{ Auth::user()->notifications()->where('type', 'won')->count() }}
                        </span>
                        <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-500">lots</span>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg">
                    <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Completed Purchases</p>
                    <div class="flex items-baseline mt-2">
                        <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                            ₹{{ number_format(Auth::user()->payments()->where('status', 'completed')->sum('amount')) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Body Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Active Bids List (Col span 2) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                            <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Your Ongoing Bidding Activity</h3>
                            <span class="px-2.5 py-0.5 text-xxs font-bold uppercase tracking-wider bg-amber-50 text-amber-800 dark:bg-[#C5A880]/10 dark:text-[#C5A880] rounded-full">Live Status</span>
                        </div>

                        @php
                            $userBids = Auth::user()->bids()->with('auction')->latest()->get();
                        @endphp

                        @if($userBids->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-150 dark:divide-zinc-900">
                                    <thead class="bg-gray-50 dark:bg-[#121212]/50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Item Details</th>
                                            <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Your Bid</th>
                                            <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Current High</th>
                                            <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-right text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-[#121212] divide-y divide-gray-150 dark:divide-zinc-900">
                                        @foreach($userBids as $bid)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-zinc-200">
                                                        {{ $bid->auction->title }}
                                                    </div>
                                                    <div class="text-xs text-gray-400 dark:text-zinc-500">
                                                        Ends {{ $bid->auction->end_time->diffForHumans() }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm font-bold text-gray-800 dark:text-zinc-200">
                                                        ₹{{ number_format($bid->amount) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm font-bold {{ $bid->amount == $bid->auction->current_price ? 'text-green-600 dark:text-green-400' : 'text-amber-600 dark:text-[#C5A880]' }}">
                                                        ₹{{ number_format($bid->auction->current_price) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($bid->auction->status === 'active')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-medium bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-medium bg-gray-50 text-gray-500 dark:bg-zinc-800/40 dark:text-zinc-400">
                                                            Closed
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('auctions.show', $bid->auction) }}" 
                                                       class="text-amber-600 dark:text-[#C5A880] hover:underline font-semibold text-xs">
                                                        View Lot
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-12 text-center text-gray-500 dark:text-zinc-500">
                                <p class="text-sm font-medium">No bids placed yet.</p>
                                <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">Explore live lots to place your first bid!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Explore / Suggest Open Lots -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-zinc-900 bg-gray-50/50 dark:bg-[#121212]/50">
                            <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Quick Bid Live Lots</h3>
                            <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">Instant active lots open for bids.</p>
                        </div>

                        <div class="divide-y divide-gray-100 dark:divide-zinc-900">
                            @php
                                $liveAuctions = \App\Models\Auction::where('status', 'active')->latest()->take(3)->get();
                            @endphp

                            @forelse($liveAuctions as $item)
                                <div class="p-6 space-y-3">
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-zinc-100 text-sm">
                                            {{ $item->title }}
                                        </h4>
                                        <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">
                                            Ending in {{ $item->end_time->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xxs text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Current High</p>
                                            <p class="text-base font-bold text-gray-900 dark:text-zinc-100 font-sans">₹{{ number_format($item->current_price) }}</p>
                                        </div>
                                        <a href="{{ route('auctions.show', $item) }}"
                                           class="inline-flex justify-center items-center px-4 py-2 text-xs font-semibold rounded-md text-white dark:text-black bg-gray-950 dark:bg-[#C5A880] hover:bg-gray-800 dark:hover:bg-[#B3966E] transition duration-150">
                                            Bid Now
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center text-gray-400 dark:text-zinc-500 text-xs">
                                    No live open lots available.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
