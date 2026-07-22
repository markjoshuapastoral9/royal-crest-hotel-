<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif; background:#101111; color:#fff; -webkit-text-size-adjust:100%; }
    .wrapper { max-width:600px; margin:30px auto; background:#1a1214; border-radius:16px; overflow:hidden; box-shadow:0 8px 40px rgba(0,0,0,.6); border:1px solid rgba(255,255,255,.08); }
    .header { background:linear-gradient(135deg,#101111 0%,#1a120a 50%,#101111 100%); padding:35px 40px; text-align:center; border-bottom:1px solid rgba(166,130,74,.2); }
    .header h1 { color:#A6824A; font-size:28px; margin:0; letter-spacing:4px; font-weight:700; font-family:Georgia,serif; }
    .header p { color:rgba(166,130,74,.7); font-size:11px; letter-spacing:4px; text-transform:uppercase; margin:8px 0 0; font-weight:600; }
    .body { padding:30px 35px; background:#1a1214; }
    .greeting { font-size:18px; font-weight:700; color:#fff; margin-bottom:8px; }
    .intro { font-size:14px; color:#C0C0C0; line-height:1.8; margin-bottom:24px; }

    /* Alert / notice box */
    .notice-box { background:rgba(166,130,74,.1); border:1px solid rgba(166,130,74,.3); border-radius:12px; padding:16px 18px; margin-bottom:22px; text-align:center; }
    .notice-box p { color:rgba(166,130,74,.9); font-size:13px; line-height:1.7; margin:0; }

    /* Booking ref box */
    .ref-box { background:rgba(166,130,74,.12); border:1px solid rgba(166,130,74,.3); border-radius:12px; padding:16px; text-align:center; margin-bottom:20px; }
    .ref-label { font-size:10px; color:rgba(166,130,74,.8); letter-spacing:2px; text-transform:uppercase; margin-bottom:6px; font-weight:700; }
    .ref-number { font-size:14px; font-weight:bold; color:#A6824A; letter-spacing:2px; font-family:'Courier New',monospace; }

    /* Status badge */
    .status-badge { display:inline-block; background:rgba(250,204,21,.15); color:#fbbf24; border:1px solid rgba(250,204,21,.3); padding:6px 16px; border-radius:20px; font-size:11px; font-weight:bold; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; }

    /* Section header */
    .section-header { font-size:10px; color:rgba(166,130,74,.8); text-transform:uppercase; letter-spacing:2px; font-weight:700; margin-bottom:10px; padding-bottom:8px; border-bottom:1px solid rgba(255,255,255,.06); }

    /* Detail table */
    .detail-table { width:100%; border-collapse:collapse; margin-bottom:20px; background:rgba(255,255,255,.03); border-radius:12px; overflow:hidden; border:1px solid rgba(255,255,255,.08); }
    .detail-table tr { border-bottom:1px solid rgba(255,255,255,.06); }
    .detail-table tr:last-child { border-bottom:none; }
    .detail-table td { padding:12px 16px; font-size:13px; }
    .detail-table td:first-child { color:#C0C0C0; width:42%; }
    .detail-table td:last-child { font-weight:600; color:#fff; text-align:right; }

    /* Room highlight card */
    .room-card { background:rgba(166,130,74,.08); border:1px solid rgba(166,130,74,.25); border-radius:12px; padding:18px 20px; margin-bottom:20px; }
    .room-card-name { font-family:Georgia,serif; font-size:20px; font-weight:bold; color:#A6824A; margin-bottom:4px; }
    .room-card-sub { font-size:12px; color:rgba(255,255,255,.6); text-transform:uppercase; letter-spacing:1px; }
    .room-card-price { font-size:22px; font-weight:bold; color:#A6824A; font-family:Georgia,serif; margin-top:10px; }
    .room-card-price-label { font-size:10px; color:rgba(255,255,255,.4); text-transform:uppercase; letter-spacing:1px; }

    /* Policy box */
    .policy-box { background:rgba(59,130,246,.08); border:1px solid rgba(59,130,246,.2); border-radius:12px; padding:16px 18px; margin:20px 0; }
    .policy-row { font-size:13px; color:#93c5fd; line-height:1.7; margin:0 0 8px; }
    .policy-row:last-child { margin-bottom:0; }

    /* Notes box */
    .notes-box { background:rgba(168,85,247,.08); border:1px solid rgba(168,85,247,.2); border-left:3px solid rgba(168,85,247,.5); border-radius:0 12px 12px 0; padding:14px 16px; margin:18px 0; font-size:13px; color:#d8b4fe; }
    .notes-label { font-size:10px; color:#c084fc; text-transform:uppercase; letter-spacing:1px; font-weight:bold; margin-bottom:6px; }

    /* Deposit box */
    .deposit-box { background:rgba(250,204,21,.08); border:1px solid rgba(250,204,21,.25); border-radius:12px; padding:16px 18px; margin:20px 0; text-align:center; }
    .deposit-label { font-size:10px; color:rgba(250,204,21,.7); text-transform:uppercase; letter-spacing:1.5px; font-weight:700; margin-bottom:6px; }
    .deposit-amount { font-size:28px; font-weight:bold; color:#fbbf24; font-family:Georgia,serif; }
    .deposit-note { font-size:12px; color:rgba(250,204,21,.6); margin-top:6px; }

    .info-text { font-size:14px; color:#C0C0C0; line-height:1.8; margin:20px 0; }
    .footer { background:#101111; padding:26px 35px; text-align:center; border-top:1px solid rgba(255,255,255,.08); }
    .footer p { color:rgba(255,255,255,.45); font-size:11px; margin:4px 0; line-height:1.6; }
    .footer .gold { color:#A6824A; font-size:14px; font-weight:bold; letter-spacing:2px; }

    @media only screen and (max-width:600px) {
        .wrapper { margin:10px; border-radius:12px; }
        .header { padding:25px 20px; }
        .header h1 { font-size:22px; letter-spacing:2px; }
        .body { padding:20px 15px; }
        .detail-table td { padding:10px 12px; font-size:12px; }
        .footer { padding:20px 15px; }
    }
</style>
</head>
<body>
<div class="wrapper">

    {{-- HEADER --}}
    <div class="header">
        @php $logoPath = public_path('images/logo.png'); @endphp
        @if(file_exists($logoPath))
        <img src="{{ $message->embed($logoPath) }}" alt="The Royal Crest" style="width:80px;height:80px;margin:0 auto 15px;display:block;border-radius:12px;">
        @endif
        <h1>THE ROYAL CREST</h1>
        <p>Private Dining Reservation</p>
    </div>

    <div class="body">
        <div class="greeting">Dear {{ $data['name'] }},</div>
        <p class="intro">
            Thank you for your private dining reservation request at <strong style="color:#fff;">The Royal Crest</strong>.
            We have received your request and our team will contact you within <strong style="color:#fff;">24 hours</strong> to confirm availability and finalize the details.
        </p>

        {{-- STATUS --}}
        <div style="text-align:center;margin-bottom:20px;">
            <span class="status-badge">⏳ Reservation Request Received</span>
        </div>

        {{-- REFERENCE --}}
        <div class="ref-box">
            <div class="ref-label">Reservation Reference</div>
            <div class="ref-number">PDR-{{ strtoupper(substr(md5($data['email'] . $data['date']), 0, 8)) }}</div>
        </div>

        {{-- ROOM HIGHLIGHT --}}
        <div class="room-card">
            <div class="room-card-sub">Selected Room</div>
            <div class="room-card-name">{{ explode('(', $data['room'])[0] }}</div>
            @php
                preg_match('/₱([\d,]+)/', $data['room'], $priceMatch);
                preg_match('/up to (\d+) guests/', $data['room'], $guestsMatch);
            @endphp
            @if(!empty($guestsMatch[1]))
            <div style="color:rgba(255,255,255,.6);font-size:12px;margin-top:4px;"><i>👥 Up to {{ $guestsMatch[1] }} guests</i></div>
            @endif
            @if(!empty($priceMatch[1]))
            <div class="room-card-price-label" style="margin-top:10px;">Venue Fee</div>
            <div class="room-card-price">₱{{ $priceMatch[1] }}</div>
            @endif
        </div>

        {{-- RESERVATION DETAILS --}}
        <div class="section-header">📋 Reservation Details</div>
        <table class="detail-table">
            <tr>
                <td style="color:#C0C0C0;">Guest Name</td>
                <td style="color:#fff;">{{ $data['name'] }}</td>
            </tr>
            <tr>
                <td style="color:#C0C0C0;">Email</td>
                <td style="color:#fff;">{{ $data['email'] }}</td>
            </tr>
            <tr>
                <td style="color:#C0C0C0;">Phone</td>
                <td style="color:#fff;">{{ $data['phone'] }}</td>
            </tr>
            <tr>
                <td style="color:#C0C0C0;">Occasion</td>
                <td style="color:#fff;">{{ $data['occasion'] }}</td>
            </tr>
            <tr>
                <td style="color:#C0C0C0;">Date</td>
                <td style="color:#fff;">{{ \Carbon\Carbon::parse($data['date'])->format('D, F d, Y') }}</td>
            </tr>
            <tr>
                <td style="color:#C0C0C0;">Time</td>
                <td style="color:#A6824A;font-weight:700;">{{ $data['time'] }}</td>
            </tr>
            <tr>
                <td style="color:#C0C0C0;">Number of Guests</td>
                <td style="color:#fff;">{{ $data['guests'] }} {{ $data['guests'] == 1 ? 'Guest' : 'Guests' }}</td>
            </tr>
            <tr>
                <td style="color:#C0C0C0;">Duration</td>
                <td style="color:#fff;">{{ $data['duration'] }}</td>
            </tr>
        </table>

        {{-- SPECIAL NOTES --}}
        @if(!empty($data['message']) && $data['message'] !== 'None')
        <div class="notes-box">
            <div class="notes-label">📝 Special Requests / Notes</div>
            {{ $data['message'] }}
        </div>
        @endif

        {{-- DEPOSIT BOX --}}
        <div class="deposit-box">
            <div class="deposit-label">Required Deposit (50%)</div>
            @if(!empty($priceMatch[1]))
            @php $venuePrice = (int) str_replace(',', '', $priceMatch[1]); @endphp
            <div class="deposit-amount">₱{{ number_format($venuePrice * 0.5, 0) }}</div>
            @else
            <div class="deposit-amount">50% of Venue Fee</div>
            @endif
            <div class="deposit-note">A 50% deposit is required to secure your reservation.</div>
        </div>

        {{-- POLICIES --}}
        <div class="policy-box">
            <p class="policy-row" style="color:#93c5fd;">✅ <strong>Confirmation:</strong> Our team will contact you within 24 hours to confirm your reservation.</p>
            <p class="policy-row" style="color:#93c5fd;">💳 <strong>Deposit:</strong> A 50% deposit is required via GCash, Maya, or bank transfer to secure your booking.</p>
            <p class="policy-row" style="color:#93c5fd;">❌ <strong>Cancellation:</strong> Free cancellation up to 48 hours before your event date.</p>
            <p class="policy-row" style="color:#93c5fd;">🍽️ <strong>Menu:</strong> Custom menus can be arranged 3 days before your event.</p>
        </div>

        <p class="info-text">
            If you have questions or need to make changes, please reply to this email or contact us directly.
            Please keep this email as your reservation reference.
        </p>
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
