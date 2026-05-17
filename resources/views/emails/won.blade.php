<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { color: #28a745; font-size: 20px; font-weight: bold; }
        .content { margin-top: 15px; line-height: 1.6; }
        .auction-link { color: #007bff; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">🎉 Congratulations, You Won!</div>
        <div class="content">
            <p>Hello,</p>
            <p>Congratulations! You won the auction for <strong>"{{ $auction->title }}"</strong> with a winning bid of <strong>${{ number_format($auction->current_price, 2) }}</strong>.</p>
            <p>Visit your auction page to complete the payment process.</p>
            <p>
                <a href="{{ url('/auctions/' . $auction->id) }}" class="auction-link">View Auction Details →</a>
            </p>
        </p>
    </div>
</body>
</html>