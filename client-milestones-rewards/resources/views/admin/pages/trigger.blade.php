@extends('admin.layouts.app')

@section('title', 'Manual Trigger')

@section('content')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Manual Trigger</h1>
      <span class="text-muted fs-12">Generate a reward link for testing.</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item active" aria-current="page">Manual Trigger</li>
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

  @if(session('mail_error'))
  <div class="alert alert-warning">
    <strong>Email error:</strong> {{ session('mail_error') }}
  </div>
@endif


  <div class="card custom-card">
    <div class="card-body">
      <form method="POST" action="{{ url('/admin/manual-trigger') }}" class="row g-3">
        @csrf

        {{-- Existing Client --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Choose Existing Client (optional)</label>
          <select class="form-select" name="client_email">
            <option value="">Select a client…</option>
            @foreach($clients as $c)
              <option value="{{ $c->client_email }}" @selected(old('client_email') === $c->client_email)>
                {{ $c->client_name ?: 'Client' }} — {{ $c->client_email }}
              </option>
            @endforeach
          </select>
          <div class="text-muted fs-12 mt-1">
            Pick an existing client OR add a new one below.
          </div>
        </div>

        {{-- Milestone --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Milestone</label>
          <select class="form-select" name="milestone_id" required>
            <option value="">Select milestone…</option>
            @foreach($milestones as $m)
              <option value="{{ $m->id }}" @selected(old('milestone_id') == $m->id)>
                {{ $m->name }} ({{ $m->type }})
              </option>
            @endforeach
          </select>
        </div>

        {{-- Divider --}}
        <div class="col-12">
          <hr class="my-1">
        </div>

        {{-- New Client (saves into DB via reward_access row creation) --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">New Client Name (optional)</label>
          <input
            class="form-control"
            name="new_client_name"
            value="{{ old('new_client_name') }}"
            placeholder="e.g., Joe Smith"
          >
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">New Client Email (optional)</label>
          <input
            class="form-control"
            name="new_client_email"
            value="{{ old('new_client_email') }}"
            placeholder="e.g., joe@client.com"
          >
          <div class="text-muted fs-12 mt-1">
            If you fill this, it will create a new client entry (stored in reward_accesses) + generate a link.
          </div>
        </div>

        <div class="col-12 d-flex gap-2">
          <button type="submit" class="btn btn-primary">Generate Link</button>
          <a href="{{ url('/admin/dashboard') }}" class="btn">Back</a>
        </div>
      </form>

      @if(session('link'))
        <hr class="my-3">

        <div class="fw-semibold mb-2">Generated Link</div>
        <div class="d-flex flex-wrap gap-2 align-items-center">
          <input class="form-control" value="{{ session('link') }}" readonly style="max-width: 720px;">
          <button class="btn btn-light" type="button"
                  onclick="navigator.clipboard.writeText(@js(session('link')))">
            Copy
          </button>
          <a class="btn btn-outline-primary" href="{{ session('link') }}" target="_blank">Open</a>
        </div>

        <div class="text-muted fs-12 mt-2">
          Token: <span class="fw-semibold">{{ session('token') }}</span>
          — expires in 7 days — one-time claim enforced.
        </div>
      @endif
    </div>
  </div>
@endsection
