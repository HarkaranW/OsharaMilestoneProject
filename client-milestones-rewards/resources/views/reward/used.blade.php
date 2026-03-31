@extends('layouts.app')

@section('title', 'Link Already Used')

@push('styles')
  <style>
    .status { background:#fffbeb; border-color:#fde68a; color:#92400e; }
  </style>
@endpush

@php
  // Determine milestone short code
  $milestoneCode = 'XX';
  if (str_contains($milestone->name, '3')) $milestoneCode = '3M';
  if (str_contains($milestone->name, '6')) $milestoneCode = '6M';
  if (str_contains($milestone->name, '12')) $milestoneCode = '12M';

  // Build reference code
  $referenceCode = 'OSH-' . $milestoneCode . '-' . strtoupper(substr($access->token, -5));
@endphp

@section('content')

  <h1>⚠️ This link has already been used</h1>

  <p class="lead">
    This reward was already claimed. For security, each reward link can only be redeemed once.
  </p>

  <div class="status">
    <strong>Reward reference:</strong> {{ $referenceCode }} <br>
      If you think this is a mistake, contact support and we’ll help you.
  </div>

  <div class="actions">
    <a
      href="{{ route('contact.show', [
        'email' => $access->client_email,
        'subject' => 'Reward Support – ' . $referenceCode,
        'token' => $access->token
        ]) }}"
        class="btn btn-primary"
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
