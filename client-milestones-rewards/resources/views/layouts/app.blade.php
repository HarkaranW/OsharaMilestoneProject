<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Oshara')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body>

    <div class="card">
        @include('partials.header')

        <div class="content">
            @yield('content')
        </div>

        @include('partials.footer')
    </div>

</body>
</html>
