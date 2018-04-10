<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"
      type="text/css"/>

<link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
{!!  HTML::style('assets/custom.css')  !!}
{!!  HTML::style('assets/css/AdminLTE.css')  !!}
<title>Print</title>
<body>
@include('common.billing',['billing' => $billing, 'client' => $client, 'items' => $items])
</body>