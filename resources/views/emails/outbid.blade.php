<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { color: #dc3545; font-size: 20px; font-weight: bold; }
        .content { margin-top: 15px; line-height: 1.6; }
        .auction-link { color: #007bff; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">⚠️ You've Been Outbid!</div>
        <div class="content">
            <p>Hello,</p>
            <p><strong>{{ $outbidderName }}</strong> has placed a higher bid on the auction <strong>"{{ $auction->title }}"</strong>.</p>
            <p>The current highest bid is now <strong>${{ number_format($auction->current_price, 2) }}</strong>.</p>
            <p>
                <a href="{{ url('/auctions/' . $auction->id) }}" class="auction-link">View and Bid on This Auction →</a>
            </p>
            <p>Good luck!</p>
        </div>
    </div>
</body>
</html>