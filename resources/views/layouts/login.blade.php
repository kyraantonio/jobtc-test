<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Job.tc</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!--    {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>--}}-->
<!--
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
-->
<!--    <link href="{{ url('assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>-->
<!--    <link href="{{url('assets/css/page/login.css')}}" rel="stylesheet" type="text/css"/>-->
<!--    <link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css"/>-->
<!--    <link href="{{url('assets/custom.css')}}" rel="stylesheet" type="text/css"/>-->
    <link href="{{url('assets/material-dashboard/BS4/assets/css/material-dashboard.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</head>
<body class="login-body">

@yield('content')

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<!-- BS4 Material Design -->
<!-- {!! HTML::script('assets/material-dashboard/BS4/assets/js/bootstrap-material-design.min.js')  !!} -->
    
    <script src="/assets/material-dashboard/BS4/assets/js/core/jquery.min.js"></script>
    <script src="/assets/material-dashboard/BS4/assets/js/core/popper.min.js"></script>
    <script src="/assets/material-dashboard/BS4/assets/js/bootstrap-material-design.js"></script>
    
 <!--   Core JS Files   -->
    {!! HTML::script('assets/material-dashboard/BS4/assets/js/core/jquery.min.js') !!}
    {!! HTML::script('assets/material-dashboard/BS4/assets/js/core/popper.min.js') !!}
    {!! HTML::script('assets/material-dashboard/BS4/assets/js/bootstrap-material-design.js') !!}
    
    <!-- Material Dashboard Core initialisations of plugins and Bootstrap Material Design Library -->
    {!! HTML::script('assets/material-dashboard/BS4/assets/js/material-dashboard.js?v=2.0.0') !!}
<script>
    $(document).ready(function ($) {
        $("#login-form").validate();
        $("#install-form").validate();
        $("#forgotPassword-form").validate();
        setTimeout(function(){
            $('.alert').fadeTo(2000, 500).slideUp(500, function(){
                $(this).alert('close');
            });
        }, 1000);
    });
</script>
</body>
</html>