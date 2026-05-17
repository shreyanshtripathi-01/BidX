<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bids for') }} {{ $auction->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    @if($bids->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($bids as $bid)
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                                    <div>
                                        <span class="font-medium text-gray-900">{{ $bid->user->name }}</span>
                                        <span class="text-sm text-gray-500 ml-2">{{ $bid->created_at->diffForHumans() }}</span>
                                    </div>
                                    <span class="font-bold text-green-600">${{ number_format($bid->amount, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $bids->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No bids have been placed yet.</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('auctions.show', $auction) }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            ← Back to Auction
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>