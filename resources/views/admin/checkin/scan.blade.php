@extends('layouts.admin')

@section('title', 'QR Check-in')

@section('breadcrumb')
<li class="breadcrumb-item active">QR Check-in</li>
@endsection

@push('styles')
<style>
    .checkin-card {
        background: var(--admin-surface);
        border: 1px solid var(--admin-border);
        border-radius: 16px;
        padding: 2rem;
    }

    /* Tab nav */
    .checkin-tabs {
        display: flex;
        gap: .5rem;
        margin-bottom: 1.5rem;
        background: var(--admin-surface-2);
        border: 1px solid var(--admin-border);
        border-radius: 10px;
        padding: .35rem;
    }
    .checkin-tab-btn {
        flex: 1;
        background: transparent;
        border: none;
        color: var(--admin-text-muted);
        padding: .6rem 1rem;
        border-radius: 8px;
        font-size: .88rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s, color .2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        white-space: nowrap;
    }
    .checkin-tab-btn.active {
        background: var(--gold);
        color: #101111;
    }
    .checkin-tab-btn:not(.active):hover {
        background: rgba(255,255,255,.06);
        color: var(--admin-text);
    }
    .tab-pane { display: none; }
    .tab-pane.active { display: block; }

    /* Inputs */
    .payload-input {
        background: var(--admin-surface-2);
        border: 1px solid var(--admin-border);
        color: var(--admin-text);
        border-radius: 10px;
        padding: .75rem 1rem;
        font-size: .95rem;
        width: 100%;
        transition: border-color .2s;
    }
    .payload-input:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201,168,76,.15);
    }
    .input-label {
        color: var(--admin-text-muted);
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .5px;
        text-transform: uppercase;
        display: block;
        margin-bottom: .5rem;
    }

    /* Buttons */
    .btn-gold-lg {
        background: var(--gold);
        color: #101111;
        border: none;
        border-radius: 10px;
        padding: .75rem 2rem;
        font-weight: 700;
        font-size: .95rem;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-gold-lg:hover { background: #b8963e; }
    .btn-gold-lg:disabled { opacity: .65; cursor: not-allowed; }

    /* Booking detail panel */
    .booking-detail-box {
        background: var(--admin-surface-2);
        border: 1px solid var(--admin-border);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .5rem 0;
        border-bottom: 1px solid rgba(255,255,255,.05);
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { color: var(--admin-text-muted); font-size: .8rem; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; }
    .detail-value { color: var(--admin-text); font-size: .9rem; font-weight: 500; }

    /* Status badges */
    .status-badge-confirmed  { background: rgba(25,135,84,.25);  color: #75b798; border-radius: 6px; padding: 3px 10px; font-size: .78rem; font-weight: 600; }
    .status-badge-checked_in { background: rgba(13,202,240,.2);  color: #6edff6; border-radius: 6px; padding: 3px 10px; font-size: .78rem; font-weight: 600; }
    .status-badge-pending    { background: rgba(255,193,7,.2);   color: #ffc107; border-radius: 6px; padding: 3px 10px; font-size: .78rem; font-weight: 600; }
    .status-badge-default    { background: rgba(255,255,255,.1); color: #aaa;    border-radius: 6px; padding: 3px 10px; font-size: .78rem; font-weight: 600; }

    /* Feedback boxes */
    .error-box {
        background: rgba(220,53,69,.15);
        border: 1px solid rgba(220,53,69,.3);
        color: #ea868f;
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
        display: none;
    }
    .checkin-result-box {
        display: none;
        margin-top: 1rem;
        padding: .85rem 1rem;
        border-radius: 10px;
        text-align: center;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color:var(--admin-text);">QR Check-in</h4>
        <p class="mb-0" style="color:var(--admin-text-muted);font-size:.88rem;">Look up a booking by number or paste a QR payload to verify and check in.</p>
    </div>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Bookings
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7 col-xl-6">

        <div class="checkin-card">

            {{-- Tab navigation --}}
            <div class="checkin-tabs" role="tablist">
                <button class="checkin-tab-btn active" id="tab-booking" onclick="switchTab('booking')" role="tab" aria-selected="true">
                    <i class="bi bi-search"></i> Search by Booking #
                </button>
                <button class="checkin-tab-btn" id="tab-qr" onclick="switchTab('qr')" role="tab" aria-selected="false">
                    <i class="bi bi-qr-code-scan"></i> Paste QR Payload
                </button>
            </div>

            {{-- Tab 1: Search by Booking Number --}}
            <div class="tab-pane active" id="pane-booking">
                <div class="mb-3">
                    <label class="input-label" for="bookingNumberInput">Booking Number</label>
                    <input
                        type="text"
                        id="bookingNumberInput"
                        class="payload-input"
                        placeholder="e.g. SUB-2026-000004"
                        autocomplete="off"
                        spellcheck="false"
                    >
                </div>
                <button id="lookupBtn" class="btn-gold-lg w-100" onclick="lookupBooking()">
                    <i class="bi bi-search me-2"></i>Look Up &amp; Check In
                </button>
                <div class="error-box" id="bookingErrorBox"></div>
                <div id="bookingSuccessBox" style="display:none;">
                    @include('admin.checkin._booking_detail_panel', ['prefix' => 'booking'])
                </div>
            </div>

            {{-- Tab 2: QR Payload --}}
            <div class="tab-pane" id="pane-qr">
                <div class="mb-3">
                    <label class="input-label" for="payloadInput">QR Payload (base64url)</label>
                    <input
                        type="text"
                        id="payloadInput"
                        class="payload-input"
                        placeholder="Paste QR payload here…"
                        autocomplete="off"
                    >
                </div>
                <button id="verifyBtn" class="btn-gold-lg w-100" onclick="verifyPayload()">
                    <i class="bi bi-shield-check me-2"></i>Verify
                </button>
                <div class="error-box" id="qrErrorBox"></div>
                <div id="qrSuccessBox" style="display:none;">
                    @include('admin.checkin._booking_detail_panel', ['prefix' => 'qr'])
                </div>
            </div>

        </div>

        {{-- Info strip --}}
        <div class="mt-3 p-3 rounded-3" style="background:rgba(201,168,76,.08);border:1px solid rgba(201,168,76,.2);">
            <p class="mb-0" style="color:rgba(201,168,76,.8);font-size:.82rem;line-height:1.6;">
                <i class="bi bi-info-circle me-1"></i>
                Use <strong>Search by Booking #</strong> for day-to-day check-ins.
                Use <strong>Paste QR Payload</strong> when scanning with a dedicated QR scanner device.
            </p>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── State ────────────────────────────────────────────────────────────────
    let currentBookingId   = { booking: null, qr: null };

    // ── Tab switching ────────────────────────────────────────────────────────
    function switchTab(tab) {
        ['booking', 'qr'].forEach(t => {
            document.getElementById('tab-' + t).classList.toggle('active', t === tab);
            document.getElementById('pane-' + t).classList.toggle('active', t === tab);
            document.getElementById('tab-' + t).setAttribute('aria-selected', t === tab ? 'true' : 'false');
        });
    }

    // ── Shared helpers ───────────────────────────────────────────────────────
    function showError(prefix, message) {
        const box = document.getElementById(prefix + 'ErrorBox');
        box.textContent = message;
        box.style.display = 'block';
    }
    function hideError(prefix) {
        document.getElementById(prefix + 'ErrorBox').style.display = 'none';
    }

    function populatePanel(prefix, b) {
        currentBookingId[prefix] = b.id;

        document.getElementById(prefix + 'BookingNumber').textContent = b.booking_number;
        document.getElementById(prefix + 'GuestName').textContent     = b.guest_name;
        document.getElementById(prefix + 'GuestEmail').textContent    = b.guest_email;
        document.getElementById(prefix + 'GuestPhone').textContent    = b.guest_phone;
        document.getElementById(prefix + 'RoomInfo').textContent      = b.room_name + ' (Room ' + b.room_number + ')';
        document.getElementById(prefix + 'CheckIn').textContent       = b.check_in;
        document.getElementById(prefix + 'CheckOut').textContent      = b.check_out;
        document.getElementById(prefix + 'Nights').textContent        = b.nights + ' night(s)';
        document.getElementById(prefix + 'TotalAmount').textContent   = '₱' + b.total_amount;
        document.getElementById(prefix + 'PaymentStatus').textContent = b.payment_status.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase());

        const badge = document.getElementById(prefix + 'StatusBadge');
        badge.className = 'status-badge-' + (['confirmed','checked_in','pending'].includes(b.status) ? b.status : 'default');
        badge.textContent = b.status.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

        const checkInBtn = document.getElementById(prefix + 'CheckInBtn');
        checkInBtn.style.display = b.can_checkin ? 'block' : 'none';

        document.getElementById(prefix + 'CheckinResultBox').style.display = 'none';
        document.getElementById(prefix + 'SuccessBox').style.display = 'block';
    }

    async function doCheckIn(prefix) {
        const id = currentBookingId[prefix];
        if (!id) return;

        const btn = document.getElementById(prefix + 'CheckInBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Checking in…';

        const url = `{{ url('admin/checkin') }}/${id}/checkin`;

        try {
            const res  = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            });
            const data = await res.json();
            const resultBox = document.getElementById(prefix + 'CheckinResultBox');

            if (data.success) {
                resultBox.style.cssText = 'display:block;background:rgba(25,135,84,.2);border:1px solid rgba(25,135,84,.4);color:#75b798;';
                resultBox.innerHTML = '<i class="bi bi-check-circle me-2"></i>' + data.message;
                btn.style.display = 'none';
                const badge = document.getElementById(prefix + 'StatusBadge');
                badge.className = 'status-badge-checked_in';
                badge.textContent = 'Checked In';
            } else {
                resultBox.style.cssText = 'display:block;background:rgba(220,53,69,.15);border:1px solid rgba(220,53,69,.3);color:#ea868f;';
                resultBox.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>' + data.message;
            }
            resultBox.classList.add('checkin-result-box');
            resultBox.style.display = 'block';
        } catch (e) {
            const resultBox = document.getElementById(prefix + 'CheckinResultBox');
            resultBox.style.cssText = 'display:block;background:rgba(220,53,69,.15);border:1px solid rgba(220,53,69,.3);color:#ea868f;';
            resultBox.textContent = 'Network error. Please try again.';
        } finally {
            btn.disabled = false;
            if (btn.style.display !== 'none') {
                btn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Check In Guest';
            }
        }
    }

    // ── Tab 1: Lookup by booking number ─────────────────────────────────────
    async function lookupBooking() {
        const value    = document.getElementById('bookingNumberInput').value.trim();
        const errorBox = document.getElementById('bookingErrorBox');
        const successBox = document.getElementById('bookingSuccessBox');

        hideError('booking');
        successBox.style.display = 'none';

        if (!value) {
            showError('booking', 'Please enter a booking number.');
            return;
        }

        const btn = document.getElementById('lookupBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Looking up…';

        try {
            const res  = await fetch('{{ route("admin.checkin.verify-booking") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ booking_number: value }),
            });
            const data = await res.json();

            if (!data.success) {
                showError('booking', data.message || 'Booking not found.');
            } else {
                populatePanel('booking', data.booking);
            }
        } catch (e) {
            showError('booking', 'Network error. Please try again.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-search me-2"></i>Look Up &amp; Check In';
        }
    }

    // ── Tab 2: Verify QR payload ─────────────────────────────────────────────
    async function verifyPayload() {
        const payload    = document.getElementById('payloadInput').value.trim();
        const successBox = document.getElementById('qrSuccessBox');

        hideError('qr');
        successBox.style.display = 'none';

        if (!payload) {
            showError('qr', 'Please enter a QR payload.');
            return;
        }

        const btn = document.getElementById('verifyBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verifying…';

        try {
            const res  = await fetch('{{ route("admin.checkin.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ payload }),
            });
            const data = await res.json();

            if (!data.success) {
                showError('qr', data.message || 'Verification failed.');
            } else {
                populatePanel('qr', data.booking);
            }
        } catch (e) {
            showError('qr', 'Network error. Please try again.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-shield-check me-2"></i>Verify';
        }
    }

    // ── Enter key shortcuts ──────────────────────────────────────────────────
    document.getElementById('bookingNumberInput').addEventListener('keydown', e => { if (e.key === 'Enter') lookupBooking(); });
    document.getElementById('payloadInput').addEventListener('keydown',        e => { if (e.key === 'Enter') verifyPayload(); });
</script>
@endpush
