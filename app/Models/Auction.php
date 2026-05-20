<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auction extends Model
{
    use HasFactory;

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

    protected $casts = [
        'starting_price' => 'decimal:2',
        'current_price' => 'decimal:2',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class)->orderBy('amount', 'desc');
    }

    public function highestBid(): HasMany
    {
        return $this->bids()->limit(1);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('end_time', '>', now());
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function watchers()
    {
        return $this->belongsToMany(User::class, 'watchlists')->withTimestamps();
    }

    public function isUserWinning(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        $highestBid = $this->bids()->orderBy('amount', 'desc')->first();
        return $highestBid && $highestBid->user_id === $user->id;
    }
}