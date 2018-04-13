@if (Auth::check('user'))
<div class="main-panel">
    {{--<ul class="navbar-nav">--}}
    @include('layouts.menu')
    {{--</ul>--}}
    <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top" id="navbar" role="navigation">
            
            <div class="container-fluid">
                <!-- <div class="container-fluid navbar-wrapper"> -->
                    <div class="float-left">
                        <h3 class="navbar-brand">Name of Company Here</h3>
                    </div>
                    <button class="navbar-toggler justify-content-end" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        {{--*/$modules = \App\Helpers\Helper::getSearchModules()/*--}}
                        <select class="btn btn-outline-primary dropdown-toggle"  type="button" aria-haspopup="true" aria-expanded="false">
                            @foreach($modules as $module)
                            <option value="{{strtolower(str_singular($module->name))}}">{{$module->name}}</option>
                            @endforeach
                        </select>
                        <form class="navbar-form">
                            <div class="input-group no-border ">
                                <i class="material-icons">search</i>
                                <input type="text" id="search-field" class="form-control" placeholder="Search...">
                            </div>
                        </form>
                    </div>
                <!-- </div> -->
            </div>
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