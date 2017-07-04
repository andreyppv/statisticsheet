<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('admin.layouts.front.head')
</head>
<body>
    <div class="canvas">
        @include('admin.layouts.front.header')

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            // --hide panel
            $(document).on("click", '#data-table-list [data-toggle="panel-collapse"]', function() {
                var $this = $(this);
                $panelparent = $this.closest('.panel');
                $panel = $this.closest('.panel').children('.panel-body');
                if (!$panelparent.hasClass('is-collapsedown')) {
                    $panelparent.addClass('is-collapsedown');
                    $panel.slideUp()
                    if ($this.hasClass('wb-chevron-up')) {
                        $this.removeClass('wb-chevron-up').addClass('wb-chevron-down');
                    }
                } else {
                    $panelparent.removeClass('is-collapsedown');
                    $panel.slideDown()
                    if ($this.hasClass('wb-chevron-down')) {
                        $this.removeClass('wb-chevron-down').addClass('wb-chevron-up');
                    }
                }
            });
        });
    </script>
</body>
</html>