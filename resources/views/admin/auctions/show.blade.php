@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Auction Details</h1>

<div class="bg-white overflow-hidden shadow rounded-lg mb-6">
    <div class="p-6">
        <div class="flex justify-between items-start mb-4">
            <h1 class="text-2xl font-bold text-gray-900">{{ $auction->title }}</h1>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                {{ $auction->status === 'active' ? 'bg-green-100 text-green-800' : ($auction->status === 'ended' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst($auction->status) }}
            </span>
        </div>

        <p class="text-gray-700 mb-4">{{ $auction->description }}</p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
            <div>
                <p class="text-xs text-gray-500 uppercase">Seller</p>
                <p class="text-lg font-semibold">{{ $auction->user->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Starting Price</p>
                <p class="text-lg font-semibold">${{ number_format($auction->starting_price, 2) }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Current Price</p>
                <p class="text-lg font-semibold text-blue-600">${{ number_format($auction->current_price, 2) }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Total Bids</p>
                <p class="text-lg font-semibold">{{ $auction->bids_count }}</p>
            </div>
        </div>

        @if($auction->image)
            <img src="{{ asset('storage/' . $auction->image) }}"
                 alt="{{ $auction->title }}"
                 class="w-full max-h-96 object-cover rounded-lg mb-4">
        @endif
    </div>
</div>

<div class="bg-white overflow-hidden shadow rounded-lg mb-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold mb-4">All Bids</h3>
        @if($auction->bids->isNotEmpty())
            <div class="space-y-3">
                @foreach($auction->bids as $bid)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div>
                            <span class="font-medium text-gray-900">{{ $bid->user->name }}</span>
                            <span class="text-sm text-gray-500 ml-2">{{ $bid->created_at->diffForHumans() }}</span>
                        </div>
                        <span class="font-bold text-green-600">${{ number_format($bid->amount, 2) }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No bids yet.</p>
        @endif
    </div>
</div>

@if($auction->status === 'ended')
    @php
        $winner = $auction->bids()->orderBy('amount', 'desc')->first();
    @endphp
    @if($winner)
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-green-800">🏆 Winner</h3>
            <p class="text-green-700 mt-2">{{ $winner->user->name }} won with <strong>${{ number_format($winner->amount, 2) }}</strong></p>
        </div>
    @endif
@endif

<a href="{{ route('admin.auctions.index') }}"
   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
    Back to List
</a>
@endsection