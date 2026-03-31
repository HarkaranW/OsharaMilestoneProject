@extends('admin.layouts.app')

@section('title', 'Inbox')

@section('content')
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
      <h1 class="page-title fw-semibold fs-18 mb-0">Inbox</h1>
      <span class="text-muted fs-12">Internal notifications (demo).</span>
    </div>
  </div>

  <div class="card custom-card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table text-nowrap mb-0">
          <thead>
            <tr>
              <th>From</th>
              <th>Subject</th>
              <th class="text-end">Time</th>
            </tr>
          </thead>
          <tbody>
            @foreach($messages as $m)
              <tr>
                <td>{{ $m['from'] }}</td>
                <td>{{ $m['subject'] }}</td>
                <td class="text-end text-muted">{{ $m['time'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="text-muted fs-12 mt-3">
        Later you can connect this to real DB records (ex: reward_access logs, support messages, etc.).
      </div>
    </div>
  </div>
@endsection