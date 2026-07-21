<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code — The Royal Crest</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, Arial, sans-serif; background: #101111 !important; margin: 0; padding: 20px 0; -webkit-text-size-adjust: 100%; }
        .wrapper { max-width: 520px; margin: 0 auto; background: #1a1214 !important; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,.6); border: 1px solid rgba(255,255,255,.08); }

        /* HEADER */
        .header { background: linear-gradient(135deg, #101111 0%, #1a120a 50%, #101111 100%) !important; padding: 32px 30px; text-align: center; border-bottom: 2px solid rgba(166,130,74,.4); }
        .logo { font-family: Georgia, serif; font-size: 30px; color: #A6824A !important; font-weight: bold; letter-spacing: 3px; }
        .tagline { color: rgba(166,130,74,.7) !important; font-size: 11px; letter-spacing: 4px; text-transform: uppercase; margin-top: 6px; font-weight: 600; }

        /* BODY */
        .body { padding: 35px 30px; background: #1a1214 !important; }
        .greeting { font-size: 16px; color: #ffffff !important; margin-bottom: 12px; font-weight: 400; }
        .message { font-size: 14px; color: #C0C0C0 !important; line-height: 1.8; margin-bottom: 28px; }

        /* OTP BOX */
        .otp-box { background: rgba(166,130,74,.08) !important; border: 2px solid rgba(166,130,74,.4); border-radius: 14px; text-align: center; padding: 28px 20px; margin: 0 0 20px; }
        .otp-label { font-size: 10px; color: rgba(166,130,74,.8) !important; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 14px; font-weight: 700; }
        .otp-code { font-family: 'Courier New', monospace; font-size: 46px; font-weight: bold; color: #A6824A !important; letter-spacing: 12px; text-indent: 12px; background: transparent !important; display: block; }

        /* EXPIRY */
        .expiry { text-align: center; font-size: 13px; color: rgba(192,192,192,.6) !important; margin-bottom: 24px; }
        .expiry strong { color: #ffffff !important; }

        /* WARNING */
        .warning { background: rgba(250,204,21,.08) !important; border: 1px solid rgba(250,204,21,.25); border-radius: 10px; padding: 14px 16px; font-size: 13px; color: #fbbf24 !important; line-height: 1.7; font-weight: 500; }

        /* FOOTER */
        .footer { background: #101111 !important; padding: 22px 30px; text-align: center; border-top: 1px solid rgba(255,255,255,.08); }
        .footer p { font-size: 12px; color: rgba(255,255,255,.4) !important; margin: 4px 0; line-height: 1.6; }
        .hotel-name { color: #A6824A !important; font-weight: bold; }

        /* Mobile */
        @media only screen and (max-width: 600px) {
            body { padding: 10px 0; }
            .wrapper { margin: 0 10px; border-radius: 12px; }
            .header { padding: 24px 20px; }
            .logo { font-size: 24px; }
            .body { padding: 24px 20px; }
            .otp-code { font-size: 36px; letter-spacing: 8px; }
            .otp-box { padding: 20px 15px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">

        {{-- HEADER --}}
        <div class="header">
            <div class="logo">The Royal Crest</div>
            <div class="tagline">Luxury Hotel &amp; Resort</div>
        </div>

        {{-- BODY --}}
        <div class="body">
            <div class="greeting">Hello, <strong style="color:#ffffff;">{{ $userName }}</strong>!</div>
            <div class="message">
                Welcome to <strong style="color:#A6824A;">The Royal Crest</strong>. Use the one-time password below to verify your identity and complete your login.
            </div>

            {{-- OTP CODE BOX --}}
            <div class="otp-box">
                <div class="otp-label">Your Verification Code</div>
                <div style="font-family:'Courier New',monospace; font-size:46px; font-weight:bold; color:#A6824A !important; -webkit-text-fill-color:#A6824A !important; letter-spacing:12px; text-indent:12px; background:transparent !important; display:block; text-align:center; padding:8px 0; text-decoration:none !important;">
                    {{ $otp }}
                </div>
            </div>

            <div class="expiry">⏱ This code will expire in <strong>5 minutes</strong></div>

            <div class="warning">
                🔒 <strong>Security Notice:</strong> If you did not request this code, please ignore this email. Do not share your OTP with anyone.
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <p>Thank you for choosing <span class="hotel-name">The Royal Crest</span></p>
            <p>Calasiao, Pangasinan, Philippines</p>
            <p>📞 +63 75 123 4567 &nbsp;|&nbsp; 📧 info@theroyalcrest.com</p>
            <p style="margin-top:8px;font-size:10px;color:rgba(255,255,255,.2) !important;">© {{ date('Y') }} The Royal Crest. All rights reserved.</p>
        </div>

    </div>
</body>
</html>
