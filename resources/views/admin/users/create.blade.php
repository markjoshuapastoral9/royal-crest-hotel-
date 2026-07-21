@extends('layouts.admin')
@section('title','Add User')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
<li class="breadcrumb-item active">Add User</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Add New User</h4>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-card p-4">
            <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Full Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Email *</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Password *</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Role *</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="customer" {{ old('role','customer')==='customer'?'selected':'' }}>Customer</option>
                        <option value="staff" {{ old('role')==='staff'?'selected':'' }}>Staff</option>
                        <option value="admin" {{ old('role')==='admin'?'selected':'' }}>Admin</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-gold px-5">Create User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
