@extends('layouts.admin')
@section('title','Edit Facility')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.facilities.index') }}">Facilities</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit: {{ $facility->name }}</h4>
    <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <form method="POST" action="{{ route('admin.facilities.update', $facility) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.facilities._form')
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-gold px-5">Update Facility</button>
                <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
