@extends('layouts.admin')
@section('title', 'Edit Room')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Rooms</a></li>
<li class="breadcrumb-item active">Edit {{ $room->name }}</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Room: {{ $room->name }}</h4>
    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>

<form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data">
@csrf @method('PUT')
@include('admin.rooms._form')

@if($room->galleries->count())
<div class="admin-card p-4 mt-4">
    <h6 class="fw-bold mb-3">Current Gallery Images</h6>
    <div class="row g-2">
        @foreach($room->galleries as $g)
        <div class="col-md-3 col-6 position-relative">
            <img src="{{ $g->image_url }}" class="img-fluid rounded-3" style="height:100px;width:100%;object-fit:cover;" alt="">
            <form method="POST" action="{{ route('admin.rooms.gallery.delete', $g) }}" class="position-absolute top-0 end-0 m-1">@csrf @method('DELETE')
                <button class="btn btn-danger btn-sm rounded-circle p-0" style="width:24px;height:24px;font-size:.7rem;" onclick="return confirm('Delete image?')"><i class="bi bi-x"></i></button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-gold px-5">Update Room</button>
    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
</form>
@endsection
