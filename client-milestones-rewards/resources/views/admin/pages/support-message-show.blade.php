@extends('admin.layouts.app')

@section('title', 'Support Message')

@section('content')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Support Message</h1>
      <span class="text-muted fs-12">Review and reply to the client.</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/admin/support-messages') }}">Support Messages</a></li>
      <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row">
    <div class="col-xl-5">
      <div class="card custom-card">
        <div class="card-header">
          <div class="card-title">Client Message</div>
        </div>
        <div class="card-body">
          <p><strong>Name:</strong> {{ $supportMessage->name }}</p>
          <p><strong>Email:</strong> {{ $supportMessage->email }}</p>
          <p><strong>Subject:</strong> {{ $supportMessage->subject }}</p>
          <p><strong>Message:</strong></p>
          <div class="p-3 border rounded">{{ $supportMessage->message }}</div>

          @if($supportMessage->reward_token)
            <div class="mt-3 text-muted fs-12">
              Related reward token: <strong>{{ $supportMessage->reward_token }}</strong>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-xl-7">
      <div class="card custom-card">
        <div class="card-header">
          <div class="card-title">Admin Actions</div>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ url('/admin/support-messages/'.$supportMessage->id) }}" class="row g-3">
            @csrf

            <div class="col-md-6">
              <label class="form-label fw-semibold">Status</label>
              <select name="status" class="form-select" required>
                @foreach(['new', 'open', 'replied', 'closed'] as $status)
                  <option value="{{ $status }}" @selected(old('status', $supportMessage->status) === $status)>
                    {{ ucfirst($status) }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Internal Note</label>
              <textarea name="admin_note" class="form-control" rows="4">{{ old('admin_note', $supportMessage->admin_note) }}</textarea>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Reply to Client</label>
              <textarea name="admin_reply" class="form-control" rows="6">{{ old('admin_reply', $supportMessage->admin_reply) }}</textarea>
            </div>

            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="send_reply" name="send_reply">
                <label class="form-check-label" for="send_reply">
                  Send this reply by email to the client
                </label>
              </div>
            </div>

            <div class="col-12 d-flex gap-2">
              <button type="submit" class="btn btn-primary">Save Changes</button>
              <a href="{{ url('/admin/support-messages') }}" class="btn btn-light">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection