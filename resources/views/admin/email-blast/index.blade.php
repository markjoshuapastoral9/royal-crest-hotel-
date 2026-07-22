@extends('layouts.admin')
@section('title', 'Email Blast')
@section('breadcrumb')
<li class="breadcrumb-item active">Email Blast</li>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background:rgba(117,183,152,.15);border:1px solid #75b798;color:#75b798;">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show mb-4" role="alert" style="background:rgba(255,193,7,.15);border:1px solid #ffc107;color:#ffc107;">
    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background:rgba(234,134,143,.15);border:1px solid #ea868f;color:#ea868f;">
    <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Email Blast</h4>
        <p class="mb-0" style="color:var(--admin-text-muted);font-size:.85rem;">Send announcements or promotions to all registered guests.</p>
    </div>
</div>

<div class="row g-4">
    {{-- LEFT: Compose Form --}}
    <div class="col-lg-7">

        {{-- Recipient Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="admin-card p-3 text-center">
                    <div style="font-size:2rem;font-weight:700;color:var(--gold);">{{ $totalGuests }}</div>
                    <div style="font-size:.8rem;color:var(--admin-text-muted);">Total Registered Guests</div>
                </div>
            </div>
            <div class="col-6">
                <div class="admin-card p-3 text-center">
                    <div style="font-size:2rem;font-weight:700;color:#75b798;">{{ $activeGuests }}</div>
                    <div style="font-size:.8rem;color:var(--admin-text-muted);">Active Guests</div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.email-blast.send') }}" id="blastForm">
        @csrf

            <div class="admin-card p-4">
                <h6 class="fw-bold mb-3" style="color:var(--gold);letter-spacing:.5px;">
                    <i class="bi bi-people me-2"></i>Recipients
                </h6>
                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <label class="recipient-card d-block" style="cursor:pointer;">
                            <input type="radio" name="target" value="all" class="d-none target-radio"
                                {{ old('target', 'active') == 'all' ? 'checked' : '' }}>
                            <div class="p-3 text-center" style="border:2px solid var(--admin-border);border-radius:8px;transition:all .2s;">
                                <i class="bi bi-people-fill fs-4 d-block mb-1" style="color:var(--admin-text-muted);"></i>
                                <div style="font-size:.85rem;font-weight:600;">All Guests</div>
                                <div style="font-size:.72rem;color:var(--admin-text-muted);">{{ $totalGuests }} recipients</div>
                            </div>
                        </label>
                    </div>
                    <div class="col-6">
                        <label class="recipient-card d-block" style="cursor:pointer;">
                            <input type="radio" name="target" value="active" class="d-none target-radio"
                                {{ old('target', 'active') == 'active' ? 'checked' : '' }}>
                            <div class="p-3 text-center" style="border:2px solid var(--admin-border);border-radius:8px;transition:all .2s;">
                                <i class="bi bi-person-check-fill fs-4 d-block mb-1" style="color:var(--admin-text-muted);"></i>
                                <div style="font-size:.85rem;font-weight:600;">Active Guests Only</div>
                                <div style="font-size:.72rem;color:var(--admin-text-muted);">{{ $activeGuests }} recipients</div>
                            </div>
                        </label>
                    </div>
                </div>

                <h6 class="fw-bold mb-3" style="color:var(--gold);letter-spacing:.5px;">
                    <i class="bi bi-envelope me-2"></i>Compose Message
                </h6>

                <div class="mb-3">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">Subject Line <span style="color:#ea868f;">*</span></label>
                    <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                        value="{{ old('subject') }}"
                        placeholder="e.g. Exclusive Weekend Promo — Book Now & Save 20%!"
                        id="subjectInput" required maxlength="255">
                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" style="font-size:.82rem;color:var(--admin-text-muted);">
                        Message Body <span style="color:#ea868f;">*</span>
                    </label>
                    <textarea name="message" id="messageBody" class="form-control @error('message') is-invalid @enderror"
                        rows="10"
                        placeholder="e.g. Book now and enjoy 20% OFF on all rooms! Limited time offer. Visit our website to reserve your stay today." required minlength="10">{{ old('message') }}</textarea>
                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="mt-1" style="font-size:.75rem;color:var(--admin-text-muted);">
                        <i class="bi bi-lightbulb me-1"></i>
                        Write a clear and engaging message for your guests. Keep it professional and friendly.
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="previewBtn">
                        <i class="bi bi-eye me-1"></i> Preview Email
                    </button>
                    <button type="submit" class="btn btn-gold fw-bold px-4" id="sendBtn"
                        onclick="return confirmSend()">
                        <i class="bi bi-send me-2"></i>Send Email Blast
                    </button>
                </div>
            </div>

        </form>
    </div>

    {{-- RIGHT: Instructions & Preview --}}
    <div class="col-lg-5">
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3" style="color:var(--gold);letter-spacing:.5px;">
                <i class="bi bi-lightbulb me-2"></i>Tips & Guidelines
            </h6>
            <ul class="list-unstyled mb-0" style="font-size:.83rem;color:var(--admin-text-muted);line-height:1.8;">
                <li><i class="bi bi-check-circle text-success me-2"></i>Keep subject lines concise and compelling</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Write clear and engaging messages for your guests</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Each email is personalized with the guest's name</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Emails are sent one at a time for deliverability</li>
                <li><i class="bi bi-exclamation-triangle text-warning me-2"></i>Large lists may take several minutes to send</li>
                <li><i class="bi bi-exclamation-triangle text-warning me-2"></i>Double-check subject and body before sending</li>
            </ul>
        </div>

        {{-- Live Preview Panel --}}
        <div class="admin-card p-4" id="previewPanel" style="display:none;">
            <h6 class="fw-bold mb-3" style="color:var(--gold);letter-spacing:.5px;">
                <i class="bi bi-eye me-2"></i>Email Preview
            </h6>
            <div style="border:1px solid var(--admin-border);border-radius:8px;overflow:hidden;background:#fff;">
                <div style="background:#1A1A1A;padding:16px 20px;text-align:center;border-bottom:3px solid #C9A84C;">
                    <div style="font-size:18px;font-weight:700;letter-spacing:4px;color:#C9A84C;font-family:Georgia,serif;">ROYAL CREST HOTEL</div>
                    <div style="font-size:9px;letter-spacing:3px;color:rgba(255,255,255,.4);margin-top:2px;">LUXURY · COMFORT · EXCELLENCE</div>
                </div>
                <div style="background:linear-gradient(135deg,#C9A84C,#a8862e);padding:10px 16px;font-size:12px;color:#1A1A1A;font-weight:600;">
                    Dear Valued Guest,
                </div>
                <div style="padding:20px;font-size:13px;color:#3a2e22;line-height:1.7;font-family:Georgia,serif;" id="previewBody">
                    <em style="color:#aaa;">Your message will appear here...</em>
                </div>
                <div style="background:#1A1A1A;padding:16px 20px;text-align:center;">
                    <div style="color:#C9A84C;font-size:11px;font-weight:600;letter-spacing:2px;">ROYAL CREST HOTEL</div>
                    <div style="color:rgba(255,255,255,.3);font-size:10px;margin-top:4px;">123 Luxury Avenue, Makati City, Philippines</div>
                </div>
            </div>
            <div class="mt-2 text-center" style="font-size:.72rem;color:var(--admin-text-muted);">
                Preview subject: <strong id="previewSubject" style="color:var(--admin-text);">—</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    // Recipient card highlight
    function updateRecipientCards() {
        document.querySelectorAll('.target-radio').forEach(function (radio) {
            const card = radio.closest('.recipient-card').querySelector('div');
            if (radio.checked) {
                card.style.borderColor = '#C9A84C';
                card.style.background  = 'rgba(201,168,76,.08)';
                card.querySelector('i').style.color = '#C9A84C';
            } else {
                card.style.borderColor = 'var(--admin-border)';
                card.style.background  = 'transparent';
                card.querySelector('i').style.color = 'var(--admin-text-muted)';
            }
        });
    }

    document.querySelectorAll('.target-radio').forEach(function (radio) {
        radio.addEventListener('change', updateRecipientCards);
    });
    updateRecipientCards(); // run on load

    // Preview toggle
    const previewBtn   = document.getElementById('previewBtn');
    const previewPanel = document.getElementById('previewPanel');
    const previewBody  = document.getElementById('previewBody');
    const previewSubj  = document.getElementById('previewSubject');
    const messageBody  = document.getElementById('messageBody');
    const subjectInput = document.getElementById('subjectInput');

    previewBtn.addEventListener('click', function () {
        const msg  = messageBody.value.trim();
        const subj = subjectInput.value.trim();

        previewBody.innerHTML = msg || '<em style="color:#aaa;">No message content yet...</em>';
        previewSubj.textContent = subj || '(no subject)';
        previewPanel.style.display = 'block';
        previewPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    // Real-time preview update if panel is visible
    [messageBody, subjectInput].forEach(function (el) {
        el.addEventListener('input', function () {
            if (previewPanel.style.display !== 'none') {
                previewBody.innerHTML = messageBody.value.trim() || '<em style="color:#aaa;">No message content yet...</em>';
                previewSubj.textContent = subjectInput.value.trim() || '(no subject)';
            }
        });
    });
})();

function confirmSend() {
    const target    = document.querySelector('.target-radio:checked')?.value;
    const allCount  = {{ $totalGuests }};
    const activeCount = {{ $activeGuests }};
    const count = target === 'all' ? allCount : activeCount;
    const label = target === 'all' ? 'all guests' : 'active guests only';

    if (count === 0) {
        alert('No guests found for the selected target. Cannot send.');
        return false;
    }

    return confirm(`Send this email blast to ${count} ${label}?\n\nThis action cannot be undone.`);
}
</script>
@endpush
