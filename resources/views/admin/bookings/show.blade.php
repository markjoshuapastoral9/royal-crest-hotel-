@extends('layouts.admin')
@section('title', 'Booking ' . $booking->booking_number)
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
<li class="breadcrumb-item active">{{ $booking->booking_number }}</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">{{ $booking->booking_number }}</h4>
        <span class="badge bg-{{ $booking->status_badge }} px-3">{{ ucfirst(str_replace('_',' ',$booking->status)) }}</span>
        <span class="badge bg-{{ $booking->payment_status_badge }} px-3 ms-1">{{ ucfirst(str_replace('_',' ',$booking->payment_status)) }}</span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="{{ route('admin.bookings.invoice', $booking) }}" class="btn btn-sm btn-outline-secondary" target="_blank"><i class="bi bi-printer me-1"></i>Invoice</a>
        @if($booking->isPending())
        <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">@csrf
            <button class="btn btn-sm btn-success"><i class="bi bi-check-circle me-1"></i>Confirm</button>
        </form>
        @elseif($booking->isConfirmed())
        <form method="POST" action="{{ route('admin.bookings.check-in', $booking) }}">@csrf
            <button class="btn btn-sm btn-info text-white"><i class="bi bi-box-arrow-in-right me-1"></i>Check In</button>
        </form>
        @elseif($booking->isCheckedIn())
        <form method="POST" action="{{ route('admin.bookings.check-out', $booking) }}">@csrf
            <button class="btn btn-sm btn-secondary"><i class="bi bi-box-arrow-right me-1"></i>Check Out</button>
        </form>
        @endif
        @if(!$booking->isCancelled() && !$booking->isCompleted())
        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel</button>
        @endif
        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-1"></i>Delete</button>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Room -->
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Room Information</h6>
            <div class="d-flex gap-3">
                <img src="{{ $booking->room->thumbnail_url }}" class="rounded-3" style="width:100px;height:75px;object-fit:cover;" alt="{{ $booking->room->name }}">
                <div>
                    <div class="fw-semibold">{{ $booking->room->name }}</div>
                    <div class="text-muted small">{{ $booking->room->roomType->name }} · Room {{ $booking->room->room_number }}</div>
                    <div class="text-muted small">Floor {{ $booking->room->floor }} · {{ $booking->room->capacity }} guests max</div>
                </div>
            </div>
        </div>

        <!-- Guest -->
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Guest Information</h6>
            <div class="row g-2 small">
                <div class="col-md-6"><span class="text-muted">Name:</span> <span class="fw-semibold">{{ $booking->guest_name }}</span></div>
                <div class="col-md-6"><span class="text-muted">Email:</span> <span class="fw-semibold">{{ $booking->guest_email }}</span></div>
                <div class="col-md-6"><span class="text-muted">Phone:</span> <span class="fw-semibold">{{ $booking->guest_phone }}</span></div>
                <div class="col-md-6"><span class="text-muted">Address:</span> <span class="fw-semibold">{{ $booking->guest_address ?? 'N/A' }}</span></div>
                <div class="col-md-6"><span class="text-muted">Adults:</span> <span class="fw-semibold">{{ $booking->adults }}</span></div>
                <div class="col-md-6"><span class="text-muted">Children:</span> <span class="fw-semibold">{{ $booking->children }}</span></div>
                @if($booking->special_requests)
                <div class="col-12"><span class="text-muted">Special Requests:</span> <span>{{ $booking->special_requests }}</span></div>
                @endif
            </div>
        </div>

        <!-- Stay -->
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Stay Details</h6>
            <div class="row g-2 small">
                <div class="col-md-4"><span class="text-muted">Check-in:</span> <span class="fw-semibold">{{ $booking->check_in->format('D, M d, Y') }}</span></div>
                <div class="col-md-4"><span class="text-muted">Check-out:</span> <span class="fw-semibold">{{ $booking->check_out->format('D, M d, Y') }}</span></div>
                <div class="col-md-4"><span class="text-muted">Nights:</span> <span class="fw-semibold">{{ $booking->nights }}</span></div>
            </div>
        </div>

        <!-- Payments -->
        @if($booking->payments->count())
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Payments</h6>
            <table class="table table-sm mb-0">
                <thead><tr><th>Reference</th><th>Method</th><th>Amount</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach($booking->payments as $pay)
                <tr>
                    <td class="small">{{ $pay->reference_number }}</td>
                    <td class="small">{{ ucfirst($pay->method) }}</td>
                    <td class="small fw-semibold">₱{{ number_format($pay->amount,2) }}</td>
                    <td><span class="badge {{ $pay->status==='verified'?'bg-success':($pay->status==='rejected'?'bg-danger':'bg-warning text-dark') }}" style="font-size:.7rem;">{{ ucfirst($pay->status) }}</span></td>
                    <td>
                        @if($pay->status === 'pending')
                        <form method="POST" action="{{ route('admin.payments.verify', $pay) }}" class="d-inline">@csrf
                            <button class="btn btn-xs btn-success" style="padding:2px 8px;font-size:.75rem;">Verify</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Financial Summary -->
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Financial Summary</h6>
            <div class="small">
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Room Rate</span><span>₱{{ number_format($booking->room_price_per_night,2) }}/night</span></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Subtotal</span><span>₱{{ number_format($booking->subtotal,2) }}</span></div>
                @if($booking->discount_amount > 0)
                <div class="d-flex justify-content-between mb-2 text-success"><span>Discount</span><span>-₱{{ number_format($booking->discount_amount,2) }}</span></div>
                @endif
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">VAT 12%</span><span>₱{{ number_format($booking->tax_amount,2) }}</span></div>
                <hr class="my-2">
                <div class="d-flex justify-content-between fw-bold"><span>Total</span><span class="text-gold">₱{{ number_format($booking->total_amount,2) }}</span></div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Timeline</h6>
            <div class="small">
                <div class="d-flex gap-2 mb-2"><i class="bi bi-circle-fill text-success mt-1" style="font-size:.5rem;"></i><div><div>Created</div><div class="text-muted">{{ $booking->created_at->format('M d, Y H:i') }}</div></div></div>
                @if($booking->confirmed_at)<div class="d-flex gap-2 mb-2"><i class="bi bi-circle-fill text-success mt-1" style="font-size:.5rem;"></i><div><div>Confirmed</div><div class="text-muted">{{ $booking->confirmed_at->format('M d, Y H:i') }}</div></div></div>@endif
                @if($booking->checked_in_at)<div class="d-flex gap-2 mb-2"><i class="bi bi-circle-fill text-info mt-1" style="font-size:.5rem;"></i><div><div>Checked In</div><div class="text-muted">{{ $booking->checked_in_at->format('M d, Y H:i') }}</div></div></div>@endif
                @if($booking->checked_out_at)<div class="d-flex gap-2 mb-2"><i class="bi bi-circle-fill text-secondary mt-1" style="font-size:.5rem;"></i><div><div>Checked Out</div><div class="text-muted">{{ $booking->checked_out_at->format('M d, Y H:i') }}</div></div></div>@endif
                @if($booking->cancelled_at)<div class="d-flex gap-2 mb-2"><i class="bi bi-circle-fill text-danger mt-1" style="font-size:.5rem;"></i><div><div>Cancelled</div><div class="text-muted">{{ $booking->cancelled_at->format('M d, Y H:i') }}</div></div></div>@endif
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h6 class="modal-title fw-bold">Cancel Booking</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">@csrf
            <div class="modal-body">
                <textarea name="reason" class="form-control" rows="3" placeholder="Reason for cancellation"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-danger">Cancel Booking</button>
            </div>
        </form>
    </div></div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h6 class="modal-title fw-bold text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Delete Booking</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <p class="mb-1">Are you sure you want to permanently delete booking <strong>{{ $booking->booking_number }}</strong>?</p>
            <p class="text-danger small mb-0"><i class="bi bi-exclamation-circle me-1"></i>This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Cancel</button>
            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash me-1"></i>Delete Permanently</button>
            </form>
        </div>
    </div></div>
</div>
@endsection
