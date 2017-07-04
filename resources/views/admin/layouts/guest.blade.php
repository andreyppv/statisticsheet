<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('admin.layouts.default.head')
</head>
<body class="guest-page">
    <div class="canvas">
        @yield('content')
    </div>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
