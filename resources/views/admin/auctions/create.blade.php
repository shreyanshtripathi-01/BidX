<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Create New Lot') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#0A0A0A]">
        <div class="max-w-2xl mx-auto space-y-6">

            <!-- Back navigation header -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.auctions.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100">Create Live Lot</h3>
                    <p class="text-xs text-gray-400 dark:text-zinc-550">Publish a new lot with starting price, timeframe, and description.</p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden shadow-sm">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.auctions.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div>
                                <x-input-label for="title" :value="__('Lot Title')" />
                                <x-text-input id="title" class="mt-1 block w-full" type="text" name="title" :value="old('title')" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Starting Price -->
                            <div>
                                <x-input-label for="starting_price" :value="__('Starting Price (₹)')" />
                                <x-text-input id="starting_price" class="mt-1 block w-full" type="number" name="starting_price" :value="old('starting_price')" step="0.01" min="0.01" required />
                                <x-input-error :messages="$errors->get('starting_price')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="5"
                                      class="mt-1 block w-full rounded-md border-gray-250 dark:border-zinc-800 bg-white dark:bg-[#181818] text-gray-900 dark:text-zinc-100 shadow-sm focus:border-amber-500 focus:ring-amber-500 @error('description') border-red-500 @enderror"
                                      required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Start Time -->
                            <div>
                                <x-input-label for="start_time" :value="__('Start Time')" />
                                <x-text-input id="start_time" class="mt-1 block w-full" type="datetime-local" name="start_time" :value="old('start_time')" required />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>

                            <!-- End Time -->
                            <div>
                                <x-input-label for="end_time" :value="__('End Time')" />
                                <x-text-input id="end_time" class="mt-1 block w-full" type="datetime-local" name="end_time" :value="old('end_time')" required />
                                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Seller ID -->
                            <div>
                                <x-input-label for="user_id" :value="__('Seller (User ID)')" />
                                <x-text-input id="user_id" class="mt-1 block w-full" type="number" name="user_id" :value="old('user_id', Auth::id())" required />
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>

                            <!-- Image -->
                            <div>
                                <x-input-label for="image" :value="__('Lot Display Image')" />
                                <input type="file" id="image" name="image" accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 dark:text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-gray-100 dark:file:bg-zinc-800 dark:file:text-zinc-200 file:text-gray-700 hover:file:bg-gray-200 dark:hover:file:bg-zinc-750 transition-colors" />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Featured Checkbox -->
                        <div class="flex items-center">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                   class="h-4 w-4 text-amber-600 dark:text-[#C5A880] border-gray-300 dark:border-zinc-800 rounded focus:ring-amber-500 dark:bg-[#181818]" />
                            <label for="is_featured" class="ml-2 block text-sm font-medium text-gray-900 dark:text-zinc-350">
                                {{ __('Promote to Featured section') }}
                            </label>
                        </div>

                        <!-- Buttons -->
                        <div class="pt-6 border-t border-gray-100 dark:border-zinc-900 flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.auctions.index') }}" 
                               class="px-4 py-2 border border-gray-250 dark:border-zinc-800 text-gray-700 dark:text-zinc-300 bg-white dark:bg-transparent hover:bg-gray-50 dark:hover:bg-zinc-900 rounded-md text-xs font-bold transition duration-150">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center items-center px-4 py-2 text-xs font-bold rounded-md text-white dark:text-black bg-gray-950 dark:bg-[#C5A880] hover:bg-gray-800 dark:hover:bg-[#B3966E] transition duration-150">
                                Create Lot
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>