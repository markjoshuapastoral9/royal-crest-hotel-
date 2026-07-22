@extends('layouts.app')
@section('title', 'Private Dining - Royal Crest Hotel')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
.flatpickr-calendar { background:#1a1214; border:1px solid rgba(166,130,74,.3); border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,.5); }
.flatpickr-months .flatpickr-month,.flatpickr-weekdays,span.flatpickr-weekday { background:#1a1214; color:#C9A87C; }
.flatpickr-day { color:#E6E2DA; }
.flatpickr-day:hover { background:rgba(166,130,74,.2); border-color:transparent; }
.flatpickr-day.selected { background:#A6824A; border-color:#A6824A; color:#fff; }
.flatpickr-prev-month,.flatpickr-next-month { color:#C9A87C !important; fill:#C9A87C !important; }
.modal-content { background:var(--surface,#1a1214); border:1px solid var(--border); color:#fff; border-radius:16px; }
.modal-header { border-color:var(--border); padding:.75rem 1rem; }
.modal-footer { border-color:var(--border); padding:.75rem 1rem; }
.modal-body { max-height:70vh; overflow-y:auto; padding:.75rem 1rem; }
.form-label { color:var(--text-sec,#B8AFA6); font-size:.82rem; font-weight:600; }
.form-control,.form-select,.form-control:focus,.form-select:focus {
    background:rgba(255,255,255,.06) !important;
    border:1px solid rgba(255,255,255,.12) !important;
    color:#fff !important;
    border-radius:10px;
}
.form-control:focus,.form-select:focus {
    border-color:var(--gold) !important;
    box-shadow:0 0 0 3px rgba(166,130,74,.12) !important;
}
.form-control::placeholder { color:rgba(255,255,255,.3) !important; }
.form-select option { background:var(--surface); color:#fff; }
.room-card { background:var(--surface,#1a1214); border:1px solid var(--border); border-radius:16px; overflow:hidden; transition:all .3s; }
.room-card:hover { border-color:rgba(201,168,76,.35); transform:translateY(-4px); box-shadow:0 12px 30px rgba(0,0,0,.4); }
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="container">
        <h1 class="text-white">Private Dining</h1>
        <p class="text-white-50">Exclusive dining experiences for special occasions</p>
    </div>
</div>

<section style="padding:50px 0; background:var(--bg-dark,#101111);">
    <div class="container">

        {{-- Hero --}}
        <div class="row g-4 mb-5 align-items-center">
            <div class="col-lg-6">
                <img src="{{ asset('images/private-dining.jpg') }}" alt="Private Dining"
                     class="img-fluid rounded-4" style="height:420px;width:100%;object-fit:cover;">
            </div>
            <div class="col-lg-6">
                <div class="rounded-4 p-4" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
                    <span class="section-tag">Intimate Celebrations</span>
                    <h2 class="section-title">Create Unforgettable Moments</h2>
                    <div class="section-divider left"></div>
                    <p class="text-muted mb-4">
                        Our private dining rooms offer an intimate setting for special celebrations,
                        business dinners, or romantic occasions. Enjoy personalized menus crafted
                        by our executive chef and impeccable service in an exclusive atmosphere.
                    </p>
                    <ul class="list-unstyled text-muted mb-4">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-gold me-2"></i>Seats 8–20 guests</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-gold me-2"></i>Customizable menu options</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-gold me-2"></i>Dedicated wait staff</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-gold me-2"></i>Audio/visual equipment available</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-gold me-2"></i>Complimentary decorations</li>
                    </ul>
                    <button class="btn btn-gold px-4" data-bs-toggle="modal" data-bs-target="#reservationModal">
                        <i class="bi bi-calendar-check me-2"></i>Request Reservation
                    </button>
                </div>
            </div>
        </div>

        {{-- Room Cards --}}
        <div class="text-center mb-5">
            <span class="section-tag">Private Dining Options</span>
            <h2 class="section-title">Choose Your Perfect Setting</h2>
            <div class="section-divider"></div>
        </div>

        <div class="row g-4 mb-5">
            @foreach([
                ['Garden Room',    'private-room-1.jpg', 'Intimate setting with garden views, perfect for romantic dinners and anniversaries.', 8,  '5,000',  'garden-room',    ['Romantic lighting','Garden view','Flower arrangements','In-room dining']],
                ['Executive Room', 'private-room-2.jpg', 'Modern space ideal for business dinners, presentations, and corporate meetings.',     12, '8,000',  'executive-room', ['Projector & screen','Whiteboard','Business setup','WiFi']],
                ['Grand Hall',     'private-room-3.jpg', 'Spacious venue for family celebrations, reunions, and large private gatherings.',     20, '12,000', 'grand-hall',     ['Full AV system','Stage area','Dance floor','Bar setup']],
            ] as [$room, $img, $desc, $cap, $price, $slug, $features])
            <div class="col-md-4">
                <div class="room-card h-100 d-flex flex-column">
                    <div class="position-relative overflow-hidden" style="height:200px;">
                        <img src="{{ asset('images/'.$img) }}" alt="{{ $room }}"
                             style="width:100%;height:100%;object-fit:cover;transition:transform .4s;"
                             onmouseover="this.style.transform='scale(1.06)'"
                             onmouseout="this.style.transform='scale(1)'">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge text-dark fw-bold" style="background:var(--gold);">₱{{ $price }}/event</span>
                        </div>
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h5 class="text-white mb-1">{{ $room }}</h5>
                        <p class="text-muted small mb-3">{{ $desc }}</p>
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @foreach($features as $f)
                            <span style="background:rgba(201,168,76,.1);border:1px solid rgba(201,168,76,.25);color:#C9A84C;border-radius:6px;padding:.2rem .6rem;font-size:.72rem;">{{ $f }}</span>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="text-muted small"><i class="bi bi-people me-1"></i>Up to {{ $cap }} guests</span>
                            <button class="btn btn-gold btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#reservationModal"
                                    onclick="prefillRoom('{{ $room }}')">
                                <i class="bi bi-calendar-check me-1"></i>Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Perfect For --}}
        <div class="rounded-4 p-4 mb-5" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
            <h4 class="text-white mb-4 text-center">Perfect For:</h4>
            <div class="row g-3 text-center">
                @foreach([
                    ['bi-heart','Anniversaries'],
                    ['bi-gem','Proposals'],
                    ['bi-cake2','Birthdays'],
                    ['bi-briefcase','Business Dinners'],
                    ['bi-people','Family Gatherings'],
                    ['bi-camera','Photo Shoots'],
                    ['bi-cup-hot','Bridal Showers'],
                    ['bi-mortarboard','Graduations'],
                ] as [$icon, $label])
                <div class="col-6 col-md-3">
                    <i class="bi {{ $icon }} fs-2 text-gold mb-2 d-block"></i>
                    <span class="small text-muted">{{ $label }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- CTA --}}
        <div class="text-center">
            <p class="text-muted mb-3">Ready to make your reservation? Fill out the form and we'll confirm within 24 hours.</p>
            <button class="btn btn-gold btn-lg px-5" data-bs-toggle="modal" data-bs-target="#reservationModal">
                <i class="bi bi-calendar-check me-2"></i>Reserve a Private Dining Room
            </button>
        </div>

    </div>
</section>

{{-- ── RESERVATION MODAL ── --}}
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold text-gold mb-0" id="reservationModalLabel" style="font-size:.95rem;">
                    <i class="bi bi-calendar-check me-2"></i>Private Dining Reservation
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            @if(session('reservation_success'))
            <div class="modal-body">
                <div class="text-center py-4">
                    <i class="bi bi-check-circle-fill text-gold" style="font-size:4rem;"></i>
                    <h4 class="text-white mt-3">Reservation Request Sent!</h4>
                    <p class="text-muted">Thank you! We'll contact you within 24 hours to confirm your private dining reservation.</p>
                    <button class="btn btn-gold mt-3" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            @else
            <form action="{{ route('dining.reservation.store') }}" method="POST" id="reservationForm">
                @csrf
                <div class="modal-body py-2">

                    @if($errors->any())
                    <div class="alert py-2 mb-2" style="background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.3);color:#fca5a5;border-radius:8px;font-size:.8rem;">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                    @endif

                    <div class="row g-2">
                        {{-- Room Selection --}}
                        <div class="col-12">
                            <label class="form-label mb-1" style="font-size:.75rem;">Select Room <span class="text-danger">*</span></label>
                            <select name="room" id="roomSelect" class="form-select form-select-sm" required>
                                <option value="">-- Choose a room --</option>
                                <option value="Garden Room (up to 8 guests) — ₱5,000">Garden Room (up to 8 guests) — ₱5,000</option>
                                <option value="Executive Room (up to 12 guests) — ₱8,000">Executive Room (up to 12 guests) — ₱8,000</option>
                                <option value="Grand Hall (up to 20 guests) — ₱12,000">Grand Hall (up to 20 guests) — ₱12,000</option>
                            </select>
                        </div>

                        {{-- Name & Email --}}
                        <div class="col-md-6">
                            <label class="form-label mb-1" style="font-size:.75rem;">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-sm"
                                   value="{{ old('name', auth()->user()->name ?? '') }}"
                                   placeholder="Your full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label mb-1" style="font-size:.75rem;">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-sm"
                                   value="{{ old('email', auth()->user()->email ?? '') }}"
                                   placeholder="your@email.com" required>
                        </div>

                        {{-- Phone & Occasion --}}
                        <div class="col-md-6">
                            <label class="form-label mb-1" style="font-size:.75rem;">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control form-control-sm"
                                   value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                   placeholder="+63 9XX XXX XXXX" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label mb-1" style="font-size:.75rem;">Occasion <span class="text-danger">*</span></label>
                            <select name="occasion" class="form-select form-select-sm" required>
                                <option value="">-- Select --</option>
                                @foreach(['Anniversary','Birthday','Business Dinner','Proposal','Bridal Shower','Graduation','Family Gathering','Corporate Meeting','Date Night','Other'] as $occ)
                                <option value="{{ $occ }}" {{ old('occasion')===$occ?'selected':'' }}>{{ $occ }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Date & Time --}}
                        <div class="col-md-6">
                            <label class="form-label mb-1" style="font-size:.75rem;">Preferred Date <span class="text-danger">*</span></label>
                            <input type="text" name="date" id="reservationDate" class="form-control form-control-sm"
                                   placeholder="Select date" value="{{ old('date') }}" required autocomplete="off" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label mb-1" style="font-size:.75rem;">Preferred Time <span class="text-danger">*</span></label>
                            <select name="time" class="form-select form-select-sm" required>
                                <option value="">-- Select time --</option>
                                @foreach(['11:00 AM','11:30 AM','12:00 PM','12:30 PM','1:00 PM','1:30 PM','2:00 PM','6:00 PM','6:30 PM','7:00 PM','7:30 PM','8:00 PM','8:30 PM','9:00 PM'] as $t)
                                <option value="{{ $t }}" {{ old('time')===$t?'selected':'' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Guests & Duration --}}
                        <div class="col-md-6">
                            <label class="form-label mb-1" style="font-size:.75rem;">Number of Guests <span class="text-danger">*</span></label>
                            <select name="guests" class="form-select form-select-sm" required>
                                <option value="">-- Select --</option>
                                @for($i=1;$i<=20;$i++)
                                <option value="{{ $i }}" {{ old('guests')==$i?'selected':'' }}>{{ $i }} {{ $i===1?'Guest':'Guests' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label mb-1" style="font-size:.75rem;">Duration</label>
                            <select name="duration" class="form-select form-select-sm">
                                <option value="2 hours">2 hours</option>
                                <option value="3 hours">3 hours</option>
                                <option value="4 hours">4 hours</option>
                                <option value="Half day">Half day (5 hours)</option>
                                <option value="Full day">Full day (8 hours)</option>
                            </select>
                        </div>

                        {{-- Special Requests --}}
                        <div class="col-12">
                            <label class="form-label mb-1" style="font-size:.75rem;">Special Requests / Notes</label>
                            <textarea name="message" class="form-control form-control-sm" rows="2"
                                      placeholder="Menu preferences, decorations, allergies, AV requirements...">{{ old('message') }}</textarea>
                        </div>

                        {{-- Info box --}}
                        <div class="col-12">
                            <div class="rounded-2 px-3 py-2" style="background:rgba(201,168,76,.08);border:1px solid rgba(201,168,76,.25);font-size:.75rem;color:rgba(192,192,192,.8);">
                                <i class="bi bi-info-circle text-gold me-1"></i>
                                We'll contact you within <strong class="text-white">24 hours</strong> to confirm. A <strong class="text-white">50% deposit</strong> is required to secure your reservation.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold btn-sm px-4 fw-semibold">
                        <i class="bi bi-send me-1"></i>Send Request
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
// Date picker
flatpickr('#reservationDate', {
    dateFormat  : 'Y-m-d',
    minDate     : new Date().fp_incr(1),
    disableMobile: true,
});

// Pre-fill room from card button
function prefillRoom(roomName) {
    const sel = document.getElementById('roomSelect');
    if (!sel) return;
    for (let i = 0; i < sel.options.length; i++) {
        if (sel.options[i].text.startsWith(roomName)) {
            sel.selectedIndex = i;
            break;
        }
    }
}

// Auto-open modal if there were validation errors
@if($errors->any())
document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(document.getElementById('reservationModal')).show();
});
@endif

// Auto-open if success
@if(session('reservation_success'))
document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(document.getElementById('reservationModal')).show();
});
@endif
</script>
@endpush
