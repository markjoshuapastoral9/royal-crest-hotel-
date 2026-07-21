@extends('layouts.admin')
@section('title','Promotions')
@section('breadcrumb')<li class="breadcrumb-item active">Promotions</li>@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Promotions & Offers</h4>
    <a href="{{ route('admin.promotions.create') }}" class="btn btn-gold"><i class="bi bi-plus-lg me-1"></i>Add Promotion</a>
</div>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Title</th><th>Code</th><th>Discount</th><th>Min Nights</th><th>Valid Until</th><th>Used</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($promotions as $promo)
                <tr>
                    <td class="small fw-semibold">{{ $promo->title }}</td>
                    <td><code class="text-gold fw-bold" style="letter-spacing:1px;">{{ $promo->code }}</code></td>
                    <td class="small">
                        @if($promo->discount_type === 'percentage')
                            <span class="badge bg-success">{{ $promo->discount_value }}%</span>
                        @else
                            <span class="badge bg-info">₱{{ number_format($promo->discount_value,0) }}</span>
                        @endif
                    </td>
                    <td class="small">{{ $promo->minimum_nights }} night(s)</td>
                    <td class="small text-muted">{{ $promo->valid_until ? $promo->valid_until->format('M d, Y') : '—' }}</td>
                    <td class="small">{{ $promo->used_count }}{{ $promo->usage_limit ? ' / '.$promo->usage_limit : '' }}</td>
                    <td>
                        <span class="badge {{ $promo->isValid() ? 'bg-success' : 'bg-secondary' }}">
                            {{ $promo->isValid() ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.promotions.edit', $promo) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.promotions.destroy', $promo) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No promotions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($promotions->hasPages())<div class="p-3 border-top">{{ $promotions->links() }}</div>@endif
</div>
@endsection
