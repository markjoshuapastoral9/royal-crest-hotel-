@extends('layouts.admin')
@section('title','Message from ' . $contact->name)
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Messages</a></li>
<li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Message from {{ $contact->name }}</h4>
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
</div>
<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card p-4 mb-4">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <h5 class="fw-bold mb-1">{{ $contact->subject }}</h5>
                    <div class="text-muted small">
                        <i class="bi bi-person me-1"></i>{{ $contact->name }}
                        &nbsp;·&nbsp;<i class="bi bi-envelope me-1"></i>{{ $contact->email }}
                        @if($contact->phone)&nbsp;·&nbsp;<i class="bi bi-telephone me-1"></i>{{ $contact->phone }}@endif
                    </div>
                </div>
                <span class="text-muted small">{{ $contact->created_at->format('M d, Y h:i A') }}</span>
            </div>
            <div class="bg-light rounded-3 p-4">
                <p class="mb-0" style="line-height:1.8;white-space:pre-wrap;">{{ $contact->message }}</p>
            </div>
        </div>

        <!-- Reply Form -->
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">{{ $contact->reply ? 'Edit Reply' : 'Send Reply' }}</h6>
            @if($contact->reply)
            <div class="alert alert-success small mb-3">
                <strong>Replied on {{ $contact->replied_at?->format('M d, Y') }}:</strong><br>
                {{ $contact->reply }}
            </div>
            @endif
            <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}">
            @csrf
            <textarea name="reply" class="form-control mb-3" rows="5"
                      placeholder="Type your reply...">{{ old('reply', $contact->reply) }}</textarea>
            <button type="submit" class="btn btn-gold"><i class="bi bi-reply me-1"></i>{{ $contact->reply ? 'Update Reply' : 'Send Reply' }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
