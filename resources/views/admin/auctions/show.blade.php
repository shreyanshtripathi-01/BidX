<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Lot Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A]">
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- Back navigation header -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.auctions.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Review Lot</h3>
                    <p class="text-xs text-gray-400 dark:text-zinc-550">Overview of item, description, active bids, and winning status.</p>
                </div>
            </div>

            <!-- Detail Card -->
            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm p-8 space-y-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 dark:text-zinc-100">{{ $auction->title }}</h1>
                        <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">Lot ID: #{{ $auction->id }} · Created {{ $auction->created_at->format('M d, Y') }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold uppercase tracking-wider
                        {{ $auction->status === 'active' ? 'bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-zinc-800/40 dark:text-zinc-400' }}">
                        {{ $auction->status }}
                    </span>
                </div>

                <p class="text-sm text-gray-600 dark:text-zinc-400 leading-relaxed">{{ $auction->description }}</p>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6 bg-gray-50 dark:bg-zinc-900/30 rounded-lg border border-gray-100 dark:border-zinc-900/50">
                    <div>
                        <p class="text-xxs text-gray-400 dark:text-zinc-500 uppercase tracking-wider font-bold">Seller</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-zinc-200 mt-1">{{ $auction->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xxs text-gray-400 dark:text-zinc-550 uppercase tracking-wider font-bold">Starting Price</p>
                        <p class="text-sm font-semibold text-gray-950 dark:text-zinc-200 mt-1">₹{{ number_format($auction->starting_price) }}</p>
                    </div>
                    <div>
                        <p class="text-xxs text-gray-400 dark:text-zinc-550 uppercase tracking-wider font-bold">Current Value</p>
                        <p class="text-sm font-extrabold text-amber-600 dark:text-[#C5A880] mt-1">₹{{ number_format($auction->current_price) }}</p>
                    </div>
                    <div>
                        <p class="text-xxs text-gray-400 dark:text-zinc-550 uppercase tracking-wider font-bold">Total Bids</p>
                        <p class="text-sm font-semibold text-gray-950 dark:text-zinc-200 mt-1">{{ $auction->bids->count() }} bids</p>
                    </div>
                </div>

                @if($auction->image)
                    <div class="border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden max-h-96">
                        <img src="{{ asset('storage/' . $auction->image) }}" alt="{{ $auction->title }}" class="w-full object-cover">
                    </div>
                @endif
            </div>

            <!-- Bid History Card -->
            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-900 dark:text-zinc-100 mb-4">Complete Bid Placements</h3>
                @if($auction->bids->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($auction->bids as $bid)
                            <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-zinc-900/30 rounded-lg border border-gray-100 dark:border-zinc-900/50">
                                <div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-zinc-200">{{ $bid->user->name }}</span>
                                    <span class="text-xs text-gray-400 dark:text-zinc-550 ml-2">{{ $bid->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="text-sm font-extrabold text-green-600 dark:text-green-400">₹{{ number_format($bid->amount) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 dark:text-zinc-550 text-center py-6 text-xs">No bids placed on this lot yet.</p>
                @endif
            </div>

            <!-- Winner Card -->
            @if($auction->status === 'ended')
                @php
                    $winner = $auction->bids()->orderBy('amount', 'desc')->first();
                @endphp
                @if($winner)
                    <div class="bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/50 rounded-lg p-6">
                        <h3 class="text-sm font-bold text-green-800 dark:text-green-450">🏆 Won Lot</h3>
                        <p class="text-sm text-green-700 dark:text-green-400 mt-2">
                            User <span class="font-bold">{{ $winner->user->name }}</span> won this lot with a premium bid of <span class="font-extrabold">₹{{ number_format($winner->amount) }}</span>.
                        </p>
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>