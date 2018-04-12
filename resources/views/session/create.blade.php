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
    <div class="col-md-4 login">
        <div class="card card-profile">
            <div class="card-avatar">
                <a href="{{url('login')}}">
                    <img class="img" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4d/Circle-icons-briefcase.svg/2000px-Circle-icons-briefcase.svg.png"/>
                </a>
            </div>
            <div class="card-body">
                <form action="{{url('login')}}" method="post" class="account_form container" id="login-form">
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
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="">
                                <div class="checkbox">
                                    <input type="checkbox" name="remember" tabindex="3" value="forever" checked/>
                                    <label for="remember">Remember me</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="">
                                <a href="{{ url('forgotPassword') }}" class="lostpass text-info" title="Password Lost and Found">Forgot Password?</a>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-edit btn-info submit btn-block" name="login" tabindex="4" value="LOGIN"/>

                    <a href="{{ url('register') }}" class="btn btn-primary btn-block" title="Password Lost and Found">SIGN UP</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end section_header -->
@stop
