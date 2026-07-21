@extends('layouts.admin')
@section('title', 'Add Room')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Rooms</a></li>
<li class="breadcrumb-item active">Add Room</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Add New Room</h4>
    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>

<form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
@csrf
@include('admin.rooms._form')
<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-gold px-5">Create Room</button>
    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
</form>
@endsection
