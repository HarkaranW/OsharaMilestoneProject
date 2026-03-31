@extends('admin.layouts.app')

@section('title', 'Profile')

@section('content')
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Profile</h1>
      <span class="text-muted fs-12">View and update your account.</span>
    </div>
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

  <div class="card custom-card">
    <div class="card-body">
      <form method="POST" action="{{ url('/admin/profile') }}" class="row g-3">
        @csrf

        <div class="col-md-6">
          <label class="form-label fw-semibold">Name</label>
          <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Email</label>
          <input class="form-control" name="email" type="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">New Password (optional)</label>
          <input class="form-control" name="password" type="password" placeholder="Leave blank to keep current">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Confirm New Password</label>
          <input class="form-control" name="password_confirmation" type="password">
        </div>

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary" type="submit">Save Changes</button>
          <a class="btn btn-light" href="{{ url('/admin/dashboard') }}">Back</a>
        </div>
      </form>
    </div>
  </div>
@endsection