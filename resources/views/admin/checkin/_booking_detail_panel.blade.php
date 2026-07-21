{{--
    Reusable booking-detail panel.
    Required variable: $prefix  (e.g. 'booking' or 'qr')
    All element IDs are prefixed so two panels can coexist on the same page.
--}}
<div class="booking-detail-box">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
        <div>
            <div style="color:var(--admin-text-muted);font-size:.72rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;">Booking</div>
            <div id="{{ $prefix }}BookingNumber" style="color:var(--gold);font-size:1.3rem;font-weight:700;letter-spacing:1px;"></div>
        </div>
        <span id="{{ $prefix }}StatusBadge"></span>
    </div>

    <div class="detail-row">
        <span class="detail-label">Guest</span>
        <span class="detail-value" id="{{ $prefix }}GuestName"></span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Email</span>
        <span class="detail-value" id="{{ $prefix }}GuestEmail"></span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Phone</span>
        <span class="detail-value" id="{{ $prefix }}GuestPhone"></span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Room</span>
        <span class="detail-value" id="{{ $prefix }}RoomInfo"></span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Check-in</span>
        <span class="detail-value" id="{{ $prefix }}CheckIn"></span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Check-out</span>
        <span class="detail-value" id="{{ $prefix }}CheckOut"></span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Nights</span>
        <span class="detail-value" id="{{ $prefix }}Nights"></span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Total</span>
        <span class="detail-value" id="{{ $prefix }}TotalAmount" style="color:var(--gold);font-weight:700;"></span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Payment</span>
        <span class="detail-value" id="{{ $prefix }}PaymentStatus"></span>
    </div>
</div>

<button
    id="{{ $prefix }}CheckInBtn"
    class="btn-gold-lg w-100 mt-3"
    onclick="doCheckIn('{{ $prefix }}')"
    style="display:none;"
>
    <i class="bi bi-box-arrow-in-right me-2"></i>Check In Guest
</button>

<div id="{{ $prefix }}CheckinResultBox" class="checkin-result-box"></div>
