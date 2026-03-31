@extends('layouts.app')

@section('title', 'Invalid Link')

@push('styles')
  <style>
    .status {
      background:#fef2f2;
      border-color:#fecaca;
      color:#991b1b;
    }
  </style>
@endpush

@section('content')

<h1>❌ Invalid reward link</h1>

<p class="lead">
  This reward link is not valid or may have been entered incorrectly.
</p>

<div class="status">
  If your reward link has expired or doesn’t work, you can request a new one below.
</div>

<div class="actions">
  <a
    href="{{ route('contact.show', [
      'subject' => 'Request new reward link'
    ]) }}"
    class="btn btn-primary"
  >
    Request new link
  </a>

  <a href="{{ route('contact.show') }}" class="btn btn-ghost">
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
