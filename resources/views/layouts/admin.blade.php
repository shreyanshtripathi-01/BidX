<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

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
        <div class="min-h-screen bg-gray-50 dark:bg-[#0A0A0A]">
            <!-- Admin Sidebar -->
            <div class="flex">
                <aside class="w-64 bg-white dark:bg-[#121212] border-r border-gray-150 dark:border-zinc-900 min-h-screen fixed left-0 top-0">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-8">Admin Panel</h2>
                        <nav class="space-y-2">
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-4 py-2 rounded-md text-sm font-medium
                                       {{ request()->routeIs('admin.dashboard') ? 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-[#C5A880]' : 'text-gray-600 dark:text-zinc-400 hover:bg-gray-100 dark:hover:bg-[#1A1A1A]' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"></path>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.auctions.index') }}"
                               class="flex items-center px-4 py-2 rounded-md text-sm font-medium
                                      {{ request()->routeIs('admin.auctions*') ? 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-[#C5A880]' : 'text-gray-600 dark:text-zinc-400 hover:bg-gray-100 dark:hover:bg-[#1A1A1A]' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Auctions
                            </a>
                            <a href="{{ route('admin.users') }}"
                               class="flex items-center px-4 py-2 rounded-md text-sm font-medium
                                      {{ request()->routeIs('admin.users') ? 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-[#C5A880]' : 'text-gray-600 dark:text-zinc-400 hover:bg-gray-100 dark:hover:bg-[#1A1A1A]' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Users
                            </a>
                            <a href="{{ route('admin.reports') }}"
                               class="flex items-center px-4 py-2 rounded-md text-sm font-medium
                                      {{ request()->routeIs('admin.reports') ? 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-[#C5A880]' : 'text-gray-600 dark:text-zinc-400 hover:bg-gray-100 dark:hover:bg-[#1A1A1A]' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Reports
                            </a>
                            <hr class="my-4 border-gray-100 dark:border-zinc-800">
                            <a href="{{ route('auctions.index') }}"
                               class="flex items-center px-4 py-2 rounded-md text-sm font-medium text-gray-600 dark:text-zinc-400 hover:bg-gray-100 dark:hover:bg-[#1A1A1A]">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Site
                            </a>
                        </nav>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="ml-64 flex-1 p-8">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>