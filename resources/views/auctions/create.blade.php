<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Auction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('auctions.store') }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
                @csrf

                <div class="mb-4">
                    <x-input-label for="title" :value="__('Auction Title')" />
                    <x-text-input id="title" class="mt-1 block w-full" type="text" name="title"
                                  :value="old('title')" required autofocus autocomplete="title" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" rows="5"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                              required>{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="starting_price" :value="__('Starting Price ($)')" />
                    <x-text-input id="starting_price" class="mt-1 block w-full" type="number" name="starting_price"
                                  :value="old('starting_price')" step="0.01" min="0.01" required autocomplete="off" />
                    <x-input-error :messages="$errors->get('starting_price')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="start_time" :value="__('Start Time')" />
                    <x-text-input id="start_time" class="mt-1 block w-full" type="datetime-local" name="start_time"
                                  :value="old('start_time')" required />
                    <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="end_time" :value="__('End Time')" />
                    <x-text-input id="end_time" class="mt-1 block w-full" type="datetime-local" name="end_time"
                                  :value="old('end_time')" required />
                    <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="image" :value="__('Item Image (optional)')" />
                    <input type="file" id="image" name="image" accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('auctions.index') }}" class="mr-3 text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                    <x-primary-button>
                        {{ __('Create Auction') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>