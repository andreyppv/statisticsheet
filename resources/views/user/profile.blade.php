@extends('layouts.default')

@section('content')

    <div class="container" style="margin-top:100px;">
        <div class="col-md-6 col-md-offset-3">
            @include('layouts.default.notification')

            <form class="form-horizontal" role="form" method="POST" action="{{ route('user.update') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ?: $currentUser->email }}" required disabled>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Name</label>

                    <div class="col-md-8">
                        <input id="name" type="name" class="form-control" name="name" value="{{ old('name') ?: $currentUser->name  }}"  autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('additional')

@endsection

@section('scripts')
    <script src="{{ asset('js/pages/dashboard/index.js') }}"></script>
@endsection