@extends('layouts.login') @section('content')
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
                <form action="{{url('register')}}" method="post" class="account_form container" id="register-form">

                    {!! csrf_field() !!}
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="name-span"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control text required" aria-describedby="name-span" placeholder="Name" name="name" tabindex="1" id="login_name" value="{{ old('name') }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="email-span"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="text" class="form-control text required" aria-describedby="email-span" placeholder="Email" name="email" tabindex="1" id="login_email" value="{{ old('email') }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="password-span"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control text required" aria-describedby="password-span" placeholder="Password" name="password" tabindex="2" id="login_password" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                         <input type="submit" class="btn btn-edit btn-primary btn-block submit" name="register" tabindex="4" value="Register" />
                        <small class="form-text text-muted">By clicking “REGISTER”, you agree to our terms of service and privacy statement.</small>
                    </div>
                </form>
                <div class="col-12 text-center container">
                    <a href="{{url('login')}}"><i class="fa fa-chevron-left"></i> Go Back</a>
                </div>
            </div>
            <!-- end section_header -->
        </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function($) {
            $("#login-form").validate();
            $("#install-form").validate();
            $("#forgotPassword-form").validate();
            setTimeout(function() {
                $('.alert').fadeTo(2000, 500).slideUp(500, function() {
                    $(this).alert('close');
                });
            }, 1000);
        });

    </script>
    @stop
