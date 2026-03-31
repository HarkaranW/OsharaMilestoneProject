@extends('admin.layouts.app')

@section('title', 'Edit Milestone')

@section('content')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Edit Milestone</h1>
      <span class="text-muted fs-12">Update milestone details.</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/admin/milestones') }}">Milestones</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </div>

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
    <div class="card-header justify-content-between">
      <div class="card-title">Milestone</div>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ url('/admin/milestones/'.$milestone->id) }}" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-md-6">
          <label class="form-label fw-semibold">Milestone Name</label>
          <input class="form-control" name="name" value="{{ old('name', $milestone->name) }}" required>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Type</label>
          <select class="form-select" name="type" required>
            <option value="time" @selected(old('type', $milestone->type) === 'time')>Time-based</option>
            <option value="performance" @selected(old('type', $milestone->type) === 'performance')>Performance-based</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Trigger Condition</label>
          <input class="form-control" name="trigger_condition" value="{{ old('trigger_condition', $milestone->trigger_condition) }}" required>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Assigned Reward (optional)</label>
          <select class="form-select" name="reward_id">
            <option value="">None</option>
            @foreach(($rewards ?? collect()) as $r)
              <option value="{{ $r->id }}" @selected(old('reward_id', $milestone->reward_id) == $r->id)>{{ $r->title }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12 d-flex gap-2">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <a href="{{ url('/admin/milestones') }}" class="btn btn-primary">Cancel</a>
        </div>
      </form>

      <hr class="my-3">
    </div>
  </div>
@endsection