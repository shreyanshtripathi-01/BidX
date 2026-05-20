<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Auctions Management') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">All Live & Ended Lots</h3>
                    <p class="text-xs text-gray-400 dark:text-zinc-550 mt-1">Full control over listing states, bidding activity, and item lifecycles.</p>
                </div>
                <a href="{{ route('admin.auctions.create') }}"
                   class="inline-flex justify-center items-center px-4 py-2.5 text-xs font-bold rounded-md text-white dark:text-black bg-gray-950 dark:bg-[#C5A880] hover:bg-gray-800 dark:hover:bg-[#B3966E] transition duration-150">
                    + Add New Lot
                </a>
            </div>

            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-150 dark:divide-zinc-900">
                        <thead class="bg-gray-50 dark:bg-[#121212]/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Lot Title</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Seller</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Current Value</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Bid Count</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Ends On</th>
                                <th class="px-6 py-3 text-right text-xxs font-bold text-gray-400 dark:text-zinc-550 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-[#121212] divide-y divide-gray-150 dark:divide-zinc-900">
                            @forelse($auctions as $auction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-zinc-200 truncate max-w-xs">{{ $auction->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-zinc-400">{{ $auction->user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-extrabold text-gray-900 dark:text-zinc-200">₹{{ number_format($auction->current_price) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold bg-amber-50 text-amber-850 dark:bg-[#C5A880]/10 dark:text-[#C5A880]">
                                            {{ $auction->bids_count }} bids
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-bold
                                            {{ $auction->status === 'active' ? 'bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-zinc-800/40 dark:text-zinc-400' }}">
                                            {{ ucfirst($auction->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 dark:text-zinc-550">
                                        {{ $auction->end_time->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold space-x-3">
                                        <a href="{{ route('admin.auctions.show', $auction) }}"
                                           class="text-gray-900 dark:text-zinc-300 hover:underline">View</a>

                                        @if($auction->status === 'active')
                                            <form method="POST" action="{{ route('admin.auctions.end', $auction) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 dark:text-green-400 hover:underline">End</button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.auctions.edit', $auction) }}"
                                           class="text-amber-600 dark:text-[#C5A880] hover:underline">Edit</a>

                                        <form method="POST" action="{{ route('admin.auctions.destroy', $auction) }}" class="inline"
                                              onsubmit="return confirm('Are you completely sure you want to delete this lot?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-zinc-550">
                                        No auctions listed yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($auctions->hasPages())
                    <div class="p-6 border-t border-gray-150 dark:border-zinc-900 bg-gray-50 dark:bg-[#121212]/50">
                        {{ $auctions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>