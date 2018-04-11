@extends('layouts.login') @section('content')
<!-- resources/views/auth/login.blade.php -->
<div class="container d-flex align-self-center justify-content-center">
    @if (count($errors->login) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->login->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
    @endif
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{url('login')}}" method="post" class="account_form" id="login-form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                            </div>
                            <input type="email" class="form-control" aria-describedby="email-span" placeholder="Email" required="" autofocus="" name="email" tabindex="1" id="login_email" value="{{ Request::old('email') }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="fa fa-unlock"></i>
                            </span>
                            </div>
                           <input type="password" class="form-control" aria-describedby="password-span" placeholder="Password" required="" name="password" tabindex="2" id="login_password" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="forever" checked name="remember"> Remember Me
                            <span class="form-check-sign"><span class="check"></span>
                            </span>
                        </label>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-edit btn-info submit btn-block" name="login" tabindex="4" value="Login" />
                    <p class="text-right">
                        <a href="{{ url('forgotPassword') }}" class="lostpass text-info" title="Password Lost and Found">Forgot Password?</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end section_header -->
@stop
