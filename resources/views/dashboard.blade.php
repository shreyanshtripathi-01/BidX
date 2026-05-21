<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Member Dashboard') }}
        </h2>
    </x-slot>

    <div class="space-y-6 pt-2">

        @if($unpaidWon->isNotEmpty())
            <div class="bg-amber-50 dark:bg-amber-950/20 border border-amber-250 dark:border-[#C5A880]/30 rounded-lg p-6 shadow-sm space-y-4">
                <div class="flex items-center space-x-2">
                    <span class="text-lg">🏆</span>
                    <h3 class="text-sm font-extrabold text-amber-800 dark:text-amber-400 uppercase tracking-wider">You Won! Complete Secure Payment</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($unpaidWon as $auction)
                        @php
                            $winningBid = $auction->bids->first();
                        @endphp
                        <div class="flex items-center justify-between p-4 bg-white dark:bg-[#121212] border border-amber-150 dark:border-zinc-900 rounded-lg shadow-sm">
                            <div class="min-w-0 pr-4 space-y-1">
                                <p class="text-sm font-bold text-gray-900 dark:text-zinc-200 truncate">{{ $auction->title }}</p>
                                <p class="text-xs text-gray-450 dark:text-zinc-500">Hammer Price: <span class="font-extrabold text-amber-600 dark:text-[#C5A880]">₹{{ number_format($winningBid->amount) }}</span></p>
                            </div>
                            <a href="{{ route('payments.show', $auction) }}" class="inline-flex justify-center items-center px-4 py-2 text-xs font-bold text-white dark:text-black bg-amber-600 dark:bg-[#C5A880] hover:bg-amber-700 dark:hover:bg-[#B3966E] rounded-md transition duration-150 shrink-0">
                                Complete Purchase
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Total Bids Placed</p>
                <div class="flex items-baseline mt-2">
                    <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                        {{ number_format($stats['total_bids']) }}
                    </span>
                    <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-500">lots</span>
                </div>
            </div>

            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Committed Bid Value</p>
                <div class="flex items-baseline mt-2">
                    <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                        ₹{{ number_format($stats['committed_value']) }}
                    </span>
                </div>
            </div>

            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Auctions Won</p>
                <div class="flex items-baseline mt-2">
                    <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                        {{ number_format($stats['won_count']) }}
                    </span>
                    <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-500">lots</span>
                </div>
            </div>

            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-6 rounded-lg shadow-sm">
                <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Completed Purchases</p>
                <div class="flex items-baseline mt-2">
                    <span class="text-2xl font-extrabold text-gray-900 dark:text-zinc-100">
                        {{ number_format($stats['purchases_count']) }}
                    </span>
                    <span class="ml-1.5 text-xs font-semibold text-gray-400 dark:text-zinc-500">lots</span>
                </div>
            </div>
        </div>

        <div class="flex border-b border-gray-150 dark:border-zinc-900" id="dashboardTabs">
            <button onclick="switchTab('bidding')" id="tabBtn-bidding" class="px-5 py-3 text-xs font-bold border-b-2 border-amber-500 text-amber-600 dark:text-[#C5A880] transition duration-150">
                My Bidding Activity
            </button>
            <button onclick="switchTab('listings')" id="tabBtn-listings" class="px-5 py-3 text-xs font-bold border-b-2 border-transparent text-gray-400 dark:text-zinc-500 hover:text-gray-900 dark:hover:text-zinc-300 transition duration-150">
                My Auction Listings ({{ $myListings->count() }})
            </button>
        </div>

        <div id="tabContent-bidding" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                    <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                        <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Your Ongoing Bidding Activity</h3>
                    </div>

                    @php
                        $userBids = Auth::user()->bids()->with('auction')->latest()->get();
                    @endphp

                    @if($userBids->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-150 dark:divide-zinc-900">
                                <thead class="bg-gray-50 dark:bg-[#121212]/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Auction</th>
                                        <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Your Bid</th>
                                        <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Top Bid</th>
                                        <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-[#121212] divide-y divide-gray-150 dark:divide-zinc-900">
                                    @foreach($userBids as $bid)
                                        @php
                                            $isWinning = $bid->auction->isUserWinning(Auth::user());
                                        @endphp
                                        <tr class="hover:bg-gray-50/30 dark:hover:bg-zinc-900/10 transition duration-150 border-b border-gray-150 dark:border-zinc-900">
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
                                                <span class="text-sm font-bold {{ $isWinning ? 'text-green-600 dark:text-green-400' : 'text-amber-600 dark:text-[#C5A880]' }}">
                                                    ₹{{ number_format($bid->auction->current_price) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($bid->auction->status === 'active')
                                                    @if($isWinning)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400">
                                                            Winning
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-450">
                                                            Outbid
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-medium bg-gray-50 text-gray-500 dark:bg-zinc-800/40 dark:text-zinc-400">
                                                        Closed
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @if($bid->auction->status === 'active' && !$isWinning)
                                                    <a href="{{ route('auctions.show', $bid->auction) }}" 
                                                       class="inline-flex justify-center items-center px-3 py-1 text-xxs font-bold text-white dark:text-black bg-rose-600 dark:bg-[#C5A880] hover:bg-rose-700 dark:hover:bg-[#B3966E] rounded transition duration-150 shadow-sm mr-2">
                                                        Re-bid
                                                    </a>
                                                @endif
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

            <div class="space-y-6">
                
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                    <div class="p-6 border-b border-gray-100 dark:border-zinc-900 bg-gray-50/50 dark:bg-[#121212]/50">
                        <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">My Watchlist</h3>
                        <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">Lots you are monitoring.</p>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-zinc-900">
                        @forelse($watchlist as $item)
                            <div class="p-6 flex items-center justify-between hover:bg-gray-50/30 dark:hover:bg-zinc-900/30 transition duration-150">
                                <div class="min-w-0 pr-4 space-y-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-zinc-200 truncate">{{ $item->title }}</p>
                                    <p class="text-xs text-gray-450 dark:text-zinc-500">
                                        Ends {{ $item->end_time->diffForHumans() }}
                                    </p>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <span class="text-xxs font-bold text-amber-600 dark:text-[#C5A880]">₹{{ number_format($item->current_price) }}</span>
                                    </div>
                                </div>
                                <div class="shrink-0 flex items-center space-x-3">
                                    
                                    <form action="{{ route('watchlist.toggle', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1 text-amber-500 hover:text-gray-400 transition" title="Remove Watch">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </button>
                                    </form>
                                    <a href="{{ route('auctions.show', $item) }}" class="text-xs font-bold text-amber-600 dark:text-[#C5A880] hover:underline">View</a>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-400 dark:text-zinc-550 text-xs">
                                Watchlist is empty.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
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
                                        Ending {{ $item->end_time->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xxs text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Current High</p>
                                        <p class="text-base font-bold text-gray-900 dark:text-zinc-100">₹{{ number_format($item->current_price) }}</p>
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

        <div id="tabContent-listings" class="hidden">
            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                <div class="p-6 border-b border-gray-100 dark:border-zinc-900 flex justify-between items-center bg-gray-50/50 dark:bg-[#121212]/50">
                    <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Your Listed Lots</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-zinc-900">
                    @forelse($myListings as $listing)
                        <div class="p-6 flex items-center justify-between hover:bg-gray-50/30 dark:hover:bg-zinc-900/30 transition duration-150">
                            <div class="min-w-0 pr-4 space-y-1">
                                <p class="text-sm font-semibold text-gray-900 dark:text-zinc-200 truncate">{{ $listing->title }}</p>
                                <p class="text-xs text-gray-450 dark:text-zinc-500">
                                    Status: <span class="font-bold {{ $listing->status === 'active' ? 'text-green-600 dark:text-green-400' : 'text-gray-500' }}">{{ ucfirst($listing->status) }}</span> · Bids: <span class="font-semibold text-gray-700 dark:text-zinc-400">{{ $listing->bids_count }}</span>
                                </p>
                            </div>
                            <div class="text-right shrink-0 flex items-center space-x-6">
                                <div>
                                    <p class="text-xxs text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Current High</p>
                                    <p class="text-sm font-bold text-amber-600 dark:text-[#C5A880]">₹{{ number_format($listing->current_price) }}</p>
                                </div>
                                <a href="{{ route('auctions.show', $listing) }}" class="text-xs font-bold text-amber-600 dark:text-[#C5A880] hover:underline">View Performance</a>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-450 dark:text-zinc-550 text-xs">
                            You have not listed any lots yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <script>
        function switchTab(tab) {
            const biddingBtn = document.getElementById('tabBtn-bidding');
            const listingsBtn = document.getElementById('tabBtn-listings');
            const biddingContent = document.getElementById('tabContent-bidding');
            const listingsContent = document.getElementById('tabContent-listings');

            if (tab === 'bidding') {
                biddingBtn.className = "px-5 py-3 text-xs font-bold border-b-2 border-amber-500 text-amber-600 dark:text-[#C5A880] transition duration-150";
                listingsBtn.className = "px-5 py-3 text-xs font-bold border-b-2 border-transparent text-gray-400 dark:text-zinc-500 hover:text-gray-900 dark:hover:text-zinc-300 transition duration-150";
                biddingContent.classList.remove('hidden');
                listingsContent.classList.add('hidden');
            } else {
                listingsBtn.className = "px-5 py-3 text-xs font-bold border-b-2 border-amber-500 text-amber-600 dark:text-[#C5A880] transition duration-150";
                biddingBtn.className = "px-5 py-3 text-xs font-bold border-b-2 border-transparent text-gray-400 dark:text-zinc-500 hover:text-gray-900 dark:hover:text-zinc-300 transition duration-150";
                biddingContent.classList.add('hidden');
                listingsContent.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>
