<section class="header">

    <nav class="navbar navbar-default " role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('home') }}">Budgeting.pro</a>
            </div>

            <div class="collapse navbar-collapse navbar-collapse-group" id="example-navbar-default-collapse">
                @include('layouts.guest.login_form')
            </div>

            <div class="collapse navbar-search-overlap" id="example-navbar-default-search">
                @include('layouts.guest.search_form')
            </div>
        </div>
    </nav>

</section>