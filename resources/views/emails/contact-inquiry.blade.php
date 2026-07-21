<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Inquiry — Monarch Hotel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, Arial, sans-serif; background: #101111; margin: 0; padding: 20px 0; }
        .wrapper { max-width: 560px; margin: 0 auto; background: #1a1214; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,.6); border: 1px solid rgba(255,255,255,.08); }

        .header { background: linear-gradient(135deg, #101111 0%, #1a120a 50%, #101111 100%); padding: 32px 30px; text-align: center; border-bottom: 2px solid rgba(166,130,74,.4); }
        .logo { font-family: Georgia, serif; font-size: 28px; color: #A6824A; font-weight: bold; letter-spacing: 3px; }
        .tagline { color: rgba(166,130,74,.7); font-size: 11px; letter-spacing: 4px; text-transform: uppercase; margin-top: 6px; }

        .badge { display: inline-block; background: rgba(166,130,74,.15); border: 1px solid rgba(166,130,74,.4); border-radius: 20px; color: #A6824A; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 14px; margin-top: 14px; }

        .body { padding: 32px 30px; }
        .greeting { font-size: 16px; color: #ffffff; margin-bottom: 8px; font-weight: 500; }
        .sub { font-size: 13px; color: #C0C0C0; line-height: 1.7; margin-bottom: 24px; }

        .info-box { background: rgba(166,130,74,.06); border: 1px solid rgba(166,130,74,.2); border-radius: 12px; padding: 20px 22px; margin-bottom: 22px; }
        .info-row { display: flex; align-items: flex-start; gap: 10px; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,.06); }
        .info-row:last-child { border-bottom: none; padding-bottom: 0; }
        .info-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #A6824A; min-width: 80px; padding-top: 1px; }
        .info-value { font-size: 13px; color: #E6E2DA; line-height: 1.6; }

        .message-box { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.1); border-radius: 12px; padding: 18px 20px; margin-bottom: 22px; }
        .message-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #A6824A; margin-bottom: 10px; }
        .message-text { font-size: 13px; color: #C0C0C0; line-height: 1.8; white-space: pre-line; }

        .note { background: rgba(250,204,21,.06); border: 1px solid rgba(250,204,21,.2); border-radius: 10px; padding: 12px 16px; font-size: 12px; color: #fbbf24; line-height: 1.7; margin-bottom: 8px; }

        .footer { background: #101111; padding: 22px 30px; text-align: center; border-top: 1px solid rgba(255,255,255,.08); }
        .footer p { font-size: 12px; color: rgba(255,255,255,.4); margin: 4px 0; line-height: 1.6; }
        .hotel-name { color: #A6824A; font-weight: bold; }

        @media only screen and (max-width: 600px) {
            body { padding: 10px 0; }
            .wrapper { margin: 0 10px; border-radius: 12px; }
            .body { padding: 22px 18px; }
            .info-label { min-width: 70px; }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="logo">THE ROYAL CREST</div>
        <div class="tagline">Luxury Hotel · Calasiao, Pangasinan</div>
        <div class="badge">📩 New Inquiry</div>
    </div>

    <div class="body">
        <div class="greeting">You have a new contact inquiry.</div>
        <div class="sub">A guest submitted a message through the website contact form. Details are below.</div>

        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Name</span>
                <span class="info-value">{{ $senderName }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $senderEmail }}</span>
            </div>
            @if($senderPhone)
            <div class="info-row">
                <span class="info-label">Phone</span>
                <span class="info-value">{{ $senderPhone }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Subject</span>
                <span class="info-value">{{ $inquirySubject }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Sent At</span>
                <span class="info-value">{{ now()->format('F d, Y — h:i A') }}</span>
            </div>
        </div>

        <div class="message-box">
            <div class="message-label">Message</div>
            <div class="message-text">{{ $messageBody }}</div>
        </div>

        <div class="note">
            💡 To reply, simply respond to this email — the reply-to address is already set to <strong>{{ $senderEmail }}</strong>.
        </div>
    </div>

    <div class="footer">
        <p>This notification was sent by <span class="hotel-name">The Royal Crest</span> booking system.</p>
        <p>Calasiao, Pangasinan 2418 &nbsp;·&nbsp; +63 75 123 4567 &nbsp;·&nbsp; info@theroyalcrest.com</p>
    </div>
</div>
</body>
</html>
