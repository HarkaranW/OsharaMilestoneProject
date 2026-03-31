@extends('admin.layouts.app')

@section('title', 'Rewards')

@section('page-header')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Rewards</h1>
      <span class="text-muted fs-12">Manage value-based rewards (not discounts).</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item active" aria-current="page">Rewards</li>
    </ol>
  </div>
@endsection

@section('content')

  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Rewards</h1>
      <span class="text-muted fs-12">Value-based rewards (not discounts).</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item active" aria-current="page">Rewards</li>
    </ol>
  </div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@php
  $rewards = $rewards ?? collect();
@endphp

<div class="row">
  <div class="col-12">
    <div class="card custom-card">
      <div class="card-header justify-content-between">
        <div class="card-title">Rewards</div>
        <a class="btn btn-sm btn-primary" href="{{ url('/admin/rewards/create') }}">+ Create Reward</a>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table text-nowrap mb-0">
            <thead>
              <tr>
                <th>Title</th>
                <th>Short Description</th>
                <th>One-time</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($rewards as $r)
                <tr>
                  <td>{{ $r->title }}</td>
                  <td class="text-muted">{{ $r->description }}</td>
                  <td>
                    <span class="badge {{ ($r->one_time ?? false) ? 'bg-success-transparent' : 'bg-secondary-transparent' }}">
                      {{ ($r->one_time ?? false) ? 'yes' : 'no' }}
                    </span>
                  </td>

                  {{-- Actions: icon buttons --}}
                  <td class="text-end">
                    <div class="d-inline-flex align-items-center gap-2">

                      <a
                        class="btn btn-sm btn-light btn-icon"
                        href="{{ url('/admin/rewards/'.$r->id.'/edit') }}"
                        title="Edit"
                        aria-label="Edit"
                      >
                        <i class="ti ti-pencil"></i>
                      </a>

                      <form
                        action="{{ url('/admin/rewards/'.$r->id) }}"
                        method="POST"
                        class="d-inline"
                        onsubmit="return confirm('Delete this reward?')"
                      >
                        @csrf
                        @method('DELETE')
                        <button
                          class="btn btn-sm btn-light btn-icon btn-delete"
                          type="submit"
                          title="Delete"
                          aria-label="Delete"
                        >
                          <i class="ti ti-trash text-delete"></i>
                        </button>
                      </form>

                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-muted">No rewards yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <p class="text-muted fs-12 mt-3 mb-0">
          Rewards are value-based (not discounts). One-time use is enforced through the reward access token.
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
