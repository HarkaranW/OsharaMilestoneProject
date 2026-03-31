@extends('admin.layouts.app')

@section('title', 'Create Reward')

@section('page-header')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Create Reward</h1>
      <span class="text-muted fs-12">Add a new value-based reward (not a discount).</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/admin/rewards') }}">Rewards</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
  </div>
@endsection

@section('content')
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
    {{-- Main form --}}
    <div class="col-12 col-xl-8">
      <div class="card custom-card">
        <div class="card-header justify-content-between">
          <div class="card-title">Reward Details</div>
          <span class="text-muted fs-12">Wireframe: Title → Description → Redeem Steps</span>
        </div>

        <div class="card-body">
          <form method="POST" action="{{ url('/admin/rewards') }}" class="row g-3">
            @csrf

            <div class="col-12">
              <label class="form-label fw-semibold">Title</label>
              <input
                type="text"
                name="title"
                class="form-control"
                value="{{ old('title') }}"
                placeholder="e.g., Premium SEO Report"
                required
              >
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Short Description</label>
              <input
                type="text"
                name="description"
                class="form-control"
                value="{{ old('description') }}"
                placeholder="One-line value statement for the client"
                required
              >
              <div class="text-muted fs-12 mt-1">
                This appears on the client landing page.
              </div>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Redemption Steps</label>
              <textarea
                name="instructions"
                class="form-control"
                rows="6"
                placeholder="Step 1...&#10;Step 2...&#10;Step 3..."
                required
              >{{ old('instructions') }}</textarea>
              <div class="text-muted fs-12 mt-1">
                Use one step per line.
              </div>
            </div>

            <div class="col-12">
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value="1"
                  id="one_time"
                  name="one_time"
                  {{ old('one_time') ? 'checked' : '' }}
                >
                <label class="form-check-label fw-semibold" for="one_time">
                  One-time use
                </label>
              </div>
              <div class="text-muted fs-12">
                Enforced when the reward is claimed via the link.
              </div>
            </div>

            <div class="col-12 d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                Create Reward
              </button>
              <a href="{{ url('/admin/rewards') }}" class="btn">
                Cancel
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- Right-side preview (wireframe inspired) --}}
    <div class="col-12 col-xl-4">
      <div class="card custom-card">
        <div class="card-header">
          <div class="card-title">Client Preview</div>
        </div>
        <div class="card-body">

          <div class="p-3 border rounded">
            <div class="fw-semibold">
              {{ old('title') ?: 'Reward Title' }}
            </div>
            <div class="text-muted fs-12 mt-1">
              {{ old('description') ?: 'Short value description shown to the client.' }}
            </div>

            <div class="mt-3 fw-semibold fs-12">Steps to redeem</div>
            <div class="text-muted fs-12" style="white-space: pre-line;">
              {{ old('instructions') ?: "Step 1\nStep 2\nStep 3" }}
            </div>
          </div>
        </div>
      </div>

      <div class="card custom-card mt-3">
        <div class="card-body">
          <div class="fw-semibold mb-1">Tip</div>
          <div class="text-muted fs-12">
            Focus on outcomes, not features. Rewards should feel exclusive and helpful.
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
