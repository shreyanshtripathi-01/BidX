<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complete Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @error
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ $message }}
                </div>
            @enderror

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">You won the auction for "{{ $auction->title }}"!</h3>

                <div class="space-y-3 mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Item:</span>
                        <span class="font-medium">{{ $auction->title }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Your Winning Bid:</span>
                        <span class="font-bold text-green-600">₹{{ number_format($winningBid->amount) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Seller:</span>
                        <span>{{ $auction->user->name }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('payments.store', $auction) }}">
                    @csrf

                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-300 rounded text-sm text-yellow-800">
                        <strong>Note:</strong> This is a demo payment. No actual payment will be processed.
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Card Number (Dummy)</label>
                        <input type="text" value="4242 4242 4242 4242" disabled
                               class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expiry (Dummy)</label>
                            <input type="text" value="12/25" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CVC (Dummy)</label>
                            <input type="text" value="123" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-500">
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('auctions.show', $auction) }}"
                           class="flex-1 inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                                class="flex-1 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                            Pay ₹{{ number_format($winningBid->amount) }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>