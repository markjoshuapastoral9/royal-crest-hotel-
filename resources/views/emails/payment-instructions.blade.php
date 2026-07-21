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
    
    /* Amount box */
    .amount-box { background: rgba(76,175,80,.08) !important; border: 2px solid rgba(76,175,80,.3); border-radius: 14px; padding: 20px; text-align: center; margin: 24px 0; }
    .amount-label { font-size: 11px; color: #81c784 !important; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; font-weight: 700; }
    .amount-value { font-size: 36px; font-weight: bold; color: #4caf50 !important; font-family: Georgia, serif; }
    
    /* Payment method box */
    .payment-method-box { background: rgba(59,130,246,.08) !important; border: 1px solid rgba(59,130,246,.3); border-radius: 12px; padding: 18px; margin: 20px 0; }
    .payment-method-title { font-size: 12px; color: #93c5fd !important; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12px; font-weight: 700; }
    
    /* Instructions box */
    .instructions-box { background: rgba(255,255,255,.03) !important; border: 1px solid rgba(255,255,255,.08); border-radius: 12px; padding: 20px; margin: 20px 0; }
    .instructions-title { font-size: 14px; color: #A6824A !important; font-weight: 700; margin-bottom: 12px; }
    .instruction-step { font-size: 13px; color: #C0C0C0 !important; line-height: 1.8; margin-bottom: 10px; padding-left: 24px; position: relative; }
    .instruction-step:before { content: "●"; position: absolute; left: 0; color: #A6824A; }
    
    /* Account details */
    .account-box { background: rgba(166,130,74,.08) !important; border: 1px solid rgba(166,130,74,.2); border-radius: 10px; padding: 16px; margin: 16px 0; font-family: 'Courier New', monospace; }
    .account-row { font-size: 13px; color: #ffffff !important; margin: 8px 0; }
    .account-label { color: #C0C0C0 !important; display: inline-block; width: 140px; }
    .account-value { color: #A6824A !important; font-weight: bold; }

    
    /* Warning box */
    .warning-box { background: rgba(250,204,21,.08) !important; border: 1px solid rgba(250,204,21,.2); border-radius: 12px; padding: 16px 18px; margin: 20px 0; }
    .warning-text { font-size: 13px; color: #fbbf24 !important; line-height: 1.7; margin: 0; }
    
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
        .amount-value { font-size: 28px; }
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
        <span class="icon">💳</span>
        <h1>THE ROYAL CREST</h1>
        <p>Payment Instructions</p>
    </div>

    <div class="body">
        <div class="greeting" style="color:#ffffff;">Dear {{ $booking->guest_name }},</div>
        <p class="intro" style="color:#C0C0C0;">Thank you for booking with <strong style="color:#A6824A;">The Royal Crest</strong>! Please complete your payment to confirm your reservation.</p>


        {{-- BOOKING NUMBER --}}
        <div class="booking-number-box">
            <div class="booking-label">Booking Reference</div>
            <div class="booking-number">{{ $booking->booking_number }}</div>
        </div>

        {{-- AMOUNT TO PAY --}}
        <div class="amount-box">
            <div class="amount-label">Total Amount to Pay</div>
            <div class="amount-value">₱{{ number_format($booking->total_amount, 2) }}</div>
        </div>

        {{-- PAYMENT METHOD --}}
        <div class="payment-method-box">
            <div class="payment-method-title">Selected Payment Method</div>
            <div style="font-size:20px;color:#ffffff;font-weight:bold;text-transform:uppercase;">
                @if($booking->payment_method === 'gcash')
                    📱 GCash
                @elseif($booking->payment_method === 'maya')
                    💳 Maya
                @elseif($booking->payment_method === 'bank_transfer')
                    🏦 Bank Transfer
                @endif
            </div>
        </div>

        {{-- PAYMENT INSTRUCTIONS --}}
        <div class="instructions-box">
            <div class="instructions-title">Payment Instructions:</div>
            
            @if($booking->payment_method === 'gcash')
                <div class="account-box">
                    <div class="account-row">
                        <span class="account-label">GCash Number:</span>
                        <span class="account-value">0917 123 4567</span>
                    </div>
                    <div class="account-row">
                        <span class="account-label">Account Name:</span>
                        <span class="account-value">THE ROYAL CREST</span>
                    </div>
                </div>
                <div class="instruction-step">Open your GCash app and select "Send Money"</div>
                <div class="instruction-step">Enter the GCash number: <strong style="color:#A6824A;">0917 123 4567</strong></div>
                <div class="instruction-step">Enter amount: <strong style="color:#4caf50;">₱{{ number_format($booking->total_amount, 2) }}</strong></div>
                <div class="instruction-step">Add a note with your booking reference: <strong style="color:#A6824A;">{{ $booking->booking_number }}</strong></div>
                <div class="instruction-step">Complete the transaction and take a screenshot of the receipt</div>
                <div class="instruction-step">Upload the proof of payment on the website or email it to us</div>

            
            @elseif($booking->payment_method === 'maya')
                <div class="account-box">
                    <div class="account-row">
                        <span class="account-label">Maya Number:</span>
                        <span class="account-value">0917 123 4567</span>
                    </div>
                    <div class="account-row">
                        <span class="account-label">Account Name:</span>
                        <span class="account-value">THE ROYAL CREST</span>
                    </div>
                </div>
                <div class="instruction-step">Open your Maya app and select "Send Money"</div>
                <div class="instruction-step">Enter the Maya number: <strong style="color:#A6824A;">0917 123 4567</strong></div>
                <div class="instruction-step">Enter amount: <strong style="color:#4caf50;">₱{{ number_format($booking->total_amount, 2) }}</strong></div>
                <div class="instruction-step">Add a note with your booking reference: <strong style="color:#A6824A;">{{ $booking->booking_number }}</strong></div>
                <div class="instruction-step">Complete the transaction and take a screenshot of the receipt</div>
                <div class="instruction-step">Upload the proof of payment on the website or email it to us</div>
            
            @elseif($booking->payment_method === 'bank_transfer')
                <div class="account-box">
                    <div class="account-row">
                        <span class="account-label">Bank Name:</span>
                        <span class="account-value">BDO UNIBANK</span>
                    </div>
                    <div class="account-row">
                        <span class="account-label">Account Number:</span>
                        <span class="account-value">123-456-789012</span>
                    </div>
                    <div class="account-row">
                        <span class="account-label">Account Name:</span>
                        <span class="account-value">THE ROYAL CREST INC.</span>
                    </div>
                </div>
                <div class="instruction-step">Visit any BDO branch or use online banking</div>
                <div class="instruction-step">Transfer to account number: <strong style="color:#A6824A;">123-456-789012</strong></div>
                <div class="instruction-step">Transfer amount: <strong style="color:#4caf50;">₱{{ number_format($booking->total_amount, 2) }}</strong></div>
                <div class="instruction-step">Use your booking reference as the transfer note: <strong style="color:#A6824A;">{{ $booking->booking_number }}</strong></div>
                <div class="instruction-step">Take a photo of the deposit slip or screenshot of the transaction</div>
                <div class="instruction-step">Upload the proof of payment on the website or email it to us</div>
            @endif
        </div>

        {{-- WARNING BOX --}}
        <div class="warning-box">
            <p class="warning-text">⚠️ <strong>Important:</strong> Your booking will only be confirmed once we receive and verify your payment. Please submit proof of payment within 24 hours to secure your reservation.</p>
        </div>

        <p class="info-text" style="color:#C0C0C0;">You can upload your proof of payment by logging into your account or by replying to this email with the screenshot/photo attached.</p>
        
        <p class="info-text" style="color:#C0C0C0;">For questions or assistance, contact us at <strong style="color:#A6824A;">info@theroyalcrest.com</strong> or <strong style="color:#A6824A;">+63 75 123 4567</strong>.</p>
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
