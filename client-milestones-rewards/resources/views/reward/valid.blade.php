@extends('layouts.app')

@section('title', 'Reward Claimed')

@push('styles')
<style>
  .status { background:#f0fdf4; border-color:#bbf7d0; color:#166534; }
</style>
@endpush

@section('content')

  @php
    // Determine milestone short code
    $milestoneCode = 'XX';
    if (str_contains($milestone->name, '3')) $milestoneCode = '3M';
    if (str_contains($milestone->name, '6')) $milestoneCode = '6M';
    if (str_contains($milestone->name, '12')) $milestoneCode = '12M';

    // Build reference code
    $referenceCode = 'OSH-' . $milestoneCode . '-' . strtoupper(substr($access->token, -5));
  @endphp

  <h1>✅ Reward Claimed</h1>

  <p class="lead">
    Thanks{{ $access->client_name ? ' '.$access->client_name : '' }}, your reward has been successfully claimed.
  </p>

  <div class="reference-box" style="margin-top:14px;">
    <span class="reference-label">Reward Reference</span>
    <span class="reference-code">{{ $referenceCode }}</span>
  </div>

  <p class="fineprint" style="margin-top:10px;">
    Please mention this reference if you contact support.
  </p>

  <div class="status">
    <strong>{{ $reward->title }}</strong> linked to <strong>{{ $milestone->name }}</strong>.
  </div>

  <p style="margin-top:14px;">
  Our team will follow up with next steps using <strong>{{ $access->client_email }}</strong>.
  </p>

  <div class="actions">
    <a class="btn btn-ghost"
      href="{{ route('contact.show', [
        'email' => $access->client_email,
        'subject' => 'Reward Support – ' . $referenceCode,
        'token' => $access->token
        ]) 
      }}">
      Contact Support
    </a>

</div>

@endsection
