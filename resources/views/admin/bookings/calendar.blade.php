@extends('layouts.admin')
@section('title', 'Booking Calendar')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
<li class="breadcrumb-item active">Calendar</li>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<style>
    /* ── Calendar container - MAXIMUM COMPACT ─────────────────────────────── */
    #calendar {
        background: var(--admin-surface);
        border-radius: 8px;
        padding: 8px;
        box-shadow: 0 1px 6px rgba(0,0,0,.3);
        border: 1px solid var(--admin-border);
        max-width: 100%;
        font-size: 0.7rem;
    }

    /* ── FullCalendar toolbar - EXTRA SMALL ─────────────────── */
    .fc .fc-toolbar-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: #E6E2DA;
    }
    .fc .fc-button-primary {
        background: var(--admin-surface-2);
        border-color: var(--admin-border);
        color: #E6E2DA;
        font-size: .6rem;
        padding: 2px 6px;
        border-radius: 4px !important;
    }
    .fc .fc-button-primary:hover,
    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background: var(--gold, #C9A84C);
        border-color: var(--gold, #C9A84C);
        color: #101111;
    }
    .fc .fc-button-primary:focus { box-shadow: none; }
    .fc-day-today { background: rgba(201,168,76,.12) !important; }
    .fc-event {
        border: none !important;
        border-radius: 2px !important;
        font-size: .55rem !important;
        padding: 0px 2px !important;
        cursor: pointer;
        line-height: 1.1;
        margin: 1px 0 !important;
        color: #000 !important;
        font-weight: 600 !important;
    }
    .fc-event .fc-event-main { color: #000 !important; }
    .fc-event .fc-event-title { color: #000 !important; }
    .fc-event:hover { filter: brightness(1.15); }
    .fc-daygrid-event-dot { display: none; }
    .fc .fc-list-event:hover td { background: rgba(201,168,76,.08); }
    
    /* Calendar cell colors - MAXIMUM COMPACT */
    .fc td, .fc th { 
        border-color: var(--admin-border) !important;
        padding: 1px !important;
    }
    .fc .fc-col-header-cell { 
        background: var(--admin-surface-2); 
        color: #E6E2DA; 
        padding: 3px 1px !important;
        font-size: 0.65rem;
        font-weight: 600;
    }
    .fc .fc-daygrid-day-number { 
        color: #E6E2DA; 
        font-size: 0.7rem;
        padding: 2px !important;
    }
    .fc .fc-day { background: var(--admin-surface); }
    .fc .fc-daygrid-day-frame { 
        min-height: 40px !important;
        padding: 1px !important;
    }
    .fc .fc-daygrid-day-top { padding: 1px !important; }
    .fc .fc-daygrid-day-events { margin-top: 1px; }
    .fc .fc-daygrid-event-harness { margin-top: 1px !important; }
    
    /* Calendar view backgrounds */
    .fc-theme-standard td, .fc-theme-standard th {
        border-color: var(--admin-border);
    }
    .fc-scrollgrid { border-color: var(--admin-border) !important; }
    
    /* Toolbar spacing - SUPER COMPACT */
    .fc .fc-toolbar { 
        margin-bottom: 6px !important; 
        gap: 4px; 
    }
    .fc .fc-toolbar-chunk { gap: 3px; }
    .fc .fc-button-group { gap: 2px; }

    /* ── Status filter pills - EXTRA SMALL ─────────────────────────────── */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 2px 8px;
        border-radius: 16px;
        font-size: .65rem;
        font-weight: 500;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all .2s;
        user-select: none;
        background: var(--admin-surface-2);
    }
    .status-pill .dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        display: inline-block;
    }
    .status-pill.active  { border-color: currentColor; background: rgba(201,168,76,.15); }
    .status-pill:hover   { opacity: .85; }

    /* ── Booking detail modal ────────────────────────────── */
    #bookingModal .modal-header {
        background: var(--admin-surface-2);
        color: #E6E2DA;
        border-radius: 12px 12px 0 0;
    }
    #bookingModal .modal-header .btn-close { filter: invert(1); }
    #bookingModal .modal-content { border-radius: 12px; border: 1px solid var(--admin-border); background: var(--admin-surface); }
    .detail-row { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 1px solid var(--admin-border); font-size: .8rem; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { color: #B8AFA6; font-weight: 500; }
    .detail-value { font-weight: 600; text-align: right; color: #E6E2DA; }

    /* ── Summary badges - MAXIMUM SMALL ──────────────────────────────────── */
    .summary-box {
        background: var(--admin-surface);
        border-radius: 6px;
        padding: 6px 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,.3);
        border: 1px solid var(--admin-border);
        display: flex;
        align-items: center;
        gap: 6px;
        min-width: 85px;
    }
    .summary-box .s-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .summary-box .s-count { 
        font-size: 0.95rem; 
        font-weight: 700; 
        line-height: 1; 
        color: #E6E2DA; 
    }
    .summary-box .s-label { 
        font-size: .6rem; 
        color: #B8AFA6; 
        margin-top: 1px; 
    }
    
    /* Hide "more" link - make it smaller */
    .fc .fc-daygrid-more-link { 
        font-size: .55rem !important; 
        padding: 0 2px !important;
    }
    
    /* Reduce spacing in day grid */
    .fc .fc-daygrid-body { font-size: .65rem; }
</style>
@endpush

@section('content')

{{-- ── Page header ──────────────────────────────────────────── --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-0">Booking Calendar</h4>
        <p class="text-muted small mb-0">Visual overview of all bookings by check-in / check-out dates</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-list-ul me-1"></i>List View
        </a>
    </div>
</div>

{{-- ── Status summary row ───────────────────────────────────── --}}
<div class="d-flex flex-wrap gap-3 mb-4">
    @php
        $summaryItems = [
            ['pending',    '#FFC107', 'Pending',    'bi-hourglass-split'],
            ['confirmed',  '#198754', 'Confirmed',  'bi-check-circle'],
            ['checked_in', '#0DCAF0', 'Checked In', 'bi-box-arrow-in-right'],
            ['completed',  '#0D6EFD', 'Completed',  'bi-patch-check'],
            ['cancelled',  '#DC3545', 'Cancelled',  'bi-x-circle'],
        ];
    @endphp
    @foreach($summaryItems as [$key, $color, $label, $icon])
    <div class="summary-box">
        <div class="s-dot" style="background:{{ $color }};"></div>
        <div>
            <div class="s-count">{{ $statusCounts[$key] ?? 0 }}</div>
            <div class="s-label">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- ── Filters ──────────────────────────────────────────────── --}}
<div class="admin-card p-3 mb-4">
    <div class="d-flex flex-wrap align-items-center gap-2">
        <span class="small fw-semibold text-muted me-1">Filter:</span>

        <span class="status-pill active" data-status="all" style="color:#E6E2DA;background:var(--admin-surface-2);">
            <span class="dot" style="background:#E6E2DA;"></span> All
        </span>
        <span class="status-pill" data-status="pending" style="color:#856404;background:#fff8e1;">
            <span class="dot" style="background:#FFC107;"></span> Pending
        </span>
        <span class="status-pill" data-status="confirmed" style="color:#155724;background:#e9f7ef;">
            <span class="dot" style="background:#198754;"></span> Confirmed
        </span>
        <span class="status-pill" data-status="checked_in" style="color:#055160;background:#e0f5fb;">
            <span class="dot" style="background:#0DCAF0;"></span> Checked In
        </span>
        <span class="status-pill" data-status="completed" style="color:#084298;background:#e8f0fe;">
            <span class="dot" style="background:#0D6EFD;"></span> Completed
        </span>
        <span class="status-pill" data-status="cancelled" style="color:#842029;background:#fde8e9;">
            <span class="dot" style="background:#DC3545;"></span> Cancelled
        </span>

        <div class="ms-auto d-flex align-items-center gap-2">
            <label class="small text-muted mb-0">View:</label>
            <select id="viewSwitcher" class="form-select form-select-sm" style="width:140px;">
                <option value="dayGridMonth">Month</option>
                <option value="timeGridWeek">Week</option>
                <option value="timeGridDay">Day</option>
                <option value="listWeek">List (Week)</option>
                <option value="listMonth">List (Month)</option>
            </select>
        </div>
    </div>
</div>

{{-- ── Calendar ─────────────────────────────────────────────── --}}
<div id="calendar"></div>

{{-- ── Booking detail modal ────────────────────────────────── --}}
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title mb-0 fw-bold" id="modalBookingNumber">—</h6>
                    <div class="small opacity-75" id="modalRoomName">—</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pb-2">
                <div id="modalStatusBadge" class="mb-3"></div>

                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-person me-1"></i>Guest</span>
                    <span class="detail-value" id="modalGuestName">—</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-envelope me-1"></i>Email</span>
                    <span class="detail-value" id="modalGuestEmail">—</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-door-open me-1"></i>Room</span>
                    <span class="detail-value" id="modalRoom">—</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-calendar-event me-1"></i>Check-in</span>
                    <span class="detail-value" id="modalCheckIn">—</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-calendar-x me-1"></i>Check-out</span>
                    <span class="detail-value" id="modalCheckOut">—</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-moon me-1"></i>Nights</span>
                    <span class="detail-value" id="modalNights">—</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-currency-exchange me-1"></i>Total</span>
                    <span class="detail-value text-gold fw-bold" id="modalTotal">—</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-credit-card me-1"></i>Payment</span>
                    <span class="detail-value" id="modalPayment">—</span>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <a href="#" class="btn btn-gold btn-sm" id="modalViewBtn">
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

    // ── Status badge colours ────────────────────────────────────
    const STATUS_COLORS = {
        'Pending'    : 'warning',
        'Confirmed'  : 'success',
        'Checked In' : 'info',
        'Completed'  : 'primary',
        'Cancelled'  : 'danger',
    };

    // ── Active filter state ────────────────────────────────────
    let activeStatus = 'all';

    // ── FullCalendar init ──────────────────────────────────────
    const calEl = document.getElementById('calendar');
    const modal  = new bootstrap.Modal(document.getElementById('bookingModal'));

    const calendar = new FullCalendar.Calendar(calEl, {
        initialView : 'dayGridMonth',
        headerToolbar: {
            left  : 'prev,next today',
            center: 'title',
            right : '',          // view switcher handled by our <select>
        },
        height    : 'auto',
        firstDay  : 1,           // Monday first
        dayMaxEvents: 3,         // "+N more" link if too many
        eventDisplay: 'block',
        navLinks  : true,

        // ── Data source (JSON endpoint) ──────────────────────
        events: function (info, successCb, failureCb) {
            const url = new URL('{{ route("admin.bookings.calendar") }}', window.location.origin);
            url.searchParams.set('start',  info.startStr.split('T')[0]);
            url.searchParams.set('end',    info.endStr.split('T')[0]);
            url.searchParams.set('status', activeStatus);

            fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(successCb)
                .catch(failureCb);
        },

        // ── Event click → open modal ──────────────────────────
        eventClick: function (info) {
            info.jsEvent.preventDefault();
            const p = info.event.extendedProps;

            document.getElementById('modalBookingNumber').textContent = p.booking_number;
            document.getElementById('modalRoomName').textContent      = 'Room ' + p.room_number;
            document.getElementById('modalGuestName').textContent     = p.guest_name;
            document.getElementById('modalGuestEmail').textContent    = p.guest_email;
            document.getElementById('modalRoom').textContent          = p.room + ' (#' + p.room_number + ')';
            document.getElementById('modalCheckIn').textContent       = p.check_in;
            document.getElementById('modalCheckOut').textContent      = p.check_out;
            document.getElementById('modalNights').textContent        = p.nights + (p.nights == 1 ? ' night' : ' nights');
            document.getElementById('modalTotal').textContent         = '₱' + p.total_amount;
            document.getElementById('modalPayment').textContent       = p.payment_status;
            document.getElementById('modalViewBtn').href              = p.url;

            const badgeColor = STATUS_COLORS[p.status] || 'secondary';
            document.getElementById('modalStatusBadge').innerHTML =
                `<span class="badge bg-${badgeColor} px-3 py-2 fs-6">${p.status}</span>`;

            modal.show();
        },

        // ── Tooltip on hover ──────────────────────────────────
        eventMouseEnter: function (info) {
            const p = info.event.extendedProps;
            info.el.title = `${p.booking_number}\n${p.guest_name}\n${p.check_in} → ${p.check_out}`;
        },

        // ── Style each event based on its status ─────────────
        eventDidMount: function (info) {
            const el = info.el;
            el.style.borderRadius = '4px';
            el.style.padding      = '2px 5px';
        },
    });

    calendar.render();

    // ── View switcher <select> ─────────────────────────────────
    document.getElementById('viewSwitcher').addEventListener('change', function () {
        calendar.changeView(this.value);
    });

    // ── Status filter pills ────────────────────────────────────
    document.querySelectorAll('.status-pill').forEach(function (pill) {
        pill.addEventListener('click', function () {
            document.querySelectorAll('.status-pill').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            activeStatus = this.dataset.status;
            calendar.refetchEvents();
        });
    });
});
</script>
@endpush
