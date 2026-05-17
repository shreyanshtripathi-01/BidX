<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Active Auctions') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950">
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($auctions as $auction)
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg">
                        <div class="p-6">
                            <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100 mb-2">{{ $auction->title }}</h3>
                            <p class="text-xs text-gray-500 dark:text-zinc-400 leading-relaxed mb-6">{{ $auction->description }}</p>

                            <div class="space-y-2 mb-6 pt-4 border-t border-gray-100 dark:border-zinc-800">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 dark:text-zinc-500 text-xs">Starting Price:</span>
                                    <span class="font-bold text-gray-800 dark:text-zinc-200 text-sm">₹{{ number_format($auction->starting_price) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 dark:text-zinc-500 text-xs">Current Price:</span>
                                    <span class="font-bold text-amber-600 dark:text-[#C5A880] text-sm">₹{{ number_format($auction->current_price) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 dark:text-zinc-500 text-xs">Bids:</span>
                                    <span class="font-bold text-gray-800 dark:text-zinc-200 text-sm">{{ $auction->bids_count }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 dark:text-zinc-500 text-xs">Ends:</span>
                                    <span class="font-bold text-gray-800 dark:text-zinc-200 text-sm">{{ $auction->end_time->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('auctions.show', $auction) }}"
                                   class="w-full inline-flex justify-center items-center py-2 px-4 text-xs font-bold text-white dark:text-black bg-gray-950 dark:bg-[#C5A880] hover:bg-gray-800 dark:hover:bg-[#B3966E] rounded-md transition duration-150">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500 dark:text-zinc-500 bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg">
                        <p class="text-sm font-semibold">No active auctions at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $auctions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>