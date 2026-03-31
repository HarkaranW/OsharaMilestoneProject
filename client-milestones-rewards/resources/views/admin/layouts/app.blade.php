<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @php
    $generalSettings = \App\Models\GeneralSetting::instance();

    // Convert hex accent color to RGB for CSS variable
    $hex = ltrim($generalSettings->accent_color ?? '#3b82f6', '#');
    $r   = hexdec(substr($hex, 0, 2));
    $g   = hexdec(substr($hex, 2, 2));
    $b   = hexdec(substr($hex, 4, 2));
  @endphp

  <title>@yield('title', $generalSettings->app_name . ' — Admin')</title>

  {{-- Favicon --}}
  @if($generalSettings->favicon)
    <link rel="icon" href="{{ asset('storage/' . $generalSettings->favicon) }}">
  @endif

  {{-- Runs before anything renders — restores saved theme on every page load --}}
  <script>
    (function () {
      const mode = localStorage.getItem('admin_theme_mode') || 'light';
      const html = document.documentElement;
      html.setAttribute('data-theme-mode', mode);
      html.setAttribute('data-menu-styles', mode);
      html.setAttribute('data-header-styles', mode);
    })();
  </script>

  <script src="{{ asset('admin/assets/js/main.js') }}"></script>

  <link id="style" href="{{ asset('admin/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/css/styles.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/libs/node-waves/waves.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">

  {{-- ── General Settings: accent color override ── --}}
  <style>
    :root {
      --primary-color: {{ $generalSettings->accent_color ?? '#3b82f6' }};
      --primary-rgb: {{ $r }}, {{ $g }}, {{ $b }};
      --primary01: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.1);
      --primary02: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.2);
      --primary03: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.3);
      --primary05: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.5);
      --primary08: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.8);
      --primary-border-color: {{ $generalSettings->accent_color ?? '#3b82f6' }};
    }

    /* Force Bootstrap + template buttons/badges to use the accent color */
    .btn-primary {
      background-color: {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
      border-color:     {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
    }
    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active {
      filter: brightness(0.9);
      background-color: {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
      border-color:     {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
    }
    .btn-outline-primary {
      color:        {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
      border-color: {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
    }
    .btn-outline-primary:hover {
      background-color: {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
      color: #fff !important;
    }
    .badge.bg-primary,
    .bg-primary {
      background-color: {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
    }
    .text-primary {
      color: {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
    }
    a:not(.btn):not(.nav-link):not(.dropdown-item):not(.header-link) {
      color: {{ $generalSettings->accent_color ?? '#3b82f6' }};
    }
    .form-check-input:checked {
      background-color: {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
      border-color:     {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
    }
    .nav-link.active,
    .settings-nav .nav-link.active {
      background-color: {{ $generalSettings->accent_color ?? '#3b82f6' }} !important;
    }

    /* No focus ring / hover bg on header links */
    .app-header .header-link,
    .app-header .header-link-1,
    .app-header .header-link.dropdown-toggle,
    .app-header .header-link-1.dropdown-toggle {
      outline: none !important;
      box-shadow: none !important;
    }

    .app-header .header-link:focus,
    .app-header .header-link:active,
    .app-header .header-link-1:focus,
    .app-header .header-link-1:active,
    .app-header .dropdown-toggle:focus,
    .app-header .dropdown-toggle:active {
      outline: none !important;
      box-shadow: none !important;
    }

    .app-header .header-link:hover,
    .app-header .header-link:active,
    .app-header .header-link-1:hover,
    .app-header .header-link-1:active {
      background: transparent !important;
    }

    /* Dark mode readability */
    html[data-theme-mode="dark"] body {
      color: rgba(255,255,255,0.88) !important;
    }

    html[data-theme-mode="dark"] h1,
    html[data-theme-mode="dark"] h2,
    html[data-theme-mode="dark"] h3,
    html[data-theme-mode="dark"] h4,
    html[data-theme-mode="dark"] h5,
    html[data-theme-mode="dark"] h6,
    html[data-theme-mode="dark"] .page-title,
    html[data-theme-mode="dark"] .fw-semibold,
    html[data-theme-mode="dark"] .card-title,
    html[data-theme-mode="dark"] .custom-card .card-title,
    html[data-theme-mode="dark"] .fw-bold {
      color: rgba(255,255,255,0.92) !important;
    }

    html[data-theme-mode="dark"] .card .card-body,
    html[data-theme-mode="dark"] .custom-card .card-body {
      color: rgba(255,255,255,0.84) !important;
    }

    /* Icon button: no highlight */
    .btn-icon,
    .btn-icon:hover,
    .btn-icon:focus,
    .btn-icon:active,
    .btn-icon:focus-visible {
      background-color: transparent !important;
      border-color: transparent !important;
      box-shadow: none !important;
      outline: none !important;
    }

    /* Force trash icon red */
    .btn-delete,
    .btn-delete i {
      color: #dc3545 !important;
    }
  </style>

  @stack('styles')
</head>

<body>
  @includeIf('admin.partials.search-modal')
  @includeIf('admin.partials.switcher')

  <div class="page">
    @include('admin.partials.topbar')
    @include('admin.partials.sidebar')

    <div class="main-content app-content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>
  </div>

  <div id="responsive-overlay"></div>

  <script src="{{ asset('admin/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
  <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/defaultmenu.min.js') }}"></script>
  <script src="{{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/sticky.js') }}"></script>
  <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/simplebar.js') }}"></script>
  {{-- custom-switcher removed — conflicts with our toggle below --}}
  <script src="{{ asset('admin/assets/js/custom.js') }}"></script>

  {{-- Theme toggle: saves to admin_theme_mode and applies immediately --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggle = document.getElementById('themeToggle');
      if (!toggle) return;

      toggle.addEventListener('click', function (e) {
        e.preventDefault();
        const html = document.documentElement;
        const current = localStorage.getItem('admin_theme_mode') || 'light';
        const next = current === 'dark' ? 'light' : 'dark';

        html.setAttribute('data-theme-mode', next);
        html.setAttribute('data-menu-styles', next);
        html.setAttribute('data-header-styles', next);
        localStorage.setItem('admin_theme_mode', next);

        // Also sync the other keys your template may read
        localStorage.setItem('admin.theme', next);
        localStorage.setItem('admin.themeMode', next);
      });
    });
  </script>

  @stack('scripts')
</body>
</html>