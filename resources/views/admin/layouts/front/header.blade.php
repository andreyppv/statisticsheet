<section class="header">

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="collapse navbar-collapse navbar-collapse-group" id="example-navbar-default-collapse">
                <ul class="nav navbar-toolbar navbar-left">
                    <li class="dropdown">
                        <a href="#">
                            <div class="btn-round profile-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                            <span class="text">{{ $selectedUser->name }}</span>
                            <!--<span class="caret"></span>-->
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-toolbar navbar-right">
                    <li>
                        <a href="{{ route('admin.user.list') }}">Back</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</section>