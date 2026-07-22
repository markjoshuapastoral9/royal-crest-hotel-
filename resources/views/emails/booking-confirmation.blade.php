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
    .body { padding: 30px 35px; background: #1a1214 !important; }
    .greeting { font-size: 18px; font-weight: 700; color: #ffffff !important; margin-bottom: 8px; }
    .intro { font-size: 14px; color: #C0C0C0 !important; line-height: 1.8; margin-bottom: 24px; }

    /* Room image block */
    .room-img-wrap { position: relative; border-radius: 14px; overflow: hidden; margin-bottom: 24px; border: 1px solid rgba(255,255,255,.12); background: #000 !important; }
    .room-img-wrap img { width: 100%; height: 220px; object-fit: cover; display: block; }
    .room-img-overlay { background: linear-gradient(to top, rgba(0,0,0,.95) 0%, rgba(0,0,0,.4) 60%, transparent 100%); padding: 20px; }
    .room-img-name { font-family: Georgia, serif; font-size: 22px; font-weight: bold; color: #A6824A !important; margin-bottom: 5px; }
    .room-img-sub { font-size: 11px; color: rgba(255,255,255,.8) !important; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600; }

    /* Booking number box */
    .booking-number-box { background: rgba(166,130,74,.12) !important; border: 1px solid rgba(166,130,74,.3); border-radius: 12px; padding: 16px; text-align: center; margin-bottom: 20px; }
    .booking-label { font-size: 10px; color: rgba(166,130,74,.8) !important; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 6px; font-weight: 700; }
    .booking-number { font-size: 22px; font-weight: bold; color: #A6824A !important; letter-spacing: 3px; font-family: 'Courier New', monospace; }

    /* Status badge */
    .status-badge { display: inline-block; background: rgba(250,204,21,.15) !important; color: #fbbf24 !important; border: 1px solid rgba(250,204,21,.3); padding: 6px 16px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; }

    /* Detail table */
    .detail-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; background: rgba(255,255,255,.03) !important; border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,.08); }
    .detail-table tr { border-bottom: 1px solid rgba(255,255,255,.06); }
    .detail-table tr:last-child { border-bottom: none; }
    .detail-table td { padding: 12px 16px; font-size: 13px; }
    .detail-table td:first-child { color: #C0C0C0 !important; width: 42%; }
    .detail-table td:last-child { font-weight: 600; color: #ffffff !important; text-align: right; }

    /* Price breakdown */
    .breakdown-box { background: rgba(255,255,255,.03) !important; border: 1px solid rgba(255,255,255,.08); border-radius: 12px; padding: 20px; margin-top: 8px; }
    .breakdown-title { font-size: 10px; color: #C0C0C0 !important; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 12px; font-weight: bold; }
    .breakdown-row { display: table; width: 100%; font-size: 13px; padding: 6px 0; }
    .breakdown-row span:first-child { display: table-cell; color: #C0C0C0 !important; }
    .breakdown-row span:last-child { display: table-cell; text-align: right; font-weight: 600; color: #ffffff !important; }
    .breakdown-row.discount span { color: #34d399 !important; }
    .breakdown-row.discount span:last-child { color: #34d399 !important; }
    .breakdown-divider { border: none; border-top: 2px solid rgba(166,130,74,.3); margin: 12px 0; }
    .total-label { font-size: 11px; color: #C0C0C0 !important; text-transform: uppercase; letter-spacing: 1px; text-align: center; margin-bottom: 6px; font-weight: 600; }
    .total-amount { font-size: 32px; font-weight: bold; color: #A6824A !important; text-align: center; font-family: Georgia, serif; }

    /* Policies */
    .policy-box { background: rgba(59,130,246,.08) !important; border: 1px solid rgba(59,130,246,.2); border-radius: 12px; padding: 16px 18px; margin: 20px 0; }
    .policy-row { font-size: 13px; color: #93c5fd !important; line-height: 1.7; margin: 0 0 8px; }
    .policy-row:last-child { margin-bottom: 0; }

    /* Special requests */
    .special-box { background: rgba(168,85,247,.08) !important; border: 1px solid rgba(168,85,247,.2); border-left: 3px solid rgba(168,85,247,.5); border-radius: 0 12px 12px 0; padding: 14px 16px; margin: 18px 0; font-size: 13px; color: #d8b4fe !important; }
    .special-label { font-size: 10px; color: #c084fc !important; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; margin-bottom: 6px; }

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
        .room-img-wrap img { height: 180px; }
        .booking-number { font-size: 18px; letter-spacing: 2px; }
        .detail-table td { padding: 10px 12px; font-size: 12px; }
        .breakdown-row { font-size: 12px; }
        .total-amount { font-size: 26px; }
        .footer { padding: 20px 15px; }
    }
</style>
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
            <img src="{{ $message->embed($logoPath) }}" alt="The Royal Crest Logo" style="width:100px;height:100px;margin:0 auto 15px;display:block;border-radius:12px;">
        @endif
        <h1>THE ROYAL CREST</h1>
        <p>Booking Confirmation</p>
    </div>

    <div class="body">
        <div class="greeting" style="color:#ffffff;">Dear {{ $booking->guest_name }},</div>
        <p class="intro" style="color:#C0C0C0;">Thank you for choosing <strong style="color:#ffffff;">The Royal Crest</strong>! We have received your booking request. Our team will review and confirm your reservation shortly.</p>

        {{-- ROOM IMAGE --}}
        @php
            $roomImagePath = $booking->room->getLocalRoomImagePath();
        @endphp
        <div class="room-img-wrap">
            @if($roomImagePath && file_exists($roomImagePath))
                <img src="{{ $message->embed($roomImagePath) }}" alt="{{ $booking->room->name }}" style="width:100%;height:220px;object-fit:cover;display:block;">
            @else
                {{-- Fallback to external URL if local image not found --}}
                <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80" alt="{{ $booking->room->name }}" style="width:100%;height:220px;object-fit:cover;display:block;">
            @endif
            <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(to top,rgba(0,0,0,.90),rgba(0,0,0,.3) 60%,transparent);padding:18px 20px;">
                <div class="room-img-name">{{ $booking->room->name }}</div>
                <div class="room-img-sub">{{ $booking->room->roomType->name }} &nbsp;·&nbsp; ₱{{ number_format($booking->room_price_per_night, 2) }} / night</div>
            </div>
        </div>

        {{-- BOOKING NUMBER --}}
        <div class="booking-number-box">
            <div class="booking-label">Booking Reference</div>
            <div class="booking-number">{{ $booking->booking_number }}</div>
        </div>

        <div style="text-align:center;margin-bottom:16px;">
            <span class="status-badge">⏳ Pending Confirmation</span>
        </div>

        {{-- BOOKING DETAILS TABLE --}}
        <table class="detail-table">
            <tr><td style="color:#C0C0C0;">Room</td><td style="color:#ffffff;">{{ $booking->room->name }}</td></tr>
            <tr><td style="color:#C0C0C0;">Room Type</td><td style="color:#ffffff;">{{ $booking->room->roomType->name }}</td></tr>
            <tr><td style="color:#C0C0C0;">Check-in</td><td style="color:#ffffff;">{{ $booking->check_in->format('D, F d, Y') }} &nbsp;<span style="color:#A6824A;font-weight:700;">{{ $booking->check_in_time_formatted }}</span></td></tr>
            <tr><td style="color:#C0C0C0;">Check-out</td><td style="color:#ffffff;">{{ $booking->check_out->format('D, F d, Y') }} &nbsp;<span style="color:#A6824A;font-weight:700;">{{ $booking->check_out_time_formatted }}</span></td></tr>
            <tr><td style="color:#C0C0C0;">Duration</td><td style="color:#ffffff;">{{ $booking->nights }} Night(s)</td></tr>
            <tr><td style="color:#C0C0C0;">Guests</td><td style="color:#ffffff;">{{ $booking->adults }} Adult(s)@if($booking->children > 0), {{ $booking->children }} Child(ren)@endif</td></tr>
            <tr><td style="color:#C0C0C0;">Payment Method</td><td style="color:#ffffff;">{{ strtoupper(str_replace('_', ' ', $booking->payment_method)) }}</td></tr>
            <tr><td style="color:#C0C0C0;">Booking Date</td><td style="color:#ffffff;">{{ $booking->created_at->format('F d, Y h:i A') }}</td></tr>
        </table>

        {{-- PRICE BREAKDOWN --}}
        <div class="breakdown-box">
            <div class="breakdown-title" style="color:#C0C0C0;">Price Breakdown</div>
            <div class="breakdown-row">
                <span style="color:#C0C0C0;">Room Rate ({{ $booking->nights }} night(s) × ₱{{ number_format($booking->room_price_per_night, 2) }})</span>
                <span style="color:#ffffff;">₱{{ number_format($booking->subtotal, 2) }}</span>
            </div>
            @if($booking->discount_amount > 0)
            <div class="breakdown-row discount">
                <span style="color:#34d399;">Discount @if($booking->promotion)({{ $booking->promotion->code }})@endif</span>
                <span style="color:#34d399;">-₱{{ number_format($booking->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="breakdown-row">
                <span style="color:#C0C0C0;">Tax (12% VAT)</span>
                <span style="color:#ffffff;">₱{{ number_format($booking->tax_amount, 2) }}</span>
            </div>
            <hr class="breakdown-divider">
            <div class="total-label" style="color:#C0C0C0;">Total Amount</div>
            <div class="total-amount" style="color:#A6824A;">₱{{ number_format($booking->total_amount, 2) }}</div>
        </div>

        {{-- SPECIAL REQUESTS --}}
        @if($booking->special_requests)
        <div class="special-box" style="color:#d8b4fe;">
            <div class="special-label" style="color:#c084fc;">📝 Special Requests</div>
            {{ $booking->special_requests }}
        </div>
        @endif

        <p class="info-text" style="color:#C0C0C0;">You will receive another email once your booking has been <strong style="color:#ffffff;">confirmed</strong>. If you have any questions, please contact us with your booking reference number.</p>

        {{-- POLICIES --}}
        <div class="policy-box">
            <p class="policy-row" style="color:#93c5fd;">✅ <strong>Check-in Policy:</strong> Check-in time is 2:00 PM. Early check-in is subject to availability.</p>
            <p class="policy-row" style="color:#93c5fd;">🛎 <strong>Check-out Policy:</strong> Check-out time is 12:00 PM noon. Late check-out may incur additional charges.</p>
            <p class="policy-row" style="color:#93c5fd;">❌ <strong>Cancellation:</strong> Free cancellation up to 24 hours before check-in.</p>
        </div>
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
