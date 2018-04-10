<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Job.tc</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>--}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{ url('assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/css/page/register.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/custom.css')}}" rel="stylesheet" type="text/css"/>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style>
        </style>
    </head>
    <body class="login-body">

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

                        <form action="{{url('register')}}" method="post" class="account_form" id="register-form">

                            {!! csrf_field() !!}

                            <div class="input-group">
                                <span class="input-group-addon" id="name-span"><i class="fa fa-user" aria-hidden="true"></i></span>
                                <input type="text" class="form-control text required" aria-describedby="name-span" placeholder="Name" name="name" tabindex="1" id="login_name" value="{{ old('name') }}" />
                            </div>
                            <br />
                            <div class="input-group">
                                <span class="input-group-addon" id="email-span"><i class="fa fa-envelope"></i></span>
                                <input type="text" class="form-control text required" aria-describedby="email-span" placeholder="Email" name="email" tabindex="1" id="login_email" value="{{ old('email') }}" />
                            </div>
                            <br />
                            <div class="input-group">
                                <span class="input-group-addon" id="password-span"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control text required" aria-describedby="password-span" placeholder="Password" name="password" tabindex="2" id="login_password" value="" />
                            </div>
                            <br/>
                            <div class="input-group pull-right">
                                <input type="submit" class="btn btn-edit btn-shadow submit" name="register" tabindex="4" value="Register" />
                            </div>
                        </form>

                    </div>
                </div><!-- end section_header -->
            </div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
        <script>
$(document).ready(function ($) {
    $("#login-form").validate();
    $("#install-form").validate();
    $("#forgotPassword-form").validate();
    setTimeout(function () {
        $('.alert').fadeTo(2000, 500).slideUp(500, function () {
            $(this).alert('close');
        });
    }, 1000);
});
        </script>
    </body>
</html>