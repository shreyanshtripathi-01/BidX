<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'starting_price',
        'current_price',
        'start_time',
        'end_time',
        'image',
        'status',
        'is_featured',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'starting_price' => 'decimal:2',
        'current_price' => 'decimal:2',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the user who created the auction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all bids for this auction.
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class)->orderBy('amount', 'desc');
    }

    /**
     * Get the highest bid for this auction.
     */
    public function highestBid(): HasMany
    {
        return $this->bids()->limit(1);
    }

    /**
     * Get all notifications for this auction.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get all payments for this auction.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scope a query to only active auctions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('end_time', '>', now());
    }

    /**
     * Scope a query to only ended auctions.
     */
    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    /**
     * Scope a query to featured auctions.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the users who are watching this auction.
     */
    public function watchers()
    {
        return $this->belongsToMany(User::class, 'watchlists')->withTimestamps();
    }

    /**
     * Check if a specific user is currently winning this auction (has the highest bid).
     */
    public function isUserWinning(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        $highestBid = $this->bids()->orderBy('amount', 'desc')->first();
        return $highestBid && $highestBid->user_id === $user->id;
    }
}