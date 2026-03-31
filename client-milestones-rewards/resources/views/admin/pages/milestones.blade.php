@extends('admin.layouts.app')

@section('title', 'Milestones')

@section('content')
  <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Milestones</h1>
      <span class="text-muted fs-12">Manage milestone triggers and assigned rewards.</span>
    </div>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Admin</a></li>
      <li class="breadcrumb-item active" aria-current="page">Milestones</li>
    </ol>
  </div>

  @php $milestones = $milestones ?? collect(); @endphp

  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">Milestones</div>
      <a class="btn btn-sm btn-primary" href="{{ url('/admin/milestones/create') }}">+ Create Milestone</a>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table text-nowrap mb-0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Type</th>
              <th>Trigger Condition</th>
              <th>Assigned Reward</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($milestones as $m)
              <tr>
                <td>{{ $m->name }}</td>
                <td class="text-muted">{{ $m->type }}</td>
                <td class="text-muted">{{ $m->trigger_condition }}</td>
                <td class="text-muted">{{ optional($m->reward)->title ?? '—' }}</td>
                <td class="text-end">
                    <div class="d-inline-flex align-items-center gap-2">

                      <a
                        class="btn btn-sm btn-light btn-icon"
                        href="{{ url('/admin/milestones/'.$m->id.'/edit') }}"
                        title="Edit"
                        aria-label="Edit"
                      >
                        <i class="ti ti-pencil"></i>
                      </a>

                      <form
                        action="{{ url('/admin/milestones/'.$m->id) }}"
                        method="POST"
                        class="d-inline"
                        onsubmit="return confirm('Delete this milestone?')"
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
              <tr><td colspan="5" class="text-muted">No milestones yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="text-muted fs-12 mt-3">
        Wireframe rule: each milestone can only be rewarded once per client.
      </div>
    </div>
  </div>
@endsection