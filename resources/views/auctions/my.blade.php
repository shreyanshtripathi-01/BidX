<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Auctions') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($auctions as $auction)
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg">
                        <div class="p-6">
                            <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100 truncate">{{ $auction->title }}</h3>
                            <p class="mt-2 text-xs text-gray-500 dark:text-zinc-400 leading-relaxed">{{ $auction->description }}</p>

                            <div class="mt-4 space-y-2 pt-4 border-t border-gray-100 dark:border-zinc-850">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 dark:text-zinc-500 text-xs">Starting Price:</span>
                                    <span class="font-bold text-gray-800 dark:text-zinc-200">₹{{ number_format($auction->starting_price) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 dark:text-zinc-500 text-xs">Current Price:</span>
                                    <span class="font-bold text-amber-600 dark:text-[#C5A880]">₹{{ number_format($auction->current_price) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 dark:text-zinc-500 text-xs">Bids:</span>
                                    <span class="font-semibold text-gray-800 dark:text-zinc-200">{{ $auction->bids_count }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 dark:text-zinc-500 text-xs">Status:</span>
                                    <span class="font-semibold capitalize text-gray-800 dark:text-zinc-200">{{ $auction->status }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 dark:text-zinc-500 text-xs">Ends:</span>
                                    <span class="font-semibold text-gray-800 dark:text-zinc-200">{{ $auction->end_time->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('auctions.show', $auction) }}"
                                   class="flex-1 inline-flex justify-center py-2 px-4 border border-[#C5A880] text-amber-600 dark:text-[#C5A880] rounded-md hover:bg-amber-500/5 text-xs font-bold transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500 dark:text-zinc-500 bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg">
                        <p class="text-sm font-semibold">You haven't listed any collections yet.</p>
                        <a href="{{ route('auctions.create') }}" class="mt-4 inline-block text-amber-600 dark:text-[#C5A880] hover:underline">
                            List your first collection lot →
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $auctions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>