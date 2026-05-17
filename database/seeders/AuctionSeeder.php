<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuctionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Mock Bidders/Sellers
        $usersData = [
            [
                'name' => 'Rajesh Kumar',
                'email' => 'rajesh@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Aisha Sharma',
                'email' => 'aisha@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Amit Patel',
                'email' => 'amit@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Priya Nair',
                'email' => 'priya@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        ];

        $users = [];
        foreach ($usersData as $userData) {
            $users[] = User::updateOrCreate(['email' => $userData['email']], $userData);
        }

        // Default test user
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            $users[] = $testUser;
        }

        // 2. Clear out existing auctions/bids
        Auction::query()->delete();
        Bid::query()->delete();

        // 3. Indian Heritage Collectibles
        $auctionsData = [
            [
                'title' => 'Vintage Royal Enfield Bullet 350 (1982)',
                'description' => 'A meticulously maintained, running condition 1982 Royal Enfield Bullet 350. Features the iconic heavy flywheel, original brass emblems, original registration logbook, and signature hand-painted pinstripes. Fully serviced and ready for the highway.',
                'starting_price' => 120000.00,
                'start_time' => now()->subDays(2),
                'end_time' => now()->addDays(5),
                'status' => 'active',
                'is_featured' => true,
                'image' => null,
            ],
            [
                'title' => 'Rare 1918 King George V One Rupee Silver Coin',
                'description' => 'A pristine historical specimen of the 1918 Silver One Rupee coin from the Bombay Mint. Features the crowned bust of King George V. Excellent lustre with minimal wear, graded Extremely Fine (EF) for serious numismatists.',
                'starting_price' => 15000.00,
                'start_time' => now()->subDay(),
                'end_time' => now()->addDays(3),
                'status' => 'active',
                'is_featured' => true,
                'image' => null,
            ],
            [
                'title' => 'Sachin Tendulkar Signed SG Cricket Bat (2011)',
                'description' => 'An authentic SG Test match-grade English Willow bat, hand-signed by the Master Blaster Sachin Tendulkar during the historic 2011 World Cup tournament campaign. Comes with holographic certificate of authenticity.',
                'starting_price' => 85000.00,
                'start_time' => now()->subDays(3),
                'end_time' => now()->addDays(2),
                'status' => 'active',
                'is_featured' => false,
                'image' => null,
            ],
            [
                'title' => 'Handwoven Pure Zari Banarasi Silk Saree',
                'description' => 'An exquisite handwoven masterpiece from the looms of Varanasi. Made with pure mulberry silk and real silver zari work in traditional Shikargah forest hunting motifs. Passed down through one family generation.',
                'starting_price' => 25000.00,
                'start_time' => now()->subHours(12),
                'end_time' => now()->addHours(36),
                'status' => 'active',
                'is_featured' => false,
                'image' => null,
            ],
            [
                'title' => 'Original Tanjore Gold Foil Lord Ganesha Painting',
                'description' => 'A gorgeous 18" x 24" traditional Tanjore painting of Lord Ganesha seated on a throne. Made by traditional temple artisans in Thanjavur using natural colours, hand-cut glass stones, and real 22-karat gold foil relief work.',
                'starting_price' => 45000.00,
                'start_time' => now()->subDays(5),
                'end_time' => now()->subHour(), // Ended recently
                'status' => 'ended',
                'is_featured' => false,
                'image' => null,
            ],
            [
                'title' => 'Vintage Brass Telescope (British India Era)',
                'description' => 'An antique marine single-draw marine telescope made of solid brass with hand-stitched leather protective grip. Engraved Bombay Marine Works - 1914. Fully functional optics with clear viewing lens.',
                'starting_price' => 12000.00,
                'start_time' => now()->subDays(10),
                'end_time' => now()->addDays(12),
                'status' => 'active',
                'is_featured' => false,
                'image' => null,
            ]
        ];

        // 4. Seed Auctions & corresponding Mock Bids
        foreach ($auctionsData as $index => $auc) {
            $owner = $users[$index % count($users)];
            
            $auction = Auction::create([
                'user_id' => $owner->id,
                'title' => $auc['title'],
                'description' => $auc['description'],
                'starting_price' => $auc['starting_price'],
                'current_price' => $auc['starting_price'],
                'start_time' => $auc['start_time'],
                'end_time' => $auc['end_time'],
                'status' => $auc['status'],
                'is_featured' => $auc['is_featured'],
                'image' => $auc['image'],
            ]);

            // Potential unique bidders (everyone except the owner)
            $potentialBidders = array_filter($users, function($u) use ($owner) {
                return $u->id !== $owner->id;
            });

            shuffle($potentialBidders);

            // Seed 2 to 4 unique bids
            $numBids = rand(2, count($potentialBidders));
            $biddersForAuction = array_slice($potentialBidders, 0, $numBids);

            $bidAmount = $auction->starting_price;
            
            foreach ($biddersForAuction as $b => $bidder) {
                // Increment bid logically in INR increments
                $bidAmount += rand(2000, 15000);

                Bid::create([
                    'auction_id' => $auction->id,
                    'user_id' => $bidder->id,
                    'amount' => $bidAmount,
                    'created_at' => $auction->start_time->addMinutes(($b + 1) * 30),
                ]);
            }

            // Update current price
            if ($numBids > 0) {
                $auction->update(['current_price' => $bidAmount]);
            }

            // End details
            if ($auction->status === 'ended') {
                $winnerBid = $auction->bids()->orderBy('amount', 'desc')->first();
                if ($winnerBid) {
                    Notification::create([
                        'user_id' => $winnerBid->user_id,
                        'type' => 'won',
                        'title' => 'Congratulations, you won!',
                        'message' => 'Congratulations! You won the auction for "' . $auction->title . '" with a bid of ₹' . number_format($winnerBid->amount, 2),
                        'auction_id' => $auction->id,
                        'is_read' => false,
                    ]);
                }
            }
        }
    }
}
