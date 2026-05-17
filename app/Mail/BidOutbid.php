<?php

namespace App\Mail;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidOutbid extends Mailable
{
    use Queueable, SerializesModels;

    public Auction $auction;
    public string $outbidderName;

    public function __construct(Auction $auction, string $outbidderName)
    {
        $this->auction = $auction;
        $this->outbidderName = $outbidderName;
    }

    public function build()
    {
        return $this->subject('You have been outbid!')
            ->view('emails.outbid')
            ->with([
                'auction' => $this->auction,
                'outbidderName' => $this->outbidderName,
            ]);
    }
}