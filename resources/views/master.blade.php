<?php
$assets = [];
?>
@include('layouts.head')
<body>

@include('layouts.header')

<div class="wrapper row-offcanvas row-offcanvas-left">
    <section class="content">
        {{ \App\Helpers\Helper::showMessage() }}

        <div class="row">
            <div class="col-md-12">
            @yield('content')
            </div>
        </div>
    </section>
</div>

@include('layouts.foot')