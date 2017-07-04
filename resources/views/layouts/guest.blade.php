<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('layouts.default.head')
</head>
<body class="guest-page">
    <div class="canvas">
        @include('layouts.guest.header')

        @yield('content')

        @include('layouts.default.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
