<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email from The Royal Crest</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; background: #101111 !important; margin: 0; padding: 0; color: #ffffff !important; -webkit-text-size-adjust: 100%; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #1a1214 !important; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,.6); border: 1px solid rgba(255,255,255,.08); }
        .header { background: linear-gradient(135deg, #101111 0%, #1a120a 50%, #101111 100%) !important; padding: 35px 40px; text-align: center; border-bottom: 1px solid rgba(166,130,74,.2); }
        .header h1 { color: #A6824A !important; font-size: 28px; margin: 0; letter-spacing: 4px; font-weight: 700; font-family: Georgia, serif; }
        .header p { color: rgba(166,130,74,.7) !important; font-size: 11px; letter-spacing: 4px; text-transform: uppercase; margin: 8px 0 0; font-weight: 600; }
        .greeting-bar { background: rgba(166,130,74,.15) !important; border-bottom: 1px solid rgba(166,130,74,.3); padding: 16px 35px; font-size: 16px; color: #ffffff !important; font-weight: 600; }
        .body-content { padding: 32px 35px; background: #1a1214 !important; color: #C0C0C0 !important; }
        .body-content p { margin: 0 0 16px; line-height: 1.8; font-size: 14px; color: #C0C0C0 !important; }
        .body-content a { color: #A6824A !important; text-decoration: underline; }
        .body-content a:hover { color: #c9a057 !important; }
        .body-content strong { color: #ffffff !important; }
        .body-content b { color: #ffffff !important; }
        .body-content ul { margin: 0 0 16px 20px; color: #C0C0C0 !important; }
        .body-content li { margin-bottom: 8px; color: #C0C0C0 !important; }
        .body-content * { color: #C0C0C0 !important; }
        .body-content strong *, .body-content b * { color: #ffffff !important; }
        .divider { border: none; border-top: 1px solid rgba(255,255,255,.08); margin: 24px 0; }
        .footer-notice { background: rgba(255,255,255,.03) !important; border: 1px solid rgba(255,255,255,.08); border-radius: 12px; padding: 16px 18px; margin-top: 20px; font-size: 12px; color: rgba(192,192,192,.8) !important; line-height: 1.7; }
        .footer { background: #101111 !important; padding: 26px 35px; text-align: center; border-top: 1px solid rgba(255,255,255,.08); }
        .footer p { color: rgba(255,255,255,.45) !important; font-size: 11px; margin: 4px 0; line-height: 1.6; }
        .footer .gold { color: #A6824A !important; font-size: 14px; font-weight: bold; letter-spacing: 2px; }
        
        /* Mobile responsive */
        @media only screen and (max-width: 600px) {
            .wrapper { margin: 10px; border-radius: 12px; }
            .header { padding: 25px 20px; }
            .header h1 { font-size: 22px; letter-spacing: 2px; }
            .greeting-bar { padding: 14px 20px; font-size: 15px; }
            .body-content { padding: 25px 20px; }
            .footer { padding: 20px 15px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            @php
                $logoPath = public_path('images/logo.png');
            @endphp
            @if(file_exists($logoPath))
                <img src="{{ $message->embed($logoPath) }}" alt="The Royal Crest Logo" style="width:100px;height:100px;margin:0 auto 18px;display:block;border-radius:12px;">
            @endif
            <h1>THE ROYAL CREST</h1>
            <p>Luxury · Comfort · Excellence</p>
        </div>

        <!-- Greeting -->
        <div class="greeting-bar">
            Dear {{ $guestName }},
        </div>

        <!-- Body -->
        <div class="body-content">
            {!! $bodyHtml !!}

            <div class="footer-notice">
                <strong style="color:#ffffff;">📧 About this email:</strong><br>
                This message was sent to you because you are a registered guest of The Royal Crest.
                If you have any questions, please contact us directly at info@theroyalcrest.com
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="gold">THE ROYAL CREST</p>
            <p>Calasiao, Pangasinan 2418, Philippines</p>
            <p>📞 +63 75 123 4567 &nbsp;·&nbsp; 📧 info@theroyalcrest.com</p>
            <p style="margin-top:10px;font-size:10px;">© {{ date('Y') }} The Royal Crest. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
