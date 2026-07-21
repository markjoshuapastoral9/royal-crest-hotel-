@extends('layouts.admin')
@section('title', $room->name)
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Rooms</a></li>
<li class="breadcrumb-item active">{{ $room->name }}</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">{{ $room->name }}</h4>
        <span class="badge bg-secondary me-1">{{ $room->roomType->name }}</span>
        <span class="badge {{ match($room->status) {
            'available'   => 'bg-success',
            'occupied'    => 'bg-warning text-dark',
            'reserved'    => 'bg-info',
            'maintenance' => 'bg-secondary',
            default       => 'bg-light text-dark'
        } }}">{{ ucfirst($room->status) }}</span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-gold btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit Room
        </a>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Main Image -->
        <div class="admin-card overflow-hidden mb-4" style="height:320px;">
            <img src="{{ $room->thumbnail_url }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $room->name }}">
        </div>

        <!-- Gallery -->
        @if($room->galleries->count())
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Gallery ({{ $room->galleries->count() }} images)</h6>
            <div class="row g-2">
                @foreach($room->galleries as $g)
                <div class="col-3">
                    <img src="{{ $g->image_url }}" class="img-fluid rounded-3 w-100"
                         style="height:80px;object-fit:cover;" alt="">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Description -->
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Description</h6>
            <p class="text-muted small" style="line-height:1.9;">{{ $room->description ?? 'No description provided.' }}</p>
        </div>

        <!-- Amenities -->
        @if($room->amenities->count())
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Amenities</h6>
            <div class="row g-2">
                @foreach($room->amenities as $amenity)
                <div class="col-6 col-md-4">
                    <div class="d-flex align-items-center gap-2 p-2 bg-light rounded-3 small">
                        <i class="bi {{ $amenity->icon ?? 'bi-check-circle' }} text-gold"></i>
                        {{ $amenity->name }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Room Details -->
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Room Details</h6>
            <div class="small">
                @foreach([
                    ['Room Number',  $room->room_number],
                    ['Room Type',    $room->roomType->name],
                    ['Floor',        'Floor '.$room->floor],
                    ['Capacity',     $room->capacity.' Guests'],
                    ['Beds',         $room->beds.' Bed(s)'],
                    ['Bathrooms',    $room->bathrooms.' Bathroom(s)'],
                    ['Size',         $room->size_sqm ? $room->size_sqm.' sq.m.' : 'N/A'],
                    ['View',         $room->view ?? 'N/A'],
                    ['Price/Night',  '₱'.number_format($room->price_per_night,2)],
                    ['Status',       ucfirst($room->status)],
                ] as [$label, $value])
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">{{ $label }}</span>
                    <span class="fw-semibold">{{ $value }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Features -->
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Features</h6>
            @foreach([
                ['has_wifi',           'bi-wifi',           'Free WiFi'],
                ['has_aircon',         'bi-wind',           'Air Conditioning'],
                ['has_tv',             'bi-tv',             'Flat-screen TV'],
                ['has_minibar',        'bi-cup-straw',      'Mini Bar'],
                ['breakfast_included', 'bi-egg-fried',      'Breakfast Included'],
                ['is_featured',        'bi-star-fill',      'Featured Room'],
            ] as [$field, $icon, $label])
            <div class="d-flex align-items-center gap-2 py-1 small">
                <i class="bi {{ $icon }} {{ $room->$field ? 'text-success' : 'text-muted' }}"></i>
                <span class="{{ $room->$field ? '' : 'text-muted' }}">{{ $label }}</span>
                @if($room->$field)
                    <i class="bi bi-check-circle-fill text-success ms-auto" style="font-size:.75rem;"></i>
                @else
                    <i class="bi bi-x-circle text-muted ms-auto" style="font-size:.75rem;"></i>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Booking Stats -->
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Booking Statistics</h6>
            @php
                $totalBookings   = $room->bookings()->count();
                $activeBookings  = $room->bookings()->whereIn('status',['confirmed','checked_in'])->count();
                $revenue         = $room->bookings()->whereIn('status',['confirmed','checked_in','checked_out','completed'])->sum('total_amount');
            @endphp
            <div class="d-flex justify-content-between py-2 border-bottom small">
                <span class="text-muted">Total Bookings</span>
                <span class="fw-bold">{{ $totalBookings }}</span>
            </div>
            <div class="d-flex justify-content-between py-2 border-bottom small">
                <span class="text-muted">Active Bookings</span>
                <span class="fw-bold text-success">{{ $activeBookings }}</span>
            </div>
            <div class="d-flex justify-content-between py-2 small">
                <span class="text-muted">Total Revenue</span>
                <span class="fw-bold text-gold">₱{{ number_format($revenue,2) }}</span>
            </div>
            <a href="{{ route('admin.bookings.index', ['room' => $room->id]) }}"
               class="btn btn-outline-secondary btn-sm w-100 mt-3">View Bookings</a>
        </div>
    </div>
</div>
@endsection
