<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-zinc-100 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">


            @if($notifications->isNotEmpty())
                <div class="space-y-4">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-100">Recent Activity</h3>
                        <form method="POST" action="{{ route('notifications.readAll') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-[#C5A880] hover:text-[#B3966E] transition duration-150">
                                Mark all as read
                            </button>
                        </form>
                    </div>

                    @foreach($notifications as $notification)
                        <div class="bg-white dark:bg-[#121212] border {{ !$notification->is_read ? 'border-[#C5A880] dark:border-[#C5A880]/50' : 'border-gray-200 dark:border-zinc-800' }} rounded-xl p-5 shadow-sm relative overflow-hidden transition-all hover:shadow-md">
                            @if(!$notification->is_read)
                                <div class="absolute top-0 left-0 w-1.5 h-full bg-[#C5A880]"></div>
                            @endif
                            <div class="flex justify-between items-start pl-2">
                                <div class="flex-1">
                                    <h4 class="font-bold {{ !$notification->is_read ? 'text-gray-900 dark:text-zinc-100' : 'text-gray-700 dark:text-zinc-300' }}">
                                        {{ $notification->title }}
                                    </h4>
                                    <p class="mt-1.5 text-sm text-gray-600 dark:text-zinc-400 leading-relaxed">{{ $notification->message }}</p>
                                    <p class="mt-2 text-xs font-medium text-gray-500 dark:text-zinc-500 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <div class="flex flex-col items-end gap-3 ml-4">
                                    @if(!$notification->is_read)
                                        <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 text-xs font-bold bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-zinc-300 rounded-md hover:bg-gray-200 dark:hover:bg-zinc-700 transition duration-150">
                                                Mark read
                                            </button>
                                        </form>
                                    @endif

                                    @if($notification->auction_id)
                                        <a href="{{ route('auctions.show', $notification->auction_id) }}"
                                           class="px-3 py-1.5 text-xs font-bold bg-gray-950 dark:bg-[#C5A880] text-white dark:text-black rounded-md hover:bg-gray-800 dark:hover:bg-[#B3966E] transition duration-150">
                                            View Auction
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-xl">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 dark:bg-zinc-900 mb-4">
                        <svg class="w-8 h-8 text-gray-400 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <p class="text-lg font-bold text-gray-900 dark:text-zinc-100">No notifications yet</p>
                    <p class="text-sm text-gray-500 dark:text-zinc-500 mt-2">When you bid or win an auction, you'll be notified here.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>