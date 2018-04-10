@extends('layouts.login')
@section('content')
<!-- resources/views/auth/login.blade.php -->
<div class="content-container">
    <div class="main-content-container col-xs-12">
        @if (count($errors->login) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->login->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="login-container">
            <div class="col-xs-12">
                <div class="space"></div>
                <form action="{{url('login')}}" method="post" class="account_form" id="login-form">

                    {!! csrf_field() !!}

                    <div class="input-group">
                        <!--label for="login_email">Email</label><br/-->
                        <span class="input-group-addon" id="email-span"><i class="fa fa-envelope"></i></span>
                        <input type="email" class="form-control" aria-describedby="email-span" placeholder="Email" required="" autofocus="" name="email" tabindex="1" id="login_email" value="{{ Request::old('email') }}" />
                    </div>
                    <br />
                    <div class="input-group">
                        <!--label for="login_password">Password</label><br/-->
                        <span class="input-group-addon" id="password-span"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" aria-describedby="password-span" placeholder="Password" required="" name="password" tabindex="2" id="login_password" value="" />
                    </div>
                    <div class="input-group">
                        <div class="checkbox">
                            <input type="checkbox" name="remember" tabindex="3" value="forever" checked/> 
                            <label for="remember">Remember me</label>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="submit" class="btn btn-edit btn-shadow submit" name="login" tabindex="4" value="Login" />
                        <a href="{{ url('forgotPassword') }}" class="lostpass space" href="" title="Password Lost and Found">Lost your password?</a><br>
                        <p style="font-size:16px;text-indent:77px;">New member?<a href="{{ url('register') }}" class="lostpass space" href="" title="Sig up">Sign up now!</a></p>
                    </div>
                </form>
                <div class="space"></div>
            </div>
        </div><!-- end section_header -->
    </div>
</div>
@stop




