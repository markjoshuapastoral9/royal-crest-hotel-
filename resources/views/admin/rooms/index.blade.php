@extends('layouts.admin')
@section('title', 'Rooms')
@section('breadcrumb')<li class="breadcrumb-item active">Rooms</li>@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Room Management</h4>
    <a href="{{ route('admin.rooms.create') }}" class="btn btn-gold"><i class="bi bi-plus-lg me-1"></i>Add Room</a>
</div>

<div class="admin-card p-3 mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search room name, number..." value="{{ request('search') }}"></div>
        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                @foreach(['available','occupied','reserved','maintenance'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="type" class="form-select form-select-sm">
                <option value="">All Types</option>
                @foreach($roomTypes as $t)
                <option value="{{ $t->id }}" {{ request('type')==$t->id?'selected':'' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-gold btn-sm flex-fill">Filter</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">Clear</a>
        </div>
    </form>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>Room</th><th>Type</th><th>Floor</th><th>Capacity</th><th>Price/Night</th><th>Status</th><th>Featured</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr style="background:var(--admin-surface);">
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $room->thumbnail_url }}" class="rounded-2" style="width:50px;height:40px;object-fit:cover;" alt="{{ $room->name }}">
                            <div>
                                <div style="font-size:.88rem;font-weight:600;color:#E6E2DA;">{{ $room->name }}</div>
                                <div style="font-size:.72rem;color:#E6E2DA;">Room {{ $room->room_number }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="color:#E6E2DA;font-size:.88rem;">{{ $room->roomType->name }}</td>
                    <td style="color:#E6E2DA;font-size:.88rem;">{{ $room->floor }}</td>
                    <td style="color:#E6E2DA;font-size:.88rem;">{{ $room->capacity }}</td>
                    <td style="color:#E6E2DA;font-size:.88rem;font-weight:600;">₱{{ number_format($room->price_per_night,2) }}</td>
                    <td>
                        @php
                            $statusClass = match($room->status) {
                                'available'   => 'bg-success',
                                'occupied'    => 'bg-warning text-dark',
                                'reserved'    => 'bg-info',
                                'maintenance' => 'bg-secondary',
                                default       => 'bg-light text-dark',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($room->status) }}</span>
                    </td>
                    <td>{!! $room->is_featured ? '<span class="badge" style="background:var(--gold)">Yes</span>' : '<span class="text-muted small">No</span>' !!}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Delete this room?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No rooms found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rooms->hasPages())<div class="p-3 border-top">{{ $rooms->links() }}</div>@endif
</div>
@endsection

@push('styles')
<style>
    /* OVERRIDE TABLE TEXT COLORS */
    table.table tbody tr td,
    table.table tbody tr td *:not(.badge):not(.btn):not(i) {
        color: #E6E2DA !important;
    }
    table.table tbody tr td .text-muted {
        color: #B8AFA6 !important;
    }
</style>
@endpush
