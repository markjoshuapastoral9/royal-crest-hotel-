@extends('layouts.admin')
@section('title','Gallery')
@section('breadcrumb')<li class="breadcrumb-item active">Gallery</li>@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Gallery Management</h4>
</div>

<!-- Upload Form -->
<div class="admin-card p-4 mb-4">
    <h6 class="fw-bold mb-3">Upload Images</h6>
    <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Category</label>
            <select name="category" class="form-select form-select-sm" required>
                @foreach(['hotel','rooms','facilities','restaurant','pool','events'] as $cat)
                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Title (optional)</label>
            <input type="text" name="title" class="form-control form-control-sm" placeholder="Image title">
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Images</label>
            <input type="file" name="images[]" class="form-control form-control-sm" accept="image/*" multiple required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-gold btn-sm"><i class="bi bi-cloud-upload me-1"></i>Upload Images</button>
        </div>
    </div>
    </form>
</div>

<!-- Filter -->
<div class="admin-card p-3 mb-4">
    <form method="GET" class="d-flex gap-2 align-items-center">
        <select name="category" class="form-select form-select-sm" style="max-width:200px;" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach(['hotel','rooms','facilities','restaurant','pool','events'] as $cat)
            <option value="{{ $cat }}" {{ request('category')===$cat?'selected':'' }}>{{ ucfirst($cat) }}</option>
            @endforeach
        </select>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
    </form>
</div>

<!-- Gallery Grid -->
<div class="admin-card p-4">
    <div class="row g-3">
        @forelse($galleries as $img)
        <div class="col-lg-2 col-md-3 col-4">
            <div class="position-relative group">
                <img src="{{ $img->image_url }}" class="img-fluid rounded-3 w-100" style="height:120px;object-fit:cover;" alt="{{ $img->title }}">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center gap-1 rounded-3" style="background:rgba(0,0,0,.5);opacity:0;transition:.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
                    <form method="POST" action="{{ route('admin.gallery.featured', $img) }}" class="d-inline">@csrf
                        <button class="btn btn-sm {{ $img->is_featured ? 'btn-warning' : 'btn-outline-light' }}" title="Toggle Featured" style="padding:3px 7px;font-size:.75rem;"><i class="bi bi-star-fill"></i></button>
                    </form>
                    <form method="POST" action="{{ route('admin.gallery.destroy', $img) }}" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" style="padding:3px 7px;font-size:.75rem;"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
                @if($img->is_featured)
                <div class="position-absolute top-0 start-0 m-1"><span class="badge bg-warning text-dark" style="font-size:.6rem;">⭐</span></div>
                @endif
                <div class="position-absolute bottom-0 start-0 w-100 p-1" style="background:rgba(0,0,0,.6);border-radius:0 0 8px 8px;">
                    <span class="badge bg-secondary" style="font-size:.65rem;">{{ $img->category }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-4">No images uploaded yet.</div>
        @endforelse
    </div>
    @if($galleries->hasPages())<div class="mt-3">{{ $galleries->links() }}</div>@endif
</div>
@endsection
