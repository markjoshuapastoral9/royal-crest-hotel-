@extends('layouts.admin')
@section('title','Room Types')
@section('breadcrumb')<li class="breadcrumb-item active">Room Types</li>@endsection

@section('content')
<div class="row g-4">
    <!-- Add Form -->
    <div class="col-lg-4">
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Add Room Type</h6>
            <form method="POST" action="{{ route('admin.room-types.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Name *</label>
                <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="e.g. Deluxe Room" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Description</label>
                <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="Brief description">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Icon Class</label>
                <input type="text" name="icon" class="form-control form-control-sm" placeholder="bi-door-open" value="{{ old('icon') }}">
            </div>
            <button type="submit" class="btn btn-gold btn-sm w-100">Add Room Type</button>
            </form>
        </div>
    </div>

    <!-- List -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="p-4 border-bottom"><h6 class="fw-bold mb-0">All Room Types</h6></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Name</th><th>Slug</th><th>Rooms</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($roomTypes as $type)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi {{ $type->icon ?? 'bi-door-open' }} text-gold fs-5"></i>
                                    <span class="fw-semibold small">{{ $type->name }}</span>
                                </div>
                            </td>
                            <td><code class="small">{{ $type->slug }}</code></td>
                            <td><span class="badge" style="background:var(--admin-surface-2);color:#E6E2DA;border:1px solid var(--admin-border);">{{ $type->rooms_count }}</span></td>
                            <td><span class="badge {{ $type->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $type->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editTypeModal{{ $type->id }}"><i class="bi bi-pencil"></i></button>
                                    <form method="POST" action="{{ route('admin.room-types.destroy', $type) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" {{ $type->rooms_count > 0 ? 'disabled title=Has rooms' : '' }}><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editTypeModal{{ $type->id }}" tabindex="-1">
                            <div class="modal-dialog modal-sm"><div class="modal-content">
                                <div class="modal-header py-2"><h6 class="modal-title fw-bold">Edit Type</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                <form method="POST" action="{{ route('admin.room-types.update', $type) }}">@csrf @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-2"><label class="form-label small">Name</label><input type="text" name="name" class="form-control form-control-sm" value="{{ $type->name }}" required></div>
                                    <div class="mb-2"><label class="form-label small">Description</label><textarea name="description" class="form-control form-control-sm" rows="2">{{ $type->description }}</textarea></div>
                                    <div class="mb-2"><label class="form-label small">Icon</label><input type="text" name="icon" class="form-control form-control-sm" value="{{ $type->icon }}"></div>
                                    <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $type->is_active ? 'checked' : '' }}><label class="form-check-label small">Active</label></div>
                                </div>
                                <div class="modal-footer py-2"><button type="submit" class="btn btn-gold btn-sm w-100">Save Changes</button></div>
                                </form>
                            </div></div>
                        </div>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No room types yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
