@extends('layouts.admin')
@section('title', 'Walk-in Booking')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
<li class="breadcrumb-item active">Walk-in Booking</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">New Walk-in Booking</h4>
        <p class="mb-0" style="color:var(--admin-text-muted);font-size:.85rem;">Create a manual booking for a guest who arrived in person.</p>
    </div>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Bookings
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <strong>Please fix the following errors:</strong>
    <ul class="mb-0 mt-1">
        @foreach($errors->all() as $error)
        <li style="font-size:.85rem;">{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form method="POST" action="{{ route('admin.bookings.walk-in.store') }}" id="walkInForm">
@csrf

<div class="row g-4">
    {{-- LEFT COLUMN --}}
    <div class="col-lg-8">

        {{-- Guest Information --}}
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3" style="color:var(--gold);letter-spacing:.5px;">
                <i class="bi bi-person-badge me-2"></i>Guest Information
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Full Name <span style="color:#ea868f;">*</span></label>
                    <input type="text" name="guest_name" class="form-control @error('guest_name') is-invalid @enderror"
                        value="{{ old('guest_name') }}" placeholder="e.g. Juan Dela Cruz" required>
                    @error('guest_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Email Address <span style="color:#ea868f;">*</span></label>
                    <input type="email" name="guest_email" class="form-control @error('guest_email') is-invalid @enderror"
                        value="{{ old('guest_email') }}" placeholder="guest@email.com" required>
                    @error('guest_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Phone Number <span style="color:#ea868f;">*</span></label>
                    <input type="text" name="guest_phone" class="form-control @error('guest_phone') is-invalid @enderror"
                        value="{{ old('guest_phone') }}" placeholder="+63 9XX XXX XXXX" required>
                    @error('guest_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Address</label>
                    <input type="text" name="guest_address" class="form-control @error('guest_address') is-invalid @enderror"
                        value="{{ old('guest_address') }}" placeholder="Street, City, Province">
                    @error('guest_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Room & Stay Details --}}
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3" style="color:var(--gold);letter-spacing:.5px;">
                <i class="bi bi-door-open me-2"></i>Room & Stay Details
            </h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Select Room <span style="color:#ea868f;">*</span></label>
                    <select name="room_id" id="roomSelect" class="form-select @error('room_id') is-invalid @enderror" required>
                        <option value="">-- Choose an available room --</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}"
                            data-price="{{ $room->price_per_night }}"
                            data-name="{{ $room->name }}"
                            {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->name }}
                            @if($room->room_number) &nbsp;(#{{ $room->room_number }})@endif
                            &nbsp;— ₱{{ number_format($room->price_per_night, 2) }}/night
                            @if($room->roomType) &nbsp;[{{ $room->roomType->name }}]@endif
                        </option>
                        @endforeach
                    </select>
                    @error('room_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($rooms->isEmpty())
                    <div class="mt-2 small" style="color:#ea868f;">
                        <i class="bi bi-exclamation-triangle me-1"></i>No available rooms at the moment.
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Check-in Date <span style="color:#ea868f;">*</span></label>
                    <input type="date" name="check_in" id="checkIn" class="form-control @error('check_in') is-invalid @enderror"
                        value="{{ old('check_in', date('Y-m-d')) }}" required>
                    @error('check_in')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Check-out Date <span style="color:#ea868f;">*</span></label>
                    <input type="date" name="check_out" id="checkOut" class="form-control @error('check_out') is-invalid @enderror"
                        value="{{ old('check_out', date('Y-m-d', strtotime('+1 day'))) }}" required>
                    @error('check_out')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Adults <span style="color:#ea868f;">*</span></label>
                    <input type="number" name="adults" class="form-control @error('adults') is-invalid @enderror"
                        value="{{ old('adults', 1) }}" min="1" max="20" required>
                    @error('adults')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Children</label>
                    <input type="number" name="children" class="form-control @error('children') is-invalid @enderror"
                        value="{{ old('children', 0) }}" min="0" max="20">
                    @error('children')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Payment & Booking Status --}}
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3" style="color:var(--gold);letter-spacing:.5px;">
                <i class="bi bi-credit-card me-2"></i>Payment & Booking Status
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Payment Method <span style="color:#ea868f;">*</span></label>
                    <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                        <option value="">-- Select Method --</option>
                        @foreach(['cash' => 'Cash', 'gcash' => 'GCash', 'maya' => 'Maya', 'bank_transfer' => 'Bank Transfer'] as $val => $label)
                        <option value="{{ $val }}" {{ old('payment_method') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Payment Status <span style="color:#ea868f;">*</span></label>
                    <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                        <option value="unpaid" {{ old('payment_status', 'unpaid') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                    @error('payment_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Booking Status <span style="color:#ea868f;">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status', 'confirmed') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', 'confirmed') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3" style="color:var(--gold);letter-spacing:.5px;">
                <i class="bi bi-chat-left-text me-2"></i>Additional Information
            </h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Special Requests</label>
                    <textarea name="special_requests" class="form-control" rows="3"
                        placeholder="Guest's special requests or preferences...">{{ old('special_requests') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Admin Notes</label>
                    <textarea name="admin_notes" class="form-control" rows="3"
                        placeholder="Internal notes for hotel staff (not visible to guest)...">{{ old('admin_notes') }}</textarea>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN — Price Summary --}}
    <div class="col-lg-4">
        <div class="admin-card p-4" style="position:sticky;top:80px;">
            <h6 class="fw-bold mb-3" style="color:var(--gold);letter-spacing:.5px;">
                <i class="bi bi-receipt me-2"></i>Booking Summary
            </h6>

            <div id="summaryPlaceholder" style="color:var(--admin-text-muted);font-size:.85rem;text-align:center;padding:20px 0;">
                <i class="bi bi-calculator fs-2 d-block mb-2"></i>
                Select a room and dates to see pricing
            </div>

            <div id="summaryDetails" style="display:none;">
                <div style="background:var(--admin-surface-2);border-radius:8px;padding:14px;margin-bottom:16px;">
                    <div class="small fw-semibold mb-1" id="sumRoomName" style="color:var(--gold);"></div>
                    <div class="small" style="color:var(--admin-text-muted);" id="sumRoomPrice"></div>
                </div>

                <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                    <span style="color:var(--admin-text-muted);">Nights</span>
                    <span id="sumNights" class="fw-semibold">—</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                    <span style="color:var(--admin-text-muted);">Subtotal</span>
                    <span id="sumSubtotal" class="fw-semibold">—</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                    <span style="color:var(--admin-text-muted);">VAT (12%)</span>
                    <span id="sumTax" class="fw-semibold">—</span>
                </div>
                <hr style="border-color:var(--admin-border);margin:10px 0;">
                <div class="d-flex justify-content-between" style="font-size:1rem;">
                    <span class="fw-bold">Total</span>
                    <span id="sumTotal" class="fw-bold" style="color:var(--gold);font-size:1.1rem;">—</span>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-gold w-100 fw-bold py-2">
                    <i class="bi bi-person-check me-2"></i>Create Walk-in Booking
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                    Cancel
                </a>
            </div>

            <div class="mt-3 p-3" style="background:rgba(201,168,76,.08);border-radius:8px;border:1px solid rgba(201,168,76,.2);">
                <div class="small" style="color:var(--admin-text-muted);">
                    <i class="bi bi-info-circle me-1" style="color:var(--gold);"></i>
                    Walk-in bookings are created without an online account. The room will be marked <strong style="color:var(--gold);">occupied</strong> if status is set to Confirmed.
                </div>
            </div>
        </div>
    </div>

</div><!-- .row -->
</form>
@endsection

@push('scripts')
<script>
(function () {
    const roomSelect = document.getElementById('roomSelect');
    const checkIn    = document.getElementById('checkIn');
    const checkOut   = document.getElementById('checkOut');

    const placeholder = document.getElementById('summaryPlaceholder');
    const details     = document.getElementById('summaryDetails');

    const sumRoomName  = document.getElementById('sumRoomName');
    const sumRoomPrice = document.getElementById('sumRoomPrice');
    const sumNights    = document.getElementById('sumNights');
    const sumSubtotal  = document.getElementById('sumSubtotal');
    const sumTax       = document.getElementById('sumTax');
    const sumTotal     = document.getElementById('sumTotal');

    function formatPHP(amount) {
        return '₱' + amount.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function recalculate() {
        const selectedOption = roomSelect.options[roomSelect.selectedIndex];
        const price = parseFloat(selectedOption?.dataset?.price || 0);
        const name  = selectedOption?.dataset?.name || '';
        const ci    = new Date(checkIn.value);
        const co    = new Date(checkOut.value);

        if (!price || !checkIn.value || !checkOut.value || isNaN(ci) || isNaN(co) || co <= ci) {
            placeholder.style.display = 'block';
            details.style.display     = 'none';
            return;
        }

        const nights   = Math.round((co - ci) / (1000 * 60 * 60 * 24));
        const subtotal = nights * price;
        const tax      = Math.round(subtotal * 0.12 * 100) / 100;
        const total    = subtotal + tax;

        sumRoomName.textContent  = name;
        sumRoomPrice.textContent = formatPHP(price) + ' / night';
        sumNights.textContent    = nights + (nights === 1 ? ' night' : ' nights');
        sumSubtotal.textContent  = formatPHP(subtotal);
        sumTax.textContent       = formatPHP(tax);
        sumTotal.textContent     = formatPHP(total);

        placeholder.style.display = 'none';
        details.style.display     = 'block';
    }

    roomSelect.addEventListener('change', recalculate);
    checkIn.addEventListener('change', function () {
        // Ensure check-out is always after check-in
        if (checkOut.value && checkOut.value <= checkIn.value) {
            const next = new Date(checkIn.value);
            next.setDate(next.getDate() + 1);
            checkOut.value = next.toISOString().split('T')[0];
        }
        recalculate();
    });
    checkOut.addEventListener('change', recalculate);

    // Initial calc if old values are present
    recalculate();
})();
</script>
@endpush
