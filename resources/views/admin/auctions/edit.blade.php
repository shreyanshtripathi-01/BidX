@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Auction</h1>

<form method="POST" action="{{ route('admin.auctions.update', $auction) }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="title" :value="__('Auction Title')" />
            <x-text-input id="title" class="mt-1 block w-full" type="text" name="title"
                          :value="old('title', $auction->title)" required autofocus />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="starting_price" :value="__('Starting Price ($)')" />
            <x-text-input id="starting_price" class="mt-1 block w-full" type="number" name="starting_price"
                          :value="old('starting_price', $auction->starting_price)" step="0.01" min="0.01" required />
            <x-input-error :messages="$errors->get('starting_price')" class="mt-2" />
        </div>
    </div>

    <div class="mt-4">
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description" rows="5"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                  required>{{ old('description', $auction->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <x-input-label for="start_time" :value="__('Start Time')" />
            <x-text-input id="start_time" class="mt-1 block w-full" type="datetime-local" name="start_time"
                          :value="old('start_time', $auction->start_time->format('Y-m-d\TH:i'))" required />
            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="end_time" :value="__('End Time')" />
            <x-text-input id="end_time" class="mt-1 block w-full" type="datetime-local" name="end_time"
                          :value="old('end_time', $auction->end_time->format('Y-m-d\TH:i'))" required />
            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="active" {{ $auction->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="ended" {{ $auction->status === 'ended' ? 'selected' : '' }}>Ended</option>
                <option value="cancelled" {{ $auction->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Item Image')" />
            <input type="file" id="image" name="image" accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
            @if($auction->image)
                <p class="mt-2 text-xs text-gray-500">Current image: {{ basename($auction->image) }}</p>
            @endif
        </div>
    </div>

    <div class="mt-4 flex items-center">
        <input type="checkbox" id="is_featured" name="is_featured" value="1"
               {{ $auction->is_featured ? 'checked' : '' }}
               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
            {{ __('Featured Auction') }}
        </label>
    </div>

    <div class="flex items-center justify-end mt-6">
        <a href="{{ route('admin.auctions.index') }}" class="mr-3 text-sm text-gray-500 hover:text-gray-700">Cancel</a>
        <x-primary-button>{{ __('Update Auction') }}</x-primary-button>
    </div>
</form>
@endsection