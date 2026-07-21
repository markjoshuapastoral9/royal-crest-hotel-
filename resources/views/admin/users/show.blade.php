@extends('layouts.admin')
@section('title', $user->name)
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
<li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">{{ $user->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-gold btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="admin-card p-4 text-center mb-4">
            <img src="{{ $user->avatar_url }}" class="rounded-circle mb-3"
                 width="80" height="80" style="object-fit:cover;" alt="{{ $user->name }}">
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'staff' ? 'bg-info' : 'bg-secondary') }} mb-2">
                {{ ucfirst($user->role) }}
            </span>
            <div class="text-muted small mb-1">{{ $user->email }}</div>
            @if($user->phone)<div class="text-muted small">{{ $user->phone }}</div>@endif
            <div class="mt-2">
                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Account Info</h6>
            <div class="small">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Joined</span>
                    <span>{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Verified</span>
                    <span>{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'No' }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Total Bookings</span>
                    <span class="fw-bold">{{ $user->bookings()->count() }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Booking History</h6>
            @php $bookings = $user->bookings()->with('room')->latest()->take(10)->get(); @endphp
            @if($bookings->count())
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Booking #</th><th>Room</th><th>Check-in</th><th>Amount</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($bookings as $b)
                        <tr>
                            <td><a href="{{ route('admin.bookings.show', $b) }}" class="text-gold small text-decoration-none">{{ $b->booking_number }}</a></td>
                            <td class="small">{{ $b->room->name }}</td>
                            <td class="small">{{ $b->check_in->format('M d, Y') }}</td>
                            <td class="small fw-semibold">₱{{ number_format($b->total_amount,2) }}</td>
                            <td><span class="badge bg-{{ $b->status_badge }}" style="font-size:.7rem;">{{ ucfirst(str_replace('_',' ',$b->status)) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted small mb-0">No bookings yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
