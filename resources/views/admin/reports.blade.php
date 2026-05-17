@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Reports & Analytics</h1>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white overflow-hidden shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Top Auctions by Bids</h3>
        <div class="space-y-3">
            @forelse($topAuctions as $auction)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900 truncate">{{ $auction->title }}</p>
                        <p class="text-sm text-gray-500">{{ $auction->user->name }}</p>
                    </div>
                    <span class="font-bold text-blue-600">{{ $auction->bids_count }} bids</span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No data available.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Platform Overview</h3>
        <div class="space-y-4">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Users</span>
                <span class="font-semibold">{{ $stats['total_users'] ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Total Auctions</span>
                <span class="font-semibold">{{ $stats['total_auctions'] ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Total Bids</span>
                <span class="font-semibold">{{ $stats['total_bids'] ?? 'N/A' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection