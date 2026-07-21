@extends('layouts.admin')
@section('title','Amenities')
@section('breadcrumb')<li class="breadcrumb-item active">Amenities</li>@endsection

@section('content')
<div class="row g-4">
    <!-- Add Form -->
    <div class="col-lg-4">
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Add Amenity</h6>
            <form method="POST" action="{{ route('admin.amenities.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Name *</label>
                <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="e.g. Free WiFi" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Icon Class</label>
                <input type="text" name="icon" class="form-control form-control-sm" placeholder="bi-wifi" value="{{ old('icon') }}">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Category *</label>
                <select name="category" class="form-select form-select-sm">
                    <option value="room" {{ old('category') === 'room' ? 'selected' : '' }}>Room</option>
                    <option value="hotel" {{ old('category') === 'hotel' ? 'selected' : '' }}>Hotel</option>
                </select>
            </div>
            <button type="submit" class="btn btn-gold btn-sm w-100">Add Amenity</button>
            </form>
        </div>
    </div>

    <!-- List -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="p-4 border-bottom"><h6 class="fw-bold mb-0">All Amenities</h6></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Name</th><th>Icon</th><th>Category</th><th>Rooms</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($amenities as $amenity)
                        <tr>
                            <td class="small fw-semibold">{{ $amenity->name }}</td>
                            <td><i class="bi {{ $amenity->icon ?? 'bi-check' }} text-gold fs-5"></i></td>
                            <td><span class="badge {{ $amenity->category === 'room' ? 'bg-primary' : 'bg-secondary' }}">{{ ucfirst($amenity->category) }}</span></td>
                            <td><span class="badge" style="background:var(--admin-surface-2);color:#E6E2DA;border:1px solid var(--admin-border);">{{ $amenity->rooms_count }}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editAmenityModal{{ $amenity->id }}"><i class="bi bi-pencil"></i></button>
                                    <form method="POST" action="{{ route('admin.amenities.destroy', $amenity) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editAmenityModal{{ $amenity->id }}" tabindex="-1">
                            <div class="modal-dialog modal-sm"><div class="modal-content">
                                <div class="modal-header py-2"><h6 class="modal-title fw-bold">Edit Amenity</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                <form method="POST" action="{{ route('admin.amenities.update', $amenity) }}">@csrf @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-2"><label class="form-label small">Name</label><input type="text" name="name" class="form-control form-control-sm" value="{{ $amenity->name }}" required></div>
                                    <div class="mb-2"><label class="form-label small">Icon</label><input type="text" name="icon" class="form-control form-control-sm" value="{{ $amenity->icon }}"></div>
                                    <div class="mb-2"><label class="form-label small">Category</label>
                                        <select name="category" class="form-select form-select-sm">
                                            <option value="room" {{ $amenity->category === 'room' ? 'selected' : '' }}>Room</option>
                                            <option value="hotel" {{ $amenity->category === 'hotel' ? 'selected' : '' }}>Hotel</option>
                                        </select>
                                    </div>
                                    <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $amenity->is_active ? 'checked' : '' }}><label class="form-check-label small">Active</label></div>
                                </div>
                                <div class="modal-footer py-2"><button type="submit" class="btn btn-gold btn-sm w-100">Save Changes</button></div>
                                </form>
                            </div></div>
                        </div>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No amenities yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
