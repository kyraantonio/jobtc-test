<li>
    <a href="{{ url('dashboard') }}">
        <i class="fa fa-home"></i> <span>Dash</span>
    </a>
</li>
@if(Auth::check())
<?php $companies = \App\Helpers\Helper::getCompanyLinks(); ?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-users"></i> 
        <span>Companies</span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="#add_company" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> <span>New Company</span></a>
        </li>
        <li class="divider"></li>
        @if(count($companies) > 0)
        @foreach($companies as $company)
        <li>
            <a href="{{ url('company/' . $company->company->id) }}">
                <i class="fa fa-list-alt" aria-hidden="true"></i> <span>{{ $company->company->name }}</span>
            </a>
        </li>
        @endforeach
        @endif
    </ul>
</li>
@endif
<li class="dropdown">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-lightbulb-o"></i>
        <span> {{Lang::get('messages.Projects')}} </span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="#add_project" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> <span>New Project</span></a>
        </li>
        <li class="divider"></li>
        <?php $project = \App\Helpers\Helper::getProjectLinks(); ?>
        @if(count($project) > 0)
        @foreach($project as $val)
        <li>
            <a href="{{ url('project/' . $val->project_id ) }}">
                <i class="fa fa-list-alt" aria-hidden="true"></i> <span>{{ $val->project_title }}</span>
            </a>
        </li>
        @endforeach
        @endif
    </ul>
</li>
@if(Auth::check('user'))
<?php $jobs = \App\Helpers\Helper::getJobLinks(); ?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-list" aria-hidden="true"></i> 
        <span>Jobs</span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu multi-level">
        <li>
            <a href="#add_job" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> <span>New Job</span></a>
        </li>
        <li class="divider"></li>
        @if(count($jobs) > 0)
            @foreach($jobs as $job)
            <li class="{{ count($job->applicants) > 0 ? 'dropdown-submenu' : '' }}">
                <a href="{{ url('job/' . $job->id) }}">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> <span>{{ $job->title }}</span>
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
@endif
@if(Auth::check('user') && Auth::user('user')->level() === 1)
<li>
    <a href="{{ url('meeting') }}">
        <i class="fa fa-calendar"></i> <span>{{Lang::get('Meetings')}}</span>
    </a>
</li>
<li>
    <a href="{{ url('message') }}">
        <i class="fa fa-envelope"></i> <span>{{Lang::get('messages.Message')}}</span>
    </a>
</li>
<li>
    <a href="{{ url('payroll') }}">
        <i class="fa fa-credit-card"></i> <span>{{Lang::get('Payroll')}}</span>
    </a>
</li>
<li>
    <a href="{{ url('quiz') }}">
        <i class="fa fa-university"></i> <span>{{Lang::get('Quiz')}}</span>
    </a>
</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-ticket"></i>
        <span>{{Lang::get('Ticket')}}</span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
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
            <a href="#add_ticket" data-toggle="modal">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <span>New Ticket</span>
            </a>
        </li>
        <li>
            <a href="{{ url('tickets-admin?c=complete') }}" data-toggle="modal">
                <i class="glyphicon glyphicon-thumbs-up"></i>
                <span>Resolved Tickets</span>
            </a>
        </li>
    </ul>
</li>

<li>
    <a href="{{ route('links.index') }}">
        <i class="fa fa-globe"></i>
        <span>Links</span></a>
</li>

<li>
    <a href="{{ route('css.index') }}" >
        <i class="fa fa-globe"></i>
        <span>CSS</span></a>
</li>
@endif

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
