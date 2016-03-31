@extends('layouts.app')

@section('content')
    <div class="container">
        {{--<div class="col-md-8 col-md-offset-2">--}}
        {{--<div class="panel panel-default">--}}
        {{--<div class="panel-heading">Login</div>--}}
        {{--<div class="panel-body">--}}
        {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">--}}
        {{--{!! csrf_field() !!}--}}

        {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
        {{--<label class="col-md-4 control-label">E-Mail Address</label>--}}

        {{--<div class="col-md-6">--}}
        {{--<input type="email" class="form-control" name="email" value="{{ old('email') }}">--}}

        {{--@if ($errors->has('email'))--}}
        {{--<span class="help-block">--}}
        {{--<strong>{{ $errors->first('email') }}</strong>--}}
        {{--</span>--}}
        {{--@endif--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
        {{--<label class="col-md-4 control-label">Password</label>--}}

        {{--<div class="col-md-6">--}}
        {{--<input type="password" class="form-control" name="password">--}}

        {{--@if ($errors->has('password'))--}}
        {{--<span class="help-block">--}}
        {{--<strong>{{ $errors->first('password') }}</strong>--}}
        {{--</span>--}}
        {{--@endif--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
        {{--<div class="col-md-6 col-md-offset-4">--}}
        {{--<div class="checkbox">--}}
        {{--<label>--}}
        {{--<input type="checkbox" name="remember"> Remember Me--}}
        {{--</label>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
        {{--<div class="col-md-6 col-md-offset-4">--}}
        {{--<button type="submit" class="btn btn-primary">--}}
        {{--<i class="fa fa-btn fa-sign-in"></i>Login--}}
        {{--</button>--}}

        {{--<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</form>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="login-box">
            <div class="login-logo">
                <a href="/">
                    <span class="logo-lg">
                        <img src="{{ asset('images/logo_login.png') }}" class="img-responsive">
                    </span>
                </a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form role="form" method="POST" action="{{ url('/login') }}">
                    {!! csrf_field() !!}
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" name="email"
                               value="{{ old('email') }}" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password"
                               name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit"
                                    class="btn btn-primary btn-block btn-flat">Sign in
                            </button>
                        </div>
                    </div>
                </form>

                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i
                                class="fa fa-facebook"></i> Sign in using Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i
                                class="fa fa-google-plus"></i> Sign in using Google+</a>
                </div>

                <a class="forgot" href="{{ url('/password/reset') }}">Забыли пароль?</a><br>
                <a href="{{ url('/register') }}">Регистрация</a></li>
            </div>
        </div>
    </div>
@endsection
