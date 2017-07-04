<form class="" id="form-login" autocomplete="off" role="form" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <ul class="nav navbar-toolbar navbar-right">

        <li>
            <div class="form-group">
                <input type="text" class="form-control" id="email" name="email"  value="{{ old('email') }}" placeholder="Email or Phone" required autofocus>
            </div>
        </li>
        <li>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <a data-target="#change-background-image" data-toggle="modal" class="forgot-account">Forgot account ?</a>
            </div>
        </li>
        <li>
            <button type="submit" class="btn btn-block btn-success" id="login-button">Login</button>
        </li>

    </ul>
</form>