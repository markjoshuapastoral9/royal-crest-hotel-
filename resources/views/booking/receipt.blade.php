<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Receipt - {{ $booking->booking_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { size: A4; margin: 0; }
        body { font-family: 'Inter', sans-serif; background: #101111; color: #fff; font-size: 14px; line-height: 1.5; }
        .receipt-wrapper { max-width: 900px; margin: 0 auto; background: #1a1214; min-height: auto; display: flex; flex-direction: column; }
        .receipt-header { background: linear-gradient(135deg, #101111 0%, #2d2d2d 100%); padding: 25px 35px; border-bottom: 3px solid #A6824A; text-align: center; }
        .hotel-logo { font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 700; color: #A6824A; letter-spacing: 2px; }
        .hotel-tagline { color: #C0C0C0; font-size: 10px; letter-spacing: 3px; text-transform: uppercase; margin: 5px 0 15px; }
        .receipt-title { font-size: 20px; color: #fff; font-weight: 700; margin-bottom: 8px; }
        .booking-number { font-family: 'Playfair Display', serif; font-size: 24px; color: #A6824A; font-weight: 700; letter-spacing: 1.2px; }
        .receipt-body { padding: 25px 35px; flex: 1; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 16px; }
        .section { margin-bottom: 16px; }
        .section-title { font-size: 11px; color: #A6824A; text-transform: uppercase; letter-spacing: 1.3px; font-weight: 700; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid rgba(166,130,74,.3); }
        .room-preview { display: flex; gap: 14px; background: rgba(255,255,255,.02); border: 1px solid rgba(255,255,255,.08); border-radius: 10px; padding: 12px; margin-bottom: 16px; }
        .room-img { width: 110px; height: 110px; object-fit: cover; border-radius: 8px; flex-shrink: 0; }
        .room-info h3 { font-family: 'Playfair Display', serif; color: #A6824A; font-size: 18px; margin-bottom: 4px; }
        .room-info p { color: #C0C0C0; font-size: 12px; margin-bottom: 3px; }
        .info-row { display: flex; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid rgba(255,255,255,.05); }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #C0C0C0; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; }
        .info-value { color: #fff; font-weight: 600; font-size: 13px; }
        .status-badge { display: inline-block; padding: 4px 9px; border-radius: 12px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
        .status-badge.pending { background: rgba(251,191,36,.15); color: #fbbf24; }
        .status-badge.confirmed { background: rgba(34,197,94,.15); color: #22c55e; }
        .breakdown-table { width: 100%; background: rgba(255,255,255,.02); border: 1px solid rgba(255,255,255,.08); border-radius: 8px; overflow: hidden; }
        .breakdown-table tr { border-bottom: 1px solid rgba(255,255,255,.05); }
        .breakdown-table tr:last-child { border-bottom: none; }
        .breakdown-table td { padding: 9px 12px; font-size: 13px; }
        .breakdown-table td:first-child { color: #C0C0C0; }
        .breakdown-table td:last-child { text-align: right; color: #fff; font-weight: 600; }
        .breakdown-table tr.discount td { color: #22c55e; }
        .breakdown-table tr.total { background: rgba(166,130,74,.1); }
        .breakdown-table tr.total td { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: #A6824A; padding: 11px 12px; }
        .receipt-footer { background: #101111; padding: 16px 35px; border-top: 1px solid rgba(255,255,255,.08); text-align: center; font-size: 11px; color: #C0C0C0; margin-top: auto; }
        .footer-note { margin-bottom: 9px; line-height: 1.5; }
        .contact-info { display: flex; justify-content: center; gap: 18px; flex-wrap: wrap; font-size: 11px; }
        .print-button { position: fixed; bottom: 25px; right: 25px; background: #A6824A; color: #101111; border: none; padding: 13px 26px; border-radius: 26px; font-weight: 700; font-size: 12px; cursor: pointer; box-shadow: 0 4px 18px rgba(166,130,74,.5); font-family: 'Inter', sans-serif; text-transform: uppercase; letter-spacing: 1px; transition: all .3s; }
        .print-button:hover { background: #C9A87C; transform: translateY(-2px); box-shadow: 0 6px 22px rgba(166,130,74,.6); }
        .back-button { position: fixed; bottom: 25px; left: 25px; background: rgba(255,255,255,.08); backdrop-filter: blur(10px); color: #fff; width: 46px; height: 46px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid rgba(255,255,255,.12); transition: all .3s; }
        .back-button:hover { background: rgba(255,255,255,.15); transform: scale(1.05); }
        @media print {
            body { background: #fff; color: #000; font-size: 11px; }
            .receipt-wrapper { background: #fff; max-width: 100%; min-height: auto; }
            .print-button, .back-button { display: none; }
            .receipt-header { padding: 15px 25px; }
            .hotel-logo { font-size: 28px; }
            .hotel-tagline { font-size: 8px; margin: 3px 0 10px; }
            .receipt-title { font-size: 16px; margin-bottom: 5px; }
            .booking-number { font-size: 18px; }
            .receipt-body { padding: 15px 25px; }
            .two-col { gap: 15px; margin-bottom: 12px; }
            .section { margin-bottom: 12px; }
            .section-title { font-size: 9px; margin-bottom: 6px; padding-bottom: 3px; }
            .room-preview { padding: 8px; margin-bottom: 12px; gap: 10px; }
            .room-img { width: 80px; height: 80px; }
            .room-info h3 { font-size: 14px; margin-bottom: 2px; }
            .room-info p { font-size: 10px; margin-bottom: 2px; }
            .room-info p[style] { font-size: 12px !important; margin-top: 5px !important; }
            .info-row { padding: 5px 0; }
            .info-label { font-size: 10px; }
            .info-value { font-size: 11px; }
            .status-badge { padding: 2px 6px; font-size: 9px; }
            .breakdown-table td { padding: 6px 10px; font-size: 11px; }
            .breakdown-table tr.total td { font-size: 16px; padding: 8px 10px; }
            .receipt-footer { padding: 12px 25px; font-size: 9px; margin-top: 0; }
            .footer-note { margin-bottom: 6px; }
            .contact-info { gap: 12px; font-size: 9px; }
        }
        @media (max-width: 768px) { 
            .two-col { grid-template-columns: 1fr; } 
            .receipt-wrapper { max-width: 100%; }
            .receipt-header { padding: 20px; }
            .receipt-body { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="receipt-wrapper">
        <div class="receipt-header">
            <div class="hotel-logo">The Royal Crest</div>
            <div class="hotel-tagline">Luxury Hotel & Resort</div>
            <div class="receipt-title">Booking Receipt</div>
            <div class="booking-number">{{ $booking->booking_number }}</div>
        </div>
        <div class="receipt-body">
            <div class="room-preview">
                <img src="{{ $booking->room->thumbnail_url }}" alt="{{ $booking->room->name }}" class="room-img">
                <div class="room-info">
                    <h3>{{ $booking->room->name }}</h3>
                    <p><strong style="color: #A6824A;">Room {{ $booking->room->room_number }}</strong> • {{ $booking->room->roomType->name ?? 'N/A' }}</p>
                    <p style="margin-top: 8px; color: #A6824A; font-weight: 700; font-size: 15px;">₱{{ number_format($booking->room_price_per_night, 2) }} / night</p>
                </div>
            </div>
            <div class="two-col">
                <div class="section">
                    <div class="section-title">Guest Information</div>
                    <div class="info-row"><span class="info-label">Name</span><span class="info-value">{{ $booking->guest_name }}</span></div>
                    <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $booking->guest_email }}</span></div>
                    <div class="info-row"><span class="info-label">Phone</span><span class="info-value">{{ $booking->guest_phone }}</span></div>
                    <div class="info-row"><span class="info-label">Booking Date</span><span class="info-value">{{ $booking->created_at->format('M d, Y') }}</span></div>
                </div>
                <div class="section">
                    <div class="section-title">Stay Details</div>
                    <div class="info-row"><span class="info-label">Check-in</span><span class="info-value">{{ $booking->check_in->format('M d, Y') }}</span></div>
                    <div class="info-row"><span class="info-label">Check-out</span><span class="info-value">{{ $booking->check_out->format('M d, Y') }}</span></div>
                    <div class="info-row"><span class="info-label">Nights</span><span class="info-value">{{ $booking->nights }} {{ Str::plural('Night', $booking->nights) }}</span></div>
                    <div class="info-row"><span class="info-label">Guests</span><span class="info-value">{{ $booking->adults }} {{ Str::plural('Adult', $booking->adults) }}@if($booking->children > 0), {{ $booking->children }} {{ Str::plural('Child', $booking->children) }}@endif</span></div>
                </div>
            </div>
            <div class="two-col">
                <div class="section">
                    <div class="section-title">Status</div>
                    <div class="info-row"><span class="info-label">Booking Status</span><span class="info-value"><span class="status-badge {{ $booking->status }}">{{ ucfirst($booking->status) }}</span></span></div>
                    <div class="info-row"><span class="info-label">Payment Method</span><span class="info-value">{{ strtoupper(str_replace('_', ' ', $booking->payment_method)) }}</span></div>
                </div>
                <div class="section">
                    <div class="section-title">Payment Summary</div>
                    <table class="breakdown-table">
                        <tr><td>Room ({{ $booking->nights }}n × ₱{{ number_format($booking->room_price_per_night, 2) }})</td><td>₱{{ number_format($booking->subtotal, 2) }}</td></tr>
                        @if($booking->discount_amount > 0)
                        <tr class="discount"><td>Discount @if($booking->promotion)({{ $booking->promotion->code }})@endif</td><td>-₱{{ number_format($booking->discount_amount, 2) }}</td></tr>
                        @endif
                        <tr><td>Tax (12%)</td><td>₱{{ number_format($booking->tax_amount, 2) }}</td></tr>
                        <tr class="total"><td>Total</td><td>₱{{ number_format($booking->total_amount, 2) }}</td></tr>
                    </table>
                </div>
            </div>
            @if($booking->special_requests)
            <div class="section">
                <div class="section-title">Special Requests</div>
                <div style="background: rgba(255,255,255,.02); border: 1px solid rgba(255,255,255,.08); border-radius: 8px; padding: 12px; color: #C0C0C0; font-size: 12px; line-height: 1.5;">{{ $booking->special_requests }}</div>
            </div>
            @endif
        </div>
        <div class="receipt-footer">
            <div class="footer-note">Thank you for choosing The Royal Crest. We look forward to welcoming you!</div>
            <div class="contact-info"><span>📧 info@theroyalcrest.com</span><span>📞 +63 123 456 7890</span><span>📍 Calasiao, Pangasinan, PH</span></div>
        </div>
    </div>
    <button class="print-button" onclick="window.print()">🖨️ Print / Save PDF</button>
    <a href="{{ url()->previous() }}" class="back-button" title="Go Back"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></a>
</body>
</html>
