@extends('layouts.app')

@section('title', 'Oshara | Contact Support')

@section('content')

<div class="hero">
    <div class="hero-badge">Support</div>
    <h1>Contact Oshara</h1>
    <p class="lead">
        Need help with your reward link or have a question? Send us a message and we’ll get back to you.
    </p>
</div>

{{-- Success message --}}
@if(session('success'))
    <div class="status" style="background:#f0fdf4; border-color:#bbf7d0; color:#166534; margin-bottom:14px;">
        {{ session('success') }}
        <button type="button" class="close-x" onclick="this.parentElement.style.display='none'">✕</button>
    </div>
@endif

{{-- Error summary --}}
@if ($errors->any())
    <div class="status" style="background:#fef2f2; border-color:#fecaca; color:#991b1b; margin-bottom:14px;">
        <strong>Please fix the errors below.</strong>
        <button type="button" class="close-x" onclick="this.parentElement.style.display='none'">✕</button>
    </div>
@endif

<div class="panel">
    <div class="panel-title">Send a message</div>

    <form method="POST" action="{{ route('contact.submit') }}" novalidate>
        @csrf

        {{-- Optional hidden fields (nice for linking support to a reward) --}}
        <input type="hidden" name="reward_access_id" value="{{ old('reward_access_id') }}">
        <input type="hidden" name="reward_token" value="{{ old('reward_token', $prefillToken ?? '') }}">

        <div class="field">
            <label for="name">Name</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                placeholder="Your name"
                required
            >
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $prefillEmail ?? '') }}"
                placeholder="you@example.com"
                required
            >
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="subject">Subject</label>
            <input
                id="subject"
                name="subject"
                type="text"
                value="{{ old('subject', $prefillSubject ?? '') }}"
                placeholder="Reward link issue / Question about my reward"
                required
            >
            @error('subject') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="message">Message</label>
            <textarea
                id="message"
                name="message"
                rows="6"
                placeholder="Tell us what happened and we’ll help you."
                required
            >{{ old('message') }}</textarea>
            @error('message') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Send Message</button>
            <button type="button" class="btn btn-ghost" onclick="tryClose()">Close</button>
        </div>

        <div class="fineprint" style="margin-top:10px;">
            We usually respond within a couple of business day.
        </div>
    </form>
</div>

<script>
    function tryClose() {
        window.close();
        // fallback if browser blocks it
        setTimeout(() => window.location.href = "/reward", 250);
    }
</script>

@endsection

@push('styles')
<style>
    /* Contact-only styles */
    .field { margin-bottom: 14px; }
    label { display:block; font-weight:800; font-size:13px; margin-bottom:6px; color:#0f172a; }
    input, textarea {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 12px;
        font-size: 14px;
        outline: none;
        background: #fff;
    }
    input:focus, textarea:focus { border-color:#94a3b8; }
    textarea { resize: vertical; }
    .error { margin-top:6px; font-size:12px; color:#b91c1c; }
    .close-x {
        float:right;
        border:none;
        background:transparent;
        cursor:pointer;
        font-size:14px;
        opacity:.7;
    }
    .close-x:hover { opacity:1; }
</style>
@endpush
