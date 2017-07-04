<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('admin.layouts.default.head')
</head>
<body>
    <div id="wrapper">
        @include('admin.layouts.default.header')

        <div id="page-wrapper">
            @yield('content')
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    @yield('additional')

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/metisMenu/dist/metisMenu.min.js') }}"></script>
    @yield('plugin-scripts')

    <script src="{{ asset('admins/js/sb-admin-2.js') }}"></script>
    @yield('scripts')
</body>
</html>
