@extends('layouts.app')
@section('title', 'Book ' . $room->name)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
/* flatpickr dark theme override */
.flatpickr-calendar { background:#1a1214; border:1px solid rgba(166,130,74,.3); border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,.5); }
.flatpickr-months .flatpickr-month, .flatpickr-weekdays, span.flatpickr-weekday { background:#1a1214; color:#C9A87C; }
.flatpickr-day { color:#E6E2DA; }
.flatpickr-day:hover { background:rgba(166,130,74,.2); border-color:transparent; }
.flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange { background:#A6824A; border-color:#A6824A; color:#fff; }
.flatpickr-day.inRange { background:rgba(166,130,74,.15); border-color:transparent; color:#E6E2DA; }
.flatpickr-day.flatpickr-disabled,
.flatpickr-day.flatpickr-disabled:hover {
    background: rgba(220,38,38,.15) !important;
    color: rgba(248,113,113,.7) !important;
    text-decoration: line-through;
    cursor: not-allowed;
    border-color: transparent !important;
}
.flatpickr-day.today { border-color: #A6824A; }
.flatpickr-prev-month, .flatpickr-next-month { color:#C9A87C !important; fill:#C9A87C !important; }
.flatpickr-current-month .flatpickr-monthDropdown-months,
.flatpickr-current-month input.cur-year { color:#E6E2DA; background:transparent; }
.numInputWrapper span { border-color:rgba(166,130,74,.2); }
.numInputWrapper span:hover { background:rgba(166,130,74,.15); }

/* availability alert */
#availAlert { border-radius:10px; font-size:.84rem; display:none; margin-top:.75rem; }
#availAlert.show { display:block; }
.avail-ok   { background:rgba(74,222,128,.1);  border:1px solid rgba(74,222,128,.3);  color:#4ade80; }
.avail-busy { background:rgba(220,38,38,.12);  border:1px solid rgba(220,38,38,.3);   color:#f87171; }

.booking-page { background: var(--bg-dark, #101111); min-height: 100vh; }
.booking-hero { background: linear-gradient(135deg, var(--bg-dark) 0%, var(--surface) 100%); padding: 100px 0 60px; border-bottom: 1px solid var(--border); }
.booking-hero h1 { color: #fff; font-family: 'Playfair Display', serif; }
.booking-hero p { color: var(--text-sec, #C0C0C0); }

.step-card { background: var(--surface, #1a1214); border: 1px solid var(--border); border-radius: 20px; padding: 2rem; margin-bottom: 1.5rem; }
.step-card h5 { color: #fff; font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; font-family: 'Inter', sans-serif; }
.step-badge { background: var(--gold); color: #101111; width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; margin-right: .5rem; font-size: .9rem; }

.step-card label { color: var(--text-sec); font-size: .82rem; font-weight: 600; font-family: 'Inter', sans-serif; }
.step-card .form-control, .step-card .form-select, .step-card textarea { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12); border-radius: 10px; color: #fff; padding: .7rem .9rem; font-size: .87rem; }
.step-card .form-control:focus, .step-card .form-select:focus, .step-card textarea:focus { border-color: var(--gold); background: rgba(255,255,255,.09); box-shadow: 0 0 0 3px rgba(166,130,74,.12); color: #fff; }
.step-card .form-control::placeholder, .step-card textarea::placeholder { color: rgba(192,192,192,.35); }
.step-card .form-select option { background: var(--surface); color: #fff; }
.step-card .form-text { color: rgba(192,192,192,.55); font-size: .75rem; }

.payment-option { position: relative; }
.payment-option .btn-check:checked + label { background: rgba(166,130,74,.15); border-color: var(--gold); color: var(--gold); }
.payment-option label { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.1); color: rgba(255,255,255,.65); transition: all .25s; }
.payment-option label:hover { background: rgba(255,255,255,.06); border-color: rgba(255,255,255,.2); }

.promo-box { background: rgba(255,255,255,.03); border: 1px solid var(--border); border-radius: 12px; padding: 1.2rem; margin-top: 1.2rem; }
.promo-box label { color: var(--text-sec); }
.promo-box .btn-outline-secondary { background: rgba(255,255,255,.05); border-color: rgba(255,255,255,.15); color: rgba(255,255,255,.7); }
.promo-box .btn-outline-secondary:hover { background: var(--gold); border-color: var(--gold); color: #101111; }

.terms-card { background: var(--surface); border: 1px solid var(--border); border-radius: 20px; padding: 1.5rem; margin-bottom: 1.5rem; }
.terms-card .form-check-label { color: rgba(192,192,192,.85); font-size: .85rem; line-height: 1.7; }
.terms-card .form-check-input { accent-color: var(--gold); width: 18px; height: 18px; }
.terms-card a { color: var(--gold); text-decoration: none; }

.summary-card { background: var(--surface); border: 1px solid var(--border); border-radius: 20px; padding: 1.8rem; position: sticky; top: 90px; }
.summary-card h5 { color: #fff; font-size: 1.05rem; font-weight: 700; margin-bottom: 1.2rem; font-family: 'Inter', sans-serif; }
.summary-card h6 { color: #fff; font-size: 1rem; font-weight: 700; }
.summary-img { border-radius: 16px; height: 180px; width: 100%; object-fit: cover; margin-bottom: 1.2rem; }
.summary-room-meta { color: var(--text-sec); font-size: .82rem; }
.summary-dates { background: rgba(255,255,255,.04); border: 1px solid var(--border); border-radius: 12px; padding: .8rem; text-align: center; font-size: .84rem; }
.summary-dates .label { color: rgba(192,192,192,.6); font-size: .68rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
.summary-dates .value { color: #fff; font-weight: 600; margin-top: .2rem; }
.summary-line { display: flex; justify-content: space-between; margin-bottom: .7rem; font-size: .85rem; }
.summary-line.muted { color: var(--text-sec); }
.summary-line.success { color: #34d399; }
.summary-total { display: flex; justify-content: space-between; font-weight: 700; margin-top: .5rem; }
.summary-total .amount { color: var(--gold); font-size: 1.4rem; font-family: 'Playfair Display', serif; }

.alert-danger { background: rgba(220,38,38,.12); border: 1px solid rgba(220,38,38,.3); color: #fca5a5; border-radius: 12px; }

/* ── MOBILE RESPONSIVE ── */
@media (max-width: 768px) {
    .booking-hero { padding: 80px 0 30px; }
    .booking-hero h1 { font-size: 1.6rem; }
    section[style] { padding: 30px 0 !important; }

    .step-card { padding: 1.2rem; border-radius: 14px; margin-bottom: 1rem; }
    .step-card h5 { font-size: .95rem; margin-bottom: 1rem; }
    .step-badge { width: 26px; height: 26px; font-size: .75rem; }

    .payment-option label { padding: .7rem .4rem !important; }
    .payment-option label i { font-size: 1.2rem !important; }
    .payment-option label span { font-size: .7rem !important; }

    .promo-box { padding: .9rem; }

    .terms-card { padding: 1rem; border-radius: 14px; }

    /* Summary card — goes below form on mobile */
    .summary-card { position: static !important; border-radius: 14px; padding: 1.2rem; margin-top: 0; }
    .summary-card h5 { font-size: .95rem; }
    .summary-img { height: 140px !important; border-radius: 12px; }
    .summary-total .amount { font-size: 1.2rem; }

    /* Date cards side by side */
    .summary-dates { padding: .6rem; }
    .summary-dates .label { font-size: .62rem; }
    .summary-dates .value { font-size: .8rem; }

    /* Move summary to top on mobile */
    .col-lg-4 { order: -1; }
    .col-lg-8 { order: 1; }

    /* Submit button */
    .btn-lg { font-size: .9rem; padding: .8rem !important; }
}

@media (max-width: 480px) {
    .booking-hero h1 { font-size: 1.4rem; }
    .step-card { padding: 1rem; }
    .summary-img { height: 120px !important; }
    .summary-card h6 { font-size: .9rem; }
    .summary-line { font-size: .8rem; }
    
    /* Payment instructions mobile */
    #paymentInstructions { padding: 1rem !important; }
    #paymentInstructions h6 { font-size: .85rem !important; }
    #paymentInstructions p { font-size: .75rem !important; }
    .payment-details > div { padding: .8rem !important; font-size: .75rem !important; }
    .payment-details span[style*="width:130px"] { display: block !important; width: 100% !important; margin-bottom: .3rem; }
}

/* Room Unit Selector Styles */
.room-units-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 0.5rem;
}

/* When only 1 unit — cap the width so it doesn't stretch full width */
.room-units-grid:has(.room-unit-option:only-child) {
    grid-template-columns: minmax(0, 220px);
}

.room-unit-option .btn {
    border: 1px solid rgba(166, 130, 74, 0.3);
    background: rgba(26, 18, 20, 0.8);
    transition: all 0.3s ease;
    height: 100%;
    border-radius: 12px;
    color: #C0C0C0;
}

.room-unit-option .btn:hover {
    border-color: #A6824A;
    background: rgba(166, 130, 74, 0.1);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(166, 130, 74, 0.2);
}

.room-unit-option .btn-check:checked + .btn {
    background: linear-gradient(135deg, #A6824A 0%, #8B6F3F 100%);
    border-color: #A6824A;
    color: white;
    box-shadow: 0 4px 12px rgba(166, 130, 74, 0.3);
}

.room-number {
    font-size: 1.1rem;
    font-weight: bold;
    color: #A6824A;
    font-family: 'Playfair Display', serif;
}

.room-unit-option .btn-check:checked + .btn .room-number {
    color: white;
}

.room-details {
    font-size: 0.85rem;
    line-height: 1.4;
    color: #C0C0C0;
}

.room-unit-option .btn-check:checked + .btn .room-details {
    color: rgba(255, 255, 255, 0.9);
}

.room-details div {
    margin-bottom: 0.2rem;
}

.room-details i {
    color: #A6824A;
    margin-right: 0.3rem;
}

.room-unit-option .btn-check:checked + .btn .room-details i {
    color: rgba(255, 255, 255, 0.8);
}

@media (max-width: 768px) {
    .room-units-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.75rem;
    }
}
</style>
@endpush

@section('content')
<div class="booking-page">
<div class="booking-hero">
    <div class="container">
        <h1>{{ __('site.bk_title') }}</h1>
        <p>{{ $displayRoom->name }} · {{ $displayRoom->roomType->name }}</p>
    </div>
</div>

<section style="padding:60px 0;">
<div class="container">
<form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" id="bookingForm">
@csrf
<div class="row g-4">
    <!-- Left: Form -->
    <div class="col-lg-8">
        <!-- Step 1: Dates -->
        <div class="step-card">
            <h5><span class="step-badge">1</span>{{ __('site.bk_step1') }}</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('site.bk_checkin') }} <span class="text-danger">*</span></label>
                    <input type="text" name="check_in" class="form-control @error('check_in') is-invalid @enderror" value="{{ old('check_in', $checkIn) }}" required id="checkIn" placeholder="Select check-in date" autocomplete="off" readonly>
                    @error('check_in')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('site.bk_checkout') }} <span class="text-danger">*</span></label>
                    <input type="text" name="check_out" class="form-control @error('check_out') is-invalid @enderror" value="{{ old('check_out', $checkOut) }}" required id="checkOut" placeholder="Select check-out date" autocomplete="off" readonly>
                    @error('check_out')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                {{-- ── Time selectors ── --}}
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-clock text-gold me-1"></i>Check-in Time <span class="text-danger">*</span>
                    </label>
                    <select name="check_in_time" id="checkInTime" class="form-select @error('check_in_time') is-invalid @enderror" required>
                        @php
                            $checkInTimes = [
                                '08:00'=>'8:00 AM (Early Check-in)',
                                '09:00'=>'9:00 AM (Early Check-in)',
                                '10:00'=>'10:00 AM (Early Check-in)',
                                '11:00'=>'11:00 AM (Early Check-in)',
                                '12:00'=>'12:00 PM (Noon)',
                                '13:00'=>'1:00 PM',
                                '14:00'=>'2:00 PM (Standard)',
                                '15:00'=>'3:00 PM',
                                '16:00'=>'4:00 PM',
                                '17:00'=>'5:00 PM',
                                '18:00'=>'6:00 PM',
                                '19:00'=>'7:00 PM',
                                '20:00'=>'8:00 PM',
                                '21:00'=>'9:00 PM',
                                '22:00'=>'10:00 PM',
                            ];
                            $selectedCiTime = old('check_in_time', '14:00');
                        @endphp
                        @foreach($checkInTimes as $val => $label)
                        <option value="{{ $val }}" {{ $selectedCiTime === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('check_in_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-clock text-gold me-1"></i>Check-out Time <span class="text-danger">*</span>
                    </label>
                    <select name="check_out_time" id="checkOutTime" class="form-select @error('check_out_time') is-invalid @enderror" required>
                        @php
                            $checkOutTimes = [
                                '06:00'=>'6:00 AM',
                                '07:00'=>'7:00 AM',
                                '08:00'=>'8:00 AM',
                                '09:00'=>'9:00 AM',
                                '10:00'=>'10:00 AM',
                                '11:00'=>'11:00 AM (Standard)',
                                '12:00'=>'12:00 PM (Late Check-out)',
                                '13:00'=>'1:00 PM (Late Check-out)',
                                '14:00'=>'2:00 PM (Late Check-out)',
                            ];
                            $selectedCoTime = old('check_out_time', '11:00');
                        @endphp
                        @foreach($checkOutTimes as $val => $label)
                        <option value="{{ $val }}" {{ $selectedCoTime === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('check_out_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Time info note --}}
                <div class="col-12">
                    <div class="d-flex align-items-start gap-2 p-3 rounded-3" style="background:rgba(201,168,76,.07);border:1px solid rgba(201,168,76,.2);font-size:.8rem;color:rgba(192,192,192,.8);">
                        <i class="bi bi-info-circle text-gold mt-1 flex-shrink-0"></i>
                        <div>
                            Standard check-in is <strong class="text-white">2:00 PM</strong> · Standard check-out is <strong class="text-white">11:00 AM</strong>.
                            If you select the same date for both, check-out time must be <strong class="text-white">after</strong> check-in time.
                            Early check-in / late check-out may be subject to an additional fee.
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    {{-- Live availability feedback --}}
                    <div id="availAlert">
                        <i class="bi bi-info-circle me-2"></i><span id="availMsg"></span>
                    </div>
                    {{-- Legend --}}
                    <div class="d-flex gap-3 align-items-center mt-2" style="font-size:.75rem;color:rgba(192,192,192,.55);">
                        <span><span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:rgba(166,130,74,.4);margin-right:4px;vertical-align:middle;"></span>Your selection</span>
                        <span><span style="display:inline-block;width:12px;height:12px;border-radius:3px;background:rgba(220,38,38,.3);margin-right:4px;vertical-align:middle;"></span>Already booked (unavailable)</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('site.bk_adults') }} <span class="text-danger">*</span></label>
                    <select name="adults" class="form-select @error('adults') is-invalid @enderror" required>
                        @for($i=1;$i<=10;$i++)
                        <option value="{{ $i }}" {{ old('adults',1)==$i?'selected':'' }}>{{ $i }} {{ $i>1 ? __('site.bk_adults_plural') : __('site.bk_adult') }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('site.bk_children') }}</label>
                    <select name="children" class="form-select">
                        @for($i=0;$i<=4;$i++)
                        <option value="{{ $i }}" {{ old('children',0)==$i?'selected':'' }}>{{ $i }} {{ __('site.bk_child') }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <!-- Room Unit Selection -->
        <div class="step-card" style="background: rgba(26, 18, 20, 0.8); border: 1px solid rgba(166, 130, 74, 0.3);">
            <h5><span class="step-badge" style="background: linear-gradient(135deg, #A6824A 0%, #8B6F3F 100%);">1.1</span>{{ __('Select Room Unit') }}</h5>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label" style="color: #A6824A; font-weight: 600;">Choose Your Preferred Room <span class="text-danger">*</span></label>
                    <div class="room-units-grid">
                        @if($availableUnits->count() > 0)
                            @foreach($availableUnits as $unit)
                            <div class="room-unit-option">
                                <input type="radio" class="btn-check" name="room_id" id="room_{{ $unit->id }}" 
                                       value="{{ $unit->id }}" {{ old('room_id', $room->id) == $unit->id ? 'checked' : '' }} required>
                                <label class="btn w-100 p-3 d-flex flex-column align-items-center gap-2" for="room_{{ $unit->id }}">
                                    <div class="room-number">{{ $unit->room_number }}</div>
                                    <div class="room-details">
                                        <div><i class="bi bi-people me-1"></i>{{ $unit->capacity }} guests</div>
                                        <div><i class="bi bi-geo-alt me-1"></i>Floor {{ $unit->floor }}</div>
                                        @if($unit->view)
                                        <div><i class="bi bi-eye me-1"></i>{{ $unit->view }} view</div>
                                        @endif
                                    </div>
                                    @if(old('room_id', $room->id) == $unit->id)
                                    <span class="badge currently-selected-badge" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; font-size: 0.7rem; padding: 0.3rem 0.6rem; border-radius: 6px;">Currently Selected</span>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                No rooms available for the selected dates. Please choose different dates.
                            </div>
                        @endif
                    </div>
                    @error('room_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <!-- Step 2: Guest Info -->
        <div class="step-card">
            <h5><span class="step-badge">2</span>{{ __('site.bk_step2') }}</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('site.bk_fullname') }} <span class="text-danger">*</span></label>
                    <input type="text" name="guest_name" class="form-control @error('guest_name') is-invalid @enderror" value="{{ old('guest_name', auth()->user()->name ?? '') }}" required>
                    @error('guest_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('site.bk_email') }} <span class="text-danger">*</span></label>
                    <input type="email" name="guest_email" class="form-control @error('guest_email') is-invalid @enderror" value="{{ old('guest_email', auth()->user()->email ?? '') }}" required>
                    @error('guest_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('site.bk_phone') }} <span class="text-danger">*</span></label>
                    <input type="text" name="guest_phone" class="form-control @error('guest_phone') is-invalid @enderror" value="{{ old('guest_phone', auth()->user()->phone ?? '') }}" required>
                    @error('guest_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('site.bk_address') }}</label>
                    <input type="text" name="guest_address" class="form-control" value="{{ old('guest_address', auth()->user()->address ?? '') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">{{ __('site.bk_special_req') }}</label>
                    <textarea name="special_requests" class="form-control" rows="3" placeholder="{{ __('site.bk_special_placeholder') }}">{{ old('special_requests') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Step 3: Payment -->
        <div class="step-card">
            <h5><span class="step-badge">3</span>{{ __('site.bk_step3') }}</h5>
            <div class="row g-3">
                @foreach(['cash'=>['bi-cash-coin',__('site.bk_cash')],'gcash'=>['bi-phone',__('site.bk_gcash')],'maya'=>['bi-credit-card',__('site.bk_maya')],'bank_transfer'=>['bi-bank',__('site.bk_bank')]] as $val=>[$icon,$label])
                <div class="col-6 col-md-3 payment-option">
                    <input type="radio" class="btn-check" name="payment_method" id="pay_{{ $val }}" value="{{ $val }}" {{ old('payment_method','cash')===$val?'checked':'' }} required>
                    <label class="btn w-100 py-3 d-flex flex-column align-items-center gap-1" for="pay_{{ $val }}">
                        <i class="bi {{ $icon }} fs-4"></i><span class="small fw-semibold">{{ $label }}</span>
                    </label>
                </div>
                @endforeach
            </div>
            @error('payment_method')<div class="text-danger small mt-2">{{ $message }}</div>@enderror

            <div id="paymentInstructions" style="display:none;margin-top:1.5rem;background:rgba(250,204,21,.12);border:1px solid rgba(250,204,21,.3);border-radius:12px;padding:1.2rem;">
                <h6 style="color:#fbbf24;font-weight:700;margin-bottom:1rem;font-size:.9rem;">{{ __('site.bk_pay_instructions') }}</h6>
                <p style="color:#fbbf24;font-size:.82rem;margin-bottom:1rem;line-height:1.7;">{{ __('site.bk_pay_sub') }}</p>
                <div id="instructions_gcash" class="payment-details" style="display:none;"><div style="background:rgba(26,18,20,.8);border:1px solid rgba(250,204,21,.2);border-radius:8px;padding:1rem;margin-bottom:1rem;font-family:'Courier New',monospace;"><div style="margin-bottom:.5rem;color:#C0C0C0;font-size:.85rem;"><span style="display:inline-block;width:130px;">GCash Number:</span><strong style="color:#fbbf24;">0917 123 4567</strong></div><div style="color:#C0C0C0;font-size:.85rem;"><span style="display:inline-block;width:130px;">Account Name:</span><strong style="color:#fbbf24;">THE ROYAL CREST</strong></div></div></div>
                <div id="instructions_maya" class="payment-details" style="display:none;"><div style="background:rgba(26,18,20,.8);border:1px solid rgba(250,204,21,.2);border-radius:8px;padding:1rem;margin-bottom:1rem;font-family:'Courier New',monospace;"><div style="margin-bottom:.5rem;color:#C0C0C0;font-size:.85rem;"><span style="display:inline-block;width:130px;">Maya Number:</span><strong style="color:#fbbf24;">0917 123 4567</strong></div><div style="color:#C0C0C0;font-size:.85rem;"><span style="display:inline-block;width:130px;">Account Name:</span><strong style="color:#fbbf24;">THE ROYAL CREST</strong></div></div></div>
                <div id="instructions_bank_transfer" class="payment-details" style="display:none;"><div style="background:rgba(26,18,20,.8);border:1px solid rgba(250,204,21,.2);border-radius:8px;padding:1rem;margin-bottom:1rem;font-family:'Courier New',monospace;"><div style="margin-bottom:.5rem;color:#C0C0C0;font-size:.85rem;"><span style="display:inline-block;width:130px;">Bank Name:</span><strong style="color:#fbbf24;">BDO UNIBANK</strong></div><div style="margin-bottom:.5rem;color:#C0C0C0;font-size:.85rem;"><span style="display:inline-block;width:130px;">Account Number:</span><strong style="color:#fbbf24;">123-456-789012</strong></div><div style="color:#C0C0C0;font-size:.85rem;"><span style="display:inline-block;width:130px;">Account Name:</span><strong style="color:#fbbf24;">THE ROYAL CREST INC.</strong></div></div></div>
                <p style="color:#fbbf24;font-size:.78rem;margin:0;line-height:1.6;">{{ __('site.bk_pay_important') }}</p>
            </div>

            <div class="mt-3">
                <label class="form-label">{{ __('site.bk_proof_label') }}</label>
                <input type="file" name="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                <div class="form-text">{{ __('site.bk_proof_hint') }}</div>
            </div>

            <div class="promo-box">
                <label class="form-label">{{ __('site.bk_promo_label') }}</label>
                <div class="input-group">
                    <input type="text" id="promoInput" class="form-control" placeholder="{{ __('site.bk_promo_placeholder') }}" style="text-transform:uppercase;">
                    <button type="button" class="btn btn-outline-secondary" onclick="applyPromo()">{{ __('site.bk_promo_apply') }}</button>
                </div>
                <div id="promoMsg" class="small mt-2"></div>
                <input type="hidden" name="promo_code" id="promoCode">
            </div>
        </div>

        <!-- Terms -->
        <div class="terms-card">
            <div class="form-check">
                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
                <label class="form-check-label" for="terms">
                    {{ __('site.bk_terms_label') }}
                    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">{{ __('site.bk_terms_link') }}</a>
                    {{ __('and') ?? 'and' }}
                    <a href="#" data-bs-toggle="modal" data-bs-target="#cancellationModal">{{ __('site.bk_cancel_link') }}</a>.
                    {{ __('site.bk_terms_times') }}
                </label>
                @error('terms')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- Terms & Conditions Modal -->
        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="background:var(--surface,#1a1214);border:1px solid var(--border);color:#fff;">
                    <div class="modal-header" style="border-color:var(--border);">
                        <h5 class="modal-title fw-bold" id="termsModalLabel" style="font-family:'Playfair Display',serif;color:var(--gold);">
                            <i class="bi bi-file-text me-2"></i>Terms &amp; Conditions
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="color:rgba(255,255,255,.8);font-size:.9rem;line-height:1.8;">
                        <h6 style="color:var(--gold);">1. Booking &amp; Reservations</h6>
                        <p>All reservations are subject to availability. A booking is confirmed only upon receipt of the required deposit or full payment, and a confirmation email has been sent.</p>

                        <h6 style="color:var(--gold);">2. Guest Responsibilities</h6>
                        <p>Guests are responsible for any damage caused to the hotel property during their stay. The hotel reserves the right to charge the guest's account for any damages.</p>

                        <h6 style="color:var(--gold);">3. Check-in &amp; Check-out</h6>
                        <p>Standard check-in time is <strong style="color:#fff;">2:00 PM</strong> and check-out time is <strong style="color:#fff;">12:00 PM (noon)</strong>. Early check-in and late check-out are subject to availability and may incur additional charges.</p>

                        <h6 style="color:var(--gold);">4. Payment</h6>
                        <p>All rates are quoted in Philippine Peso (₱) and are inclusive of applicable taxes. The hotel accepts cash, GCash, Maya, and bank transfers.</p>

                        <h6 style="color:var(--gold);">5. Privacy</h6>
                        <p>Personal information collected during booking is used solely for reservation purposes and will not be shared with third parties without your consent, in accordance with the Data Privacy Act of 2012.</p>

                        <h6 style="color:var(--gold);">6. Liability</h6>
                        <p>The Royal Crest shall not be liable for any loss, theft, or damage to personal belongings during your stay. Guests are advised to use the in-room safe for valuables.</p>
                    </div>
                    <div class="modal-footer" style="border-color:var(--border);">
                        <button type="button" class="btn btn-gold px-4" data-bs-dismiss="modal">I Understand</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancellation Policy Modal -->
        <div class="modal fade" id="cancellationModal" tabindex="-1" aria-labelledby="cancellationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="background:var(--surface,#1a1214);border:1px solid var(--border);color:#fff;">
                    <div class="modal-header" style="border-color:var(--border);">
                        <h5 class="modal-title fw-bold" id="cancellationModalLabel" style="font-family:'Playfair Display',serif;color:var(--gold);">
                            <i class="bi bi-x-circle me-2"></i>Cancellation Policy
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="color:rgba(255,255,255,.8);font-size:.9rem;line-height:1.8;">
                        <h6 style="color:var(--gold);">Free Cancellation</h6>
                        <p>Cancellations made <strong style="color:#4ade80;">more than 48 hours</strong> before the check-in date will receive a <strong style="color:#fff;">full refund</strong>.</p>

                        <h6 style="color:var(--gold);">Late Cancellation</h6>
                        <p>Cancellations made <strong style="color:#facc15;">within 24–48 hours</strong> of check-in will be charged <strong style="color:#fff;">50% of the total booking amount</strong>.</p>

                        <h6 style="color:var(--gold);">No-Show / Same-Day Cancellation</h6>
                        <p>Cancellations made <strong style="color:#f87171;">less than 24 hours</strong> before check-in, or in the event of a no-show, will be charged <strong style="color:#fff;">the full booking amount</strong>.</p>

                        <h6 style="color:var(--gold);">How to Cancel</h6>
                        <p>You may cancel your booking through your account under <em>My Bookings</em>, or by contacting us directly at <strong style="color:var(--gold);">info@theroyalcrest.com</strong> or <strong style="color:var(--gold);">+63 75 123 4567</strong>.</p>

                        <h6 style="color:var(--gold);">Refund Processing</h6>
                        <p>Approved refunds will be processed within <strong style="color:#fff;">5–7 business days</strong> via the original payment method.</p>
                    </div>
                    <div class="modal-footer" style="border-color:var(--border);">
                        <button type="button" class="btn btn-gold px-4" data-bs-dismiss="modal">I Understand</button>
                    </div>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <button type="submit" class="btn btn-gold btn-lg w-100 py-3 fw-bold rounded-3">
            <i class="bi bi-check-circle me-2"></i>{{ __('site.bk_confirm_btn') }}
        </button>
    </div>

    <!-- Right: Summary -->
    <div class="col-lg-4">
        <div class="summary-card">
            <h5>{{ __('site.bk_summary_title') }}</h5>
            <img src="{{ $displayRoom->thumbnail_url }}" class="summary-img" alt="{{ $displayRoom->name }}" loading="lazy">
            <h6>{{ $displayRoom->name }}</h6>
            <p class="summary-room-meta mb-1">{{ $displayRoom->roomType->name }}</p>
            <p class="summary-room-meta mb-3" style="font-size:.75rem;">
                @php $avail = $totalUnits ?? 4; @endphp
                @if($avail > 1)
                    <span style="color:#4ade80;"><i class="bi bi-door-open me-1"></i>{{ $avail }} units available</span>
                @elseif($avail === 1)
                    <span style="color:#facc15;"><i class="bi bi-exclamation-circle me-1"></i>Only 1 unit left!</span>
                @else
                    <span style="color:#f87171;"><i class="bi bi-x-circle me-1"></i>Fully booked — pick other dates</span>
                @endif
            </p>
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <div class="summary-dates">
                        <div class="label">{{ __('site.bk_checkin') }}</div>
                        <div class="value" id="summCheckIn">{{ \Carbon\Carbon::parse($checkIn)->format('M d, Y') }}</div>
                        <div style="color:var(--gold);font-size:.7rem;margin-top:.2rem;" id="summCheckInTime">2:00 PM</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="summary-dates">
                        <div class="label">{{ __('site.bk_checkout') }}</div>
                        <div class="value" id="summCheckOut">{{ \Carbon\Carbon::parse($checkOut)->format('M d, Y') }}</div>
                        <div style="color:var(--gold);font-size:.7rem;margin-top:.2rem;" id="summCheckOutTime">11:00 AM</div>
                    </div>
                </div>
            </div>
            <div>
                <div class="summary-line muted">
                    <span>₱{{ number_format($room->price_per_night,2) }} × <span id="summNights">{{ $nights }}</span> {{ __('site.bk_nights') }}</span>
                    <span id="summSubtotal">₱{{ number_format($room->price_per_night * $nights, 2) }}</span>
                </div>
                <div class="summary-line success" id="discRow" style="display:none!important;">
                    <span>{{ __('site.bk_discount') }}</span><span id="summDiscount">-₱0.00</span>
                </div>
                <div class="summary-line muted">
                    <span>{{ __('site.bk_vat') }}</span>
                    <span id="summTax">₱{{ number_format($room->price_per_night * $nights * 0.12, 2) }}</span>
                </div>
                <hr style="border-color:var(--border);margin:1rem 0;">
                <div class="summary-total">
                    <span style="color:#fff;font-size:1rem;">{{ __('site.bk_total') }}</span>
                    <span class="amount" id="summTotal">₱{{ number_format($room->price_per_night * $nights * 1.12, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</div>
</section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
const pricePerNight = {{ $displayRoom->price_per_night }};
const bookedRanges  = @json($bookedRanges);
const totalUnits    = {{ $totalUnits ?? 5 }};
let discountAmount  = 0;

// ── Build booked ranges as datetime-aware objects ─────────────────────────────
// Each range now includes times so we can check overlap precisely
// Format from server: { from: 'YYYY-MM-DD', to: 'YYYY-MM-DD' }
// We'll fetch actual check_in_time/check_out_time from the server-side bookedRanges
// For now we use the standard times (14:00 check-in, 11:00 check-out)
function buildBookedDatetimes(ranges) {
    return ranges.map(({ from, to, ci_time, co_time }) => ({
        start : new Date(from + 'T' + (ci_time || '14:00') + ':00'),
        end   : new Date(to   + 'T' + (co_time || '11:00') + ':00'),
    }));
}

const bookedDatetimes = buildBookedDatetimes(bookedRanges);

// ── Check overlap with time precision ────────────────────────────────────────
// Two bookings overlap if: newStart < existingEnd AND newEnd > existingStart
function hasConflict(ciDate, ciTime, coDate, coTime) {
    if (!ciDate || !coDate) return false;
    const newStart = new Date(ciDate + 'T' + (ciTime || '14:00') + ':00');
    const newEnd   = new Date(coDate + 'T' + (coTime || '11:00') + ':00');
    if (newEnd <= newStart) return true; // same-day invalid

    return bookedDatetimes.some(({ start, end }) =>
        newStart < end && newEnd > start
    );
}

// ── Calendar disabled dates (date-level, conservative) ───────────────────────
// Only disable a date on the calendar if ALL time slots on that day are blocked
function buildBookedSet(ranges) {
    const set = new Set();
    ranges.forEach(({ from, to }) => {
        let cur = new Date(from + 'T00:00:00');
        const end = new Date(to + 'T00:00:00');
        while (cur < end) {
            set.add(cur.toISOString().split('T')[0]);
            cur.setDate(cur.getDate() + 1);
        }
    });
    return set;
}
const bookedSet = buildBookedSet(bookedRanges);
function isBooked(date) {
    return bookedSet.has(date.toISOString().split('T')[0]);
}

// ── Helper: format 24h time → 12h AM/PM ─────────────────────────────────────
function fmt24to12(time24) {
    if (!time24) return '';
    const [h, m] = time24.split(':').map(Number);
    const suffix = h >= 12 ? 'PM' : 'AM';
    const h12    = h % 12 || 12;
    return `${h12}:${String(m).padStart(2,'0')} ${suffix}`;
}

// ── Recalculate summary panel ────────────────────────────────────────────────
function recalc() {
    const ci     = document.getElementById('checkIn').value;
    const co     = document.getElementById('checkOut').value;
    const ciTime = document.getElementById('checkInTime')?.value  || '14:00';
    const coTime = document.getElementById('checkOutTime')?.value || '11:00';
    if (!ci || !co) return;

    // Time-aware duration in hours → nights (each night = 24h block)
    const startDt = new Date(ci + 'T' + ciTime + ':00');
    const endDt   = new Date(co + 'T' + coTime + ':00');
    const diffHrs = (endDt - startDt) / 3600000;
    const nights  = Math.max(1, Math.ceil(diffHrs / 24));

    const sub       = nights * pricePerNight;
    const afterDisc = sub - discountAmount;
    const tax       = afterDisc * 0.12;
    const total     = afterDisc + tax;

    document.getElementById('summNights').textContent    = nights;
    document.getElementById('summSubtotal').textContent  = '₱' + sub.toLocaleString('en-PH',{minimumFractionDigits:2});
    document.getElementById('summTax').textContent       = '₱' + tax.toLocaleString('en-PH',{minimumFractionDigits:2});
    document.getElementById('summTotal').textContent     = '₱' + total.toLocaleString('en-PH',{minimumFractionDigits:2});

    // Date labels
    const fmt = { month:'short', day:'numeric', year:'numeric' };
    document.getElementById('summCheckIn').textContent   = new Date(ci + 'T00:00:00').toLocaleDateString('en-US', fmt);
    document.getElementById('summCheckOut').textContent  = new Date(co + 'T00:00:00').toLocaleDateString('en-US', fmt);
    document.getElementById('summCheckInTime').textContent  = fmt24to12(ciTime);
    document.getElementById('summCheckOutTime').textContent = fmt24to12(coTime);

    // ── Live conflict check (time-aware) ──────────────────────────────────────
    const alert = document.getElementById('availAlert');
    const msg   = document.getElementById('availMsg');
    const btn   = document.querySelector('button[type="submit"]');

    if (diffHrs <= 0) {
        alert.className = 'avail-busy show';
        msg.textContent = 'Check-out time must be after check-in time.';
        if (btn) btn.disabled = true;
    } else if (hasConflict(ci, ciTime, co, coTime)) {
        alert.className = 'avail-busy show';
        msg.textContent = `All ${totalUnits} units are fully booked for the selected dates and times. Try adjusting the check-in/check-out time or date.`;
        if (btn) btn.disabled = true;
    } else {
        alert.className = 'avail-ok show';
        msg.textContent = `${nights} night${nights>1?'s':''} — available! Check-in ${fmt24to12(ciTime)}, Check-out ${fmt24to12(coTime)}.`;
        if (btn) btn.disabled = false;
    }
}

// ── Flatpickr ────────────────────────────────────────────────────────────────
const fpIn = flatpickr('#checkIn', {
    dateFormat  : 'Y-m-d',
    minDate     : 'today',
    defaultDate : '{{ $checkIn }}',
    disableMobile: true,
    disable: [isBooked],
    onChange(dates) {
        if (!dates[0]) return;
        const next = new Date(dates[0]);
        next.setDate(next.getDate() + 1);
        fpOut.set('minDate', next);
        if (fpOut.selectedDates[0] && fpOut.selectedDates[0] <= dates[0]) {
            fpOut.setDate(next, true);
        }
        recalc();
    },
});

const fpOut = flatpickr('#checkOut', {
    dateFormat  : 'Y-m-d',
    minDate     : new Date(new Date('{{ $checkIn }}').getTime() + 86400000),
    defaultDate : '{{ $checkOut }}',
    disableMobile: true,
    disable: [isBooked],
    onChange() { recalc(); },
});

// Re-run recalc when time dropdowns change
document.getElementById('checkInTime')?.addEventListener('change', recalc);
document.getElementById('checkOutTime')?.addEventListener('change', recalc);

// Run on load
recalc();

// ── Promo code ────────────────────────────────────────────────────────────────
function applyPromo() {
    const ciTime = document.getElementById('checkInTime')?.value  || '14:00';
    const coTime = document.getElementById('checkOutTime')?.value || '11:00';
    const ci     = document.getElementById('checkIn').value;
    const co     = document.getElementById('checkOut').value;
    const startDt = new Date(ci + 'T' + ciTime + ':00');
    const endDt   = new Date(co + 'T' + coTime + ':00');
    const diffHrs = (endDt - startDt) / 3600000;
    const nights  = Math.max(1, Math.ceil(diffHrs / 24));
    const amount  = nights * pricePerNight;
    const code    = document.getElementById('promoInput').value.trim().toUpperCase();
    if (!code) return;

    fetch('{{ route("booking.apply-promo") }}', {
        method  : 'POST',
        headers : {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body    : JSON.stringify({code, amount, nights})
    }).then(r => r.json()).then(data => {
        const msg = document.getElementById('promoMsg');
        if (data.valid) {
            discountAmount = data.discount;
            document.getElementById('promoCode').value = code;
            document.getElementById('discRow').style.display = '';
            document.getElementById('summDiscount').textContent = '-₱' + discountAmount.toLocaleString('en-PH',{minimumFractionDigits:2});
            msg.innerHTML = '<span class="text-success"><i class="bi bi-check-circle me-1"></i>' + data.message + '</span>';
            recalc();
        } else {
            discountAmount = 0;
            document.getElementById('promoCode').value = '';
            document.getElementById('discRow').style.display = 'none';
            msg.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i>' + data.message + '</span>';
            recalc();
        }
    });
}

// ── Payment instructions ──────────────────────────────────────────────────────
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const box = document.getElementById('paymentInstructions');
        document.querySelectorAll('.payment-details').forEach(d => d.style.display = 'none');
        if (['gcash','maya','bank_transfer'].includes(this.value)) {
            box.style.display = 'block';
            const specific = document.getElementById('instructions_' + this.value);
            if (specific) specific.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const sel = document.querySelector('input[name="payment_method"]:checked');
    if (sel) sel.dispatchEvent(new Event('change'));
    
    // Handle room selection badge updates
    document.querySelectorAll('input[name="room_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove all "Currently Selected" badges
            document.querySelectorAll('.currently-selected-badge').forEach(badge => {
                badge.remove();
            });
            
            // Add badge to the newly selected room
            if (this.checked) {
                const label = document.querySelector(`label[for="${this.id}"]`);
                if (label && !label.querySelector('.currently-selected-badge')) {
                    const badge = document.createElement('span');
                    badge.className = 'badge currently-selected-badge';
                    badge.style.cssText = 'background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; font-size: 0.7rem; padding: 0.3rem 0.6rem; border-radius: 6px;';
                    badge.textContent = 'Currently Selected';
                    label.appendChild(badge);
                }
            }
        });
    });
});
</script>
@endpush
