<section class="header">

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle hamburger hamburger-close collapsed sidebarbut" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="hamburger-bar"></span>
                </button>

                <a class="navbar-brand" href="{{ route('home') }}">Budgeting.pro</a>
            </div>

            <div class="collapse navbar-collapse navbar-collapse-group" id="example-navbar-default-collapse">
                <ul class="nav navbar-toolbar navbar-left">
                    {{--<li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="scale-up" role="button">
                            <div class="btn-round profile-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                            <span class="text">{{ $currentUser->name }}</span>
                            <!--<span class="caret"></span>-->
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem">Action</a></li>
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem">Another action</a></li>
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem">Something else here</a></li>
                            <li class="divider" role="presentation"></li>
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem">Separated link</a></li>
                        </ul>
                    </li>--}}
                    <li>
                        <a href="{{ route('user.profile') }}">
                            <div class="btn-round profile-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                            <span class="text">{{ $currentUser->name }}</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-toolbar navbar-right">
                    <li><a href="#">Help</a></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>

            <div class="collapse navbar-search-overlap" id="example-navbar-default-search">
                <form role="search">
                    <div class="form-group">
                        <div class="input-search">
                            <i class="input-search-icon wb-search" aria-hidden="true"></i>
                            <input type="text" class="form-control" name="site-search" placeholder="Search...">
                            <button type="button" class="input-search-close icon wb-close" data-target="#example-navbar-default-search" data-toggle="collapse" aria-label="Close"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>

</section>