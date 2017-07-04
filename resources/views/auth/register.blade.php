@extends('layouts.guest')

@section('content')

<div class="container" id="login-page">
    <div class="row">
        <div class="col-lg-7 hidden-sm hidden-xs">
            <div class="left-login">
                <h1>Create your future by using <span>Budgeting.pro</span> to save for you next</h1>

                <section class="rw-wrapper">
                    <h2 class="rw-sentence">

                        <div class="rw-words rw-words-1">
                            <span>car</span>
                            <span>house</span>
                            <span>shoe</span>
                            <span>wedding</span>
                            <span>christmas</span>
                        </div>
                    </h2>
                </section>

                <div class="checklist">
                    <div class="checklist-item">
                        <button type="button" class="btn btn-icon btn-success btn-round"><i class="icon wb-check" aria-hidden="true"></i></button>
                        <p>Know how much monet you're making</p>
                    </div>
                    <div class="checklist-item">
                        <button type="button" class="btn btn-icon btn-success btn-round"><i class="icon wb-check" aria-hidden="true"></i></button>
                        <p>Learn how to save your money</p>
                    </div>
                    <div class="checklist-item">
                        <button type="button" class="btn btn-icon btn-success btn-round"><i class="icon wb-check" aria-hidden="true"></i></button>
                        <p>Track your spending & save more</p>
                    </div>
                    <div class="checklist-item">
                        <button type="button" class="btn btn-icon btn-success btn-round"><i class="icon wb-check" aria-hidden="true"></i></button>
                        <p>Set saving goals</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-5">

            <h1 class="sign-up-title">SIGN UP</h1>
            <p class="sign-up-subtle">ITS FREE AND EASY TOOL TO HELP YOU SAVE</p>

            <form class="" id="form-sign-up" autocomplete="off" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="row ">
                    <div class="col-lg-6 col-md-6 col-sm-6 nopaddright">
                        <div class="form-group">
                            <input type="text" class="form-control" id="first-name" name="first_name" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6  nopaddleft">
                        <div class="form-group">
                            <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name" required>
                        </div>
                    </div>
                </div>

                <div class="form-group {{ $errors->has('reg_email') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" id="reg_email" name="reg_email" value="{{ old('reg_email') }}" placeholder="Mobile number or email" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('reg_email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('email_confirmation') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" id="email-confirm" name="email_confirmation" value="{{ old('email_confirmation') }}" placeholder="Re-enter mobile number or email" required>

                    @if ($errors->has('email_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" id="password" name="password" placeholder="New password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn btn-lg btn-success pull-left" id="sign-up-button">Sign Up</button>

                <span class="sepButton">or</span>
                <a class="btn btn-social  btn-facebook pull-right">
                    <span class="fa fa-facebook"></span><span> Sign up with Facebook</span>
                </a>

                <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>

            </form>

        </div>

    </div>
</div>

@endsection
