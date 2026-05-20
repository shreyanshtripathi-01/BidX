<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ $auction->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg mb-6">
                <div class="p-6">
                    @if($auction->image)
                        <img src="{{ asset('storage/' . $auction->image) }}"
                             alt="{{ $auction->title }}"
                             class="w-full max-h-96 object-cover rounded-md mb-6">
                    @endif

                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100 flex items-center gap-3">
                                {{ $auction->title }}
                                @auth
                                    <form action="{{ route('watchlist.toggle', $auction) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-zinc-800 transition duration-150 group" title="{{ Auth::user()->isWatching($auction) ? 'Remove from Watchlist' : 'Add to Watchlist' }}">
                                            @if(Auth::user()->isWatching($auction))
                                                <svg class="w-5 h-5 text-amber-500 fill-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-400 group-hover:text-amber-500 transition duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.837-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                </svg>
                                            @endif
                                        </button>
                                    </form>
                                @endauth
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1">By {{ $auction->user->name }}</p>
                        </div>
                        <div class="flex items-center space-x-2 border border-gray-150 dark:border-zinc-800 px-3 py-1.5 rounded-full">
                            <span class="w-2 h-2 rounded-full {{ $auction->status === 'active' ? 'bg-green-500 animate-pulse' : 'bg-gray-400 dark:bg-zinc-600' }}"></span>
                            <span class="text-xs font-semibold text-gray-700 dark:text-zinc-300">{{ $auction->status === 'active' ? 'Live Auction' : 'Auction Closed' }}</span>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 dark:text-zinc-400 leading-relaxed mb-6">{{ $auction->description }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 p-4 bg-gray-50 dark:bg-[#0A0A0A] rounded-lg">
                        <div>
                            <p class="text-xs text-gray-400 dark:text-zinc-500 uppercase">Starting Price</p>
                            <p class="text-base font-extrabold text-gray-900 dark:text-zinc-200">₹{{ number_format($auction->starting_price) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 dark:text-zinc-500 uppercase">Current Price</p>
                            <p class="text-base font-extrabold text-amber-600 dark:text-[#C5A880]">₹{{ number_format($auction->current_price) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 dark:text-zinc-500 uppercase">Total Bids</p>
                            <p class="text-base font-extrabold text-gray-900 dark:text-zinc-200">{{ $auction->bids()->count() }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 dark:text-zinc-500 uppercase">Ends</p>
                            <p class="text-base font-extrabold text-gray-900 dark:text-zinc-200">{{ $auction->end_time->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($auction->status === 'active' && $auction->end_time > now())
                @auth
                    @if($auction->user_id !== Auth::id())
                        <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg mb-6">
                            <div class="p-6">
                                <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100 mb-4">Place a Bid</h3>
                                <form id="bidForm" class="flex gap-3">
                                    @csrf
                                    <input type="hidden" name="auction_id" value="{{ $auction->id }}">
                                    <div class="flex-1">
                                        <input type="number" name="amount" id="bidAmount" step="1" min="{{ $auction->current_price + 1 }}"
                                               placeholder="Min bid: ₹{{ number_format($auction->current_price + 1) }}"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-[#C5A880]/30 focus:border-[#C5A880]"
                                               required>
                                        <span class="text-xs text-gray-400 dark:text-zinc-500 mt-1 block">Minimum bid: ₹{{ number_format($auction->current_price + 1) }}</span>
                                    </div>
                                    <button type="submit"
                                            class="px-6 py-2 bg-gray-950 dark:bg-[#C5A880] text-white dark:text-black font-semibold rounded-md hover:bg-gray-800 dark:hover:bg-[#B3966E] transition duration-150 disabled:opacity-50"
                                            id="bidBtn">
                                        Place Bid
                                    </button>
                                </form>
                                <div id="bidMessage" class="mt-3"></div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg mb-6">
                        <div class="p-6 text-center">
                            <p class="text-sm font-semibold text-gray-800 dark:text-zinc-200">You must be logged in to place a bid.</p>
                            <a href="{{ route('login') }}" class="inline-flex justify-center items-center mt-3 px-6 py-2.5 text-xs font-bold text-white dark:text-black bg-gray-950 dark:bg-[#C5A880] hover:bg-gray-800 dark:hover:bg-[#B3966E] rounded-md transition duration-150">
                                Log In
                            </a>
                        </div>
                    </div>
                @endauth
            @endif

            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100 mb-4">Bid History</h3>
                    @if($auction->bids->isNotEmpty())
                        <div class="space-y-3" id="bidsList">
                            @foreach($auction->bids as $bid)
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-[#0A0A0A] rounded-lg border border-gray-100 dark:border-zinc-900">
                                    <div>
                                        <span class="font-semibold text-sm text-gray-900 dark:text-zinc-200">{{ $bid->user->name }}</span>
                                        <span class="text-xs text-gray-400 dark:text-zinc-500 ml-2">{{ $bid->created_at->diffForHumans() }}</span>
                                    </div>
                                    <span class="font-bold text-sm text-amber-600 dark:text-[#C5A880]">₹{{ number_format($bid->amount) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-4 text-sm">No bids yet. Be the first!</p>
                    @endif
                </div>
            </div>

            @if($auction->status === 'ended')
                @php
                    $winner = $auction->bids()->orderBy('amount', 'desc')->first();
                @endphp
                @if($winner)
                    <div class="bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800/40 rounded-lg p-6 mb-6">
                        <h3 class="text-sm font-bold text-green-800 dark:text-green-400">🏆 Auction Winner</h3>
                        <p class="text-green-700 dark:text-green-500 mt-2 text-sm">{{ $winner->user->name }} won with a bid of <strong>₹{{ number_format($winner->amount) }}</strong></p>
                    </div>
                @endif
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('bidForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();const formData = new FormData(this);
            const btn = document.getElementById('bidBtn');
            const messageDiv = document.getElementById('bidMessage');

            btn.disabled = true;
            btn.textContent = 'Placing Bid...';

            try {
                const response = await fetch('{{ route("api.bids.store", $auction) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    messageDiv.innerHTML = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">' + data.message + '</div>';
                    const newMin = Math.ceil(data.bid.amount + 1);
                    document.getElementById('bidAmount').min = newMin;
                    document.getElementById('bidAmount').placeholder = 'Min bid: ₹' + newMin.toLocaleString('en-IN');
                    document.getElementById('bidAmount').value = '';

                    const bidsList = document.getElementById('bidsList');
                    if (bidsList) {
                        bidsList.insertAdjacentHTML('afterbegin',
                            '<div class="flex justify-between items-center p-3 bg-green-50 rounded-lg border border-green-100">' +
                            '<div><span class="font-medium text-gray-900">' + data.bid.user_name + ' (You)</span>' +
                            '<span class="text-sm text-gray-500 ml-2">Just now</span></div>' +
                            '<span class="font-bold text-green-600">₹' + Math.ceil(data.bid.amount).toLocaleString('en-IN') + '</span></div>'
                        );
                    }
                } else {
                    messageDiv.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">' + data.message + '</div>';
                }
            } catch (error) {
                messageDiv.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">An error occurred. Please try again.</div>';
            }

            btn.disabled = false;
            btn.textContent = 'Place Bid';
        });
    </script>
    @endpush
</x-app-layout>