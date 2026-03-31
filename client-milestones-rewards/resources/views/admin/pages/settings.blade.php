@extends('admin.layouts.app')

@section('title', 'Settings')

@section('page-header')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Settings</h1>
      <span class="text-muted fs-12">Admin preferences and defaults for the platform.</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item active" aria-current="page">Settings</li>
    </ol>
  </div>
@endsection

@section('content')
@php
  $user = $user ?? auth()->user();
  $settings = $settings ?? null;
@endphp

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

  <div class="col-xxl-4 col-xl-5">
    <div class="card custom-card">
      <div class="card-header">
        <div class="card-title">Account</div>
      </div>

      <div class="card-body">
        <div class="d-flex align-items-center gap-3">
          <span class="avatar avatar-xl avatar-rounded bg-primary-transparent">
            <i class="ti ti-user fs-22"></i>
          </span>

          <div>
            <div class="fw-semibold">{{ $user->name ?? 'Admin' }}</div>
            <div class="text-muted fs-12">{{ $user->email ?? 'admin@example.com' }}</div>
          </div>
        </div>

        <hr class="my-3">

        <div class="d-grid gap-2">
          <a href="{{ url('/profile') }}" class="btn btn-primary">
            <i class="ti ti-user-edit me-1"></i> Edit Profile
          </a>
          <a href="{{ url('/inbox') }}" class="btn btn-light">
            <i class="ti ti-mail me-1"></i> Inbox
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xxl-8 col-xl-7">
    <div class="card custom-card">
      <div class="card-header justify-content-between">
        <div class="card-title">Platform Defaults</div>
        <span class="badge bg-primary-transparent">Saved</span>
      </div>

      <div class="card-body">
        <form method="POST" action="{{ url('/admin/settings') }}" class="row gy-3">
          @csrf

          <div class="col-md-6">
            <label class="form-label fw-semibold">Default link expiry</label>
            <select class="form-select" name="default_expiry_days" required>
              @foreach([3,7,14,30] as $d)
                <option value="{{ $d }}" @selected((int)old('default_expiry_days', $settings?->default_expiry_days ?? 7) === $d)>
                  {{ $d }} days
                </option>
              @endforeach
            </select>
            <div class="text-muted fs-12 mt-1">
              Used when generating reward links (manual trigger / automation).
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Reward assignment</label>
            <select class="form-select" name="reward_assignment" required>
              <option value="random" @selected(old('reward_assignment', $settings?->reward_assignment ?? 'random') === 'random')>
                Random reward
              </option>
              <option value="milestone" @selected(old('reward_assignment', $settings?->reward_assignment ?? 'random') === 'milestone')>
                Milestone-assigned reward
              </option>
            </select>
            <div class="text-muted fs-12 mt-1">
              Random keeps rewards varied. Milestone-assigned is controlled.
            </div>
          </div>

          <div class="col-12">
            <div class="p-3 border rounded-3">
              <div class="fw-semibold mb-2">Notifications</div>

              <div class="row gy-2">
                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="notif_claimed" name="notif_claimed"
                      @checked(old('notif_claimed', $settings?->notif_claimed ?? true))>
                    <label class="form-check-label" for="notif_claimed">Notify when a reward is claimed</label>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="notif_opened" name="notif_opened"
                      @checked(old('notif_opened', $settings?->notif_opened ?? true))>
                    <label class="form-check-label" for="notif_opened">Notify when a link is opened</label>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="notif_expired" name="notif_expired"
                      @checked(old('notif_expired', $settings?->notif_expired ?? false))>
                    <label class="form-check-label" for="notif_expired">Notify when a link expires</label>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="notif_weekly" name="notif_weekly"
                      @checked(old('notif_weekly', $settings?->notif_weekly ?? true))>
                    <label class="form-check-label" for="notif_weekly">Weekly summary email (admin)</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <div class="p-3 border rounded-3">
              <div class="fw-semibold mb-2">Security</div>

              <div class="row gy-2">
                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="enforce_one_time" name="enforce_one_time"
                      @checked(old('enforce_one_time', $settings?->enforce_one_time ?? true))>
                    <label class="form-check-label" for="enforce_one_time">Enforce one-time claim</label>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="prevent_multi_active" name="prevent_multi_active"
                      @checked(old('prevent_multi_active', $settings?->prevent_multi_active ?? true))>
                    <label class="form-check-label" for="prevent_multi_active">Prevent multiple active links</label>
                  </div>
                </div>
              </div>

              <div class="text-muted fs-12 mt-2">
                (Your TriggerController logic should respect these — next step below.)
              </div>
            </div>
          </div>

          <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="ti ti-device-floppy me-1"></i> Save Settings
            </button>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-light">Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection