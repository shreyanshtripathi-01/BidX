@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white overflow-hidden shadow rounded-lg p-5">
        <p class="text-sm text-gray-500 uppercase">Total Users</p>
        <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
    </div>
    <div class="bg-white overflow-hidden shadow rounded-lg p-5">
        <p class="text-sm text-gray-500 uppercase">Total Auctions</p>
        <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['total_auctions'] }}</p>
    </div>
    <div class="bg-white overflow-hidden shadow rounded-lg p-5">
        <p class="text-sm text-gray-500 uppercase">Active Auctions</p>
        <p class="mt-1 text-3xl font-bold text-green-600">{{ $stats['active_auctions'] }}</p>
    </div>
    <div class="bg-white overflow-hidden shadow rounded-lg p-5">
        <p class="text-sm text-gray-500 uppercase">Ended Auctions</p>
        <p class="mt-1 text-3xl font-bold text-gray-600">{{ $stats['ended_auctions'] }}</p>
    </div>
    <div class="bg-white overflow-hidden shadow rounded-lg p-5">
        <p class="text-sm text-gray-500 uppercase">Total Bids</p>
        <p class="mt-1 text-3xl font-bold text-blue-600">{{ $stats['total_bids'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Recent Auctions</h3>
            <div class="space-y-3">
                @forelse($recentAuctions as $auction)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900 truncate max-w-md">{{ $auction->title }}</p>
                            <p class="text-sm text-gray-500">{{ $auction->user->name }} · {{ $auction->bids_count }} bids</p>
                        </div>
                        <span class="text-sm text-gray-500">{{ $auction->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No auctions yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Recent Bids</h3>
            <div class="space-y-3">
                @forelse($recentBids as $bid)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $bid->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $bid->auction->title }}</p>
                        </div>
                        <span class="font-bold text-green-600">${{ number_format($bid->amount, 2) }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No bids yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="mt-8 bg-white overflow-hidden shadow rounded-lg p-6">
    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
    <div class="flex gap-4">
        <a href="{{ route('admin.auctions.create') }}"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
            Create Auction
        </a>
        <a href="{{ route('admin.users') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Manage Users
        </a>
        <a href="{{ route('admin.reports') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            View Reports
        </a>
    </div>
</div>
@endsection