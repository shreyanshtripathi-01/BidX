<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Theme Initialization script to avoid visual shifts -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-[#0A0A0A] dark:text-[#E5E5E5] transition-colors duration-200">
        <div x-data="{ showLoginModal: false, showRegisterModal: false }" 
             @login-modal.window="showLoginModal = true; showRegisterModal = false" 
             @register-modal.window="showRegisterModal = true; showLoginModal = false" 
             class="min-h-screen bg-gray-50 dark:bg-[#0A0A0A]">
            
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-[#121212] border-b border-gray-150 dark:border-zinc-900">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-md border border-green-200 bg-green-50 text-sm font-semibold text-green-850 dark:bg-green-950/20 dark:border-green-900/50 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-md border border-red-200 bg-red-50 text-sm font-semibold text-red-850 dark:bg-red-950/20 dark:border-red-900/50 dark:text-red-400">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </main>

            @guest
                <!-- Beautiful, blurred-background Login Modal -->
                <div x-show="showLoginModal" 
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     style="display: none;">
                    
                    <!-- Blurred backdrop -->
                    <div class="fixed inset-0 bg-black/60 backdrop-blur-md transition-opacity" @click="showLoginModal = false"></div>

                    <!-- Modal content card -->
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg shadow-2xl w-full max-w-md p-8 relative z-10 transform transition-all"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        
                        <!-- Close button -->
                        <button @click="showLoginModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-650 dark:hover:text-zinc-300 text-2xl leading-none">
                            &times;
                        </button>

                        <!-- Logo & Title -->
                        <div class="text-center mb-6">
                            <div class="inline-block mb-4">
                                <x-application-logo class="w-24 h-auto text-gray-900 dark:text-zinc-150" />
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-zinc-100">
                                Log In to BidX
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">
                                Enter your credentials to manage listings and bid.
                            </p>
                        </div>

                        <!-- Login Form inside Modal -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf

                            <!-- Email Address -->
                            <div class="space-y-1">
                                <x-input-label for="modal_email" :value="__('Email')" class="text-xs font-semibold text-gray-600 dark:text-zinc-400" />
                                <x-text-input id="modal_email" class="block w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            </div>

                            <!-- Password -->
                            <div class="space-y-1">
                                <x-input-label for="modal_password" :value="__('Password')" class="text-xs font-semibold text-gray-600 dark:text-zinc-400" />
                                <x-text-input id="modal_password" class="block w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm"
                                                type="password"
                                                name="password"
                                                required autocomplete="current-password" />
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center justify-between pt-1">
                                <label for="modal_remember_me" class="inline-flex items-center">
                                    <input id="modal_remember_me" type="checkbox" class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500" name="remember">
                                    <span class="ms-2 text-xs text-gray-500 dark:text-zinc-455">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button type="submit" class="w-full inline-flex justify-center items-center py-2.5 px-4 text-xs font-bold text-white bg-gray-900 dark:bg-[#C5A880] dark:text-black hover:bg-gray-800 dark:hover:bg-[#B3966E] rounded-md shadow-sm transition duration-150">
                                    {{ __('Log In') }}
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center pt-4 mt-4 border-t border-gray-100 dark:border-zinc-900">
                            <button @click="showLoginModal = false; showRegisterModal = true" class="text-xs font-semibold text-amber-600 dark:text-[#C5A880] hover:underline">
                                New to BidX? Create an Account
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Beautiful, blurred-background Register Modal -->
                <div x-show="showRegisterModal" 
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     style="display: none;">
                    
                    <!-- Blurred backdrop -->
                    <div class="fixed inset-0 bg-black/60 backdrop-blur-md transition-opacity" @click="showRegisterModal = false"></div>

                    <!-- Modal content card -->
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg shadow-2xl w-full max-w-md p-8 relative z-10 transform transition-all"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        
                        <!-- Close button -->
                        <button @click="showRegisterModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-650 dark:hover:text-zinc-300 text-2xl leading-none">
                            &times;
                        </button>

                        <!-- Logo & Title -->
                        <div class="text-center mb-6">
                            <div class="inline-block mb-4">
                                <x-application-logo class="w-24 h-auto text-gray-900 dark:text-zinc-150" />
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-zinc-100">
                                Create an Account
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">
                                Sign up to start listing and bidding in real-time.
                            </p>
                        </div>

                        <!-- Register Form inside Modal -->
                        <form method="POST" action="{{ route('register') }}" class="space-y-4">
                            @csrf

                            <!-- Name -->
                            <div class="space-y-1">
                                <x-input-label for="modal_name" :value="__('Name')" class="text-xs font-semibold text-gray-600 dark:text-zinc-400" />
                                <x-text-input id="modal_name" class="block w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            </div>

                            <!-- Email Address -->
                            <div class="space-y-1">
                                <x-input-label for="modal_reg_email" :value="__('Email')" class="text-xs font-semibold text-gray-600 dark:text-zinc-400" />
                                <x-text-input id="modal_reg_email" class="block w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            </div>

                            <!-- Password -->
                            <div class="space-y-1">
                                <x-input-label for="modal_reg_password" :value="__('Password')" class="text-xs font-semibold text-gray-600 dark:text-zinc-400" />
                                <x-text-input id="modal_reg_password" class="block w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm"
                                                type="password"
                                                name="password"
                                                required autocomplete="new-password" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-1">
                                <x-input-label for="modal_password_confirmation" :value="__('Confirm Password')" class="text-xs font-semibold text-gray-600 dark:text-zinc-400" />
                                <x-text-input id="modal_password_confirmation" class="block w-full px-4 py-2 border border-gray-300 dark:border-zinc-800 bg-white dark:bg-[#0A0A0A] text-gray-900 dark:text-[#E5E5E5] rounded-md focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm"
                                                type="password"
                                                name="password_confirmation" required autocomplete="new-password" />
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button type="submit" class="w-full inline-flex justify-center items-center py-2.5 px-4 text-xs font-bold text-white bg-gray-900 dark:bg-[#C5A880] dark:text-black hover:bg-gray-800 dark:hover:bg-[#B3966E] rounded-md shadow-sm transition duration-150">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center pt-4 mt-4 border-t border-gray-100 dark:border-zinc-900">
                            <button @click="showRegisterModal = false; showLoginModal = true" class="text-xs font-semibold text-amber-600 dark:text-[#C5A880] hover:underline">
                                Already have an account? Log In
                            </button>
                        </div>
                    </div>
                </div>
            @endguest
        </div>
    </body>
</html>