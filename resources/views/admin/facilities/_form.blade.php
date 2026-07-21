<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label small fw-semibold">Facility Name *</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $facility->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Icon Class</label>
        <input type="text" name="icon" class="form-control" placeholder="bi-water"
               value="{{ old('icon', $facility->icon ?? '') }}">
        <div class="form-text">Bootstrap Icons class e.g. <code>bi-water</code></div>
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $facility->description ?? '') }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Operating Hours</label>
        <input type="text" name="operating_hours" class="form-control" placeholder="6:00 AM – 10:00 PM"
               value="{{ old('operating_hours', $facility->operating_hours ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0"
               value="{{ old('sort_order', $facility->sort_order ?? 0) }}">
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold d-block">Options</label>
        <div class="form-check form-switch mb-1">
            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                   {{ old('is_featured', $facility->is_featured ?? false) ? 'checked' : '' }}>
            <label class="form-check-label small" for="is_featured">Featured</label>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $facility->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label small" for="is_active">Active</label>
        </div>
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Facility Image</label>
        @if(isset($facility) && $facility->image)
            <div class="mb-2"><img src="{{ $facility->image_url }}" class="rounded-3" style="height:100px;object-fit:cover;" alt=""></div>
        @endif
        <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
    </div>
</div>
