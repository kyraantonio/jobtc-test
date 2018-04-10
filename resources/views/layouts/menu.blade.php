<div class="container-fluid">
    <div class="sidebar" data-color="purple" data-background-color="white">
        <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text logo-normal">
                    Job TC
                </a>
        </div>
        <div id="dl-menu" class="sidebar-wrapper">
            <ul class="nav">
                @if(Auth::check())
                {{--*/ $companies = \App\Helpers\Helper::getCompanyLinks() /*--}}
                <li class="nav-item">
                    <a class="nav-link" href="#add_company" data-toggle="modal"><i class="material-icons">add</i> <span>New Company</span></a>
                </li>
                @if(count($companies) > 0)
                @foreach($companies as $company)
                @if($company->company->deleted_at === NULL)
                {{--*/ $module_permissions = \App\Helpers\Helper::getPermissions($company->company->id) /*--}}
                <li  class="nav-item dropdown">
                    <a class="nav-link" id="navbarCompanyDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="{{ url('company/' . $company->company->id) }}">
                        <i class="material-icons">account_balance</i> <span>{{ $company->company->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarCompanyDropdown">
                        <a class="dropdown-item" href="{{ url('company/' . $company->company->id) }}">
                            <i class="material-icons" aria-hidden="true">dashboard</i>
                            Dashboard
                        </a>
                        @if($module_permissions->where('slug','view.projects')->count() === 1)
                        <a class="dropdown-item nav-link" id="navbarProjectDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">
                            <i class="material-icons" aria-hidden="true">folder</i>
                            <p> Projects </p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarProjectDropdown">
                            <a class="dropdown-item" href="#">back</a>

                            @if($module_permissions->where('slug','create.projects')->count() === 1)
                                <a class="dropdown-item" href="#add_project" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> <span>New Project</span></a>
                            @endif
                            <ul class="dl-submenu">
                                <li class="dl-back"><a href="#">back</a></li>
                                @if($module_permissions->where('slug','create.projects')->count() === 1)
                                <li>
                                    <a href="#add_project" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> <span>New Project</span></a>
                                </li>
                                @endif
                                <li class="divider"></li>
                                <li>
                                    <a href="{{url('company/'.$company->company->id.'/projects')}}">
                                        <i class="fa fa-folder-open"></i>
                                        <span> All Projects </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-folder-open"></i>
                                        <span> My Projects </span>
                                    </a>
                                    <ul class="dl-submenu">
                                        <li class="dl-back"><a href="#">back</a></li>
                                        {{--*/ $my_projects = \App\Helpers\Helper::getMyProjects($company->company->id) /*--}}
                                        @if(count($my_projects) > 0)
                                        @foreach($my_projects as $val)
                                        <li class="{{ count($val->task) > 0 ? 'dropdown' : '' }}">
                                            <a href="{{ url('project/' . $val->project_id ) }}">
                                                <i class="fa fa-briefcase" aria-hidden="true"></i> <span>{{ $val->project_title }}</span>
                                            </a>
                                            @if(count($val->task) > 0)
                                            <ul class="dropdown-menu">
                                                @foreach($val->task as $briefcase)
                                                <li class="dropdown">
                                                    <a href="{{ url('briefcase/' .$briefcase->task_id) }}"><i class="fa fa-bars" aria-hidden="true"></i> {{ $briefcase->task_title }}</a>
                                                    @if(count($briefcase->task_list_items) > 0)
                                                    <ul class="dropdown-menu">
                                                        @foreach($briefcase->task_list_items as $task_list_item)
                                                        <li class="dropdown">
                                                            <a href="{{url('taskitem/'.$task_list_item->id)}}">
                                                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                {{$task_list_item->checklist_header}}
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-folder-open"></i>
                                        <span> Shared Projects </span>
                                    </a>
                                    <ul class="dl-submenu">
                                        <li class="dl-back"><a href="#">back</a></li>
                                        {{--*/ $shared_projects = \App\Helpers\Helper::getSharedProjects($company->company->id) /*--}}
                                        @if(count($shared_projects) > 0)
                                        @foreach($shared_projects as $val)
                                        {{--*/ $task_permissions = \App\Helpers\Helper::getBriefcasePermission($val->project_id) /*--}}
                                        <li class="{{ count($val->task) > 0 ? 'dropdown' : '' }}">
                                            <a href="{{ url('project/' . $val->project_id ) }}">
                                                <i class="fa fa-briefcase" aria-hidden="true"></i> <span>{{ $val->project_title }}</span>
                                            </a>
                                            @if(count($val->task) > 0)
                                            <ul class="dropdown-menu">
                                                @foreach($val->task as $briefcase)
                                                @if($task_permissions->contains('task_id',$briefcase->task_id))
                                                <li class="dropdown">
                                                    <a href="{{ url('briefcase/' .$briefcase->task_id) }}"><i class="fa fa-bars" aria-hidden="true"></i> {{ $briefcase->task_title }}</a>
                                                    @if(count($briefcase->task_list_items) > 0)
                                                    <ul class="dropdown-menu">
                                                        @foreach($briefcase->task_list_items as $task_list_item)
                                                        
                                                        <li class="dropdown">
                                                            <a href="{{url('taskitem/'.$task_list_item->id)}}">
                                                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                {{$task_list_item->checklist_header}}
                                                            </a>
                                                        </li>
                                                        
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </li>
                                                @endif
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        
                                        @endforeach
                                        @endif
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-folder-open"></i>
                                        <span> Subordinate Projects </span>
                                    </a>
                                    <ul class="dl-submenu">
                                        <li class="dl-back"><a href="#">back</a></li>
                                        {{--*/ $subordinate_projects = \App\Helpers\Helper::getSubordinateProjects($company->company->id) /*--}}
                                        @if(count($subordinate_projects) > 0)
                                        @foreach($subordinate_projects as $val)
                                        <li class="{{ count($val->task) > 0 ? 'dropdown' : '' }}">
                                            <a href="{{ url('project/' . $val->project_id ) }}">
                                                <i class="fa fa-briefcase" aria-hidden="true"></i> <span>{{ $val->project_title }}</span>
                                            </a>
                                            @if(count($val->task) > 0)
                                            <ul class="dropdown-menu">
                                                @foreach($val->task as $briefcase)
                                                <li class="dropdown">
                                                    <a href="{{ url('briefcase/' .$briefcase->task_id) }}"><i class="fa fa-bars" aria-hidden="true"></i> {{ $briefcase->task_title }}</a>
                                                    @if(count($briefcase->task_list_items) > 0)
                                                    <ul class="dropdown-menu">
                                                        @foreach($briefcase->task_list_items as $task_list_item)
                                                        <li class="dropdown">
                                                            <a href="{{url('taskitem/'.$task_list_item->id)}}">
                                                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                                {{$task_list_item->checklist_header}}
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </li>
                            </ul>

                        </div>

                        @endif
                        @if(Auth::check('user'))
                        @if($module_permissions->where('slug','view.jobs')->count() === 1)
                        <a class="dropdown-item" id="navbarJobDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="material-icons" aria-hidden="true">work</i>
                            <span>Jobs</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarJobDropdown">
                            <ul class="dl-submenu">
                                <li class="dl-back"><a href="#">back</a></li>
                                @if($module_permissions->where('slug','create.jobs')->count() === 1)
                                <li>
                                    <a href="#add_job" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> <span>New Job</span></a>
                                </li>
                                @endif
                                <li class="divider"></li>
                                <li>
                                    <a href="{{url('company/'.$company->company->id.'/jobs')}}">
                                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                                        <span>All Jobs</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                                        <span>My Jobs</span>
                                    </a>
                                    <ul class="dl-submenu">
                                        <li class="dl-back"><a href="#">back</a></li>
                                        {{--*/ $my_jobs = \App\Helpers\Helper::getMyJobs($company->company->id) /*--}}
                                        @if(count($my_jobs) > 0)
                                        @foreach($my_jobs as $job)
                                        <li class="{{ count($job->applicants) > 0 ? 'dropdown' : '' }}">
                                            <a href="{{ url('job/' . $job->id) }}" class="dropdown-toggle">
                                                <i class="fa fa-clipboard" aria-hidden="true"></i> <span>{{ $job->title }}</span>
                                            </a>
                                            @if(count($job->applicants) > 0)
                                            <ul class="dropdown-menu">
                                                @foreach($job->applicants as $applicants)
                                                <li>
                                                    <a href="{{ url('a/' . $applicants->id) }}"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> {{ $applicants->name }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                                        <span>Shared Jobs</span>
                                    </a>
                                    <ul class="dl-submenu">
                                        <li class="dl-back"><a href="#">back</a></li>
                                        {{--*/ $shared_jobs = \App\Helpers\Helper::getSharedJobs($company->company->id) /*--}}
                                        @if(count($shared_jobs) > 0)
                                        @foreach($shared_jobs as $job)
                                        <li class="{{ count($job->applicants) > 0 ? 'dropdown' : '' }}">
                                            <a href="{{ url('job/' . $job->id) }}" class="dropdown-toggle">
                                                <i class="fa fa-clipboard" aria-hidden="true"></i> <span>{{ $job->title }}</span>
                                            </a>
                                            @if(count($job->applicants) > 0)
                                            <ul class="dropdown-menu">
                                                @foreach($job->applicants as $applicants)
                                                <li>
                                                    <a href="{{ url('a/' . $applicants->id) }}"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> {{ $applicants->name }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                                        <span>Subordinate Jobs</span>
                                    </a>
                                    <ul class="dl-submenu">
                                        <li class="dl-back"><a href="#">back</a></li>
                                        {{--*/ $subordinate_jobs = \App\Helpers\Helper::getSubordinateJobs($company->company->id) /*--}}
                                        @if(count($subordinate_jobs) > 0)
                                        @foreach($subordinate_jobs as $job)
                                        <li class="{{ count($job->applicants) > 0 ? 'dropdown' : '' }}">
                                            <a href="{{ url('job/' . $job->id) }}" class="dropdown-toggle">
                                                <i class="fa fa-clipboard" aria-hidden="true"></i> <span>{{ $job->title }}</span>
                                            </a>
                                            @if(count($job->applicants) > 0)
                                            <ul class="dropdown-menu">
                                                @foreach($job->applicants as $applicants)
                                                <li>
                                                    <a href="{{ url('a/' . $applicants->id) }}"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> {{ $applicants->name }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        @endif <!--Permissions-->
                        @endif <!--Auth Check-->
                        @if($module_permissions->where('slug','view.tests')->count() === 1)
                        <a class="dropdown-item" href="{{ url('quizPerCompany/' . $company->company->id) }}">
                            <i class="material-icons">school</i>
                            <span>Test</span>
                        </a>
                        @endif
                        @if($module_permissions->where('slug','view.tickets')->count() === 1)
                        <a class="dropdown-item" id="navbarTicketsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="material-icons">local_movies</i>
                            <span>Tickets</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarTicketsDropdown">
                            <ul class="dl-submenu">
                                <li class="dl-back"><a href="#">back</a></li>
                                @if($module_permissions->where('slug','create.tickets')->count() === 1)
                                <li>
                                    <a href="#add_ticket" data-toggle="modal">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        <span>New Ticket</span>
                                    </a>
                                </li>
                                @endif
                                <li class="divider"></li>
                                <li>
                                    @if(Auth::user()->ticketit_admin)
                                    <a href="{{ url('tickets-admin') }}">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span>Ticket Dashboard</span>
                                    </a>
                                    @elseif(Auth::user()->ticketit_agent)
                                    <a href="{{ url('tickets') }}">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span>{{Lang::get('Ticket')}}</span>
                                    </a>
                                    @endif
                                </li>
                                <li>
                                    <a href="{{ url('tickets-admin?c=complete') }}" data-toggle="modal">
                                        <i class="glyphicon glyphicon-thumbs-up"></i>
                                        <span>Resolved Tickets</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @endif
                        @if($module_permissions->where('slug','view.employees')->count() === 1)
                        <a class="dropdown-item" href="{{url('/employees/'.$company->company->id)}}">
                            <i class="material-icons">group</i>
                            <span>Employees</span>
                        </a>
                        @endif
                        @if(Auth::user('user')->level() === 1 || $module_permissions->where('slug','view.employees')->count() === 1)
                        <a  class="dropdown-item" href="{{url('/positions/'.$company->company->id)}}">
                            <i class="material-icons">flag</i>
                            <span>Positions</span>
                        </a>
                        @endif
                        <a class="dropdown-item" href="{{url('/payroll/'.$company->company->id)}}">
                            <i class="material-icons">credit_card</i>
                            <span>Payroll</span>
                        </a>
                        @if(
                        $module_permissions->where('slug','assign.projects')->count() === 1 || 
                        $module_permissions->where('slug','assign.jobs')->count() === 1 || 
                        $module_permissions->where('slug','assign.tests')->count() === 1 || 
                        $module_permissions->where('slug','assign.positions')->count() === 1
                        )
                        <a class="dropdown-item" id="navbarTicketsDropdown" href="#">
                            <i class="fa fa-share-alt" aria-hidden="true"></i>
                            <span>Assign</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarTicketsDropdown">
                            <ul class="dl-submenu">
                                <li class="dl-back"><a href="#">back</a></li>
                                @if($module_permissions->where('slug','assign.projects')->count() === 1)
                                <li>
                                    <a href="{{url('/assignProjects/'.$company->company->id)}}">
                                        <i class="fa fa-folder-open"></i>
                                        <span>Projects</span>
                                    </a>
                                </li>
                                @endif
                                @if($module_permissions->where('slug','assign.jobs')->count() === 1)
                                <li>
                                    <a href="{{url('/assignJobs/'.$company->company->id)}}">
                                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                                        <span>Jobs</span>
                                    </a>
                                </li>
                                @endif
                                @if($module_permissions->where('slug','assign.tests')->count() === 1)
                                <li>
                                    <a href="{{url('/assignTests/'.$company->company->id)}}">
                                        <i class="glyphicon glyphicon-education"></i> 
                                        <span>Tests</span>
                                    </a>
                                </li>
                                @endif
                                @if($module_permissions->where('slug','assign.positions')->count() === 1)
                                <li>
                                    <a href="{{url('/assignAuthorityLevels/'.$company->company->id)}}">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                        <span>Authority Levels</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                            
                        @endif

                        <a class="dashboard-item" href="{{ url('companyLinks/'.$company->company->id) }}"><i class="fa fa-globe" aria-hidden="true"></i> Links</a>

                    </div>
                </li>
                @endif
                @endforeach
                @endif
                @endif
                <li class="divider"></li>
                <li class="nav-item">
                    <!--a href="https://laravel.software/jangouts/dist/#/rooms/1234?user={{Auth::user('user')->name}}"><i class="fa fa-th-large" aria-hidden="true"></i> Meeting Room</a-->
                    <a href="{{url('/discussions')}}"><i class="fa fa-th-large" aria-hidden="true"></i> Meeting Rooms</a>
                </li>
                <li class="nav-item">
                    <!--a href="https://laravel.software/jangouts/dist/#/rooms/1234?user={{Auth::user('user')->name}}"><i class="fa fa-th-large" aria-hidden="true"></i> Meeting Room</a-->
                    <a href="{{url('/indeed/importer')}}"><i class="fa fa-th-large" aria-hidden="true"></i> Indeed Importer</a>
                </li>
                <li class="nav-item">
                    <a target="_blank" href="{{ url('/dashboard') }}"><i class="material-icons">local_movies</i> My Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/profile') }}"><i class="glyphicon glyphicon-user"></i> My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/logout') }}"><i class="glyphicon glyphicon-off"></i> Logout</a>
                </li>
            </ul>
        </div>
        {{--*/ $breadcrumbs = \App\Helpers\Helper::getBreadcrumbs() /*--}}
        <div class="breadcrumb_container">
            <ul class="breadcrumb">
                @foreach($breadcrumbs as $title => $url)
                <li><a href="{{url($url)}}" title="{{$title}}">{{$title}}</a></li>
                <!-- <li><a href="{{url($url)}}" title="{{$title}}" data-toggle="tooltip" data-placement="right">{{$title}}</a></li> -->
                @endforeach
            </ul>
        </div>
    </div>
    <div class="main-panel row">
        <div class="col-lg-6 ">
            <h3 class="navbar-brand">Name of Company Here</h3>
        </div>
        <div class="col-lg-6">
            {{--*/$modules = \App\Helpers\Helper::getSearchModules()/*--}}
            <div class="">
                <div class="input-group">
                    <span class="input-group-btn">
                        <select class="module-selector btn">
                            @foreach($modules as $module)
                            <option value="{{strtolower(str_singular($module->name))}}">{{$module->name}}</option>
                            @endforeach
                        </select>
                    </span>
                    <form class="form-inline ml-auto">
                        <div class="form-group has-white">
                          <input  id="search-field" name="search" type="text" class="form-control" placeholder="Search">
                        </div>
                    </form>
                    <!-- <input id="search-field" name="search" type="text" class="form-control"> -->
                </div>
            </div>
        </div>
    </div>
</div>

