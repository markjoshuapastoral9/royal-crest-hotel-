@extends('layouts.app')
@section('title', 'My Booking Calendar')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<style>
/* ── Page shell ──────────────────────────────────────────── */
.cal-page { background: #101111; min-height: 100vh; }
.cal-hero  {
    background: linear-gradient(135deg,#1e1613 0%,#241a0e 50%,#1e1613 100%);
    padding: 80px 0 40px;
    border-bottom: 1px solid rgba(166,130,74,.25);
}
.cal-hero h1 { color:#E6E2DA; font-family:'Playfair Display',serif; font-size:2rem; }
.cal-hero p  { color:#B8AFA6; }

/* ── Summary boxes ───────────────────────────────────────── */
.s-box {
    background: #231d1e;
    border: 1px solid rgba(166,130,74,.22);
    border-radius: 14px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 120px;
    flex: 1;
}
.s-dot   { width:12px;height:12px;border-radius:50%;flex-shrink:0; }
.s-count { font-size:1.5rem;font-weight:700;color:#E6E2DA;line-height:1; }
.s-label { font-size:.7rem;color:#9a9189;margin-top:2px;letter-spacing:.4px; }

/* ── Filter pills ─────────────────────────────────────────── */
.f-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: .78rem;
    font-weight: 500;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all .2s;
    user-select: none;
    white-space: nowrap;
}
.f-pill .dot { width:8px;height:8px;border-radius:50%;display:inline-block; }
.f-pill.active { border-color: currentColor; }
.f-pill:hover  { opacity:.8; }

/* ── Calendar card ────────────────────────────────────────── */
.cal-card {
    background: #231d1e;
    border: 1px solid rgba(166,130,74,.22);
    border-radius: 18px;
    padding: 24px;
}

/* ── FullCalendar overrides (dark) ───────────────────────── */
.fc { color: #E6E2DA; }
.fc .fc-toolbar-title { font-size:1.05rem; font-weight:700; color:#E6E2DA; }
.fc .fc-button-primary {
    background: rgba(166,130,74,.2);
    border: 1px solid rgba(166,130,74,.35);
    color: #C9A87C;
    font-size:.8rem;
    padding:5px 12px;
    border-radius:6px !important;
}
.fc .fc-button-primary:hover,
.fc .fc-button-primary:not(:disabled).fc-button-active {
    background: #A6824A;
    border-color: #A6824A;
    color: #fff;
}
.fc .fc-button-primary:focus { box-shadow:none; }
.fc .fc-col-header-cell-cushion { color:#C9A87C; font-size:.8rem; font-weight:600; }
.fc .fc-daygrid-day-number { color:#9a9189; font-size:.8rem; }
.fc .fc-daygrid-day-number:hover { color:#E6E2DA; }
.fc th, .fc td { border-color: rgba(255,255,255,.07) !important; }
.fc .fc-scrollgrid { border-color: rgba(255,255,255,.07) !important; }
.fc-day-today { background: rgba(166,130,74,.08) !important; }
.fc-day-today .fc-daygrid-day-number { color:#D4A853 !important; font-weight:700; }
.fc-event {
    border:none !important;
    border-radius:5px !important;
    font-size:.74rem !important;
    padding:2px 6px !important;
    cursor:pointer;
    font-weight:500;
}
.fc-event:hover { filter:brightness(.88); }
.fc-daygrid-event-dot { display:none; }
.fc .fc-list-event:hover td { background:rgba(166,130,74,.08); }
.fc .fc-list-day-cushion { background:#1e1613; color:#C9A87C; font-size:.78rem; }
.fc .fc-list-event td { background:#231d1e; border-color:rgba(255,255,255,.06); color:#B8AFA6; }
.fc .fc-list-empty { background:#231d1e; color:#9a9189; }
.fc .fc-more-link { color:#C9A87C; font-size:.75rem; }
.fc .fc-popover { background:#2a2020; border:1px solid rgba(166,130,74,.3); border-radius:10px; }
.fc .fc-popover-title { background:#1e1613; color:#C9A87C; }
.fc .fc-popover-body { background:#2a2020; }

/* ── View switcher ───────────────────────────────────────── */
#viewSwitcher {
    background:#2a2020;
    border:1px solid rgba(166,130,74,.35);
    color:#C9A87C;
    font-size:.8rem;
}
#viewSwitcher option { background:#2a2020; }

/* ── Detail modal ────────────────────────────────────────── */
#bModal .modal-content {
    background:#231d1e;
    border:1px solid rgba(166,130,74,.3);
    border-radius:16px;
}
#bModal .modal-header {
    background:linear-gradient(135deg,#1e1613,#2a1e10);
    border-bottom:1px solid rgba(166,130,74,.2);
    border-radius:16px 16px 0 0;
}
#bModal .modal-header .btn-close { filter:invert(1) opacity(.6); }
#bModal .modal-title { color:#E6E2DA; }
#bModal .modal-sub  { color:#9a9189; font-size:.78rem; }
.d-row {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:8px 0;
    border-bottom:1px solid rgba(255,255,255,.06);
    font-size:.875rem;
}
.d-row:last-child { border-bottom:none; }
.d-lbl { color:#9a9189; }
.d-val { font-weight:600; color:#E6E2DA; text-align:right; }
#bModal .modal-footer { border-top:1px solid rgba(255,255,255,.07); }
.btn-outline-gold {
    border:1px solid rgba(166,130,74,.6);
    color:#C9A87C;
    background:transparent;
    font-size:.85rem;
}
.btn-outline-gold:hover { background:rgba(166,130,74,.15); color:#E6C97C; border-color:#C9A87C; }

/* ── Legend shortcut bar ─────────────────────────────────── */
.legend-bar {
    background:#231d1e;
    border:1px solid rgba(166,130,74,.18);
    border-radius:12px;
    padding:12px 18px;
    display:flex;
    flex-wrap:wrap;
    gap:16px;
    align-items:center;
}
.leg-item { display:flex;align-items:center;gap:6px;font-size:.76rem;color:#9a9189; }
.leg-dot  { width:10px;height:10px;border-radius:3px;flex-shrink:0; }

@media(max-width:768px){
    .cal-hero { padding:70px 0 25px; }
    .cal-hero h1 { font-size:1.5rem; }
    .s-box { min-width:unset; padding:10px 12px; }
    .s-count { font-size:1.2rem; }
    .cal-card { padding:14px; border-radius:14px; }
}
</style>
@endpush

@section('content')
<div class="cal-page">

    {{-- ── Hero ──────────────────────────────────────────── --}}
    <div class="cal-hero">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                <div>
                    <h1 class="mb-1"><i class="bi bi-calendar3 me-2" style="color:#C9A87C;"></i>My Booking Calendar</h1>
                    <p class="mb-0">All your bookings at a glance — click any event to view details</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('customer.bookings') }}" class="btn btn-outline-gold btn-sm">
                        <i class="bi bi-list-ul me-1"></i>List View
                    </a>
                    <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Book a Room
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section style="padding:40px 0 60px;">
    <div class="container">

        {{-- ── Summary row ─────────────────────────────── --}}
        <div class="d-flex flex-wrap gap-3 mb-4">
            @php
                $items = [
                    ['pending',    '#D4A853', 'Pending'],
                    ['confirmed',  '#4ade80', 'Confirmed'],
                    ['checked_in', '#38bdf8', 'Checked In'],
                    ['completed',  '#818cf8', 'Completed'],
                    ['cancelled',  '#f87171', 'Cancelled'],
                ];
            @endphp
            @foreach($items as [$key,$color,$label])
            <div class="s-box">
                <div class="s-dot" style="background:{{ $color }};"></div>
                <div>
                    <div class="s-count">{{ $statusCounts[$key] ?? 0 }}</div>
                    <div class="s-label">{{ $label }}</div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ── Filter + view switcher ───────────────────── --}}
        <div class="legend-bar mb-4">
            <span style="font-size:.76rem;color:#9a9189;font-weight:600;letter-spacing:1px;text-transform:uppercase;">Filter:</span>

            <span class="f-pill active" data-status="all" style="color:#B8AFA6;background:rgba(255,255,255,.06);">
                <span class="dot" style="background:#B8AFA6;"></span>All
            </span>
            <span class="f-pill" data-status="pending" style="color:#856404;background:rgba(212,168,83,.12);">
                <span class="dot" style="background:#D4A853;"></span>Pending
            </span>
            <span class="f-pill" data-status="confirmed" style="color:#166534;background:rgba(74,222,128,.1);">
                <span class="dot" style="background:#4ade80;"></span>Confirmed
            </span>
            <span class="f-pill" data-status="checked_in" style="color:#0e7490;background:rgba(56,189,248,.1);">
                <span class="dot" style="background:#38bdf8;"></span>Checked In
            </span>
            <span class="f-pill" data-status="completed" style="color:#5b4fce;background:rgba(129,140,248,.1);">
                <span class="dot" style="background:#818cf8;"></span>Completed
            </span>
            <span class="f-pill" data-status="cancelled" style="color:#b91c1c;background:rgba(248,113,113,.1);">
                <span class="dot" style="background:#f87171;"></span>Cancelled
            </span>

            <div class="ms-auto">
                <select id="viewSwitcher" class="form-select form-select-sm" style="width:140px;">
                    <option value="dayGridMonth">Month</option>
                    <option value="timeGridWeek">Week</option>
                    <option value="timeGridDay">Day</option>
                    <option value="listWeek">List (Week)</option>
                    <option value="listMonth">List (Month)</option>
                </select>
            </div>
        </div>

        {{-- ── Calendar ─────────────────────────────────── --}}
        <div class="cal-card">
            <div id="calendar"></div>
        </div>

        {{-- ── Empty hint (shown if 0 total bookings) ─────── --}}
        @if(array_sum($statusCounts->toArray()) === 0)
        <div class="text-center mt-5" style="color:#9a9189;">
            <i class="bi bi-calendar-x" style="font-size:3rem;color:rgba(166,130,74,.35);display:block;margin-bottom:1rem;"></i>
            <p>You have no bookings yet.</p>
            <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-sm">Browse Rooms</a>
        </div>
        @endif

    </div>
    </section>
</div>

{{-- ── Booking detail modal ──────────────────────────────── --}}
<div class="modal fade" id="bModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <div class="modal-title fw-bold" id="mBookingNo">—</div>
                    <div class="modal-sub" id="mRoomNo">—</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pb-1">
                <div class="mb-3" id="mStatusBadge"></div>
                <div class="d-row"><span class="d-lbl"><i class="bi bi-door-open me-1"></i>Room</span><span class="d-val" id="mRoom">—</span></div>
                <div class="d-row"><span class="d-lbl"><i class="bi bi-calendar-event me-1"></i>Check-in</span><span class="d-val" id="mCheckIn">—</span></div>
                <div class="d-row"><span class="d-lbl"><i class="bi bi-calendar-x me-1"></i>Check-out</span><span class="d-val" id="mCheckOut">—</span></div>
                <div class="d-row"><span class="d-lbl"><i class="bi bi-moon me-1"></i>Nights</span><span class="d-val" id="mNights">—</span></div>
                <div class="d-row"><span class="d-lbl"><i class="bi bi-credit-card me-1"></i>Payment</span><span class="d-val" id="mPayment">—</span></div>
                <div class="d-row"><span class="d-lbl"><i class="bi bi-currency-exchange me-1"></i>Total</span><span class="d-val" id="mTotal" style="color:#C9A87C;font-size:1.05rem;">—</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-gold btn-sm" data-bs-dismiss="modal">Close</button>
                <a href="#" id="mViewBtn" class="btn btn-gold btn-sm">
                    <i class="bi bi-eye me-1"></i>View Details
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const STATUS_BADGE = {
        'Pending'    : 'warning',
        'Confirmed'  : 'success',
        'Checked In' : 'info',
        'Completed'  : 'primary',
        'Cancelled'  : 'danger',
    };

    let activeStatus = 'all';
    const modal = new bootstrap.Modal(document.getElementById('bModal'));

    // ── FullCalendar ────────────────────────────────────────
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView : 'dayGridMonth',
        headerToolbar: { left:'prev,next today', center:'title', right:'' },
        height    : 'auto',
        firstDay  : 1,
        dayMaxEvents: 3,
        eventDisplay: 'block',
        navLinks  : true,
        themeSystem: 'standard',

        events: function (info, successCb, failureCb) {
            const url = new URL('{{ route("customer.calendar") }}', window.location.origin);
            url.searchParams.set('start',  info.startStr.split('T')[0]);
            url.searchParams.set('end',    info.endStr.split('T')[0]);
            url.searchParams.set('status', activeStatus);

            fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(r => r.json())
            .then(successCb)
            .catch(failureCb);
        },

        eventClick: function (info) {
            info.jsEvent.preventDefault();
            const p = info.event.extendedProps;

            document.getElementById('mBookingNo').textContent  = p.booking_number;
            document.getElementById('mRoomNo').textContent     = 'Room ' + p.room_number;
            document.getElementById('mRoom').textContent       = p.room + ' (#' + p.room_number + ')';
            document.getElementById('mCheckIn').textContent    = p.check_in;
            document.getElementById('mCheckOut').textContent   = p.check_out;
            document.getElementById('mNights').textContent     = p.nights + (p.nights == 1 ? ' night' : ' nights');
            document.getElementById('mPayment').textContent    = p.payment_status;
            document.getElementById('mTotal').textContent      = '₱' + p.total_amount;
            document.getElementById('mViewBtn').href           = p.url;

            const badge = STATUS_BADGE[p.status] || 'secondary';
            document.getElementById('mStatusBadge').innerHTML =
                `<span class="badge bg-${badge} px-3 py-2" style="font-size:.85rem;">${p.status}</span>`;

            modal.show();
        },

        eventMouseEnter: function (info) {
            const p = info.event.extendedProps;
            info.el.title = `${p.booking_number} · ${p.check_in} → ${p.check_out}`;
        },

        // No link navigation on click (we use modal instead)
        eventDidMount: function (info) {
            if (info.event.url) {
                info.el.removeAttribute('href');
            }
        },
    });

    calendar.render();

    // ── View switcher ───────────────────────────────────────
    document.getElementById('viewSwitcher').addEventListener('change', function () {
        calendar.changeView(this.value);
    });

    // ── Status filter pills ─────────────────────────────────
    document.querySelectorAll('.f-pill').forEach(function (pill) {
        pill.addEventListener('click', function () {
            document.querySelectorAll('.f-pill').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            activeStatus = this.dataset.status;
            calendar.refetchEvents();
        });
    });
});
</script>
@endpush
