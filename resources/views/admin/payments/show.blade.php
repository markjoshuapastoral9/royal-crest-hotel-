@extends('layouts.admin')
@section('title','Payment Details')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payments</a></li>
<li class="breadcrumb-item active">{{ $payment->reference_number }}</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0" style="color:#E6E2DA;">Payment Details</h4>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Payments
    </a>
</div>

<div class="row g-4">
    {{-- LEFT: Payment Info + Actions --}}
    <div class="col-lg-7">

        {{-- Status Banner --}}
        @if($payment->status === 'pending')
        <div style="background:rgba(255,193,7,.12);border:1px solid rgba(255,193,7,.3);border-radius:12px;padding:1rem 1.2rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.8rem;">
            <i class="bi bi-clock-history" style="color:#ffc107;font-size:1.4rem;"></i>
            <div>
                <div style="color:#ffc107;font-weight:700;font-size:.95rem;">Awaiting Verification</div>
                <div style="color:#B8AFA6;font-size:.82rem;">Review the payment proof and verify or reject this payment.</div>
            </div>
        </div>
        @elseif($payment->status === 'verified')
        <div style="background:rgba(25,135,84,.12);border:1px solid rgba(25,135,84,.3);border-radius:12px;padding:1rem 1.2rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.8rem;">
            <i class="bi bi-check-circle-fill" style="color:#4caf50;font-size:1.4rem;"></i>
            <div>
                <div style="color:#4caf50;font-weight:700;font-size:.95rem;">Payment Verified</div>
                <div style="color:#B8AFA6;font-size:.82rem;">Verified on {{ $payment->verified_at?->format('M d, Y h:i A') }}</div>
            </div>
        </div>
        @else
        <div style="background:rgba(220,53,69,.12);border:1px solid rgba(220,53,69,.3);border-radius:12px;padding:1rem 1.2rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.8rem;">
            <i class="bi bi-x-circle-fill" style="color:#dc3545;font-size:1.4rem;"></i>
            <div>
                <div style="color:#dc3545;font-weight:700;font-size:.95rem;">Payment Rejected</div>
                <div style="color:#B8AFA6;font-size:.82rem;">This payment was rejected.</div>
            </div>
        </div>
        @endif

        {{-- Payment Info Card --}}
        <div class="admin-card p-4 mb-4">
            <h6 style="color:#C9A84C;font-weight:700;letter-spacing:.5px;text-transform:uppercase;font-size:.78rem;margin-bottom:1.2rem;"><i class="bi bi-receipt me-2"></i>Payment Information</h6>
            
            <div class="row g-3">
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Reference Number</div>
                    <div style="font-family:monospace;font-size:1rem;font-weight:700;color:#C9A84C;">{{ $payment->reference_number }}</div>
                </div>
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Amount Paid</div>
                    <div style="font-size:1.3rem;font-weight:700;color:#4caf50;">₱{{ number_format($payment->amount,2) }}</div>
                </div>
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Payment Method</div>
                    <div class="d-flex align-items-center gap-2" style="color:#E6E2DA;font-size:.9rem;font-weight:600;">
                        @php
                            $icon = match($payment->method) {
                                'gcash' => 'bi-phone', 'maya' => 'bi-phone-fill',
                                'bank_transfer' => 'bi-bank', 'cash' => 'bi-cash', default => 'bi-credit-card'
                            };
                        @endphp
                        <i class="bi {{ $icon }}" style="color:#C9A84C;"></i>
                        {{ match($payment->method) {
                            'gcash' => 'GCash', 'maya' => 'Maya',
                            'bank_transfer' => 'Bank Transfer', 'cash' => 'Cash', default => ucfirst($payment->method)
                        } }}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Submitted</div>
                    <div style="color:#E6E2DA;font-size:.9rem;">{{ $payment->created_at->format('M d, Y') }}</div>
                    <div style="color:#B8AFA6;font-size:.78rem;">{{ $payment->created_at->format('h:i A') }}</div>
                </div>
                @if($payment->notes)
                <div class="col-12">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Notes</div>
                    <div style="color:#E6E2DA;font-size:.88rem;background:var(--admin-surface-2);border-radius:8px;padding:.7rem 1rem;">{{ $payment->notes }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Booking Info --}}
        <div class="admin-card p-4 mb-4">
            <h6 style="color:#C9A84C;font-weight:700;letter-spacing:.5px;text-transform:uppercase;font-size:.78rem;margin-bottom:1.2rem;"><i class="bi bi-calendar-check me-2"></i>Booking Information</h6>
            <div class="row g-3">
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Booking #</div>
                    <a href="{{ route('admin.bookings.show', $payment->booking) }}" style="color:#C9A84C;font-weight:700;font-family:monospace;font-size:.95rem;text-decoration:none;">{{ $payment->booking->booking_number }}</a>
                </div>
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Guest Name</div>
                    <div style="color:#E6E2DA;font-size:.9rem;font-weight:600;">{{ $payment->booking->guest_name }}</div>
                </div>
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Email</div>
                    <div style="color:#E6E2DA;font-size:.88rem;">{{ $payment->booking->guest_email }}</div>
                </div>
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Room</div>
                    <div style="color:#E6E2DA;font-size:.88rem;font-weight:600;">{{ $payment->booking->room->name }}</div>
                    <div style="color:#C9A84C;font-size:.78rem;">Room {{ $payment->booking->room->room_number }}</div>
                </div>
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Check-in</div>
                    <div style="color:#E6E2DA;font-size:.88rem;">{{ $payment->booking->check_in->format('M d, Y') }}</div>
                </div>
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Check-out</div>
                    <div style="color:#E6E2DA;font-size:.88rem;">{{ $payment->booking->check_out->format('M d, Y') }}</div>
                </div>
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Total Booking Amount</div>
                    <div style="color:#E6E2DA;font-size:.95rem;font-weight:700;">₱{{ number_format($payment->booking->total_amount,2) }}</div>
                </div>
                <div class="col-sm-6">
                    <div style="color:#B8AFA6;font-size:.72rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.3rem;">Booking Status</div>
                    <span class="badge bg-{{ $payment->booking->status_badge }}">{{ ucfirst(str_replace('_',' ',$payment->booking->status)) }}</span>
                </div>
            </div>
        </div>

        {{-- Verify / Reject Actions --}}
        @if($payment->status === 'pending')
        <div class="admin-card p-4">
            <h6 style="color:#C9A84C;font-weight:700;letter-spacing:.5px;text-transform:uppercase;font-size:.78rem;margin-bottom:1.2rem;"><i class="bi bi-shield-check me-2"></i>Verify or Reject Payment</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.payments.verify', $payment) }}">
                        @csrf
                        <div class="mb-3">
                            <label style="color:#B8AFA6;font-size:.78rem;font-weight:600;display:block;margin-bottom:.4rem;">Notes (optional)</label>
                            <textarea name="notes" rows="2" class="form-control" placeholder="Add verification notes..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-semibold">
                            <i class="bi bi-check-circle me-2"></i>Verify Payment & Confirm Booking
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('admin.payments.reject', $payment) }}">
                        @csrf
                        <div class="mb-3">
                            <label style="color:#B8AFA6;font-size:.78rem;font-weight:600;display:block;margin-bottom:.4rem;">Rejection Reason</label>
                            <textarea name="notes" rows="2" class="form-control" placeholder="Reason for rejection..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 fw-semibold">
                            <i class="bi bi-x-circle me-2"></i>Reject Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- RIGHT: Payment Proof Image --}}
    <div class="col-lg-5">
        <div class="admin-card p-4" style="position:sticky;top:80px;">
            <h6 style="color:#C9A84C;font-weight:700;letter-spacing:.5px;text-transform:uppercase;font-size:.78rem;margin-bottom:1.2rem;"><i class="bi bi-image me-2"></i>Payment Proof / Screenshot</h6>
            @if($payment->proof_image)
            <div style="border:2px solid rgba(201,168,76,.2);border-radius:12px;overflow:hidden;margin-bottom:1rem;">
                @if(str_ends_with(strtolower($payment->proof_image), '.pdf'))
                <div style="padding:2rem;text-align:center;background:var(--admin-surface-2);">
                    <i class="bi bi-file-earmark-pdf" style="font-size:3rem;color:#dc3545;display:block;margin-bottom:.8rem;"></i>
                    <div style="color:#B8AFA6;font-size:.85rem;margin-bottom:1rem;">PDF Document</div>
                    <a href="{{ asset('storage/'.$payment->proof_image) }}" target="_blank" class="btn btn-sm btn-gold">
                        <i class="bi bi-eye me-1"></i>Open PDF
                    </a>
                </div>
                @else
                <a href="{{ asset('storage/'.$payment->proof_image) }}" target="_blank">
                    <img src="{{ asset('storage/'.$payment->proof_image) }}" alt="Payment Proof" style="width:100%;display:block;max-height:500px;object-fit:contain;background:#000;">
                </a>
                @endif
            </div>
            <a href="{{ asset('storage/'.$payment->proof_image) }}" target="_blank" class="btn btn-sm w-100" style="background:rgba(201,168,76,.12);border:1px solid rgba(201,168,76,.3);color:#C9A84C;">
                <i class="bi bi-box-arrow-up-right me-1"></i>Open Full Size
            </a>
            @else
            <div style="text-align:center;padding:3rem 1rem;background:var(--admin-surface-2);border-radius:12px;border:2px dashed rgba(201,168,76,.2);">
                <i class="bi bi-image" style="font-size:2.5rem;color:#B8AFA6;display:block;margin-bottom:.8rem;"></i>
                <div style="color:#B8AFA6;font-size:.88rem;">No payment proof uploaded</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
