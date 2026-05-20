<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return str_ends_with($this->email, '@bidx.com');
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function watchlist()
    {
        return $this->belongsToMany(Auction::class, 'watchlists')->withTimestamps();
    }

    public function isWatching(Auction $auction): bool
    {
        return $this->watchlist()->where('auction_id', $auction->id)->exists();
    }
}