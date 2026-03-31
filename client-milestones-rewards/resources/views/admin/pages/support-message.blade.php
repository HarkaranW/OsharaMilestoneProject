@extends('admin.layouts.app')

@section('title', 'Support Messages')

@section('content')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Support Messages</h1>
      <span class="text-muted fs-12">Messages sent by clients from the contact support page.</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item active" aria-current="page">Support Messages</li>
    </ol>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card custom-card">
    <div class="card-header">
      <div class="card-title">Client Support Requests</div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table text-nowrap mb-0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Subject</th>
              <th>Status</th>
              <th>Date</th>
              <th class="text-end">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($messages as $m)
              <tr>
                <td>{{ $m->name }}</td>
                <td>{{ $m->email }}</td>
                <td>{{ $m->subject }}</td>
                <td>
                  <span class="badge
                    {{ $m->status === 'new' ? 'bg-danger-transparent' : '' }}
                    {{ $m->status === 'open' ? 'bg-warning-transparent' : '' }}
                    {{ $m->status === 'replied' ? 'bg-success-transparent' : '' }}
                    {{ $m->status === 'closed' ? 'bg-secondary-transparent' : '' }}">
                    {{ ucfirst($m->status) }}
                  </span>
                </td>
                <td class="text-muted">{{ $m->created_at?->format('Y-m-d H:i') }}</td>
                <td class="text-end">
                  <a href="{{ url('/admin/support-messages/'.$m->id) }}" class="btn btn-sm btn-primary">Open</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-muted">No support messages yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $messages->links() }}
      </div>
    </div>
  </div>
@endsection