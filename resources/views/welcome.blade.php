<x-app-layout>
<div class="relative">
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
                        Start Bidding
                    </button>
                    <button @click="showRegisterModal = true"
                            class="inline-flex justify-center items-center px-6 py-3.5 text-sm font-semibold rounded-md text-gray-700 dark:text-zinc-300 bg-gray-50 dark:bg-[#121212] hover:bg-gray-100 dark:hover:bg-[#1E1E1E] border border-gray-200 dark:border-zinc-800 transition duration-150">
                        Start Selling
                    </button>
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

</div>
</x-app-layout>