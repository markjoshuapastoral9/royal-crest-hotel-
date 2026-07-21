<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email — The Royal Crest</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, Arial, sans-serif; background: #101111; margin: 0; padding: 20px 0; }
        .wrapper { max-width: 560px; margin: 0 auto; background: #1a1214; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,.6); border: 1px solid rgba(255,255,255,.07); }

        /* Header */
        .header { background: linear-gradient(135deg, #101111 0%, #1a120a 50%, #101111 100%); padding: 36px 40px; text-align: center; border-bottom: 2px solid rgba(166,130,74,.35); }
        .logo { font-family: Georgia, 'Times New Roman', serif; font-size: 32px; color: #A6824A; font-weight: bold; letter-spacing: 4px; }
        .logo-sub { color: rgba(166,130,74,.6); font-size: 10px; letter-spacing: 5px; text-transform: uppercase; margin-top: 4px; font-weight: 600; }

        /* Body */
        .body { padding: 36px 40px; background: #1a1214; }
        .greeting { font-size: 17px; font-weight: 700; color: #E6E2DA; margin-bottom: 12px; }
        .message { font-size: 14px; color: #B8AFA6; line-height: 1.85; margin-bottom: 28px; }

        /* Verify Button */
        .btn-wrap { text-align: center; margin: 28px 0; }
        .btn-verify {
            display: inline-block;
            background: #A6824A;
            color: #101111 !important;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            padding: 14px 40px;
            border-radius: 10px;
            letter-spacing: .5px;
            font-family: 'Inter', Arial, sans-serif;
        }

        /* Info box */
        .info-box { background: rgba(166,130,74,.07); border: 1px solid rgba(166,130,74,.2); border-radius: 12px; padding: 16px 20px; margin: 24px 0; }
        .info-row { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 8px; font-size: 13px; color: #B8AFA6; }
        .info-row:last-child { margin-bottom: 0; }
        .info-icon { color: #A6824A; font-size: 15px; flex-shrink: 0; margin-top: 1px; }

        /* URL fallback */
        .url-fallback { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 8px; padding: 12px 16px; margin-top: 20px; word-break: break-all; }
        .url-fallback p { font-size: 11px; color: rgba(184,175,166,.5); margin-bottom: 6px; letter-spacing: 1px; text-transform: uppercase; }
        .url-fallback a { color: #A6824A; font-size: 12px; word-break: break-all; }

        /* Footer */
        .footer { background: #101111; padding: 24px 40px; text-align: center; border-top: 1px solid rgba(255,255,255,.07); }
        .footer-brand { color: #A6824A; font-weight: 700; letter-spacing: 2px; font-size: 13px; margin-bottom: 6px; }
        .footer p { font-size: 11px; color: rgba(184,175,166,.4); margin: 3px 0; line-height: 1.6; }

        @media (max-width: 600px) {
            .body, .header, .footer { padding: 24px 24px; }
            .logo { font-size: 26px; }
            .btn-verify { padding: 12px 28px; font-size: 14px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">

        {{-- Header --}}
        <div class="header">
            <div class="logo">The Royal Crest</div>
            <div class="logo-sub">Luxury Hotel &amp; Resort</div>
        </div>

        {{-- Body --}}
        <div class="body">
            <div class="greeting">Hello, {{ $user->name }}!</div>
            <div class="message">
                Thank you for registering at <strong style="color:#A6824A;">The Royal Crest</strong>.
                Please verify your email address to activate your account and start booking your perfect stay.
            </div>

            <div class="btn-wrap">
                <a href="{{ $url }}" class="btn-verify">
                    ✓ &nbsp; Verify Email Address
                </a>
            </div>

            <div class="info-box">
                <div class="info-row">
                    <span class="info-icon">⏱</span>
                    <span>This verification link expires in <strong style="color:#E6E2DA;">60 minutes</strong>.</span>
                </div>
                <div class="info-row">
                    <span class="info-icon">🔒</span>
                    <span>If you did not create an account, no further action is required.</span>
                </div>
                <div class="info-row">
                    <span class="info-icon">📧</span>
                    <span>Button not working? Copy and paste the link below into your browser.</span>
                </div>
            </div>

            <div class="url-fallback">
                <p>Verification Link</p>
                <a href="{{ $url }}">{{ $url }}</a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <div class="footer-brand">THE ROYAL CREST</div>
            <p>Calasiao, Pangasinan 2418, Philippines</p>
            <p>+63 75 123 4567 · info@theroyalcrest.com</p>
            <p style="margin-top:10px;">This email was sent because you registered at The Royal Crest.</p>
        </div>

    </div>
</body>
</html>
