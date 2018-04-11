<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Job.tc</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('assets/css/page/login.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/material-dashboard/BS4/assets/css/material-dashboard.min.css')}}" rel="stylesheet" type="text/css"/>
</head>
<body>

@yield('content')

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
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