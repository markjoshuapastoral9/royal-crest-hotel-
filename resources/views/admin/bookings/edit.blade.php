@extends('layouts.admin')
@section('title', 'Edit Booking ' . $booking->booking_number)
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.bookings.show', $booking) }}">{{ $booking->booking_number }}</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Edit Booking</h4>
        <small class="text-muted">{{ $booking->booking_number }}</small>
    </div>
    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger mb-4">
    <ul class="mb-0 small">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
    @csrf @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">

            {{-- Guest Information --}}
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-person me-2 text-gold"></i>Guest Information</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="guest_name" class="form-control form-control-sm @error('guest_name') is-invalid @enderror"
                            value="{{ old('guest_name', $booking->guest_name) }}" required>
                        @error('guest_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="guest_email" class="form-control form-control-sm @error('guest_email') is-invalid @enderror"
                            value="{{ old('guest_email', $booking->guest_email) }}" required>
                        @error('guest_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Phone</label>
                        <input type="text" name="guest_phone" class="form-control form-control-sm"
                            value="{{ old('guest_phone', $booking->guest_phone) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Address</label>
                        <input type="text" name="guest_address" class="form-control form-control-sm"
                            value="{{ old('guest_address', $booking->guest_address) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Adults <span class="text-danger">*</span></label>
                        <input type="number" name="adults" class="form-control form-control-sm" min="1"
                            value="{{ old('adults', $booking->adults) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Children</label>
                        <input type="number" name="children" class="form-control form-control-sm" min="0"
                            value="{{ old('children', $booking->children) }}">
                    </div>
                </div>
            </div>

            {{-- Stay Details --}}
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-calendar me-2 text-gold"></i>Stay Details</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Check-in Date <span class="text-danger">*</span></label>
                        <input type="date" name="check_in" id="checkIn" class="form-control form-control-sm @error('check_in') is-invalid @enderror"
                            value="{{ old('check_in', $booking->check_in->format('Y-m-d')) }}" required>
                        @error('check_in')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Check-out Date <span class="text-danger">*</span></label>
                        <input type="date" name="check_out" id="checkOut" class="form-control form-control-sm @error('check_out') is-invalid @enderror"
                            value="{{ old('check_out', $booking->check_out->format('Y-m-d')) }}" required>
                        @error('check_out')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Nights</label>
                        <input type="text" id="nightsDisplay" class="form-control form-control-sm" value="{{ $booking->nights }}" readonly
                            style="background:rgba(255,255,255,.04);color:var(--gold);">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Room</label>
                        <input type="text" class="form-control form-control-sm" readonly
                            value="{{ $booking->room->name }} ({{ $booking->room->roomType->name }} · Room {{ $booking->room->room_number }})"
                            style="background:rgba(255,255,255,.04);">
                        <div class="form-text">Room cannot be changed. Cancel and create a new booking to change room.</div>
                    </div>
                </div>
            </div>

            {{-- Special Requests / Admin Notes --}}
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-chat-text me-2 text-gold"></i>Notes</h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Special Requests</label>
                        <textarea name="special_requests" class="form-control form-control-sm" rows="2"
                            placeholder="Guest special requests...">{{ old('special_requests', $booking->special_requests) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Admin Notes</label>
                        <textarea name="admin_notes" class="form-control form-control-sm" rows="2"
                            placeholder="Internal notes (not visible to guest)...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">

            {{-- Status --}}
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-sliders me-2 text-gold"></i>Booking Status</h6>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Booking Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select form-select-sm">
                        @foreach(['pending','confirmed','checked_in','completed','cancelled'] as $s)
                        <option value="{{ $s }}" {{ old('status', $booking->status) === $s ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label small fw-semibold">Payment Status <span class="text-danger">*</span></label>
                    <select name="payment_status" class="form-select form-select-sm">
                        @foreach(['unpaid','partially_paid','paid','refunded'] as $ps)
                        <option value="{{ $ps }}" {{ old('payment_status', $booking->payment_status) === $ps ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $ps)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Financial Summary --}}
            <div class="admin-card p-4 mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-cash me-2 text-gold"></i>Financial Summary</h6>
                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Room Rate</span>
                        <span>₱{{ number_format($booking->room_price_per_night, 2) }}/night</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span id="subtotalDisplay">₱{{ number_format($booking->subtotal, 2) }}</span>
                    </div>
                    @if($booking->discount_amount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Discount</span>
                        <span>-₱{{ number_format($booking->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">VAT 12%</span>
                        <span id="taxDisplay">₱{{ number_format($booking->tax_amount, 2) }}</span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span class="text-gold" id="totalDisplay">₱{{ number_format($booking->total_amount, 2) }}</span>
                    </div>
                    <div class="form-text mt-2">Totals auto-update when you change dates.</div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-2"></i>Save Changes
                </button>
                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x me-2"></i>Discard
                </a>
            </div>

        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const ratePerNight = {{ $booking->room_price_per_night }};
    const discount     = {{ $booking->discount_amount }};

    function recalculate() {
        const ci = new Date(document.getElementById('checkIn').value);
        const co = new Date(document.getElementById('checkOut').value);
        if (isNaN(ci) || isNaN(co) || co <= ci) return;

        const nights  = Math.round((co - ci) / (1000 * 60 * 60 * 24));
        const sub     = nights * ratePerNight;
        const tax     = sub * 0.12;
        const total   = sub - discount + tax;

        document.getElementById('nightsDisplay').value  = nights + ' night(s)';
        document.getElementById('subtotalDisplay').textContent = '₱' + sub.toLocaleString('en-PH', {minimumFractionDigits:2});
        document.getElementById('taxDisplay').textContent      = '₱' + tax.toLocaleString('en-PH', {minimumFractionDigits:2});
        document.getElementById('totalDisplay').textContent    = '₱' + total.toLocaleString('en-PH', {minimumFractionDigits:2});
    }

    document.getElementById('checkIn').addEventListener('change', recalculate);
    document.getElementById('checkOut').addEventListener('change', recalculate);
</script>
@endpush
