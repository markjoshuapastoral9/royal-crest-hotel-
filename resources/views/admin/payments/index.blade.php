@extends('layouts.admin')
@section('title','Payments')
@section('breadcrumb')<li class="breadcrumb-item active">Payments</li>@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0" style="color:#E6E2DA;">Payment Management</h4>
</div>

{{-- Summary Stats --}}
@php
    $pending  = $payments->getCollection()->where('status','pending')->count();
    $verified = $payments->getCollection()->where('status','verified')->count();
    $rejected = $payments->getCollection()->where('status','rejected')->count();
@endphp
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="admin-card p-3 d-flex align-items-center gap-3">
            <div style="width:44px;height:44px;border-radius:10px;background:rgba(255,193,7,.15);display:flex;align-items:center;justify-content:center;color:#ffc107;font-size:1.3rem;flex-shrink:0;">
                <i class="bi bi-clock"></i>
            </div>
            <div>
                <div style="font-size:.72rem;color:#B8AFA6;text-transform:uppercase;letter-spacing:.5px;">Pending Verification</div>
                <div style="font-size:1.5rem;font-weight:700;color:#ffc107;">{{ \App\Models\Payment::where('status','pending')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-3 d-flex align-items-center gap-3">
            <div style="width:44px;height:44px;border-radius:10px;background:rgba(25,135,84,.15);display:flex;align-items:center;justify-content:center;color:#198754;font-size:1.3rem;flex-shrink:0;">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <div style="font-size:.72rem;color:#B8AFA6;text-transform:uppercase;letter-spacing:.5px;">Verified</div>
                <div style="font-size:1.5rem;font-weight:700;color:#198754;">{{ \App\Models\Payment::where('status','verified')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-3 d-flex align-items-center gap-3">
            <div style="width:44px;height:44px;border-radius:10px;background:rgba(220,53,69,.15);display:flex;align-items:center;justify-content:center;color:#dc3545;font-size:1.3rem;flex-shrink:0;">
                <i class="bi bi-x-circle"></i>
            </div>
            <div>
                <div style="font-size:.72rem;color:#B8AFA6;text-transform:uppercase;letter-spacing:.5px;">Rejected</div>
                <div style="font-size:1.5rem;font-weight:700;color:#dc3545;">{{ \App\Models\Payment::where('status','rejected')->count() }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="admin-card p-3 mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Statuses</option>
                @foreach(['pending','verified','rejected'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-gold btn-sm flex-fill">Filter</button>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">Clear</a>
        </div>
    </form>
</div>

{{-- Payments Table --}}
<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Reference #</th>
                    <th>Guest</th>
                    <th>Booking #</th>
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Proof</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr style="background:var(--admin-surface);">
                    <td>
                        <div style="font-family:monospace;font-size:.82rem;font-weight:700;color:#C9A84C;">{{ $payment->reference_number }}</div>
                    </td>
                    <td>
                        <div style="font-size:.88rem;font-weight:600;color:#E6E2DA;">{{ $payment->booking->guest_name }}</div>
                        <div style="font-size:.72rem;color:#B8AFA6;">{{ $payment->booking->guest_email }}</div>
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $payment->booking) }}" style="font-size:.82rem;color:#C9A84C;text-decoration:none;font-weight:600;">{{ $payment->booking->booking_number }}</a>
                    </td>
                    <td>
                        @php
                            $methodIcon = match($payment->method) {
                                'gcash' => 'bi-phone',
                                'maya' => 'bi-phone-fill',
                                'bank_transfer' => 'bi-bank',
                                'cash' => 'bi-cash',
                                default => 'bi-credit-card'
                            };
                            $methodLabel = match($payment->method) {
                                'gcash' => 'GCash',
                                'maya' => 'Maya',
                                'bank_transfer' => 'Bank Transfer',
                                'cash' => 'Cash',
                                default => ucfirst($payment->method)
                            };
                        @endphp
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi {{ $methodIcon }}" style="color:#C9A84C;font-size:1rem;"></i>
                            <span style="font-size:.85rem;color:#E6E2DA;">{{ $methodLabel }}</span>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:.9rem;font-weight:700;color:#E6E2DA;">₱{{ number_format($payment->amount,2) }}</div>
                    </td>
                    <td>
                        @if($payment->proof_image)
                        <a href="{{ asset('storage/'.$payment->proof_image) }}" target="_blank"
                           style="display:inline-flex;align-items:center;gap:5px;background:rgba(201,168,76,.12);border:1px solid rgba(201,168,76,.3);color:#C9A84C;border-radius:6px;padding:4px 10px;font-size:.78rem;text-decoration:none;font-weight:600;">
                            <i class="bi bi-image"></i> View
                        </a>
                        @else
                        <span style="color:#B8AFA6;font-size:.82rem;">— No proof</span>
                        @endif
                    </td>
                    <td>
                        @if($payment->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($payment->status === 'verified')
                        <span class="badge bg-success">Verified</span>
                        @else
                        <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size:.78rem;color:#B8AFA6;">{{ $payment->created_at->format('M d, Y') }}</div>
                        <div style="font-size:.72rem;color:#B8AFA6;">{{ $payment->created_at->format('h:i A') }}</div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm" style="background:rgba(201,168,76,.15);border:1px solid rgba(201,168,76,.3);color:#C9A84C;" title="View Details"><i class="bi bi-eye"></i></a>
                            @if($payment->status === 'pending')
                            <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="d-inline">@csrf
                                <button class="btn btn-sm btn-success" title="Verify Payment"><i class="bi bi-check-lg"></i></button>
                            </form>
                            <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="d-inline">@csrf
                                <button class="btn btn-sm btn-danger" title="Reject Payment"><i class="bi bi-x-lg"></i></button>
                            </form>
                            @elseif($payment->status === 'verified')
                            <span style="font-size:.72rem;color:#4caf50;">
                                <i class="bi bi-check-circle me-1"></i>
                                @if($payment->verified_at){{ $payment->verified_at->format('M d') }}@endif
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4" style="color:#B8AFA6;">No payments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="p-3 border-top" style="border-color:var(--admin-border)!important;">{{ $payments->links() }}</div>
    @endif
</div>
@endsection
