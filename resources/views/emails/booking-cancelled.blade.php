<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; background: #101111 !important; margin: 0; padding: 0; color: #ffffff !important; -webkit-text-size-adjust: 100%; }
    .wrapper { max-width: 600px; margin: 30px auto; background: #1a1214 !important; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,.6); border: 1px solid rgba(255,255,255,.08); }
    .header { background: linear-gradient(135deg, #101111 0%, #1a120a 50%, #101111 100%) !important; padding: 35px 40px; text-align: center; border-bottom: 1px solid rgba(166,130,74,.2); }
    .header h1 { color: #A6824A !important; font-size: 28px; margin: 0; letter-spacing: 4px; font-weight: 700; font-family: Georgia, serif; }
    .header p { color: rgba(166,130,74,.7) !important; font-size: 11px; letter-spacing: 4px; text-transform: uppercase; margin: 8px 0 0; font-weight: 600; }
    .header .icon { font-size: 50px; display: block; margin-bottom: 10px; }
    .body { padding: 30px 35px; background: #1a1214 !important; }
    .greeting { font-size: 18px; font-weight: 700; color: #ffffff !important; margin-bottom: 8px; }
    .intro { font-size: 14px; color: #C0C0C0 !important; line-height: 1.8; margin-bottom: 24px; }
    
    /* Booking number box */
    .booking-number-box { background: rgba(166,130,74,.12) !important; border: 1px solid rgba(166,130,74,.3); border-radius: 12px; padding: 16px; text-align: center; margin-bottom: 20px; }
    .booking-label { font-size: 10px; color: rgba(166,130,74,.8) !important; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 6px; font-weight: 700; }
    .booking-number { font-size: 22px; font-weight: bold; color: #A6824A !important; letter-spacing: 3px; font-family: 'Courier New', monospace; }
    
    /* Detail table */
    .detail-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; background: rgba(255,255,255,.03) !important; border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,.08); }
    .detail-table tr { border-bottom: 1px solid rgba(255,255,255,.06); }
    .detail-table tr:last-child { border-bottom: none; }
    .detail-table td { padding: 12px 16px; font-size: 13px; }
    .detail-table td:first-child { color: #C0C0C0 !important; width: 42%; }
    .detail-table td:last-child { font-weight: 600; color: #ffffff !important; text-align: right; }
    
    /* Info box */
    .info-box { background: rgba(239,68,68,.08) !important; border: 1px solid rgba(239,68,68,.2); border-radius: 12px; padding: 16px 18px; margin: 20px 0; }
    .info-row { font-size: 13px; color: #ef4444 !important; line-height: 1.7; margin: 0; }
    
    .info-text { font-size: 14px; color: #C0C0C0 !important; line-height: 1.8; margin: 20px 0; }
    .footer { background: #101111 !important; padding: 26px 35px; text-align: center; border-top: 1px solid rgba(255,255,255,.08); }
    .footer p { color: rgba(255,255,255,.45) !important; font-size: 11px; margin: 4px 0; line-height: 1.6; }
    .footer .gold { color: #A6824A !important; font-size: 14px; font-weight: bold; letter-spacing: 2px; }
    
    /* Mobile responsive */
    @media only screen and (max-width: 600px) {
        .wrapper { margin: 10px; border-radius: 12px; }
        .header { padding: 25px 20px; }
        .header h1 { font-size: 22px; letter-spacing: 2px; }
        .body { padding: 20px 15px; }
        .booking-number { font-size: 18px; letter-spacing: 2px; }
        .detail-table td { padding: 10px 12px; font-size: 12px; }
        .footer { padding: 20px 15px; }
    }
</style>
</head>
<body>
<div class="wrapper">

    {{-- HEADER --}}
    <div class="header">
        @php
            $logoPath = public_path('images/logo.png');
        @endphp
        @if(file_exists($logoPath))
            <img src="{{ $message->embed($logoPath) }}" alt="The Royal Crest Logo" style="width:70px;height:70px;margin:0 auto 12px;display:block;border-radius:12px;">
        @endif
        <span class="icon">❌</span>
        <h1>THE ROYAL CREST</h1>
        <p>Booking Cancelled</p>
    </div>

    <div class="body">
        <div class="greeting" style="color:#ffffff;">Dear {{ $booking->guest_name }},</div>
        <p class="intro" style="color:#C0C0C0;">Your booking has been <strong style="color:#ef4444;">cancelled</strong>. We're sorry to see you go.</p>

        {{-- BOOKING NUMBER --}}
        <div class="booking-number-box">
            <div class="booking-label">Booking Reference</div>
            <div class="booking-number">{{ $booking->booking_number }}</div>
        </div>

        {{-- BOOKING DETAILS TABLE --}}
        <table class="detail-table">
            <tr><td style="color:#C0C0C0;">Room</td><td style="color:#ffffff;">{{ $booking->room->name }}</td></tr>
            <tr><td style="color:#C0C0C0;">Check-in Date</td><td style="color:#ffffff;">{{ $booking->check_in->format('D, F d, Y') }}</td></tr>
            <tr><td style="color:#C0C0C0;">Check-out Date</td><td style="color:#ffffff;">{{ $booking->check_out->format('D, F d, Y') }}</td></tr>
            <tr><td style="color:#C0C0C0;">Duration</td><td style="color:#ffffff;">{{ $booking->nights }} Night(s)</td></tr>
            @if($booking->cancellation_reason)
            <tr><td style="color:#C0C0C0;">Reason</td><td style="color:#ffffff;">{{ $booking->cancellation_reason }}</td></tr>
            @endif
        </table>

        {{-- INFO BOX --}}
        <div class="info-box">
            <p class="info-row" style="color:#ef4444;">📋 For refund inquiries, please contact us with your booking reference number.</p>
        </div>

        <p class="info-text" style="color:#C0C0C0;">We hope to welcome you to The Royal Crest in the future. Browse our available rooms anytime on our website.</p>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p class="gold">THE ROYAL CREST</p>
        <p>Calasiao, Pangasinan 2418, Philippines</p>
        <p>📞 +63 75 123 4567 &nbsp;·&nbsp; 📧 info@theroyalcrest.com</p>
        <p style="margin-top:10px;font-size:10px;">© {{ date('Y') }} The Royal Crest. All rights reserved.</p>
    </div>

</div>
</body>
</html>
