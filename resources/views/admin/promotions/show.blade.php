@extends('layouts.admin')
@section('title', $promotion->title)
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}">Promotions</a></li>
<li class="breadcrumb-item active">{{ $promotion->title }}</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">{{ $promotion->title }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.promotions.edit', $promotion) }}" class="btn btn-gold btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>
</div>
<div class="row g-4 justify-content-center">
    <div class="col-lg-7">
        <div class="admin-card p-4">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <code class="text-gold fw-bold fs-5" style="letter-spacing:2px;">{{ $promotion->code }}</code>
                    <div class="mt-1">
                        <span class="badge {{ $promotion->isValid() ? 'bg-success' : 'bg-secondary' }}">
                            {{ $promotion->isValid() ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="badge {{ $promotion->discount_type === 'percentage' ? 'bg-primary' : 'bg-info' }} ms-1">
                            {{ $promotion->discount_type === 'percentage' ? $promotion->discount_value.'% OFF' : '₱'.number_format($promotion->discount_value,0).' OFF' }}
                        </span>
                    </div>
                </div>
                @if($promotion->image)
                <img src="{{ asset('storage/'.$promotion->image) }}" class="rounded-3" style="height:60px;object-fit:cover;" alt="">
                @endif
            </div>
            <p class="text-muted small mb-4" style="line-height:1.8;">{{ $promotion->description }}</p>
            <div class="row g-2 small">
                <div class="col-6"><span class="text-muted">Min. Nights:</span> <strong>{{ $promotion->minimum_nights }}</strong></div>
                <div class="col-6"><span class="text-muted">Used:</span> <strong>{{ $promotion->used_count }}{{ $promotion->usage_limit ? ' / '.$promotion->usage_limit : '' }}</strong></div>
                <div class="col-6"><span class="text-muted">Valid From:</span> <strong>{{ $promotion->valid_from ? $promotion->valid_from->format('M d, Y') : 'Any' }}</strong></div>
                <div class="col-6"><span class="text-muted">Valid Until:</span> <strong>{{ $promotion->valid_until ? $promotion->valid_until->format('M d, Y') : 'No expiry' }}</strong></div>
            </div>
        </div>
    </div>
</div>
@endsection
