@extends('layouts.app')
@section('title', __('site.bkd_booking') . ' ' . $booking->booking_number)

@push('styles')
<style>
@media (max-width: 576px) {
    .d-flex.gap-4.align-items-start { flex-direction: column; gap: 1rem !important; }
    .d-flex.gap-4.align-items-start img { width: 100% !important; height: 140px !important; }
    .bg-white.rounded-4.p-4 { padding: 1rem !important; }
    section[style] { padding: 25px 0 !important; }
}
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('customer.bookings') }}" class="text-gold">{{ __('site.cb_title') }}</a></li>
                <li class="breadcrumb-item active text-white-50">{{ $booking->booking_number }}</li>
            </ol>
        </nav>
        <h1 class="text-white mt-2">{{ __('site.bkd_booking') }} {{ $booking->booking_number }}</h1>
        <span class="badge bg-{{ $booking->status_badge }} px-3 py-2">{{ ucfirst(str_replace('_',' ',$booking->status)) }}</span>
    </div>
</div>

<section style="padding:50px 0; background:#F8F7F4;">
<div class="container">
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Room Info -->
            <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">{{ __('site.bkd_room_info') }}</h5>
                <div class="d-flex gap-4 align-items-start">
                    <img src="{{ $booking->room->thumbnail_url }}" class="rounded-3" style="width:120px;height:90px;object-fit:cover;" alt="{{ $booking->room->translated_name }}">
                    <div>
                        <h5 class="fw-bold mb-1">{{ $booking->room->translated_name }}</h5>
                        <div class="text-muted small">{{ $booking->room->roomType->name }} · {{ __('site.bkd_room_label') }} {{ $booking->room->room_number }}</div>
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            <span class="badge bg-light text-dark border small"><i class="bi bi-people me-1"></i>{{ $booking->room->capacity }} {{ __('site.rooms_guests') }}</span>
                            <span class="badge bg-light text-dark border small"><i class="bi bi-moon me-1"></i>{{ $booking->room->beds }} {{ __('site.bkd_beds') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stay Details -->
            <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">{{ __('site.bkd_stay_details') }}</h5>
                <div class="row g-3">
                    <div class="col-6"><div class="small text-muted">{{ __('site.bs_checkin') }}</div><div class="fw-semibold">{{ $booking->check_in->format('D, M d, Y') }}</div><div class="text-muted" style="font-size:.75rem;">{{ __('site.bkd_after_2pm') }}</div></div>
                    <div class="col-6"><div class="small text-muted">{{ __('site.bs_checkout') }}</div><div class="fw-semibold">{{ $booking->check_out->format('D, M d, Y') }}</div><div class="text-muted" style="font-size:.75rem;">{{ __('site.bkd_before_12pm') }}</div></div>
                    <div class="col-6"><div class="small text-muted">{{ __('site.bkd_duration') }}</div><div class="fw-semibold">{{ $booking->nights }} {{ __('site.bkd_nights_label') }}</div></div>
                    <div class="col-6"><div class="small text-muted">{{ __('site.bkd_guests') }}</div><div class="fw-semibold">{{ $booking->adults }} {{ __('site.bkd_adults_label') }}{{ $booking->children > 0 ? ', '.$booking->children.' '.__('site.bkd_children_label') : '' }}</div></div>
                    @if($booking->special_requests)<div class="col-12"><div class="small text-muted">{{ __('site.bk_special_req') }}</div><div class="small">{{ $booking->special_requests }}</div></div>@endif
                </div>
            </div>

            @if(in_array($booking->payment_method, ['gcash', 'maya', 'bank_transfer']) && $booking->payment_status !== 'paid')
            <!-- Payment Instructions -->
            <div class="bg-white rounded-4 p-4 shadow-sm mb-4" style="border-left:4px solid #fbbf24;">
                <h5 class="fw-bold mb-3" style="color:#d97706;">💳 {{ __('site.bkd_pay_instructions') }}</h5>
                <p class="text-muted mb-3">{{ __('site.bkd_pay_sub') }}</p>

                <div style="background:#FFF9E6;border:1px solid #fbbf24;border-radius:8px;padding:1rem;margin-bottom:1rem;">
                    @if($booking->payment_method === 'gcash')
                    <div class="mb-2"><span class="text-muted">{{ __('site.bkd_gcash_num') }}:</span> <strong style="color:#d97706;">0917 123 4567</strong></div>
                    <div><span class="text-muted">{{ __('site.bkd_account_name') }}:</span> <strong style="color:#d97706;">THE ROYAL CREST</strong></div>
                    @elseif($booking->payment_method === 'maya')
                    <div class="mb-2"><span class="text-muted">{{ __('site.bkd_maya_num') }}:</span> <strong style="color:#d97706;">0917 123 4567</strong></div>
                    <div><span class="text-muted">{{ __('site.bkd_account_name') }}:</span> <strong style="color:#d97706;">THE ROYAL CREST</strong></div>
                    @elseif($booking->payment_method === 'bank_transfer')
                    <div class="mb-2"><span class="text-muted">{{ __('site.bkd_bank_name') }}:</span> <strong style="color:#d97706;">BDO UNIBANK</strong></div>
                    <div class="mb-2"><span class="text-muted">{{ __('site.bkd_account_num') }}:</span> <strong style="color:#d97706;">123-456-789012</strong></div>
                    <div><span class="text-muted">{{ __('site.bkd_account_name') }}:</span> <strong style="color:#d97706;">THE ROYAL CREST INC.</strong></div>
                    @endif
                </div>

                <div style="background:#E8F5E9;border:1px solid #4caf50;border-radius:8px;padding:1rem;margin-bottom:1rem;text-align:center;">
                    <div style="color:#2e7d32;font-size:.9rem;font-weight:600;">{{ __('site.bs_amount_to_pay') }}</div>
                    <div style="color:#2e7d32;font-size:2rem;font-weight:bold;font-family:Georgia,serif;">₱{{ number_format($booking->total_amount, 2) }}</div>
                </div>

                <div class="alert alert-warning mb-0">
                    <small>
                        <strong>⚠️ {{ __('site.bkd_important') }}:</strong> {{ __('site.bkd_use_ref') }} <strong>{{ $booking->booking_number }}</strong>.
                        {{ __('site.bkd_after_pay') }} <strong>info@monarchhotel.com</strong> {{ __('site.bkd_or_call') }} <strong>+63 75 123 4567</strong>.
                    </small>
                </div>
            </div>
            @endif

            <!-- Payment Summary -->
            <div class="bg-white rounded-4 p-4 shadow-sm">
                <h5 class="fw-bold mb-3">{{ __('site.bkd_pay_summary') }}</h5>
                <div class="small">
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ __('site.rs_rate_per_night') }}</span><span>₱{{ number_format($booking->room_price_per_night,2) }}/{{ __('site.bk_nights') }}</span></div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ $booking->nights }} {{ __('site.bkd_nights_label') }}</span><span>₱{{ number_format($booking->subtotal,2) }}</span></div>
                    @if($booking->discount_amount > 0)<div class="d-flex justify-content-between mb-2 text-success"><span>{{ __('site.bk_discount') }}</span><span>-₱{{ number_format($booking->discount_amount,2) }}</span></div>@endif
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ __('site.bk_vat') }}</span><span>₱{{ number_format($booking->tax_amount,2) }}</span></div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5"><span>{{ __('site.bk_total') }}</span><span class="text-gold">₱{{ number_format($booking->total_amount,2) }}</span></div>
                </div>
                <div class="mt-3 pt-3 border-top d-flex gap-2">
                    <span class="badge bg-{{ $booking->payment_status_badge }}">{{ ucfirst(str_replace('_',' ',$booking->payment_status)) }}</span>
                    <span class="badge bg-light text-dark border">{{ ucfirst($booking->payment_method ?? 'N/A') }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if(!$booking->isCancelled())
            <!-- QR Code -->
            <div class="bg-white rounded-4 p-4 shadow-sm mb-4 text-center">
                <h6 class="fw-bold mb-3"><i class="bi bi-qr-code me-2 text-gold"></i>{{ __('Check-In QR Code') }}</h6>
                <p class="text-muted small mb-3">{{ __('Present this QR code at the front desk for express check-in.') }}</p>
                @php
                    try {
                        $qrSvc = app(\App\Services\QrCodeService::class);
                        $qrUri = $qrSvc->generate($booking);
                    } catch (\Throwable $e) {
                        $qrUri = null;
                    }
                @endphp
                @if($qrUri)
                <div style="background:#fff;padding:14px;border-radius:10px;border:1px solid #ddd;display:inline-block;">
                    <img src="{{ $qrUri }}" alt="QR Code" style="width:200px;height:200px;display:block;">
                </div>
                <div class="mt-2 text-gold fw-bold small">{{ $booking->booking_number }}</div>
                <a href="{{ $qrUri }}" download="checkin-{{ $booking->booking_number }}.svg" class="btn btn-outline-gold btn-sm mt-3">
                    <i class="bi bi-download me-1"></i>{{ __('Download QR Code') }}
                </a>
                @if($booking->isPending())
                <div class="alert alert-info mt-3 mb-0 small">
                    <i class="bi bi-info-circle me-1"></i> {{ __('Your booking is pending approval. You can still use this QR code once confirmed.') }}
                </div>
                @endif
                @else
                <p class="text-danger small">{{ __('Could not generate QR code. Please try again later.') }}</p>
                @endif
            </div>
            @endif

            <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
                <h6 class="fw-bold mb-3">{{ __('site.bkd_actions') }}</h6>
                <a href="{{ route('customer.invoice', $booking) }}" class="btn btn-gold w-100 mb-2"><i class="bi bi-download me-2"></i>{{ __('site.bs_download') }}</a>
                @if($booking->isPending() || $booking->isConfirmed())
                <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#cancelModal">{{ __('site.cb_cancel_title') }}</button>
                @endif
            </div>
            <div class="bg-white rounded-4 p-4 shadow-sm">
                <h6 class="fw-bold mb-3">{{ __('site.bkd_timeline') }}</h6>
                <div class="small">
                    <div class="d-flex gap-2 mb-2"><i class="bi bi-check-circle-fill text-success mt-1"></i><div><div class="fw-semibold">{{ __('site.bkd_submitted') }}</div><div class="text-muted">{{ $booking->created_at->format('M d, Y h:i A') }}</div></div></div>
                    @if($booking->confirmed_at)<div class="d-flex gap-2 mb-2"><i class="bi bi-check-circle-fill text-success mt-1"></i><div><div class="fw-semibold">{{ __('site.bkd_confirmed') }}</div><div class="text-muted">{{ $booking->confirmed_at->format('M d, Y h:i A') }}</div></div></div>@endif
                    @if($booking->checked_in_at)<div class="d-flex gap-2 mb-2"><i class="bi bi-check-circle-fill text-info mt-1"></i><div><div class="fw-semibold">{{ __('site.bkd_checked_in') }}</div><div class="text-muted">{{ $booking->checked_in_at->format('M d, Y h:i A') }}</div></div></div>@endif
                    @if($booking->checked_out_at)<div class="d-flex gap-2 mb-2"><i class="bi bi-check-circle-fill text-secondary mt-1"></i><div><div class="fw-semibold">{{ __('site.bkd_checked_out') }}</div><div class="text-muted">{{ $booking->checked_out_at->format('M d, Y h:i A') }}</div></div></div>@endif
                    @if($booking->cancelled_at)<div class="d-flex gap-2 mb-2"><i class="bi bi-x-circle-fill text-danger mt-1"></i><div><div class="fw-semibold">{{ __('site.bkd_cancelled') }}</div><div class="text-muted">{{ $booking->cancelled_at->format('M d, Y h:i A') }}</div></div></div>@endif
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title fw-bold">{{ __('site.cb_cancel_title') }}</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <form method="POST" action="{{ route('booking.cancel', $booking) }}">@csrf
            <div class="modal-body">
                <p class="text-muted small">{{ __('site.cb_cancel_confirm_msg') }} <strong>{{ $booking->booking_number }}</strong>?</p>
                <textarea name="reason" class="form-control" rows="3" placeholder="{{ __('site.cb_reason_placeholder') }}"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('site.cb_keep_booking') }}</button>
                <button type="submit" class="btn btn-danger">{{ __('site.cb_cancel_confirm') }}</button>
            </div>
        </form>
    </div></div>
</div>
@endsection
