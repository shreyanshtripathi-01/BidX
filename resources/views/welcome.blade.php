<x-app-layout>
<div x-data="{ showLoginModal: false }" @login-modal.window="showLoginModal = true" class="relative">
    <!-- Simple spacious hero -->
    <div class="py-24 bg-white dark:bg-[#0A0A0A] border-b border-gray-150 dark:border-zinc-900">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 dark:text-zinc-100 tracking-tight leading-tight mb-6">
                An Online Auction Platform to List and Bid in Real-Time
            </h1>
            <p class="text-base sm:text-lg text-gray-600 dark:text-zinc-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Create your own auctions, place bids in real-time, and get notified instantly when you win. Our platform makes listing and bidding simple and straightforward.
            </p>
            <div class="flex justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex justify-center items-center px-6 py-3.5 text-sm font-semibold rounded-md text-white bg-gray-900 dark:bg-[#C5A880] dark:text-black hover:bg-gray-800 dark:hover:bg-[#B3966E] shadow-sm transition duration-150">
                        Go to Dashboard
                    </a>
                @else
                    <button @click="showLoginModal = true"
                            class="inline-flex justify-center items-center px-6 py-3.5 text-sm font-semibold rounded-md text-white bg-gray-900 dark:bg-[#C5A880] dark:text-black hover:bg-gray-800 dark:hover:bg-[#B3966E] shadow-sm transition duration-150">
                        Log In
                    </button>
                    <a href="{{ route('register') }}"
                       class="inline-flex justify-center items-center px-6 py-3.5 text-sm font-semibold rounded-md text-gray-700 dark:text-zinc-300 bg-gray-50 dark:bg-[#121212] hover:bg-gray-100 dark:hover:bg-[#1E1E1E] border border-gray-200 dark:border-zinc-800 transition duration-150">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Overview / About the platform -->
    <div id="about-platform" class="py-20 bg-gray-50/50 dark:bg-[#0C0C0C] border-b border-gray-150 dark:border-zinc-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-zinc-100 tracking-tight">
                        A Simple and Secure Way to Buy and Sell
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-zinc-400 leading-relaxed">
                        We believe that online buying and selling should be clean and straightforward. Traditional auction sites are often complicated, full of fake listings, and hard to navigate.
                    </p>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-zinc-400 leading-relaxed">
                        Our website is designed from scratch to connect real buyers and sellers. Anyone can quickly list an item for sale or start placing bids, with clear real-time updates.
                    </p>
                </div>
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-8 rounded-lg shadow-none">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-100 mb-4">Popular Categories</h3>
                    <ul class="space-y-4 text-sm text-gray-600 dark:text-zinc-400">
                        <li class="flex items-start">
                            <span class="text-[#C5A880] mr-2">✦</span>
                            <span><strong>Collectible Coins:</strong> Old and rare coins, historical currency, and unique metal tokens.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-[#C5A880] mr-2">✦</span>
                            <span><strong>Vintage & Classic Cars:</strong> Retro vehicles, auto collectibles, and classic car parts.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-[#C5A880] mr-2">✦</span>
                            <span><strong>Art & Handcrafted Items:</strong> Unique paintings, handmade textiles, and custom home decor.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- The 3-Step Flow -->
    <div class="py-20 bg-white dark:bg-[#0A0A0A] border-b border-gray-150 dark:border-zinc-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-16">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-zinc-100 tracking-tight">
                    How it Works
                </h2>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-2">
                    A simple three-step process to list items, place bids, and complete your purchase.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="bg-gray-50 dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-8 rounded-lg">
                    <p class="text-xs font-bold text-[#C5A880] tracking-wider uppercase mb-3">Step 1</p>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-100 mb-3">Item Listings</h3>
                    <p class="text-sm text-gray-600 dark:text-zinc-400 leading-relaxed">
                        Sellers can easily create an auction listing. Upload a photo, write a description, and set a starting price.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-gray-50 dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-8 rounded-lg">
                    <p class="text-xs font-bold text-[#C5A880] tracking-wider uppercase mb-3">Step 2</p>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-100 mb-3">Real-Time Bidding</h3>
                    <p class="text-sm text-gray-600 dark:text-zinc-400 leading-relaxed">
                        Buyers place bids in Indian Rupees (₹). Every bid is processed instantly in real-time so everyone has a fair chance.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-gray-50 dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-8 rounded-lg">
                    <p class="text-xs font-bold text-[#C5A880] tracking-wider uppercase mb-3">Step 3</p>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-100 mb-3">Win and Receive</h3>
                    <p class="text-sm text-gray-600 dark:text-zinc-400 leading-relaxed">
                        When the auction time runs out, the highest bidder wins. The winner gets an instant notification and can complete the payment.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Auctions Catalog -->
    <div id="catalog-glimpse" class="py-20 bg-gray-50/50 dark:bg-[#0C0C0C]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-zinc-100 tracking-tight">Active Auctions</h2>
                    <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">Browse through the active items currently open for bidding.</p>
                </div>
                <a href="{{ route('auctions.index') }}" class="text-sm font-semibold text-gray-700 dark:text-[#C5A880] hover:underline">
                    View All Auctions →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $featuredAuctions = \App\Models\Auction::active()->take(3)->get();
                @endphp

                @forelse($featuredAuctions as $auction)
                    <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-2.5 py-0.5 text-xxs font-bold uppercase tracking-wider bg-amber-50 text-amber-800 dark:bg-[#C5A880]/10 dark:text-[#C5A880] rounded-full">
                                    Active Auction
                                </span>
                                <span class="text-xxs text-gray-400 dark:text-zinc-550">
                                    {{ $auction->end_time->diffForHumans() }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-gray-900 dark:text-zinc-100 mb-2">
                                {{ $auction->title }}
                            </h3>
                            
                            <p class="text-xs text-gray-500 dark:text-zinc-400 leading-relaxed mb-6">
                                {{ $auction->description }}
                            </p>

                            <div class="pt-4 border-t border-gray-100 dark:border-zinc-800 flex items-center justify-between">
                                <div>
                                    <p class="text-xxs text-gray-400 dark:text-zinc-550 uppercase tracking-wider font-semibold">Current Bid</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-zinc-100">₹{{ number_format($auction->current_price) }}</p>
                                </div>
                                <a href="{{ route('auctions.show', $auction) }}" 
                                   class="inline-flex justify-center items-center px-4 py-2 text-xs font-bold text-white bg-gray-900 dark:bg-[#C5A880] dark:text-black hover:bg-gray-800 dark:hover:bg-[#B3966E] rounded-md transition duration-150">
                                    Place Bid
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 rounded-lg p-12 text-center text-gray-500 dark:text-zinc-400">
                        <p class="text-sm font-semibold text-gray-800 dark:text-zinc-200">No active auctions at the moment.</p>
                        <p class="text-xs text-gray-400 dark:text-zinc-550 mt-1">Please check back later or log in to create your own auction!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Simple, human footer -->
    <footer class="py-12 bg-white dark:bg-[#121212] border-t border-gray-150 dark:border-zinc-900 mt-20 text-center">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-4">
            <div class="flex justify-center items-center gap-2">
                <span class="text-sm font-bold text-gray-900 dark:text-zinc-100">BidX</span>
                <span class="text-xs text-gray-400 dark:text-zinc-500">•</span>
                <span class="text-xs text-gray-500 dark:text-zinc-405">Simple Online Auctions</span>
            </div>
            <p class="text-xs text-gray-400 dark:text-zinc-500 max-w-md mx-auto leading-relaxed">
                An online auction platform where users can list and bid on items in real-time. Easily create auctions, place bids, and receive notifications when you win.
            </p>
            <div class="text-xxs text-gray-450 dark:text-zinc-600 pt-2">
                &copy; {{ date('Y') }} BidX Platform. Handcrafted for real-time bidding.
            </div>
        </div>
    </footer>

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
                        <span class="ms-2 text-xs text-gray-500 dark:text-zinc-450">{{ __('Remember me') }}</span>
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
                <a href="{{ route('register') }}" class="text-xs font-semibold text-amber-600 dark:text-[#C5A880] hover:underline">
                    New to BidX? Create an Account
                </a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>