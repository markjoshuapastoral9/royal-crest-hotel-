@extends('layouts.app')
@section('title', $room->translated_name)

@section('content')
@push('styles')
<style>
@media (max-width: 991px) {
    .col-lg-8 .rounded-4 { height: 260px !important; }
    .col-lg-4 .sticky-top { position: static !important; margin-top: 1.5rem; }
    section[style] { padding: 30px 0 !important; }
}
@media (max-width: 576px) {
    .col-lg-8 .rounded-4 { height: 210px !important; }
    .gallery-thumb { height: 60px !important; width: 88px !important; }
    .d-flex.gap-4.align-items-start { flex-wrap: wrap; }
}
</style>
@endpush
<div class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-gold">{{ __('site.rs_home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}" class="text-gold">{{ __('site.rs_rooms') }}</a></li>
                <li class="breadcrumb-item active text-white-50">{{ $room->translated_name }}</li>
            </ol>
        </nav>
        <h1 class="text-white mt-2">{{ $room->translated_name }}</h1>
        <span class="badge bg-gold px-3 py-2">{{ $room->roomType->name }}</span>
    </div>
</div>

<section style="padding:60px 0; background:var(--bg-dark,#101111);">
    <div class="container">
        <div class="row g-5">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Main Image -->
                <div class="rounded-4 overflow-hidden shadow mb-4" style="height:420px;">
                    <img src="{{ $room->thumbnail_url }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $room->translated_name }}" id="mainRoomImg">
                </div>
                <!-- Gallery Thumbnails -->
                @if($room->galleries->count())
                <div class="d-flex gap-2 mb-4 flex-wrap">
                    <img src="{{ $room->thumbnail_url }}" class="rounded-3 gallery-thumb active" style="height:80px;width:120px;object-fit:cover;cursor:pointer;border:3px solid var(--gold);" onclick="setMainImg(this.src)">
                    @foreach($room->galleries as $g)
                    <img src="{{ $g->image_url }}" class="rounded-3 gallery-thumb" style="height:80px;width:120px;object-fit:cover;cursor:pointer;border:3px solid transparent;" onclick="setMainImg(this.src)">
                    @endforeach
                </div>
                @endif

                <!-- Description -->
                <div class="rounded-4 p-4 shadow-sm mb-4" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
                    <h4 class="fw-bold mb-3 text-white">{{ __('site.rs_about_room') }}</h4>
                    <p class="text-muted" style="line-height:1.9;">{{ $room->translated_description }}</p>
                </div>

                <!-- Room Details -->
                <div class="rounded-4 p-4 shadow-sm mb-4" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
                    <h4 class="fw-bold mb-4 text-white">{{ __('site.rs_room_details') }}</h4>
                    <div class="row g-3">
                        <div class="col-6 col-md-3 text-center">
                            <div class="text-gold fs-4 mb-1"><i class="bi bi-people-fill"></i></div>
                            <div class="fw-semibold">{{ $room->capacity }}</div>
                            <div class="text-muted small">{{ __('site.rs_max_guests') }}</div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="text-gold fs-4 mb-1"><i class="bi bi-moon-fill"></i></div>
                            <div class="fw-semibold">{{ $room->beds }}</div>
                            <div class="text-muted small">{{ $room->beds > 1 ? __('site.rs_beds') : __('site.rooms_bed') }}</div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="text-gold fs-4 mb-1"><i class="bi bi-droplet-fill"></i></div>
                            <div class="fw-semibold">{{ $room->bathrooms }}</div>
                            <div class="text-muted small">{{ $room->bathrooms > 1 ? __('site.rs_bathrooms') : __('site.rs_bathroom') }}</div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="text-gold fs-4 mb-1"><i class="bi bi-aspect-ratio-fill"></i></div>
                            <div class="fw-semibold">{{ $room->size_sqm ?? 'N/A' }}</div>
                            <div class="text-muted small">sq.m.</div>
                        </div>
                    </div>
                </div>

                <!-- Amenities -->
                @if($room->amenities->count())
                <div class="rounded-4 p-4 shadow-sm" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
                    <h4 class="fw-bold mb-4 text-white">{{ __('site.rs_amenities') }}</h4>
                    <div class="row g-2">
                        @foreach($room->amenities as $amenity)
                        <div class="col-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-3 border" style="font-size:.88rem;">
                                <i class="bi {{ $amenity->icon ?? 'bi-check-circle' }} text-gold"></i>
                                {{ $amenity->name }}
                            </div>
                        </div>
                        @endforeach
                        @if($room->has_wifi)<div class="col-6 col-md-4"><div class="d-flex align-items-center gap-2 p-2 rounded-3 border" style="font-size:.88rem;"><i class="bi bi-wifi text-gold"></i>{{ __('site.rs_free_wifi') }}</div></div>@endif
                        @if($room->has_aircon)<div class="col-6 col-md-4"><div class="d-flex align-items-center gap-2 p-2 rounded-3 border" style="font-size:.88rem;"><i class="bi bi-wind text-gold"></i>{{ __('site.rs_aircon') }}</div></div>@endif
                        @if($room->has_tv)<div class="col-6 col-md-4"><div class="d-flex align-items-center gap-2 p-2 rounded-3 border" style="font-size:.88rem;"><i class="bi bi-tv text-gold"></i>{{ __('site.rs_tv') }}</div></div>@endif
                        @if($room->has_minibar)<div class="col-6 col-md-4"><div class="d-flex align-items-center gap-2 p-2 rounded-3 border" style="font-size:.88rem;"><i class="bi bi-cup-straw text-gold"></i>{{ __('site.rs_minibar') }}</div></div>@endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Booking Panel -->
            <div class="col-lg-4">
                <div class="rounded-4 p-4 shadow sticky-top" style="top:90px;background:var(--surface,#1a1214);border:1px solid var(--border);">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div style="font-family:'Playfair Display',serif;font-size:1.8rem;color:var(--gold);font-weight:700;">{{ $room->formatted_price }}</div>
                            <div class="text-muted small">{{ __('site.rs_per_night') }}</div>
                        </div>
                        <span class="badge {{ $room->status === 'available' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                            {{ ucfirst($room->status) }}
                        </span>
                    </div>

                    @if($room->status === 'available')
                    <form action="{{ route('booking.create', $room) }}" method="GET" id="bookForm">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ __('site.ri_check_in') }}</label>
                            <input type="date" name="check_in" id="checkIn" class="form-control" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ __('site.ri_check_out') }}</label>
                            <input type="date" name="check_out" id="checkOut" class="form-control" min="{{ date('Y-m-d', strtotime('+2 days')) }}" value="{{ date('Y-m-d', strtotime('+2 days')) }}" required>
                        </div>
                        <div id="priceBreakdown" class="rounded-3 p-3 mb-3 small" style="background:rgba(255,255,255,.04);border:1px solid var(--border);">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">{{ __('site.rs_rate_per_night') }}</span>
                                <span>₱{{ number_format($room->price_per_night, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted" id="nightsLabel">1 {{ __('site.rs_night') }}</span>
                                <span id="subtotalVal">₱{{ number_format($room->price_per_night, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">{{ __('site.rs_vat') }}</span>
                                <span id="taxVal">₱{{ number_format($room->price_per_night * 0.12, 2) }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>{{ __('site.rs_total') }}</span>
                                <span class="text-gold" id="totalVal">₱{{ number_format($room->price_per_night * 1.12, 2) }}</span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-gold w-100 py-3 fw-semibold rounded-3">
                            <i class="bi bi-calendar-check me-2"></i>{{ __('site.rs_book_room') }}
                        </button>
                    </form>
                    @else
                    <div class="alert alert-warning small"><i class="bi bi-exclamation-triangle me-2"></i>{{ __('site.rs_unavailable') }}</div>
                    <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary w-100">{{ __('site.rs_browse_other') }}</a>
                    @endif

                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex align-items-center gap-2 small text-muted mb-2"><i class="bi bi-shield-check text-success"></i>{{ __('site.rs_free_cancel') }}</div>
                        <div class="d-flex align-items-center gap-2 small text-muted mb-2"><i class="bi bi-clock text-gold"></i>{{ __('site.rs_checkin_time') }}</div>
                        <div class="d-flex align-items-center gap-2 small text-muted"><i class="bi bi-telephone text-gold"></i>{{ __('site.rs_need_help') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Rooms -->
        @if($relatedRooms->count())
        <div class="mt-5">
            <h4 class="fw-bold mb-4">{{ __('site.rs_similar_rooms') }}</h4>
            <div class="row g-4">
                @foreach($relatedRooms as $r)
                <div class="col-md-4">
                    <div class="room-card card">
                        <img src="{{ $r->thumbnail_url }}" class="card-img-top" style="height:180px;object-fit:cover;" alt="{{ $r->translated_name }}">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-1">{{ $r->translated_name }}</h6>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="price" style="font-size:1rem;">{{ $r->formatted_price }}</span>
                                <a href="{{ route('rooms.show', $r) }}" class="btn btn-gold btn-sm">{{ __('site.rs_view') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    const pricePerNight = {{ $room->price_per_night }};
    const nightLabel    = @json(__('site.rs_night'));
    const nightsLabel   = @json(__('site.rs_nights'));

    function setMainImg(src) {
        document.getElementById('mainRoomImg').src = src;
        document.querySelectorAll('.gallery-thumb').forEach(t => t.style.borderColor = 'transparent');
        event.target.style.borderColor = 'var(--gold)';
    }

    function updatePrice() {
        const ci = document.getElementById('checkIn')?.value;
        const co = document.getElementById('checkOut')?.value;
        if (!ci || !co) return;
        const nights = Math.max(1, Math.round((new Date(co) - new Date(ci)) / 86400000));
        const sub = nights * pricePerNight;
        const tax = sub * 0.12;
        document.getElementById('nightsLabel').textContent = nights + ' ' + (nights > 1 ? nightsLabel : nightLabel);
        document.getElementById('subtotalVal').textContent = '₱' + sub.toLocaleString('en-PH', {minimumFractionDigits:2});
        document.getElementById('taxVal').textContent = '₱' + tax.toLocaleString('en-PH', {minimumFractionDigits:2});
        document.getElementById('totalVal').textContent = '₱' + (sub + tax).toLocaleString('en-PH', {minimumFractionDigits:2});
    }

    document.getElementById('checkIn')?.addEventListener('change', function() {
        const co = document.getElementById('checkOut');
        if (co.value <= this.value) {
            const next = new Date(this.value);
            next.setDate(next.getDate() + 1);
            co.value = next.toISOString().split('T')[0];
        }
        co.min = new Date(new Date(this.value).getTime() + 86400000).toISOString().split('T')[0];
        updatePrice();
    });
    document.getElementById('checkOut')?.addEventListener('change', updatePrice);
    updatePrice();
</script>
@endpush
