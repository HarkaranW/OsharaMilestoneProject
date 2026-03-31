@extends('layouts.app')

@section('title', 'Oshara | Your Reward')

@section('content')

  @php
    $name = $access->client_name ?: $access->client_email;
    $expiresAt = $access->expires_at;
    
    // Determine milestone short code
    $milestoneCode = 'XX';
    if (str_contains($milestone->name, '3')) $milestoneCode = '3M';
    if (str_contains($milestone->name, '6')) $milestoneCode = '6M';
    if (str_contains($milestone->name, '12')) $milestoneCode = '12M';

    // Build reference code
    $referenceCode = 'OSH-' . $milestoneCode . '-' . strtoupper(substr($access->token, -5));
  @endphp

  <div class="hero">
    <div class="hero-badge">Milestone unlocked</div>

    <h1>🎉 Congrats, {{ $name }}!</h1>

    <p class="lead">
      You’ve reached <strong>{{ $milestone->name }}</strong>.
      Here’s a value based gift to celebrate your progress.
    </p>

    @if ($expiresAt)
      <div class="expiry-box">
        <span class="expiry-icon">⏰</span>
        <span id="expiry-countdown">
          Calculating time remaining…
            </span>
            <div class="expiry-date">
              Expires on {{ \Carbon\Carbon::parse($expiresAt)->format('M j, Y \\a\\t g:i A') }}
            </div>
      </div>
    @endif

    <div class="reference-box">
      <span class="reference-label">Reward Reference</span>
      <span class="reference-code">{{ $referenceCode }}</span>
    </div>

  </div>

  <div class="panel">
    <div class="panel-title">Your reward</div>

    <div class="reward-card">
      <div class="reward-title">{{ $reward->title }}</div>
      <div class="reward-desc">{{ $reward->description }}</div>
    </div>

    <div class="panel-title" style="margin-top:16px;">How to redeem</div>

    <ol class="steps">
      @foreach (explode("\n", $reward->instructions ?? '') as $step)
        @if (trim($step) !== '')
          <li>{{ $step }}</li>
        @endif
      @endforeach
    </ol>

    <div class="actions">
      <form method="POST" action="{{ route('reward.redeem', ['token' => $access->token]) }}">
        @csrf
          <button type="submit" class="btn btn-primary">Redeem My Reward</button>
      </form>

      <a
  class="btn btn-ghost"
  href="{{ route('contact.show', [
      'email' => $access->client_email,
      'subject' => 'Reward Support – ' . $referenceCode,
      'token' => $access->token
  ]) }}"
>
  Contact Support
</a>

    </div>

    <div class="fineprint">
      For security, this link is personal and can only be redeemed once.
    </div>
  </div>

  @if ($expiresAt)
    <script>
      const expiryTime = new Date("{{ \Carbon\Carbon::parse($expiresAt)->toIso8601String() }}").getTime();
      const countdownEl = document.getElementById('expiry-countdown');

      function updateCountdown() {
        const now = new Date().getTime();
        const diff = expiryTime - now;

        if (diff <= 0) {
          countdownEl.textContent = "This reward has expired.";
          setTimeout(() => window.location.reload(), 1500);
          return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);

        let parts = [];
        if (days > 0) parts.push(`${days} day${days !== 1 ? 's' : ''}`);
        if (hours > 0) parts.push(`${hours} hour${hours !== 1 ? 's' : ''}`);
        if (days === 0) parts.push(`${minutes} minute${minutes !== 1 ? 's' : ''}`);

        countdownEl.textContent = `This reward expires in ${parts.join(', ')}`;
      }

      updateCountdown();
      setInterval(updateCountdown, 60000); // update every minute
    </script>
  @endif
@endsection
