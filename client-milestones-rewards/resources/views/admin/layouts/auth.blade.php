<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Admin — Client Milestones Rewards')</title>

  {{-- Template CSS --}}
  <link rel="stylesheet" href="{{ asset('admin/assets/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/icons.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/libs/simplebar/simplebar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/libs/node-waves/waves.min.css') }}">

  @stack('styles')
</head>

<body>

  @yield('content')

  {{-- Template JS (this is what makes theme toggle work like the template) --}}
  <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/main.js') }}"></script>

  @stack('scripts')
</body>
</html>