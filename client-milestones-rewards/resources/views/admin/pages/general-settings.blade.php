@extends('admin.layouts.app')

@section('title', 'Website Settings — Admin')

@push('styles')
<style>
  .settings-nav .nav-link {
    color: var(--default-text-color);
    border-radius: 0.4rem;
    padding: 0.6rem 1rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    transition: background 0.15s, color 0.15s;
  }
  .settings-nav .nav-link:hover {
    background: var(--primary-01);
    color: var(--primary-color);
  }
  .settings-nav .nav-link.active {
    background: var(--primary-color);
    color: #fff !important;
  }
  .settings-nav .nav-link.active i {
    color: #fff !important;
  }
  .settings-section {
    display: none;
  }
  .settings-section.active {
    display: block;
  }
  .section-header {
    border-bottom: 1px solid var(--default-border);
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
  }
  .section-header h5 {
    margin: 0;
    font-weight: 700;
    font-size: 1.05rem;
  }
  .section-header p {
    margin: 0.25rem 0 0;
    font-size: 0.82rem;
    opacity: 0.65;
  }
  .color-swatch-row {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    align-items: center;
  }
  .color-swatch {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    border: 3px solid transparent;
    transition: border-color 0.15s, transform 0.15s;
  }
  .color-swatch:hover { transform: scale(1.12); }
  .color-swatch.selected { border-color: var(--primary-color); }
  .logo-upload-area {
    border: 2px dashed var(--default-border);
    border-radius: 0.6rem;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
  }
  .logo-upload-area:hover {
    border-color: var(--primary-color);
    background: var(--primary-005);
  }
  .logo-upload-area i {
    font-size: 2rem;
    opacity: 0.45;
    display: block;
    margin-bottom: 0.5rem;
  }
  .smtp-test-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.78rem;
    font-weight: 600;
  }
  .smtp-test-badge.success { background: var(--success-01); color: var(--success); }
  .smtp-test-badge.fail    { background: var(--danger-01);  color: var(--danger);  }
  .toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--default-border);
  }
  .toggle-row:last-child { border-bottom: none; }
  .toggle-row-label strong {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
  }
  .toggle-row-label span {
    font-size: 0.78rem;
    opacity: 0.6;
  }
  .save-bar {
    position: sticky;
    bottom: 0;
    background: var(--custom-white);
    border-top: 1px solid var(--default-border);
    padding: 0.9rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 10;
    border-radius: 0 0 0.5rem 0.5rem;
  }
  .save-bar .saved-indicator {
    font-size: 0.82rem;
    color: var(--success);
    opacity: 0;
    transition: opacity 0.3s;
    display: flex;
    align-items: center;
    gap: 0.35rem;
  }
  .save-bar .saved-indicator.show { opacity: 1; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between my-4">
  <div>
    <h4 class="fw-bold mb-0">Website Settings</h4>
    <p class="text-muted fs-12 mb-0">Manage global configuration for your platform</p>
  </div>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Website Settings</li>
    </ol>
  </nav>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="ti ti-circle-check me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="row g-4">

  {{-- Sidebar Nav --}}
  <div class="col-xl-3 col-lg-3">
    <div class="card custom-card">
      <div class="card-body p-2">
        <nav class="settings-nav nav flex-column gap-1">
          <a href="#" class="nav-link active" data-section="branding">
            <i class="ti ti-palette fs-16"></i> Branding
          </a>
          <a href="#" class="nav-link" data-section="email">
            <i class="ti ti-mail fs-16"></i> Email / SMTP
          </a>
          <a href="#" class="nav-link" data-section="rewards">
            <i class="ti ti-gift fs-16"></i> Reward Defaults
          </a>
          <a href="#" class="nav-link" data-section="security">
            <i class="ti ti-shield-lock fs-16"></i> Security
          </a>
        </nav>
      </div>
    </div>
  </div>

  {{-- Settings Panel --}}
  <div class="col-xl-9 col-lg-9">
    <form method="POST" action="{{ url('/admin/general-settings') }}" enctype="multipart/form-data" id="settingsForm">
      @csrf

      {{-- ═══════════════════════════════
           BRANDING
      ═══════════════════════════════ --}}
      <div class="card custom-card settings-section active" id="section-branding">
        <div class="card-body">
          <div class="section-header">
            <h5><i class="ti ti-palette me-2 text-primary"></i>Branding</h5>
            <p>Customize how your platform looks and feels to clients</p>
          </div>

          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-semibold">App Name</label>
              <input type="text" name="app_name" class="form-control"
                value="{{ old('app_name', $settings->app_name) }}"
                placeholder="e.g. Bizlyt">
              <div class="form-text">Shown in browser tab, emails, and the client portal.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Support Email</label>
              <input type="email" name="support_email" class="form-control"
                value="{{ old('support_email', $settings->support_email) }}"
                placeholder="support@yourdomain.com">
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Primary Accent Color</label>
              <div class="color-swatch-row">
                @php
                  $swatches = ['#3b82f6','#6366f1','#8b5cf6','#ec4899','#f59e0b','#10b981','#ef4444','#0ea5e9'];
                  $currentColor = old('accent_color', $settings->accent_color ?? '#3b82f6');
                @endphp
                @foreach($swatches as $color)
                  <div class="color-swatch {{ $color === $currentColor ? 'selected' : '' }}"
                       style="background:{{ $color }}"
                       data-color="{{ $color }}"
                       title="{{ $color }}"></div>
                @endforeach
                <input type="color" name="accent_color" id="accentColorPicker"
                       value="{{ $currentColor }}"
                       class="form-control form-control-color ms-2"
                       title="Custom color" style="width:42px;height:36px;padding:2px;">
              </div>
              <div class="form-text">Used in buttons, badges, and highlights throughout the admin.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Logo (Light Mode)</label>
              <label class="logo-upload-area d-block" for="logoLight">
                <i class="ti ti-cloud-upload"></i>
                <span class="fw-semibold">Click to upload</span><br>
                <small class="text-muted">PNG, SVG · max 2 MB</small>
              </label>
              <input type="file" id="logoLight" name="logo_light" class="d-none" accept="image/*">
              @if($settings->logo_light)
                <img src="{{ asset('storage/' . $settings->logo_light) }}" alt="Logo" class="mt-2 rounded" style="height:40px;">
              @endif
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Logo (Dark Mode)</label>
              <label class="logo-upload-area d-block" for="logoDark">
                <i class="ti ti-cloud-upload"></i>
                <span class="fw-semibold">Click to upload</span><br>
                <small class="text-muted">PNG, SVG · max 2 MB</small>
              </label>
              <input type="file" id="logoDark" name="logo_dark" class="d-none" accept="image/*">
              @if($settings->logo_dark)
                <img src="{{ asset('storage/' . $settings->logo_dark) }}" alt="Dark Logo" class="mt-2 rounded" style="height:40px;">
              @endif
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Favicon</label>
              <label class="logo-upload-area d-block" for="favicon" style="padding:1rem 2rem;">
                <i class="ti ti-star" style="font-size:1.4rem;"></i>
                <span class="fw-semibold">Upload favicon</span><br>
                <small class="text-muted">ICO, PNG 32×32 recommended</small>
              </label>
              <input type="file" id="favicon" name="favicon" class="d-none" accept="image/*,.ico">
              @if($settings->favicon)
                <img src="{{ asset('storage/' . $settings->favicon) }}" alt="Favicon" class="mt-2 rounded" style="height:32px;">
              @endif
            </div>
          </div>
        </div>
        <div class="save-bar">
          <span class="saved-indicator" id="savedBranding"><i class="ti ti-circle-check"></i> Saved</span>
          <button type="submit" name="section" value="branding" class="btn btn-primary px-4">
            <i class="ti ti-device-floppy me-1"></i> Save Branding
          </button>
        </div>
      </div>

      {{-- ═══════════════════════════════
           EMAIL / SMTP
      ═══════════════════════════════ --}}
      <div class="card custom-card settings-section" id="section-email">
        <div class="card-body">
          <div class="section-header">
            <h5><i class="ti ti-mail me-2 text-primary"></i>Email / SMTP</h5>
            <p>Configure outbound email delivery for notifications and reward links</p>
          </div>

          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Mail Driver</label>
              <select name="mail_driver" class="form-select">
                @foreach(['smtp' => 'SMTP', 'ses' => 'Amazon SES', 'mailgun' => 'Mailgun', 'postmark' => 'Postmark', 'sendmail' => 'Sendmail', 'log' => 'Log (dev only)'] as $val => $label)
                  <option value="{{ $val }}" {{ old('mail_driver', $settings->mail_driver) === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Encryption</label>
              <select name="mail_encryption" class="form-select">
                <option value="tls"  {{ old('mail_encryption', $settings->mail_encryption) === 'tls'  ? 'selected' : '' }}>TLS</option>
                <option value="ssl"  {{ old('mail_encryption', $settings->mail_encryption) === 'ssl'  ? 'selected' : '' }}>SSL</option>
                <option value=""     {{ old('mail_encryption', $settings->mail_encryption) === ''     ? 'selected' : '' }}>None</option>
              </select>
            </div>

            <div class="col-md-8">
              <label class="form-label fw-semibold">SMTP Host</label>
              <input type="text" name="mail_host" class="form-control"
                value="{{ old('mail_host', $settings->mail_host) }}"
                placeholder="smtp.mailgun.org">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Port</label>
              <input type="number" name="mail_port" class="form-control"
                value="{{ old('mail_port', $settings->mail_port) }}"
                placeholder="587">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Username</label>
              <input type="text" name="mail_username" class="form-control"
                value="{{ old('mail_username', $settings->mail_username) }}"
                placeholder="SMTP username">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Password</label>
              <div class="input-group">
                <input type="password" name="mail_password" id="smtpPass" class="form-control"
                  value="{{ old('mail_password', $settings->mail_password) }}"
                  placeholder="••••••••">
                <button type="button" class="btn btn-outline-secondary" id="toggleSmtpPass">
                  <i class="ti ti-eye"></i>
                </button>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">From Name</label>
              <input type="text" name="mail_from_name" class="form-control"
                value="{{ old('mail_from_name', $settings->mail_from_name) }}"
                placeholder="Bizlyt Rewards">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">From Address</label>
              <input type="email" name="mail_from_address" class="form-control"
                value="{{ old('mail_from_address', $settings->mail_from_address) }}"
                placeholder="no-reply@yourdomain.com">
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Send Test Email To</label>
              <div class="input-group" style="max-width:420px;">
                <input type="email" id="testEmailAddr" class="form-control" placeholder="you@example.com">
                <button type="button" class="btn btn-outline-primary" id="sendTestEmail">
                  <i class="ti ti-send me-1"></i> Send Test
                </button>
              </div>
              <div class="mt-2" id="smtpTestResult"></div>
            </div>
          </div>
        </div>
        <div class="save-bar">
          <span class="saved-indicator" id="savedEmail"><i class="ti ti-circle-check"></i> Saved</span>
          <button type="submit" name="section" value="email" class="btn btn-primary px-4">
            <i class="ti ti-device-floppy me-1"></i> Save Email Settings
          </button>
        </div>
      </div>

      {{-- ═══════════════════════════════
           REWARD DEFAULTS
      ═══════════════════════════════ --}}
      <div class="card custom-card settings-section" id="section-rewards">
        <div class="card-body">
          <div class="section-header">
            <h5><i class="ti ti-gift me-2 text-primary"></i>Reward & Milestone Defaults</h5>
            <p>Platform-wide defaults applied when creating new reward links</p>
          </div>

          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Default Link Expiry</label>
              <select name="default_expiry" class="form-select">
                @foreach(['1' => '1 day', '3' => '3 days', '7' => '7 days', '14' => '14 days', '30' => '30 days', '0' => 'Never'] as $val => $label)
                  <option value="{{ $val }}" {{ (string) old('default_expiry', $settings->default_expiry) === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
              <div class="form-text">Used when generating reward links via manual trigger or automation.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Reward Assignment</label>
              <select name="reward_assignment" class="form-select">
                <option value="random"    {{ old('reward_assignment', $settings->reward_assignment) === 'random'    ? 'selected' : '' }}>Random reward</option>
                <option value="milestone" {{ old('reward_assignment', $settings->reward_assignment) === 'milestone' ? 'selected' : '' }}>Milestone-assigned</option>
                <option value="manual"    {{ old('reward_assignment', $settings->reward_assignment) === 'manual'    ? 'selected' : '' }}>Manual selection</option>
              </select>
              <div class="form-text">Random keeps rewards varied. Milestone-assigned is controlled.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Max Active Links Per Client</label>
              <input type="number" name="max_active_links" class="form-control" min="1" max="100"
                value="{{ old('max_active_links', $settings->max_active_links) }}">
              <div class="form-text">How many unclaimed reward links a client can hold at once.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Points Per Milestone</label>
              <input type="number" name="points_per_milestone" class="form-control" min="1"
                value="{{ old('points_per_milestone', $settings->points_per_milestone) }}">
              <div class="form-text">Default point value awarded when a milestone is reached.</div>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold mb-3 d-block">Notifications</label>

              <div class="toggle-row">
                <div class="toggle-row-label">
                  <strong>Notify when a reward is claimed</strong>
                  <span>Send admin an email when a client claims their reward</span>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="notify_claimed" role="switch"
                    {{ $settings->notify_claimed ? 'checked' : '' }}>
                </div>
              </div>

              <div class="toggle-row">
                <div class="toggle-row-label">
                  <strong>Notify when a link is opened</strong>
                  <span>Track client engagement when reward links are clicked</span>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="notify_opened" role="switch"
                    {{ $settings->notify_opened ? 'checked' : '' }}>
                </div>
              </div>

              <div class="toggle-row">
                <div class="toggle-row-label">
                  <strong>Notify when a link expires</strong>
                  <span>Alert admin when an unclaimed link passes its expiry</span>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="notify_expired" role="switch"
                    {{ $settings->notify_expired ? 'checked' : '' }}>
                </div>
              </div>

              <div class="toggle-row">
                <div class="toggle-row-label">
                  <strong>Weekly summary email</strong>
                  <span>Receive a weekly digest of reward activity</span>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="notify_weekly" role="switch"
                    {{ $settings->notify_weekly ? 'checked' : '' }}>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="save-bar">
          <span class="saved-indicator" id="savedRewards"><i class="ti ti-circle-check"></i> Saved</span>
          <button type="submit" name="section" value="rewards" class="btn btn-primary px-4">
            <i class="ti ti-device-floppy me-1"></i> Save Reward Defaults
          </button>
        </div>
      </div>

      {{-- ═══════════════════════════════
           SECURITY
      ═══════════════════════════════ --}}
      <div class="card custom-card settings-section" id="section-security">
        <div class="card-body">
          <div class="section-header">
            <h5><i class="ti ti-shield-lock me-2 text-primary"></i>Security & Access Control</h5>
            <p>Control how clients interact with rewards and how admins access the platform</p>
          </div>

          <div class="row g-4">
            <div class="col-12">
              <label class="form-label fw-semibold mb-3 d-block">Reward Security</label>

              <div class="toggle-row">
                <div class="toggle-row-label">
                  <strong>Enforce one-time claim</strong>
                  <span>Each reward link can only be claimed once</span>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="enforce_one_time" role="switch"
                    {{ $settings->enforce_one_time ? 'checked' : '' }}>
                </div>
              </div>

              <div class="toggle-row">
                <div class="toggle-row-label">
                  <strong>Prevent multiple active links</strong>
                  <span>Block issuing a new link if an unclaimed one already exists</span>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="prevent_multiple_links" role="switch"
                    {{ $settings->prevent_multiple_links ? 'checked' : '' }}>
                </div>
              </div>

              <div class="toggle-row">
                <div class="toggle-row-label">
                  <strong>Require email verification on claim</strong>
                  <span>Client must verify their email before reward is released</span>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="require_email_verify" role="switch"
                    {{ $settings->require_email_verify ? 'checked' : '' }}>
                </div>
              </div>
            </div>

            <div class="col-12 mt-2">
              <label class="form-label fw-semibold mb-3 d-block">Admin Access</label>

              <div class="toggle-row">
                <div class="toggle-row-label">
                  <strong>Two-factor authentication</strong>
                  <span>Require 2FA for all admin logins</span>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="require_2fa" role="switch"
                    {{ $settings->require_2fa ? 'checked' : '' }}>
                </div>
              </div>

              <div class="toggle-row">
                <div class="toggle-row-label">
                  <strong>Session timeout</strong>
                  <span>Automatically log out inactive admin sessions</span>
                </div>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="session_timeout_enabled" role="switch"
                    id="sessionTimeoutToggle"
                    {{ $settings->session_timeout_enabled ? 'checked' : '' }}>
                </div>
              </div>

              <div class="mt-3" id="sessionTimeoutRow" style="{{ $settings->session_timeout_enabled ? '' : 'display:none' }}">
                <label class="form-label fw-semibold">Timeout after (minutes)</label>
                <input type="number" name="session_timeout_minutes" class="form-control"
                  style="max-width:180px;" min="5"
                  value="{{ old('session_timeout_minutes', $settings->session_timeout_minutes) }}">
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Allowed Admin IP Addresses</label>
              <textarea name="allowed_ips" class="form-control" rows="3"
                placeholder="One IP per line. Leave blank to allow all.">{{ old('allowed_ips', $settings->allowed_ips) }}</textarea>
              <div class="form-text">Restrict admin panel access to specific IPs. Use with caution.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Max Login Attempts</label>
              <input type="number" name="max_login_attempts" class="form-control" min="3" max="20"
                value="{{ old('max_login_attempts', $settings->max_login_attempts) }}">
              <div class="form-text">Account locked after this many failed login attempts.</div>
            </div>
          </div>
        </div>
        <div class="save-bar">
          <span class="saved-indicator" id="savedSecurity"><i class="ti ti-circle-check"></i> Saved</span>
          <button type="submit" name="section" value="security" class="btn btn-primary px-4">
            <i class="ti ti-device-floppy me-1"></i> Save Security Settings
          </button>
        </div>
      </div>

    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ── Section nav ──
  const navLinks = document.querySelectorAll('.settings-nav .nav-link');
  const sections = document.querySelectorAll('.settings-section');

  navLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const target = this.dataset.section;
      navLinks.forEach(l => l.classList.remove('active'));
      sections.forEach(s => s.classList.remove('active'));
      this.classList.add('active');
      document.getElementById('section-' + target)?.classList.add('active');
    });
  });

  // ── Color swatches ──
  const swatches   = document.querySelectorAll('.color-swatch');
  const colorInput = document.getElementById('accentColorPicker');

  swatches.forEach(sw => {
    sw.addEventListener('click', function () {
      swatches.forEach(s => s.classList.remove('selected'));
      this.classList.add('selected');
      colorInput.value = this.dataset.color;
    });
  });

  colorInput.addEventListener('input', function () {
    swatches.forEach(s => s.classList.remove('selected'));
  });

  // ── Show/hide SMTP password ──
  const smtpPassInput = document.getElementById('smtpPass');
  const smtpPassBtn   = document.getElementById('toggleSmtpPass');
  if (smtpPassBtn) {
    smtpPassBtn.addEventListener('click', function () {
      const isText = smtpPassInput.type === 'text';
      smtpPassInput.type = isText ? 'password' : 'text';
      this.querySelector('i').className = isText ? 'ti ti-eye' : 'ti ti-eye-off';
    });
  }

  // ── Send test email ──
  const testBtn    = document.getElementById('sendTestEmail');
  const testResult = document.getElementById('smtpTestResult');
  if (testBtn) {
    testBtn.addEventListener('click', function () {
      const addr = document.getElementById('testEmailAddr').value.trim();
      if (!addr) {
        testResult.innerHTML = '<span class="smtp-test-badge fail"><i class="ti ti-x"></i> Enter an email address first</span>';
        return;
      }
      testBtn.disabled = true;
      testBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Sending…';

      fetch('{{ url("/admin/general-settings/test-email") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ email: addr })
      })
      .then(r => r.json())
      .then(data => {
        testResult.innerHTML = data.success
          ? '<span class="smtp-test-badge success"><i class="ti ti-circle-check"></i> Test email sent successfully</span>'
          : `<span class="smtp-test-badge fail"><i class="ti ti-alert-circle"></i> ${data.message ?? 'Failed to send'}</span>`;
      })
      .catch(() => {
        testResult.innerHTML = '<span class="smtp-test-badge fail"><i class="ti ti-alert-circle"></i> Request failed</span>';
      })
      .finally(() => {
        testBtn.disabled = false;
        testBtn.innerHTML = '<i class="ti ti-send me-1"></i> Send Test';
      });
    });
  }

  // ── Session timeout toggle ──
  const sessionToggle = document.getElementById('sessionTimeoutToggle');
  const sessionRow    = document.getElementById('sessionTimeoutRow');
  if (sessionToggle) {
    sessionToggle.addEventListener('change', function () {
      sessionRow.style.display = this.checked ? '' : 'none';
    });
  }

  // ── Switch back to saved tab after submit ──
  @if(session('success') && session('saved_section'))
    const savedEl  = document.getElementById('saved{{ \Illuminate\Support\Str::studly(session("saved_section")) }}');
    const savedNav = document.querySelector('[data-section="{{ session("saved_section") }}"]');
    if (savedNav)  savedNav.click();
    if (savedEl) {
      savedEl.classList.add('show');
      setTimeout(() => savedEl.classList.remove('show'), 3000);
    }
  @endif

});
</script>
@endpush