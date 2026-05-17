<x-app-layout>
    <!-- Premium spacious hero -->
    <div class="py-24 bg-white dark:bg-[#0A0A0A] border-b border-gray-150 dark:border-zinc-900">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 dark:text-zinc-100 tracking-tight leading-tight mb-6">
                Preserving India's Cultural Legacy & Curated History
            </h1>
            <p class="text-base sm:text-lg text-gray-600 dark:text-zinc-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Welcome to a private, highly authenticated space for passionate historians and collectors. We offer direct access to verified physical artifacts, rare numismatics, estate collectibles, and legacy heirlooms.
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex justify-center items-center px-6 py-3.5 text-sm font-semibold rounded-md text-white bg-gray-900 dark:bg-[#C5A880] dark:text-black hover:bg-gray-800 dark:hover:bg-[#B3966E] shadow-sm transition duration-150">
                    Enter Member Dashboard
                </a>
                <a href="#about-platform"
                   class="inline-flex justify-center items-center px-6 py-3.5 text-sm font-semibold rounded-md text-gray-700 dark:text-zinc-300 bg-gray-50 dark:bg-[#121212] hover:bg-gray-100 dark:hover:bg-[#1E1E1E] border border-gray-200 dark:border-zinc-800 transition duration-150">
                    Our Philosophy
                </a>
            </div>
        </div>
    </div>

    <!-- Overview / About the platform -->
    <div id="about-platform" class="py-20 bg-gray-50/50 dark:bg-[#0C0C0C] border-b border-gray-150 dark:border-zinc-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-zinc-100 tracking-tight">
                        A Private Club For History & Preservation
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-zinc-400 leading-relaxed">
                        We believe that historic artifacts are not merely commodities—they are physical anchors to our past. Traditional marketplaces are flooded with replicas, unverified valuations, and automated AI cataloging that destroys the sacred story behind human legacy.
                    </p>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-zinc-400 leading-relaxed">
                        Our platform is designed by hand to reconnect discerning Indian collectors with authentic heirloom lots. Every single item listed here undergoes a rigorous provenance trace and professional vetting before ever being scheduled for public bidding.
                    </p>
                </div>
                <div class="bg-white dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-8 rounded-lg shadow-none">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-100 mb-4">What We Specialize In</h3>
                    <ul class="space-y-4 text-sm text-gray-600 dark:text-zinc-400">
                        <li class="flex items-start">
                            <span class="text-[#C5A880] mr-2">✦</span>
                            <span><strong>Ancient Indian Coinage & Numismatics:</strong> Authenticated silver, gold, and copper currencies spanning centuries of royal dynasties and colonial history.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-[#C5A880] mr-2">✦</span>
                            <span><strong>Vintage Automobilia & Restoration:</strong> Relics of vintage transportation, high-value classic vehicles, and genuine period parts with full running credentials.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-[#C5A880] mr-2">✦</span>
                            <span><strong>Royal Textiles, Textiles & Fine Art:</strong> Handwoven silk sarees, certified temple paintings, and historical estate decor preserved in immaculate archival condition.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- The 3-Step Collectors' Acquisition Flow -->
    <div class="py-20 bg-white dark:bg-[#0A0A0A] border-b border-gray-150 dark:border-zinc-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-16">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-zinc-100 tracking-tight">
                    The Acquisition Flow
                </h2>
                <p class="text-sm text-gray-500 dark:text-zinc-400 mt-2">
                    How high-value items are verified, open for competitive bidding, and securely delivered.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="bg-gray-50 dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-8 rounded-lg">
                    <p class="text-xs font-bold text-[#C5A880] tracking-wider uppercase mb-3">Phase I</p>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-100 mb-3">Physical Vetting</h3>
                    <p class="text-sm text-gray-600 dark:text-zinc-400 leading-relaxed">
                        We physically secure and inventory every single listing. Experts review physical attributes, metallic composition, and historical records to certify authentic origin.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-gray-50 dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-8 rounded-lg">
                    <p class="text-xs font-bold text-[#C5A880] tracking-wider uppercase mb-3">Phase II</p>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-100 mb-3">Transparent Bidding</h3>
                    <p class="text-sm text-gray-600 dark:text-zinc-400 leading-relaxed">
                        Registered users bid securely in Indian Rupees (₹) with integer step validation. Dynamic bid histories are refreshed instantly to provide an absolute equal playing field.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-gray-50 dark:bg-[#121212] border border-gray-150 dark:border-zinc-900 p-8 rounded-lg">
                    <p class="text-xs font-bold text-[#C5A880] tracking-wider uppercase mb-3">Phase III</p>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-zinc-100 mb-3">White-Glove Delivery</h3>
                    <p class="text-sm text-gray-600 dark:text-zinc-400 leading-relaxed">
                        Upon closure, secure digital invoices are compiled instantly. Artifacts are safely stored in climate-controlled facilities before armored transit is arranged directly to you.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Glimpse Catalog -->
    <div id="catalog-glimpse" class="py-20 bg-gray-50/50 dark:bg-[#0C0C0C]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-zinc-100 tracking-tight">Active Collections</h2>
                    <p class="text-xs text-gray-500 dark:text-zinc-400 mt-1">A live glimpse of historic lots currently open for public bidding.</p>
                </div>
                <a href="{{ route('auctions.index') }}" class="text-sm font-semibold text-gray-700 dark:text-[#C5A880] hover:underline">
                    View Live Catalog →
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
                                    Historic Lot
                                </span>
                                <span class="text-xxs text-gray-400 dark:text-zinc-500">
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
                                    <p class="text-xxs text-gray-400 dark:text-zinc-500 uppercase tracking-wider font-semibold">Standing Bid</p>
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
                        <p class="text-sm font-semibold text-gray-800 dark:text-zinc-200">No active curated lots</p>
                        <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">Please check back later or enter the dashboard for updates.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>