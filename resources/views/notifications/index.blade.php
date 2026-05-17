<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if($notifications->isNotEmpty())
                <div class="space-y-3">
                    @foreach($notifications as $notification)
                        <div class="bg-white shadow rounded-lg p-4 border-l-4
                            {{ !$notification->is_read ? 'border-blue-500' : 'border-gray-200' }}
                            {{ !$notification->is_read ? 'bg-blue-50' : '' }}">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $notification->title }}</h4>
                                    <p class="mt-1 text-sm text-gray-600">{{ $notification->message }}</p>
                                    <p class="mt-1 text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>

                                @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                        @csrf
                                        <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 underline">
                                            Mark as read
                                        </button>
                                    </form>
                                @endif
                            </div>

                            @if($notification->auction_id)
                                <div class="mt-3">
                                    <a href="{{ route('auctions.show', $notification->auction) }}"
                                       class="text-sm text-blue-600 hover:text-blue-800 underline">
                                        View Auction →
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-between items-center">
                    {{ $notifications->links() }}

                    @if($notifications->count() > 0)
                        <form method="POST" action="{{ route('notifications.readAll') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-800 underline">
                                Mark all as read
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <p>No notifications yet.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>