<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Registered Users</h3>
                    <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">Total registered buyer and seller accounts in the system.</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex justify-center items-center px-4 py-2.5 text-xs font-bold rounded-md text-white dark:text-black bg-gray-950 dark:bg-[#C5A880] hover:bg-gray-800 dark:hover:bg-[#B3966E] transition duration-150">
                    + Add New User
                </a>
            </div>

            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-150 dark:divide-zinc-900">
                        <thead class="bg-gray-50 dark:bg-[#121212]/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Auctions Created</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Bids Submitted</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider">Join Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-[#121212] divide-y divide-gray-150 dark:divide-zinc-900">
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-zinc-200">{{ $user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-zinc-400">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900 dark:text-zinc-200">
                                            {{ $user->auctions_count }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900 dark:text-zinc-200">
                                            {{ $user->bids_count }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 dark:text-zinc-550">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-zinc-550">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="p-6 border-t border-gray-150 dark:border-zinc-900 bg-gray-50 dark:bg-[#121212]/50">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>