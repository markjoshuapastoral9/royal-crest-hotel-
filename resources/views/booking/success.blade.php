@extends('layouts.app')
@section('title', 'Booking Confirmed!')

@push('styles')
<style>
:root {
    --bg-dark: #101111;
    --surface: #1a1214;
    --border: rgba(255,255,255,0.1);
    --text-sec: #C0C0C0;
    --gold: #A6824A;
}

.success-page { 
    min-height: 100vh; 
    background: var(--bg-dark); 
    display: flex; 
    align-items: center; 
    padding: 120px 0 60px; 
}
.success-card { 
    background: var(--surface); 
    border: 1px solid var(--border); 
    border-radius: 24px; 
    padding: 3.5rem 3rem; 
    text-align: center; 
}
.success-icon { 
    width: 90px; 
    height: 90px; 
    border-radius: 50%; 
    background: linear-gradient(135deg, rgba(16,185,129,.2), rgba(16,185,129,.1)); 
    border: 2px solid rgba(16,185,129,.3); 
    display: inline-flex; 
    align-items: center; 
    justify-content: center; 
    margin-bottom: 1.5rem; 
}
.success-icon i { 
    color: #34d399; 
    font-size: 2.8rem; 
}
.success-card h2 { 
    color: #fff; 
    font-family: 'Playfair Display', serif; 
    font-size: 2rem; 
    font-weight: 700; 
    margin-bottom: .8rem; 
}
.success-card > p { 
    color: var(--text-sec); 
    font-size: .95rem; 
    line-height: 1.7; 
    margin-bottom: 2rem; 
}
.details-box { 
    background: rgba(255,255,255,.03); 
    border: 1px solid var(--border); 
    border-radius: 18px; 
    padding: 2rem 1.5rem; 
    margin-bottom: 1.5rem; 
}
.details-box .booking-number { 
    color: rgba(192,192,192,.7); 
    font-size: .72rem; 
    font-weight: 700; 
    letter-spacing: 1.5px; 
    text-transform: uppercase; 
    margin-bottom: .5rem; 
    font-family: 'Inter', sans-serif; 
}
.details-box .booking-id { 
    color: var(--gold); 
    font-size: 1.8rem; 
    font-weight: 700; 
    letter-spacing: 2px; 
    font-family: 'Playfair Display', serif; 
    margin-bottom: 1.5rem; 
}
.detail-item { 
    text-align: center; 
    padding: .8rem 0; 
}
.detail-label { 
    color: rgba(192,192,192,.6); 
    font-size: .72rem; 
    font-weight: 700; 
    letter-spacing: 1px; 
    text-transform: uppercase; 
    margin-bottom: .4rem; 
    font-family: 'Inter', sans-serif; 
}
.detail-value { 
    color: #fff; 
    font-size: .9rem; 
    font-weight: 600; 
}
.detail-value.gold { 
    color: var(--gold); 
    font-size: 1.05rem; 
    font-weight: 700; 
}
.alert-info-dark { 
    background: rgba(59,130,246,.12); 
    border: 1px solid rgba(59,130,246,.25); 
    color: #93c5fd; 
    border-radius: 12px; 
    padding: 1rem 1.2rem; 
    font-size: .85rem; 
    text-align: left; 
    line-height: 1.7; 
    margin-bottom: 2rem; 
}
.alert-info-dark strong { 
    color: #60a5fa; 
}

@media (max-width: 576px) {
    .success-page { padding: 90px 0 40px; }
    .success-card { padding: 2rem 1.2rem; border-radius: 18px; }
    .success-icon { width: 70px; height: 70px; }
    .success-icon i { font-size: 2.2rem; }
    .success-card h2 { font-size: 1.5rem; }
    .details-box .booking-id { font-size: 1.3rem; letter-spacing: 1px; }
    .details-box { padding: 1.2rem 1rem; }
    .d-flex.gap-3 { flex-direction: column; }
    .d-flex.gap-3 .btn { width: 100%; }
}
</style>
@endpush

@section('content')
<div class="success-page">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="success-card">
                <div class="success-icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <h2>{{ __('site.bs_title') }}</h2>
                <p>{{ __('site.bs_sub') }}</p>

                <div class="details-box">
                    <div class="booking-number">{{ __('site.bs_booking_number') }}</div>
                    <div class="booking-id">{{ $booking->booking_number }}</div>
                    <div class="row g-3">
                        <div class="col-6"><div class="detail-item"><div class="detail-label">{{ __('site.bs_room') }}</div><div class="detail-value" style="line-height: 1.4;">{{ $booking->room->name }}<br><span style="color: #A6824A; font-size: 0.85rem; font-weight: 700; display: inline-block; margin-top: 0.3rem;">Room {{ $booking->room->room_number }}</span></div></div></div>
                        <div class="col-6"><div class="detail-item"><div class="detail-label">{{ __('site.bs_status') }}</div><div class="detail-value"><span class="badge bg-warning text-dark" style="font-size:.75rem;padding:.3rem .7rem;">{{ __('site.bs_pending') }}</span></div></div></div>
                        <div class="col-6"><div class="detail-item"><div class="detail-label">{{ __('site.bs_checkin') }}</div><div class="detail-value">{{ $booking->check_in->format('M d, Y') }}<br><span style="color:var(--gold);font-size:.8rem;">{{ $booking->check_in_time_formatted }}</span></div></div></div>
                        <div class="col-6"><div class="detail-item"><div class="detail-label">{{ __('site.bs_checkout') }}</div><div class="detail-value">{{ $booking->check_out->format('M d, Y') }}<br><span style="color:var(--gold);font-size:.8rem;">{{ $booking->check_out_time_formatted }}</span></div></div></div>
                        <div class="col-6"><div class="detail-item"><div class="detail-label">{{ __('site.bs_nights') }}</div><div class="detail-value">{{ $booking->nights }}</div></div></div>
                        <div class="col-6"><div class="detail-item"><div class="detail-label">{{ __('site.bs_total') }}</div><div class="detail-value gold">₱{{ number_format($booking->total_amount, 2) }}</div></div></div>
                    </div>
                </div>

                @if(in_array($booking->payment_method, ['gcash', 'maya', 'bank_transfer']))
                {{-- PAYMENT INSTRUCTIONS --}}
                <div class="alert" style="background:rgba(250,204,21,.12);border:1px solid rgba(250,204,21,.3);color:#fbbf24;border-radius:12px;padding:1.2rem;text-align:left;margin-bottom:1.5rem;">
                    <h6 style="color:#fbbf24;font-weight:700;margin-bottom:1rem;font-size:.95rem;"><i class="bi bi-credit-card me-2"></i>Payment Instructions</h6>
                    
                    <div style="background:rgba(26,18,20,.8);border:1px solid rgba(250,204,21,.2);border-radius:8px;padding:1rem;margin-bottom:1rem;font-family:'Courier New',monospace;font-size:.88rem;">
                        @if($booking->payment_method === 'gcash')
                        <div style="margin-bottom:.5rem;"><span style="color:#C0C0C0;">GCash Number:</span> <strong style="color:#fbbf24;">0917 123 4567</strong></div>
                        <div><span style="color:#C0C0C0;">Account Name:</span> <strong style="color:#fbbf24;">THE ROYAL CREST</strong></div>
                        @elseif($booking->payment_method === 'maya')
                        <div style="margin-bottom:.5rem;"><span style="color:#C0C0C0;">Maya Number:</span> <strong style="color:#fbbf24;">0917 123 4567</strong></div>
                        <div><span style="color:#C0C0C0;">Account Name:</span> <strong style="color:#fbbf24;">THE ROYAL CREST</strong></div>
                        @elseif($booking->payment_method === 'bank_transfer')
                        <div style="margin-bottom:.5rem;"><span style="color:#C0C0C0;">Bank Name:</span> <strong style="color:#fbbf24;">BDO UNIBANK</strong></div>
                        <div style="margin-bottom:.5rem;"><span style="color:#C0C0C0;">Account Number:</span> <strong style="color:#fbbf24;">123-456-789012</strong></div>
                        <div><span style="color:#C0C0C0;">Account Name:</span> <strong style="color:#fbbf24;">THE ROYAL CREST INC.</strong></div>
                        @endif
                    </div>
                    
                    <div style="background:rgba(76,175,80,.12);border:1px solid rgba(76,175,80,.3);border-radius:8px;padding:.8rem 1rem;">
                        <div style="color:#4caf50;font-size:.8rem;font-weight:700;margin-bottom:.2rem;">TOTAL AMOUNT TO PAY</div>
                        <div style="color:#4caf50;font-size:1.6rem;font-weight:bold;font-family:Georgia,serif;">₱{{ number_format($booking->total_amount, 2) }}</div>
                    </div>
                </div>

                {{-- PAYMENT PROOF UPLOAD FORM --}}
                @php $alreadySubmitted = $booking->payments()->where('status','!=','rejected')->exists(); @endphp
                @if($alreadySubmitted)
                <div style="background:rgba(76,175,80,.12);border:1px solid rgba(76,175,80,.3);border-radius:12px;padding:1.2rem;margin-bottom:2rem;text-align:left;">
                    <div style="color:#4caf50;font-weight:700;font-size:.95rem;margin-bottom:.3rem;"><i class="bi bi-check-circle me-2"></i>Payment Proof Submitted</div>
                    <div style="color:#C0C0C0;font-size:.85rem;">Your payment proof has been submitted and is pending verification by our team.</div>
                </div>
                @else
                <div style="background:rgba(26,18,20,.9);border:1px solid rgba(166,130,74,.3);border-radius:16px;padding:1.5rem;margin-bottom:2rem;text-align:left;">
                    <h6 style="color:#A6824A;font-weight:700;margin-bottom:1.2rem;font-size:1rem;"><i class="bi bi-upload me-2"></i>Submit Payment Proof</h6>
                    <p style="color:#C0C0C0;font-size:.83rem;margin-bottom:1.2rem;line-height:1.6;">After sending payment, upload your screenshot or receipt below. Our team will verify and confirm your booking.</p>
                    
                    @if(session('success'))
                    <div style="background:rgba(76,175,80,.15);border:1px solid rgba(76,175,80,.3);border-radius:8px;padding:.8rem 1rem;margin-bottom:1rem;color:#4caf50;font-size:.85rem;">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('booking.submit-payment', $booking) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label style="color:#C0C0C0;font-size:.78rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;display:block;margin-bottom:.4rem;">Payment Method</label>
                                <select name="method" required style="width:100%;background:#1a1214;border:1px solid rgba(166,130,74,.3);color:#E6E2DA;border-radius:8px;padding:.55rem .8rem;font-size:.88rem;">
                                    <option value="gcash" {{ $booking->payment_method==='gcash'?'selected':'' }}>GCash</option>
                                    <option value="maya" {{ $booking->payment_method==='maya'?'selected':'' }}>Maya</option>
                                    <option value="bank_transfer" {{ $booking->payment_method==='bank_transfer'?'selected':'' }}>Bank Transfer</option>
                                    <option value="cash" {{ $booking->payment_method==='cash'?'selected':'' }}>Cash</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label style="color:#C0C0C0;font-size:.78rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;display:block;margin-bottom:.4rem;">Reference / Transaction No.</label>
                                <input type="text" name="reference_number" required placeholder="e.g. GC-2026-123456" style="width:100%;background:#1a1214;border:1px solid rgba(166,130,74,.3);color:#E6E2DA;border-radius:8px;padding:.55rem .8rem;font-size:.88rem;" value="{{ old('reference_number') }}">
                                @error('reference_number')<div style="color:#f87171;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label style="color:#C0C0C0;font-size:.78rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;display:block;margin-bottom:.4rem;">Amount Paid (₱)</label>
                                <input type="number" name="amount" required step="0.01" min="1" value="{{ old('amount', $booking->total_amount) }}" style="width:100%;background:#1a1214;border:1px solid rgba(166,130,74,.3);color:#E6E2DA;border-radius:8px;padding:.55rem .8rem;font-size:.88rem;">
                                @error('amount')<div style="color:#f87171;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label style="color:#C0C0C0;font-size:.78rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;display:block;margin-bottom:.4rem;">Payment Screenshot / Receipt</label>
                                <input type="file" name="proof_image" required accept="image/*,.pdf" style="width:100%;background:#1a1214;border:1px solid rgba(166,130,74,.3);color:#E6E2DA;border-radius:8px;padding:.45rem .8rem;font-size:.85rem;">
                                @error('proof_image')<div style="color:#f87171;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <button type="submit" style="margin-top:1.2rem;background:#A6824A;color:#101111;border:none;border-radius:10px;padding:.7rem 2rem;font-weight:700;font-size:.9rem;cursor:pointer;width:100%;transition:background .2s;" onmouseover="this.style.background='#C9A87C'" onmouseout="this.style.background='#A6824A'">
                            <i class="bi bi-send me-2"></i>Submit Payment Proof
                        </button>
                    </form>
                </div>
                @endif
                @endif

                @if($qrDataUri)
                {{-- QR CODE SECTION --}}
                <div style="background:rgba(255,255,255,.04);border:1px solid rgba(201,168,76,.25);border-radius:16px;padding:1.5rem;margin-bottom:2rem;text-align:center;">
                    <h6 style="color:#C9A84C;font-weight:700;margin-bottom:.5rem;font-size:1rem;"><i class="bi bi-qr-code me-2"></i>Check-in QR Code</h6>
                    <p style="color:#C0C0C0;font-size:.82rem;margin-bottom:1.2rem;line-height:1.6;">Present this QR code at the front desk when you arrive. Staff will scan it for express check-in.</p>
                    <div style="display:inline-block;background:#ffffff;padding:16px;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.3);">
                        <img src="{{ $qrDataUri }}" alt="Check-in QR Code" style="display:block;width:200px;height:200px;">
                    </div>
                    <div style="margin-top:1rem;">
                        <a href="{{ $qrDataUri }}" download="checkin-{{ $booking->booking_number }}.png" style="display:inline-flex;align-items:center;gap:.5rem;background:rgba(201,168,76,.15);border:1px solid rgba(201,168,76,.4);color:#C9A84C;border-radius:8px;padding:.5rem 1.2rem;font-size:.85rem;font-weight:600;text-decoration:none;transition:background .2s;" onmouseover="this.style.background='rgba(201,168,76,.25)'" onmouseout="this.style.background='rgba(201,168,76,.15)'">
                            <i class="bi bi-download"></i> Download QR
                        </a>
                    </div>
                    <p style="color:rgba(192,192,192,.5);font-size:.75rem;margin-top:.8rem;margin-bottom:0;">Booking: <strong style="color:#C9A84C;">{{ $booking->booking_number }}</strong></p>
                    @if($booking->isPending())
                    <div class="alert alert-info mt-3 mb-0" style="background:rgba(59,130,246,.1);border:1px solid rgba(59,130,246,.3);border-radius:8px;padding:.8rem;font-size:.82rem;color:#93c5fd;">
                        <i class="bi bi-info-circle me-1"></i> {{ __('Your booking is pending approval. You can use this QR code once your booking is confirmed by our staff.') }}
                    </div>
                    @endif
                </div>
                @endif

                <div class="alert-info-dark">
                    <i class="bi bi-info-circle me-2"></i>
                    {{ __('site.bs_email_notice') }} <strong>{{ $booking->guest_email }}</strong>. {{ __('site.bs_keep_number') }}
                </div>

                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('booking.receipt', $booking->id) }}" class="btn btn-gold px-4 py-3 rounded-3 fw-semibold" target="_blank">
                        <i class="bi bi-download me-2"></i>{{ __('site.bs_download') }}
                    </a>
                    @auth
                    <a href="{{ route('customer.bookings') }}" class="btn btn-outline-gold px-4 py-3 rounded-3 fw-semibold">
                        <i class="bi bi-calendar2-check me-2"></i>{{ __('site.bs_my_bookings') }}
                    </a>
                    @endauth
                    <a href="{{ route('home') }}" class="btn btn-outline-gold px-4 py-3 rounded-3 fw-semibold">
                        <i class="bi bi-house me-2"></i>{{ __('site.bs_back_home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
