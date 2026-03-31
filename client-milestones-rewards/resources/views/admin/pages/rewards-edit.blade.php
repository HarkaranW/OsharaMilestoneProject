@extends('admin.layouts.app')

@section('title', 'Edit Reward')

@section('page-header')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Edit Reward</h1>
      <span class="text-muted fs-12">Update a value-based reward (no discounts).</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/admin/rewards') }}">Rewards</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
    <div class="col-12 col-xl-8">
      <div class="card custom-card">
        <div class="card-header justify-content-between">
          <div class="card-title">Reward Details</div>
          <span class="text-muted fs-12">Wireframe: Title → Description → Redeem Steps</span>
        </div>

        <div class="card-body">
          {{-- UPDATE FORM --}}
          <form method="POST" action="{{ url('/admin/rewards/'.$reward->id) }}" class="row g-3" id="updateForm">
            @csrf
            @method('PUT')

            <div class="col-12">
              <label class="form-label fw-semibold">Title</label>
              <input
                type="text"
                name="title"
                class="form-control"
                value="{{ old('title', $reward->title) }}"
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
                value="{{ old('description', $reward->description) }}"
                placeholder="One-line value statement for the client"
                required
              >
              <div class="text-muted fs-12 mt-1">This appears on the client landing page.</div>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Redemption Steps</label>
              <textarea
                name="instructions"
                class="form-control"
                rows="6"
                placeholder="Step 1...&#10;Step 2...&#10;Step 3..."
                required
              >{{ old('instructions', $reward->instructions) }}</textarea>
              <div class="text-muted fs-12 mt-1">Use one step per line.</div>
            </div>

            <div class="col-12">
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value="1"
                  id="one_time"
                  name="one_time"
                  {{ old('one_time', $reward->one_time) ? 'checked' : '' }}
                >
                <label class="form-check-label fw-semibold" for="one_time">
                  One-time use
                </label>
              </div>
              <div class="text-muted fs-12">Enforced by reward access token claiming.</div>
            </div>

            <div class="col-12 d-flex gap-2">
              <button type="submit" class="btn btn-primary">Save Changes</button>
              <a href="{{ url('/admin/rewards') }}" class="btn">Cancel</a>

              {{-- Delete button triggers the separate form below --}}
              <button
                type="button"
                class="btn btn-outline-danger ms-auto"
                onclick="document.getElementById('deleteForm').submit();"
              >
                <i class="ti ti-trash"></i> Delete
              </button>
            </div>
          </form>

          {{-- DELETE FORM (NOT nested) --}}
          <form
            id="deleteForm"
            method="POST"
            action="{{ url('/admin/rewards/'.$reward->id) }}"
            onsubmit="return confirm('Delete this reward? This cannot be undone.')"
            class="d-none"
          >
            @csrf
            @method('DELETE')
          </form>
        </div>
      </div>
    </div>

    {{-- Preview --}}
    <div class="col-12 col-xl-4">
      <div class="card custom-card">
        <div class="card-header">
          <div class="card-title">Client Preview</div>
        </div>
        <div class="card-body">
          <div class="p-3 border rounded">
            <div class="fw-semibold">{{ old('title', $reward->title) }}</div>
            <div class="text-muted fs-12 mt-1">{{ old('description', $reward->description) }}</div>

            <div class="mt-3 fw-semibold fs-12">Steps to redeem</div>
            <div class="text-muted fs-12" style="white-space: pre-line;">
              {{ old('instructions', $reward->instructions) }}
            </div>
          </div>
        </div>
      </div>

      <div class="card custom-card mt-3">
        <div class="card-body">
          <div class="fw-semibold mb-1">Tip</div>
          <div class="text-muted fs-12">
            Keep the title punchy, and the description outcome-based.
            Steps should be short and easy.
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
