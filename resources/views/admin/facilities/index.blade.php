@extends('layouts.admin')
@section('title','Facilities')
@section('breadcrumb')<li class="breadcrumb-item active">Facilities</li>@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Facility Management</h4>
    <a href="{{ route('admin.facilities.create') }}" class="btn btn-gold"><i class="bi bi-plus-lg me-1"></i>Add Facility</a>
</div>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Facility</th><th>Icon</th><th>Hours</th><th>Featured</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($facilities as $f)
                <tr>
                    <td>
                        <div class="fw-semibold small">{{ $f->name }}</div>
                        <div class="text-muted" style="font-size:.72rem;">{{ Str::limit($f->description,60) }}</div>
                    </td>
                    <td><i class="bi {{ $f->icon ?? 'bi-building' }} text-gold fs-5"></i></td>
                    <td class="small text-muted">{{ $f->operating_hours ?? '—' }}</td>
                    <td>{!! $f->is_featured ? '<span class="badge" style="background:var(--gold);color:#fff;">Yes</span>' : '<span class="text-muted small">No</span>' !!}</td>
                    <td><span class="badge {{ $f->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $f->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.facilities.edit', $f) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.facilities.destroy', $f) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No facilities yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($facilities->hasPages())<div class="p-3 border-top">{{ $facilities->links() }}</div>@endif
</div>
@endsection
