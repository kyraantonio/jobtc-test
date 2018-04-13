@include('layouts.head')
<body>

@include('layouts.header')
<div class="main-panel">

    {{ \App\Helpers\Helper::showMessage() }}
    @yield('content')
    
</div>
@include('layouts.foot')