@extends('layouts.app')
@section('title', 'Book Package - ' . $package->name)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
.flatpickr-calendar { background:#1a1214; border:1px solid rgba(166,130,74,.3); border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,.5); }
.flatpickr-months .flatpickr-month, .flatpickr-weekdays, span.flatpickr-weekday { background:#1a1214; color:#C9A87C; }
.flatpickr-day { color:#E6E2DA; }
.flatpickr-day:hover { background:rgba(166,130,74,.2); border-color:transparent; }
.flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange { background:#A6824A; border-color:#A6824A; color:#fff; }
.flatpickr-day.inRange { background:rgba(166,130,74,.15); border-color:transparent; }
.flatpickr-prev-month, .flatpickr-next-month { color:#C9A87C !important; fill:#C9A87C !important; }
.step-card { background:var(--surface,#1a1214); border:1px solid var(--border); border-radius:20px; padding:2rem; margin-bottom:1.5rem; }
.step-card h5 { color:#fff; font-size:1.1rem; font-weight:700; margin-bottom:1.5rem; }
.step-badge { background:var(--gold); color:#101111; width:32px; height:32px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-weight:700; margin-right:.5rem; font-size:.9rem; }
.step-card label { color:var(--text-sec); font-size:.82rem; font-weight:600; }
.step-card .form-control, .step-card .form-select, .step-card textarea { background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); border-radius:10px; color:#fff; padding:.7rem .9rem; font-size:.87rem; }
.step-card .form-control:focus, .step-card .form-select:focus { border-color:var(--gold); background:rgba(255,255,255,.09); box-shadow:0 0 0 3px rgba(166,130,74,.12); color:#fff; }
.step-card .form-control::placeholder, .step-card textarea::placeholder { color:rgba(192,192,192,.35); }
.payment-option .btn-check:checked + label { background:rgba(166,130,74,.15); border-color:var(--gold); color:var(--gold); }
.payment-option label { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.1); color:rgba(255,255,255,.65); transition:all .25s; }
.summary-card { background:var(--surface,#1a1214); border:1px solid var(--border); border-radius:20px; padding:1.8rem; position:sticky; top:90px; }
.summary-card h5 { color:#fff; font-size:1.05rem; font-weight:700; margin-bottom:1.2rem; }
.summary-img { border-radius:16px; height:200px; width:100%; object-fit:cover; margin-bottom:1.2rem; }
.summary-line { display:flex; justify-content:space-between; margin-bottom:.7rem; font-size:.85rem; }
.summary-line.muted { color:var(--text-sec); }
.summary-total { display:flex; justify-content:space-between; font-weight:700; margin-top:.5rem; }
.summary-total .amount { color:var(--gold); font-size:1.4rem; font-family:'Playfair Display',serif; }
.package-inclusion-badge { display:inline-flex; align-items:center; gap:.4rem; background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.25); color:#C9A84C; border-radius:8px; padding:.35rem .7rem; font-size:.78rem; font-weight:600; margin:.2rem; }
.room-option-card { background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.1); border-radius:12px; padding:1rem; cursor:pointer; transition:all .25s; }
.room-option-card:hover { border-color:rgba(201,168,76,.4); background:rgba(201,168,76,.06); }
.room-option-card.selected { border-color:var(--gold); background:rgba(201,168,76,.12); }
</style>
@endpush

@section('content')
<div style="background:var(--bg-dark,#101111); min-height:100vh;">

{{-- Hero --}}
<div class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-gold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('packages.index') }}" class="text-gold">Packages</a></li>
                <li class="breadcrumb-item active text-white-50">Book Package</li>
            </ol>
        </nav>
        <h1 class="text-white mt-2">Book: {{ $package->name }}</h1>
        <p class="text-white-50">Complete your booking details below</p>
    </div>
</div>

<section style="padding:60px 0;">
<div class="container">

@auth
<form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" id="bookingForm">
@csrf
{{-- Hidden: package_id --}}
<input type="hidden" name="package_id" value="{{ $package->id }}">

<div class="row g-4">
{{-- ── LEFT COLUMN ── --}}
<div class="col-lg-8">

    {{-- Package Highlights --}}
    <div class="step-card" style="border-color:rgba(201,168,76,.3);">
        <h5><i class="bi bi-gift text-gold me-2"></i>Package Inclusions</h5>
        <div class="d-flex flex-wrap gap-1 mb-3">
            @foreach($package->inclusion_list as $inclusion)
            <span class="package-inclusion-badge">{{ $inclusion }}</span>
            @endforeach
        </div>
        <div class="d-flex gap-4 small text-muted">
            <span><i class="bi bi-moon-stars text-gold me-1"></i>Minimum {{ $package->min_nights }} {{ Str::plural('night', $package->min_nights) }}</span>
            @if($package->savings > 0)
            <span><i class="bi bi-tag text-gold me-1"></i>Save ₱{{ number_format($package->savings, 0) }}</span>
            @endif
        </div>
    </div>

    {{-- Step 1: Dates --}}
    <div class="step-card">
        <h5><span class="step-badge">1</span>Select Your Dates</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Check-in Date <span class="text-danger">*</span></label>
                <input type="text" name="check_in" id="checkIn" class="form-control" value="{{ old('check_in', $checkIn) }}" required autocomplete="off" readonly placeholder="Select check-in date">
                @error('check_in')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Check-out Date <span class="text-danger">*</span></label>
                <input type="text" name="check_out" id="checkOut" class="form-control" value="{{ old('check_out', $checkOut) }}" required autocomplete="off" readonly placeholder="Select check-out date">
                @error('check_out')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <div id="minNightsNote" class="small" style="color:rgba(201,168,76,.8);">
                    <i class="bi bi-info-circle me-1"></i>Minimum stay: <strong>{{ $package->min_nights }} {{ Str::plural('night', $package->min_nights) }}</strong>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Adults <span class="text-danger">*</span></label>
                <select name="adults" class="form-select" required>
                    @for($i=1;$i<=10;$i++)
                    <option value="{{ $i }}" {{ old('adults',2)==$i?'selected':'' }}>{{ $i }} {{ $i>1?'Adults':'Adult' }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Children</label>
                <select name="children" class="form-select">
                    @for($i=0;$i<=4;$i++)
                    <option value="{{ $i }}" {{ old('children',0)==$i?'selected':'' }}>{{ $i }} {{ $i===1?'Child':'Children' }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    {{-- Step 2: Choose Room --}}
    <div class="step-card">
        <h5><span class="step-badge">2</span>Choose Your Room</h5>
        <p class="text-muted small mb-3">Select the room you'd like for this package</p>
        <div class="row g-3" id="roomList">
            @forelse($rooms->unique('name') as $room)
            <div class="col-md-6">
                <div class="room-option-card" onclick="selectRoom({{ $room->id }}, this)">
                    <input type="radio" name="room_id" value="{{ $room->id }}" id="room_{{ $room->id }}" class="d-none" {{ old('room_id') == $room->id ? 'checked' : '' }} required>
                    <div class="d-flex gap-3 align-items-center">
                        <img src="{{ $room->thumbnail_url }}" style="width:70px;height:55px;object-fit:cover;border-radius:8px;flex-shrink:0;" alt="{{ $room->name }}">
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-white small">{{ $room->name }}</div>
                            <div class="text-muted" style="font-size:.75rem;">{{ $room->roomType->name }}</div>
                            <div class="text-gold fw-bold small">₱{{ number_format($room->price_per_night, 0) }}/night</div>
                        </div>
                        <div class="text-center flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-gold fs-5 check-icon" style="opacity:0;"></i>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert" style="background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.3);color:#f87171;border-radius:10px;">
                    <i class="bi bi-exclamation-circle me-2"></i>No rooms available. Please try different dates.
                </div>
            </div>
            @endforelse
        </div>
        @error('room_id')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
    </div>

    {{-- Step 3: Guest Info --}}
    <div class="step-card">
        <h5><span class="step-badge">3</span>Guest Information</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="guest_name" class="form-control" value="{{ old('guest_name', auth()->user()->name ?? '') }}" required>
                @error('guest_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="guest_email" class="form-control" value="{{ old('guest_email', auth()->user()->email ?? '') }}" required>
                @error('guest_email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                <input type="text" name="guest_phone" class="form-control" value="{{ old('guest_phone', auth()->user()->phone ?? '') }}" required>
                @error('guest_phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Address</label>
                <input type="text" name="guest_address" class="form-control" value="{{ old('guest_address', auth()->user()->address ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Special Requests</label>
                <textarea name="special_requests" class="form-control" rows="3" placeholder="Any special requests or preferences...">{{ old('special_requests') }}</textarea>
            </div>
        </div>
    </div>

    {{-- Step 4: Payment --}}
    <div class="step-card">
        <h5><span class="step-badge">4</span>Payment Method</h5>
        <div class="row g-3">
            @foreach(['cash'=>['bi-cash-coin','Cash'],'gcash'=>['bi-phone','GCash'],'maya'=>['bi-credit-card','Maya'],'bank_transfer'=>['bi-bank','Bank Transfer']] as $val=>[$icon,$label])
            <div class="col-6 col-md-3 payment-option">
                <input type="radio" class="btn-check" name="payment_method" id="pay_{{ $val }}" value="{{ $val }}" {{ old('payment_method','cash')===$val?'checked':'' }} required>
                <label class="btn w-100 py-3 d-flex flex-column align-items-center gap-1" for="pay_{{ $val }}">
                    <i class="bi {{ $icon }} fs-4"></i>
                    <span class="small fw-semibold">{{ $label }}</span>
                </label>
            </div>
            @endforeach
        </div>
        @error('payment_method')<div class="text-danger small mt-2">{{ $message }}</div>@enderror

        {{-- Payment Instructions --}}
        <div id="paymentInstructions" style="display:none;margin-top:1.5rem;background:rgba(250,204,21,.1);border:1px solid rgba(250,204,21,.3);border-radius:12px;padding:1.2rem;">
            <h6 style="color:#fbbf24;font-weight:700;margin-bottom:.8rem;font-size:.9rem;"><i class="bi bi-info-circle me-2"></i>Payment Instructions</h6>
            <div id="instructions_gcash" class="payment-details" style="display:none;color:#fbbf24;font-size:.85rem;">
                <div>GCash Number: <strong>0917 123 4567</strong></div>
                <div>Account Name: <strong>THE ROYAL CREST</strong></div>
            </div>
            <div id="instructions_maya" class="payment-details" style="display:none;color:#fbbf24;font-size:.85rem;">
                <div>Maya Number: <strong>0917 123 4567</strong></div>
                <div>Account Name: <strong>THE ROYAL CREST</strong></div>
            </div>
            <div id="instructions_bank_transfer" class="payment-details" style="display:none;color:#fbbf24;font-size:.85rem;">
                <div>Bank: <strong>BDO UNIBANK</strong></div>
                <div>Account No: <strong>123-456-789012</strong></div>
                <div>Account Name: <strong>THE ROYAL CREST INC.</strong></div>
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label">Payment Proof (optional)</label>
            <input type="file" name="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
            <div class="form-text text-muted small">Upload screenshot or receipt if paying via GCash, Maya, or Bank Transfer</div>
        </div>
    </div>

    {{-- Terms --}}
    <div class="step-card" style="padding:1.5rem;">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="terms" id="terms" value="1" {{ old('terms')?'checked':'' }} required>
            <label class="form-check-label" for="terms" style="color:rgba(192,192,192,.85);font-size:.85rem;">
                I agree to the <a href="#" style="color:var(--gold);">Terms & Conditions</a> and <a href="#" style="color:var(--gold);">Cancellation Policy</a>. Check-in: 2:00 PM · Check-out: 12:00 PM
            </label>
            @error('terms')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
    </div>

    @if($errors->any())
    <div class="alert" style="background:rgba(220,38,38,.12);border:1px solid rgba(220,38,38,.3);color:#fca5a5;border-radius:12px;" class="small">
        <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 fw-bold rounded-3">
        <i class="bi bi-check-circle me-2"></i>Confirm Package Booking
    </button>

</div>{{-- end col-lg-8 --}}

{{-- ── RIGHT COLUMN: Summary ── --}}
<div class="col-lg-4">
    <div class="summary-card">
        <h5><i class="bi bi-receipt me-2 text-gold"></i>Booking Summary</h5>

        {{-- Package Image --}}
        <img src="{{ asset($package->image ?? 'images/placeholder-package.jpg') }}" class="summary-img" alt="{{ $package->name }}">

        {{-- Package Name + Badge --}}
        <h6 class="text-white fw-bold mb-1">{{ $package->name }}</h6>
        @if($package->discount_percentage > 0)
        <span class="badge mb-3" style="background:rgba(201,168,76,.2);color:#C9A84C;border:1px solid rgba(201,168,76,.4);">SAVE {{ $package->discount_percentage }}%</span>
        @endif

        {{-- Inclusions --}}
        <div class="mb-3">
            @foreach($package->inclusion_list as $inclusion)
            <div class="small text-muted mb-1"><i class="bi bi-check-circle-fill text-gold me-2" style="font-size:.75rem;"></i>{{ $inclusion }}</div>
            @endforeach
        </div>

        <hr style="border-color:var(--border);">

        {{-- Date Summary --}}
        <div class="row g-2 mb-3">
            <div class="col-6">
                <div style="background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:10px;padding:.7rem;text-align:center;">
                    <div style="color:rgba(192,192,192,.6);font-size:.65rem;letter-spacing:1px;text-transform:uppercase;">Check-in</div>
                    <div class="text-white fw-semibold small" id="summCheckIn">--</div>
                </div>
            </div>
            <div class="col-6">
                <div style="background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:10px;padding:.7rem;text-align:center;">
                    <div style="color:rgba(192,192,192,.6);font-size:.65rem;letter-spacing:1px;text-transform:uppercase;">Check-out</div>
                    <div class="text-white fw-semibold small" id="summCheckOut">--</div>
                </div>
            </div>
        </div>

        {{-- Price Breakdown --}}
        <div class="summary-line muted">
            <span>Package Price</span>
            <span class="text-white">₱{{ number_format($package->price, 0) }}</span>
        </div>
        <div class="summary-line muted">
            <span><span id="summNights">{{ $package->min_nights }}</span> {{ Str::plural('night', $package->min_nights) }} stay</span>
            <span id="summRoomCost" class="text-white">--</span>
        </div>
        <div class="summary-line muted">
            <span>VAT (12%)</span>
            <span id="summTax" class="text-white">--</span>
        </div>

        @if($package->original_price)
        <div class="summary-line" style="color:#4ade80;">
            <span><i class="bi bi-tag me-1"></i>You Save</span>
            <span>₱{{ number_format($package->savings, 0) }}</span>
        </div>
        @endif

        <hr style="border-color:var(--border);">
        <div class="summary-total">
            <span class="text-white">Total</span>
            <span class="amount" id="summTotal">₱{{ number_format($package->price * 1.12, 0) }}</span>
        </div>

        <div class="mt-3 small text-muted text-center">
            <i class="bi bi-shield-check text-gold me-1"></i>Free cancellation on pending bookings
        </div>
    </div>
</div>

</div>{{-- end row --}}
</form>

@else
{{-- Not logged in --}}
<div class="text-center py-5">
    <div class="rounded-4 p-5 mx-auto" style="max-width:500px;background:var(--surface,#1a1214);border:1px solid var(--border);">
        <i class="bi bi-person-lock text-gold fs-1 mb-3 d-block"></i>
        <h4 class="text-white mb-2">Login Required</h4>
        <p class="text-muted mb-4">Please log in to book this package.</p>
        <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="btn btn-gold px-5">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login to Continue
        </a>
    </div>
</div>
@endauth

</div>
</section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
const packagePrice = {{ $package->price }};
const minNights    = {{ $package->min_nights }};

// ── Flatpickr ────────────────────────────────────────────────────────────────
const fpIn = flatpickr('#checkIn', {
    dateFormat  : 'Y-m-d',
    minDate     : 'today',
    defaultDate : '{{ $checkIn }}',
    disableMobile: true,
    onChange(dates) {
        if (!dates[0]) return;
        const minOut = new Date(dates[0]);
        minOut.setDate(minOut.getDate() + minNights);
        fpOut.set('minDate', minOut);
        if (fpOut.selectedDates[0] && fpOut.selectedDates[0] < minOut) {
            fpOut.setDate(minOut, true);
        }
        recalc();
    },
});

const fpOut = flatpickr('#checkOut', {
    dateFormat  : 'Y-m-d',
    minDate     : new Date(new Date('{{ $checkOut }}').getTime()),
    defaultDate : '{{ $checkOut }}',
    disableMobile: true,
    onChange() { recalc(); },
});

// ── Recalculate Summary ───────────────────────────────────────────────────────
function recalc() {
    const ci = document.getElementById('checkIn').value;
    const co = document.getElementById('checkOut').value;
    if (!ci || !co) return;

    const nights  = Math.max(minNights, Math.round((new Date(co) - new Date(ci)) / 86400000));
    const roomRow = document.getElementById('summRoomCost');
    const tax     = packagePrice * 0.12;
    const total   = packagePrice + tax;

    document.getElementById('summNights').textContent  = nights;
    if (roomRow) roomRow.textContent = '₱' + packagePrice.toLocaleString('en-PH', {minimumFractionDigits:0});
    document.getElementById('summTax').textContent     = '₱' + tax.toLocaleString('en-PH', {minimumFractionDigits:0});
    document.getElementById('summTotal').textContent   = '₱' + total.toLocaleString('en-PH', {minimumFractionDigits:0});

    const fmt = {month:'short', day:'numeric', year:'numeric'};
    document.getElementById('summCheckIn').textContent  = new Date(ci + 'T00:00:00').toLocaleDateString('en-US', fmt);
    document.getElementById('summCheckOut').textContent = new Date(co + 'T00:00:00').toLocaleDateString('en-US', fmt);
}

// ── Room Selection ────────────────────────────────────────────────────────────
function selectRoom(id, card) {
    document.querySelectorAll('.room-option-card').forEach(c => {
        c.classList.remove('selected');
        c.querySelector('.check-icon').style.opacity = '0';
    });
    card.classList.add('selected');
    card.querySelector('.check-icon').style.opacity = '1';
    document.getElementById('room_' + id).checked = true;
}

// ── Payment Instructions ──────────────────────────────────────────────────────
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function () {
        const box = document.getElementById('paymentInstructions');
        document.querySelectorAll('.payment-details').forEach(d => d.style.display = 'none');
        if (['gcash','maya','bank_transfer'].includes(this.value)) {
            box.style.display = 'block';
            const el = document.getElementById('instructions_' + this.value);
            if (el) el.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    });
});

// Init on load
recalc();
document.addEventListener('DOMContentLoaded', function () {
    const sel = document.querySelector('input[name="payment_method"]:checked');
    if (sel) sel.dispatchEvent(new Event('change'));

    // Pre-select first room
    const firstRoom = document.querySelector('.room-option-card');
    if (firstRoom) {
        const id = firstRoom.querySelector('input[type="radio"]').value;
        selectRoom(id, firstRoom);
    }
});
</script>
@endpush
