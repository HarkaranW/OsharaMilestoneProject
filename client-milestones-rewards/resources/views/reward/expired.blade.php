@extends('layouts.app')

@section('title', 'Link Expired')

@push('styles')
  <style>
    .status { background:#fef2f2; border-color:#fecaca; color:#991b1b; }
  </style>
@endpush

@php
  // Only compute these if we actually have the variables (sometimes expired page is shown with no access)
  $referenceCode = null;

  if (isset($access) && isset($milestone)) {
    $milestoneCode = 'XX';
    if (str_contains($milestone->name, '3')) $milestoneCode = '3M';
    if (str_contains($milestone->name, '6')) $milestoneCode = '6M';
    if (str_contains($milestone->name, '12')) $milestoneCode = '12M';

    $referenceCode = 'OSH-' . $milestoneCode . '-' . strtoupper(substr($access->token, -5));
  }
@endphp

@section('content')

  <h1>⏰ This link is no longer valid</h1>

  <p class="lead">
    This reward link has expired. For security, reward links are time-limited.
  </p>

  <div class="status">
    @if($referenceCode)
      <strong>Reward reference:</strong> {{ $referenceCode }} <br>
    @endif
    Contact support and we can help verify your milestone.
  </div>

  <div class="actions">
    <a
      href="{{ route('contact.show', [
        'email' => $access->client_email ?? null,
        'subject' => 'Request new reward link',
        'token' => $access->token ?? null
        ]) }}"
        class="btn btn-primary"
      >
      Request new link
    </a>

    <a
      href="{{ route('contact.show', [
        'email' => $access->client_email ?? null,
        'subject' => 'Reward Support – ' . ($referenceCode ?? ''),
        'token' => $access->token ?? null
        ]) }}"
        class="btn btn-ghost"
      >
      Contact Support
    </a>

    <button class="btn btn-ghost" onclick="tryClose()">Close</button>
  </div>


  <script>
    function tryClose() {
      window.close();
      setTimeout(() => window.location.href = "{{ route('contact.show') }}", 250);
    }
  </script>

@endsection
