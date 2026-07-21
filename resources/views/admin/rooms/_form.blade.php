<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Basic Information</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Room Type <span class="text-danger">*</span></label>
                    <select name="room_type_id" class="form-select @error('room_type_id') is-invalid @enderror" required>
                        <option value="">Select Type</option>
                        @foreach($roomTypes as $t)
                        <option value="{{ $t->id }}" {{ old('room_type_id', $room->room_type_id ?? '') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                        @endforeach
                    </select>
                    @error('room_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Room Number <span class="text-danger">*</span></label>
                    <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror" value="{{ old('room_number', $room->room_number ?? '') }}" required>
                    @error('room_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Floor</label>
                    <input type="number" name="floor" class="form-control" value="{{ old('floor', $room->floor ?? 1) }}" min="1">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Room Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $room->name ?? '') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $room->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Room Specifications</h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Price/Night (₱) <span class="text-danger">*</span></label>
                    <input type="number" name="price_per_night" class="form-control @error('price_per_night') is-invalid @enderror" value="{{ old('price_per_night', $room->price_per_night ?? '') }}" step="0.01" min="0" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Capacity <span class="text-danger">*</span></label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $room->capacity ?? 2) }}" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Beds <span class="text-danger">*</span></label>
                    <input type="number" name="beds" class="form-control" value="{{ old('beds', $room->beds ?? 1) }}" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Bathrooms</label>
                    <input type="number" name="bathrooms" class="form-control" value="{{ old('bathrooms', $room->bathrooms ?? 1) }}" min="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Size (sq.m.)</label>
                    <input type="number" name="size_sqm" class="form-control" value="{{ old('size_sqm', $room->size_sqm ?? '') }}" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">View</label>
                    <select name="view" class="form-select">
                        <option value="">N/A</option>
                        @foreach(['Garden','Pool','City','Ocean','Mountain','Panoramic'] as $v)
                        <option value="{{ $v }}" {{ old('view', $room->view ?? '') === $v ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(['available','occupied','reserved','maintenance'] as $s)
                        <option value="{{ $s }}" {{ old('status', $room->status ?? 'available') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Features</h6>
            <div class="row g-2">
                @foreach([['has_wifi','WiFi'],['has_aircon','Air Conditioning'],['has_tv','Flat-screen TV'],['has_minibar','Mini Bar'],['breakfast_included','Breakfast Included'],['is_featured','Featured Room']] as [$field,$label])
                <div class="col-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="{{ $field }}" id="{{ $field }}" value="1"
                            {{ old($field, $room->{$field} ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="{{ $field }}">{{ $label }}</label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Amenities</h6>
            <div class="row g-2">
                @foreach($amenities as $amenity)
                <div class="col-md-4 col-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}"
                            {{ in_array($amenity->id, old('amenities', isset($room) ? $room->amenities->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="amenity_{{ $amenity->id }}">
                            <i class="bi {{ $amenity->icon }} text-gold me-1"></i>{{ $amenity->name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Thumbnail Image</h6>
            @if(isset($room) && $room->thumbnail)
            <img src="{{ $room->thumbnail_url }}" class="img-fluid rounded-3 mb-3" style="height:150px;width:100%;object-fit:cover;" id="thumbPreview" alt="">
            @else
            <div class="bg-light rounded-3 mb-3 d-flex align-items-center justify-content-center" style="height:150px;" id="thumbPreview">
                <i class="bi bi-image text-muted fs-2"></i>
            </div>
            @endif
            <input type="file" name="thumbnail" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this,'thumbPreview')">
        </div>

        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Gallery Images</h6>
            <input type="file" name="gallery_images[]" class="form-control form-control-sm" accept="image/*" multiple>
            <div class="form-text">Upload multiple images for the room gallery</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const el = document.getElementById(previewId);
            if (el.tagName === 'IMG') el.src = e.target.result;
            else { const img = document.createElement('img'); img.src = e.target.result; img.className = 'img-fluid rounded-3'; img.style = 'height:150px;width:100%;object-fit:cover;'; el.replaceWith(img); }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
