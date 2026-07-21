@extends('layouts.admin')
@section('title', 'Bookings')
@section('breadcrumb')<li class="breadcrumb-item active">Bookings</li>@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">All Bookings</h4>
    <div class="d-flex gap-2 align-items-center">
        <a href="{{ route('admin.bookings.walk-in') }}" class="btn btn-gold btn-sm">
            <i class="bi bi-person-plus me-1"></i> Walk-in Booking
        </a>
        <form method="POST" action="{{ route('admin.bookings.index') }}" id="bulkApproveForm">
            @csrf
            @method('PATCH')
            <button type="button" class="btn btn-success btn-sm" id="bulkApproveBtn" onclick="bulkApprove()" title="Approve all pending bookings">
                <i class="bi bi-check2-all me-1"></i> Approve All Pending
            </button>
        </form>
    </div>
</div>

<!-- Filters -->
<div class="admin-card p-3 mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search by booking #, name, email..." value="{{ request('search') }}"></div>
        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Statuses</option>
                @foreach(['pending','confirmed','checked_in','checked_out','cancelled','completed'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="From"></div>
        <div class="col-md-2"><input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" placeholder="To"></div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-gold btn-sm flex-fill">Filter</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">Clear</a>
        </div>
    </form>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Booking #</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr style="background:var(--admin-surface);">
                    <td><a href="{{ route('admin.bookings.show', $b) }}" style="letter-spacing:1px;text-decoration:none;color:#E6E2DA;font-weight:600;font-size:.85rem;">{{ $b->booking_number }}</a></td>
                    <td>
                        <div style="font-weight:600;font-size:.88rem;color:#E6E2DA;">{{ $b->guest_name }}</div>
                        <div style="font-size:.75rem;color:#E6E2DA;">{{ $b->guest_email }}</div>
                    </td>
                    <td>
                        <div style="font-size:.88rem;color:#E6E2DA;">{{ $b->room->name }}</div>
                        <div style="font-size:.72rem;color:#E6E2DA;">{{ $b->room->room_number }}</div>
                    </td>
                    <td style="font-size:.88rem;color:#E6E2DA;">{{ $b->check_in->format('M d, Y') }}</td>
                    <td style="font-size:.88rem;color:#E6E2DA;">{{ $b->check_out->format('M d, Y') }}</td>
                    <td style="font-size:.88rem;color:#E6E2DA;font-weight:600;">₱{{ number_format($b->total_amount,2) }}</td>
                    <td><span class="badge bg-{{ $b->payment_status_badge }}" style="font-size:.7rem;">{{ ucfirst(str_replace('_',' ',$b->payment_status)) }}</span></td>
                    <td><span class="badge bg-{{ $b->status_badge }}" style="font-size:.7rem;">{{ ucfirst(str_replace('_',' ',$b->status)) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.bookings.show', $b) }}" class="btn btn-sm btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.bookings.edit', $b) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            @if($b->isPending())
                            <form method="POST" action="{{ route('admin.bookings.confirm', $b) }}" class="d-inline quick-approve-form">@csrf
                                <button type="submit" class="btn btn-sm btn-success" title="Quick Approve" data-booking-id="{{ $b->id }}">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            @elseif($b->isConfirmed())
                            <form method="POST" action="{{ route('admin.bookings.check-in', $b) }}" class="d-inline">@csrf
                                <button class="btn btn-sm btn-info text-white" title="Check In"><i class="bi bi-box-arrow-in-right"></i></button>
                            </form>
                            @elseif($b->isCheckedIn())
                            <form method="POST" action="{{ route('admin.bookings.check-out', $b) }}" class="d-inline">@csrf
                                <button class="btn btn-sm btn-secondary" title="Check Out"><i class="bi bi-box-arrow-right"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
    <div class="p-3 border-top">{{ $bookings->links() }}</div>
    @endif
</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick approve with AJAX
    document.querySelectorAll('.quick-approve-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button');
            const originalHTML = button.innerHTML;
            const bookingId = button.dataset.bookingId;
            
            // Disable button and show loading
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            
            // Submit via AJAX
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success feedback
                    button.classList.remove('btn-success');
                    button.classList.add('btn-info');
                    button.innerHTML = '<i class="bi bi-check-circle-fill"></i>';
                    
                    // Update status badge
                    const row = button.closest('tr');
                    const statusBadge = row.querySelector('td:nth-last-child(2) .badge');
                    if (statusBadge) {
                        statusBadge.className = 'badge bg-success';
                        statusBadge.textContent = 'Confirmed';
                    }
                    
                    // Show toast notification
                    showToast('Success', 'Booking approved successfully!', 'success');
                    
                    // Reload after 1 second to update all data
                    setTimeout(() => location.reload(), 1000);
                } else {
                    throw new Error(data.message || 'Approval failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
                button.innerHTML = originalHTML;
                showToast('Error', error.message || 'Failed to approve booking', 'danger');
            });
        });
    });
});

// Bulk approve all pending bookings on current page
function bulkApprove() {
    const pendingForms = document.querySelectorAll('.quick-approve-form');
    if (pendingForms.length === 0) {
        showToast('Info', 'No pending bookings to approve.', 'warning');
        return;
    }
    
    if (!confirm(`Approve all ${pendingForms.length} pending booking(s) on this page?`)) return;

    const btn = document.getElementById('bulkApproveBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Approving...';

    const promises = Array.from(pendingForms).map(form => {
        return fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(r => r.json());
    });

    Promise.all(promises).then(results => {
        const success = results.filter(r => r.success).length;
        showToast('Success', `${success} booking(s) approved successfully!`, 'success');
        setTimeout(() => location.reload(), 1200);
    }).catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check2-all me-1"></i> Approve All Pending';
        showToast('Error', 'Some approvals failed. Please try again.', 'danger');
    });
}

// Toast notification helper
function showToast(title, message, type = 'info') {
    const toastHTML = `
        <div class="toast align-items-center text-white bg-${type} border-0" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>${title}:</strong> ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    const toastContainer = document.createElement('div');
    toastContainer.innerHTML = toastHTML;
    document.body.appendChild(toastContainer);
    
    const toastElement = toastContainer.querySelector('.toast');
    const toast = new bootstrap.Toast(toastElement, { autohide: true, delay: 3000 });
    toast.show();
    
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastContainer.remove();
    });
}
</script>
@endpush
