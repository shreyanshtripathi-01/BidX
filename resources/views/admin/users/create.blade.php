<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Add New User') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A]">
        <div class="max-w-2xl mx-auto space-y-6">

            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.users') }}" class="text-gray-500 hover:text-gray-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Add System User</h3>
                    <p class="text-xs text-gray-400 dark:text-zinc-550">Create a verified user or administrator account.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>

                        <div class="pt-6 border-t border-gray-100 dark:border-zinc-900 flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.users') }}" 
                               class="px-4 py-2 border border-gray-250 dark:border-zinc-800 text-gray-700 dark:text-zinc-300 bg-white dark:bg-transparent hover:bg-gray-50 dark:hover:bg-zinc-900 rounded-md text-xs font-bold transition duration-150">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center items-center px-4 py-2 text-xs font-bold rounded-md text-white dark:text-black bg-gray-950 dark:bg-[#C5A880] hover:bg-gray-800 dark:hover:bg-[#B3966E] transition duration-150">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
