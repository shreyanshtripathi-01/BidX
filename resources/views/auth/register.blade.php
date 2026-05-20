<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Register - BidX') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-[#0A0A0A]">
    <div class="min-h-screen flex flex-col md:flex-row">

        <div class="hidden md:flex md:w-1/2 bg-[#FAF8F4] dark:bg-[#0E0E0D] border-r border-gray-150 dark:border-zinc-900 flex-col justify-center p-16">
            <div class="space-y-6 max-w-md">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-[#C5A880]">Real-Time Auction Platform</span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-zinc-100 tracking-tight leading-tight">
                    Join BidX today
                </h1>
                <p class="text-sm text-gray-550 dark:text-zinc-400 leading-relaxed">
                    An online auction platform built for listing and bidding on items in real-time. Create auctions, place bids, and receive instant notifications when you win.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-20 bg-white dark:bg-[#0A0A0A]">
            <div class="w-full max-w-md space-y-8">

                <div class="flex justify-between items-center">
                    <a href="/" class="inline-flex items-center text-xs font-bold text-gray-400 dark:text-zinc-500 hover:text-gray-900 dark:hover:text-zinc-200 transition-colors">
                        ← Back to Home
                    </a>
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="text-xs font-bold text-amber-600 dark:text-[#C5A880] hover:underline">
                            Already Registered? Log In
                        </a>
                    @endif
                </div>

                <div class="pt-4">
                    <x-application-logo class="w-32 h-auto text-gray-900 dark:text-zinc-150" />
                    <h2 class="text-xl font-bold text-gray-900 dark:text-zinc-100 mt-6">
                        Create your Account
                    </h2>
                    <p class="text-xs text-gray-450 dark:text-zinc-550 mt-1">
                        Sign up to start listing auctions and placing real-time bids.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div class="space-y-1">
                        <x-input-label for="name" :value="__('Name')" class="text-xs font-semibold text-gray-600 dark:text-zinc-400" />
                        <x-text-input id="name" class="block w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-500" />
                    </div>

                    <div class="space-y-1">
                        <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold text-gray-600 dark:text-zinc-400" />
                        <x-text-input id="email" class="block w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500" />
                    </div>

                    <div class="space-y-1">
                        <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold text-gray-600 dark:text-zinc-400" />
                        <x-text-input id="password" class="block w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
                    </div>

                    <div class="space-y-1">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-semibold text-gray-600 dark:text-zinc-400" />
                        <x-text-input id="password_confirmation" class="block w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-500" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex justify-center items-center py-3 px-6 text-sm font-bold text-white bg-gray-950 dark:bg-[#C5A880] dark:text-black hover:bg-gray-800 dark:hover:bg-[#B3966E] rounded-md shadow-sm transition duration-150">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>

                <div class="md:hidden text-center pt-4 border-t border-gray-100 dark:border-zinc-900">
                    <p class="text-xxs text-gray-400 dark:text-zinc-500">
                        &copy; {{ date('Y') }} BidX Platform. Handcrafted for transparent bidding.
                    </p>
                </div>

            </div>
        </div>

    </div>
</body>
</html>
