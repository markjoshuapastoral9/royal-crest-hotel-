@extends('layouts.app')
@section('title', __('site.cb_title'))

@push('styles')
<style>
@media (max-width: 576px) {
    .col-md-2.col-4 img { height: 65px !important; }
    .col-md-3 { display: none; }
    .col-md-4.col-8 { flex: 1; }
    .p-4.border-bottom { padding: 1rem !important; }
    .d-flex.gap-2.mt-3 { flex-wrap: wrap; }
    .d-flex.gap-2.mt-3 .btn { flex: 1; font-size: .78rem; padding: .35rem .5rem; }
    section[style] { padding: 20px 0 !important; }
}
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="container">
        <h1 class="text-white">{{ __('site.cb_title') }}</h1>
        <p class="text-white-50">{{ __('site.cb_subtitle') }}</p>
    </div>
</div>

<section style="padding:50px 0; background:var(--bg-dark,#101111);">
<div class="container">
    <div class="rounded-4 shadow-sm" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center" style="border-color:var(--border)!important;">
            <h5 class="fw-bold mb-0 text-white">{{ __('site.cb_history') }}</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('customer.calendar') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-calendar3 me-1"></i>Calendar View
                </a>
                <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-sm">{{ __('site.cb_book_new') }}</a>
            </div>
        </div>
        @forelse($bookings as $booking)
        <div class="p-4 border-bottom" style="border-color:var(--border)!important;">
            <div class="row align-items-center g-3">
                <div class="col-md-2 col-4">
                    <img src="{{ $booking->room->thumbnail_url }}" class="img-fluid rounded-3" style="height:80px;width:100%;object-fit:cover;" alt="{{ $booking->room->translated_name }}">
                </div>
                <div class="col-md-4 col-8">
                    <div class="fw-semibold text-white">{{ $booking->room->translated_name }}</div>
                    <div class="text-muted small">{{ $booking->room->roomType->name }} • Room {{ $booking->room->room_number }}</div>
                    <div class="text-gold small fw-bold mt-1" style="letter-spacing:1px;">{{ $booking->booking_number }}</div>
                </div>
                <div class="col-md-3">
                    <div class="small text-muted"><i class="bi bi-calendar me-1"></i>{{ __('site.cb_checkin') }}</div>
                    <div class="small fw-semibold text-white">{{ $booking->check_in->format('M d, Y') }}</div>
                    <div class="small text-muted mt-1"><i class="bi bi-calendar me-1"></i>{{ __('site.cb_checkout') }}</div>
                    <div class="small fw-semibold text-white">{{ $booking->check_out->format('M d, Y') }}</div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column align-items-start gap-1">
                        <span class="badge bg-{{ $booking->status_badge }}">{{ ucfirst(str_replace('_',' ',$booking->status)) }}</span>
                        <span class="badge bg-{{ $booking->payment_status_badge }}">{{ ucfirst(str_replace('_',' ',$booking->payment_status)) }}</span>
                        <div class="fw-bold text-gold mt-1">₱{{ number_format($booking->total_amount,2) }}</div>
                    </div>
                </div>
            </div>
            @if(in_array($booking->payment_method, ['gcash', 'maya', 'bank_transfer']) && $booking->payment_status !== 'paid')
            <div class="alert alert-warning mb-0 mt-3" style="font-size:.85rem;">
                <i class="bi bi-exclamation-triangle me-2"></i><strong>{{ __('site.cb_payment_pending') }}</strong> {{ strtoupper(str_replace('_', ' ', $booking->payment_method)) }} payment. <a href="{{ route('booking.show', $booking) }}" class="alert-link fw-bold">{{ __('site.cb_view_instructions') }}</a>
            </div>
            @endif
            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('booking.show', $booking) }}" class="btn btn-outline-secondary btn-sm">{{ __('site.cb_view_details') }}</a>
                <a href="{{ route('customer.invoice', $booking) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-download me-1"></i>{{ __('site.cb_invoice') }}</a>
                @if(!$booking->isCancelled())
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#qrModal{{ $booking->id }}">
                    <i class="bi bi-qr-code me-1"></i>Show QR
                </button>
                @endif
                @if($booking->isPending() || $booking->isConfirmed())
                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $booking->id }}">{{ __('site.cb_cancel') }}</button>
                @endif
            </div>
        </div>

        {{-- QR Modal for all active bookings --}}
        @if(!$booking->isCancelled())
        @php
            try {
                $qrSvc = app(\App\Services\QrCodeService::class);
                $qrUri = $qrSvc->generate($booking);
            } catch (\Throwable $e) {
                $qrUri = null;
            }
        @endphp
        <div class="modal fade" id="qrModal{{ $booking->id }}" tabindex="-1">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content" style="background:var(--surface,#1a1214);border:1px solid var(--border);color:#fff;border-radius:16px;">
                    <div class="modal-header border-0 pb-0">
                        <h6 class="modal-title fw-bold" style="color:#C9A84C;"><i class="bi bi-qr-code me-2"></i>Check-in QR Code</h6>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center pt-2">
                        <p style="color:#C0C0C0;font-size:.8rem;margin-bottom:1rem;">Present this at the front desk for express check-in.</p>
                        @if($qrUri)
                        <div style="display:inline-block;background:#fff;padding:14px;border-radius:10px;">
                            <img src="{{ $qrUri }}" alt="QR Code" style="width:180px;height:180px;display:block;">
                        </div>
                        <div style="margin-top:.8rem;color:rgba(201,168,76,.8);font-size:.8rem;font-weight:600;">{{ $booking->booking_number }}</div>
                        <a href="{{ $qrUri }}" download="checkin-{{ $booking->booking_number }}.svg" class="btn btn-sm mt-2" style="background:rgba(201,168,76,.15);border:1px solid rgba(201,168,76,.4);color:#C9A84C;font-size:.8rem;border-radius:7px;">
                            <i class="bi bi-download me-1"></i>Download
                        </a>
                        @else
                        <p style="color:#ea868f;font-size:.85rem;">Could not generate QR code. Please try again later.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Cancel Modal -->
        <div class="modal fade" id="cancelModal{{ $booking->id }}" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" style="background:var(--surface,#1a1214);border:1px solid var(--border);color:#fff;">
                    <div class="modal-header border-0"><h6 class="modal-title fw-bold text-white">{{ __('site.cb_cancel_title') }}</h6><button class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
                    <form method="POST" action="{{ route('booking.cancel', $booking) }}">@csrf
                        <div class="modal-body pt-0">
                            <p class="text-muted small mb-3">{{ __('site.cb_cancel_confirm_msg') }} <strong class="text-white">{{ $booking->booking_number }}</strong>?</p>
                            <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="{{ __('site.cb_reason_placeholder') }}" style="background:var(--surface-2,#150e10);border-color:var(--border);color:#fff;"></textarea>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">{{ __('site.cb_keep_booking') }}</button>
                            <button class="btn btn-sm btn-danger">{{ __('site.cb_cancel_confirm') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="bi bi-calendar-x fs-2 d-block mb-3"></i>{{ __('site.cb_no_bookings') }}
            <div class="mt-2"><a href="{{ route('rooms.index') }}" class="btn btn-gold">{{ __('site.cd_browse_rooms') }}</a></div>
        </div>
        @endforelse
        @if($bookings->hasPages())
        <div class="p-4">{{ $bookings->links() }}</div>
        @endif
    </div>
</div>
</section>
@endsection
