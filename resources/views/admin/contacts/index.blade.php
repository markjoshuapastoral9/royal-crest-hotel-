@extends('layouts.admin')
@section('title','Contact Messages')
@section('breadcrumb')<li class="breadcrumb-item active">Messages</li>@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Contact Messages</h4>
</div>
<div class="admin-card p-3 mb-4">
    <form method="GET" class="d-flex gap-2">
        <select name="status" class="form-select form-select-sm" style="max-width:160px;" onchange="this.form.submit()">
            <option value="">All Messages</option>
            <option value="unread" {{ request('status')==='unread'?'selected':'' }}>Unread</option>
            <option value="read" {{ request('status')==='read'?'selected':'' }}>Read</option>
        </select>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
    </form>
</div>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>From</th><th>Subject</th><th>Received</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr class="{{ !$contact->is_read ? 'fw-semibold' : '' }}">
                    <td>
                        <div class="small {{ !$contact->is_read ? 'fw-bold' : '' }}">{{ $contact->name }}</div>
                        <div class="text-muted" style="font-size:.72rem;">{{ $contact->email }}</div>
                    </td>
                    <td class="small">{{ Str::limit($contact->subject,50) }}</td>
                    <td class="small text-muted">{{ $contact->created_at->format('M d, Y') }}</td>
                    <td>
                        @if(!$contact->is_read)
                            <span class="badge bg-warning text-dark">New</span>
                        @elseif($contact->reply)
                            <span class="badge bg-success">Replied</span>
                        @else
                            <span class="badge bg-secondary">Read</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No messages found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($contacts->hasPages())<div class="p-3 border-top">{{ $contacts->links() }}</div>@endif
</div>
@endsection
