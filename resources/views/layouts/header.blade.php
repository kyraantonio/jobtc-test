@if (Auth::check('user'))
<nav class="navbar navbar-default navbar-static-top navbar-border" role="navigation">
    <div class="" id="navbar">
        {{--<ul class="nav navbar-nav">--}}
        @include('layouts.menu')
        {{--</ul>--}}
        {{--<ul class="nav navbar-nav pull-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>{{ Auth::user('user')->name }} <i class="caret"></i></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ url('/profile') }}"><i class="glyphicon glyphicon-user"></i> My Profile</a>
            </li>
            <li role="separator" class="divider"></li>
            <li>
                <a href="{{ url('/logout') }}"><i class="glyphicon glyphicon-off"></i> Logout</a>
            </li>
        </ul>
        </li>
        </ul>--}}
    </div>
</nav>
@endif