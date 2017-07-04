<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('layouts.default.head')
</head>
<body>
    <div class="canvas">
        @include('layouts.default.header')

        @yield('content')

        @include('layouts.default.footer')
    </div>

    @yield('additional')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('plugins')
    @yield('scripts')
</body>
</html>
