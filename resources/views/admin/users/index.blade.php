@extends('layouts.admin')
@section('title','Users')
@section('breadcrumb')<li class="breadcrumb-item active">Users</li>@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">User Management</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-gold"><i class="bi bi-person-plus me-1"></i>Add User</a>
</div>

<div class="admin-card p-3 mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5"><input type="text" name="search" class="form-control form-control-sm" placeholder="Search name, email..." value="{{ request('search') }}"></div>
        <div class="col-md-2">
            <select name="role" class="form-select form-select-sm">
                <option value="">All Roles</option>
                @foreach(['admin','staff','customer'] as $r)
                <option value="{{ $r }}" {{ request('role')===$r?'selected':'' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-gold btn-sm flex-fill">Filter</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">Clear</a>
        </div>
    </form>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>User</th><th>Role</th><th>Phone</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $user->avatar_url }}" class="rounded-circle" width="38" height="38" style="object-fit:cover;">
                            <div>
                                <div class="small fw-semibold">{{ $user->name }}</div>
                                <div class="text-muted" style="font-size:.73rem;">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge {{ $user->role==='admin'?'bg-danger':($user->role==='staff'?'bg-info':'bg-secondary') }}">{{ ucfirst($user->role) }}</span></td>
                    <td class="small text-muted">{{ $user->phone ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                    </td>
                    <td class="small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="d-inline">@csrf
                                <button class="btn btn-sm {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="bi {{ $user->is_active ? 'bi-pause' : 'bi-play' }}"></i>
                                </button>
                            </form>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())<div class="p-3 border-top">{{ $users->links() }}</div>@endif
</div>
@endsection
