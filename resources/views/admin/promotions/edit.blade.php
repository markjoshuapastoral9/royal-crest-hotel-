@extends('layouts.admin')
@section('title','Edit Promotion')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}">Promotions</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit: {{ $promotion->title }}</h4>
    <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>
<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card p-4">
    <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.promotions._form')
    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-gold px-5">Update Promotion</button>
        <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
    </form>
</div>
</div></div>
@endsection
