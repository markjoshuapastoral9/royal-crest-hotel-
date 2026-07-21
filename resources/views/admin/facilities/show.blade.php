@extends('layouts.admin')
@section('title', $facility->name)
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.facilities.index') }}">Facilities</a></li>
<li class="breadcrumb-item active">{{ $facility->name }}</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">{{ $facility->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.facilities.edit', $facility) }}" class="btn btn-gold btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>
</div>
<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card overflow-hidden mb-4">
            @if($facility->image)
            <img src="{{ $facility->image_url }}" class="w-100" style="height:280px;object-fit:cover;" alt="{{ $facility->name }}">
            @endif
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:linear-gradient(135deg,var(--gold),var(--gold-dark));color:#fff;font-size:1.4rem;">
                        <i class="bi {{ $facility->icon ?? 'bi-building' }}"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">{{ $facility->name }}</h5>
                        @if($facility->operating_hours)
                        <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $facility->operating_hours }}</small>
                        @endif
                    </div>
                    <div class="ms-auto">
                        <span class="badge {{ $facility->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $facility->is_active ? 'Active' : 'Inactive' }}</span>
                        @if($facility->is_featured)<span class="badge bg-warning text-dark ms-1">Featured</span>@endif
                    </div>
                </div>
                <p class="text-muted" style="line-height:1.8;">{{ $facility->description }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
