@extends('layouts.default')
@section('content')
<ul id="company_tabs" class="nav nav-tabs">
    @if($module_permissions->where('slug','view.projects')->count() === 1)
    <li class="projects_tab active"><a data-toggle="pill" href="#my_tasks">Projects</a></li>
    @endif
    @if($module_permissions->where('slug','view.jobs')->count() === 1)
    <li class="jobs_tab"><a data-toggle="pill" href="#my_jobs">Jobs</a></li>
    @endif
    @if($module_permissions->where('slug','view.employees')->count() === 1)
    <li><a class="employees_tab" data-toggle="pill" href="#employees">Employees</a></li>
    @endif
    <li><a class="positions_tab" data-toggle="pill" href="#positions">Positions</a></li>
    <li><a class="assign_tab" data-toggle="pill" href="#assign">Assign</a></li>
</ul>
<div class="tab-content">
    <div id="my_tasks" class="tab-pane fade in active">
        @include('company.partials._mytasklist')
    </div>
    @if(Auth::user('user')->level() === 1)
    <div id="my_jobs" class="tab-pane fade in">
        <!--Load the content with AJAX when the user clicks on tab-->
    </div>
    <div id="employees" class="tab-pane fade in">
        <!--Load the content with AJAX when the user clicks on tab-->
    </div>
    
    <div id="positions" class="tab-pane fade in">
        <!--Load the content with AJAX when the user clicks on tab-->
    </div>
    
    <div id="assign" class="tab-pane fade in">
        <!--Load the content with AJAX when the user clicks on tab-->
    </div>
    @endif
</div>
@stop