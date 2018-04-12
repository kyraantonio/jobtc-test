@if (Auth::check('user'))
<div class="main-panel">
<nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top" id="navbar" role="navigation">
        {{--<ul class="navbar-nav">--}}
        @include('layouts.menu')
        {{--</ul>--}}
        {{--<ul class="navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>{{ Auth::user('user')->name }} <i class="caret"></i></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ url('/profile') }}"><i class="material-icons">person</i> My Profile</a>
            </li>
            <li role="separator" class="divider"></li>
            <li>
                <a href="{{ url('/logout') }}"><i class="material-icons">exit_to_app</i></i> Logout</a>
            </li>
        </ul>
        </li>
        </ul>--}}
</nav>
</div>
@endif