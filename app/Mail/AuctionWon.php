<?php

namespace App\Mail;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionWon extends Mailable
{
    use Queueable, SerializesModels;

    public Auction $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function build()
    {
        return $this->subject('Congratulations, you won the auction!')
            ->view('emails.won')
            ->with([
                'auction' => $this->auction,
            ]);
    }
}