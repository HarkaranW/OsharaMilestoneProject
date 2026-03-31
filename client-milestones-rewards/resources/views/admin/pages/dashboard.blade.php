@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('page-header')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Dashboard</h1>
      <span class="text-muted fs-12">Overview of client milestone rewards activity.</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
  </div>
@endsection

@section('content')
@php
  $totalLinks = $totalLinks ?? 0;
  $claimedLinks = $claimedLinks ?? 0;
  $openRate = $openRate ?? null; // can be null
  $expiredLinks = $expiredLinks ?? 0;
  $recent = $recent ?? collect();
@endphp

<div class="row">
  <div class="col-xxl-3 col-md-6">
    <div class="card custom-card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="mb-1 text-muted">Rewards Sent</p>
            <h4 class="mb-0">{{ $totalLinks }}</h4>
          </div>
          <span class="avatar avatar-lg bg-primary-transparent avatar-rounded">
            <i class="ti ti-send fs-22"></i>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xxl-3 col-md-6">
    <div class="card custom-card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="mb-1 text-muted">Claimed</p>
            <h4 class="mb-0">{{ $claimedLinks }}</h4>
          </div>
          <span class="avatar avatar-lg bg-success-transparent avatar-rounded">
            <i class="ti ti-check fs-22"></i>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xxl-3 col-md-6">
    <div class="card custom-card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="mb-1 text-muted">Open Rate</p>
            <h4 class="mb-0">{{ is_null($openRate) ? '—%' : $openRate.'%' }}</h4>
          </div>
          <span class="avatar avatar-lg bg-warning-transparent avatar-rounded">
            <i class="ti ti-eye fs-22"></i>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xxl-3 col-md-6">
    <div class="card custom-card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <p class="mb-1 text-muted">Expired Links</p>
            <h4 class="mb-0">{{ $expiredLinks }}</h4>
          </div>
          <span class="avatar avatar-lg bg-danger-transparent avatar-rounded">
            <i class="ti ti-clock-off fs-22"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xxl-8">
    <div class="card custom-card">
      <div class="card-header justify-content-between">
        <div class="card-title">Recent Activity</div>
        <a class="btn btn-sm btn-primary" href="{{ url('/admin/logs') }}">View Logs</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table text-nowrap mb-0">
            <thead>
              <tr>
                <th>Client</th>
                <th>Milestone</th>
                <th>Reward</th>
                <th>Status</th>
                <th>When</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recent as $row)
                <tr>
                  <td>{{ $row->client_email ?? '—' }}</td>
                  <td>{{ $row->milestone->name ?? '—' }}</td>
                  <td>{{ $row->reward->title ?? '—' }}</td>
                  <td>
                    <span class="badge bg-secondary-transparent">
                      {{ ($row->used ?? false) ? 'claimed' : 'active' }}
                    </span>
                  </td>
                  <td class="text-muted">{{ $row->created_at ?? '—' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-muted">No activity yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <p class="text-muted fs-12 mt-3 mb-0">
          Tip: this fills automatically once your controllers pass stats + recent log rows.
        </p>
      </div>
    </div>
  </div>

  <div class="col-xxl-4">
    <div class="card custom-card">
      <div class="card-header">
        <div class="card-title">Quick Actions</div>
      </div>
      <div class="card-body d-grid gap-2">
        <a class="btn btn-primary" href="{{ url('/admin/manual-trigger') }}">
          <i class="ti ti-playstation-triangle me-2"></i>Manual Trigger
        </a>
        <a class="btn btn-outline-primary" href="{{ url('/admin/milestones') }}">
          <i class="ti ti-flag me-2"></i>Manage Milestones
        </a>
        <a class="btn btn-outline-primary" href="{{ url('/admin/rewards') }}">
          <i class="ti ti-gift me-2"></i>Manage Rewards
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
