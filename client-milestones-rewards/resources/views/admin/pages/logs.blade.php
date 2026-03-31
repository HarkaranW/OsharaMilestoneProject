@extends('admin.layouts.app')

@section('title', 'Logs / Audit')

@section('page-header')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Logs / Audit</h1>
      <span class="text-muted fs-12">Track reward link opens and claims.</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item active" aria-current="page">Logs / Audit</li>
    </ol>
  </div>
@endsection

@section('content')

  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Logs / Audit Trail</h1>
      <span class="text-muted fs-12">Who received what, and when.</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item active" aria-current="page">Logs</li>
    </ol>
  </div>
@php
  $logs = $logs ?? collect();
@endphp

<div class="row">
  <div class="col-12">
    <div class="card custom-card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table text-nowrap mb-0">
            <thead>
              <tr>
                <th>Client</th>
                <th>Milestone</th>
                <th>Reward</th>
                <th>Link Status</th>
                <th>Opened At</th>
                <th>Claimed At</th>
              </tr>
            </thead>
            <tbody>
              @forelse($logs as $l)
                <tr>
                  <td>{{ $l->client_email ?? '—' }}</td>
                  <td>{{ $l->milestone->name ?? '—' }}</td>
                  <td>{{ $l->reward->title ?? '—' }}</td>
                  <td>
                    @php
                      $status = 'active';
                      if (!empty($l->expires_at) && now()->greaterThan($l->expires_at)) $status = 'expired';
                      if (($l->used ?? false) === true) $status = 'claimed';
                    @endphp
                    <span class="badge bg-secondary-transparent">{{ $status }}</span>
                  </td>
                  <td class="text-muted">{{ $l->opened_at ?? '—' }}</td>
                  <td class="text-muted">{{ $l->claimed_at ?? '—' }}</td>
                </tr>
              @empty
                <tr><td colspan="6" class="text-muted">No logs yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <p class="text-muted fs-12 mt-3 mb-0">
          This shows who received what, when they opened the link, and whether the reward was claimed.
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
