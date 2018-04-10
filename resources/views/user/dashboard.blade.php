@extends('layouts.default')
@section('content')
<!-- Centered Pills -->
<ul id="company_tabs" class="nav nav-tabs nav-justified">
    <li class="active"><a data-toggle="pill" href="#my_companies">My Companies</a></li>
    <li ><a id="job_postings_tab" data-toggle="pill" href="#my_jobs" >Job Postings</a></li>
    <li><a data-toggle="pill" href="#my_projects">My Projects</a></li>
</ul>
<div class="tab-content">
    <div id="my_companies" class="tab-pane fade in active">
        <div class="mini-space"></div>
        <div class="row">
            <div class="mini-space"></div>
            <div class="company_tab_options">
                <a href="#" id="add-company" class="btn btn-shadow btn-default add-company">
                    <i class="fa fa-plus"></i> 
                    <strong>New Company</strong>
                </a>
            </div>
        </div>
        <div class="companies_container">
            <div class="row">
                @foreach($companies->chunk(1) as $chunk)
                <div class="column">
                    @foreach($chunk as $index => $company)
                    @if($company->company->deleted_at === NULL)
                    <div id="company-{{$company->company->id}}" class="portlet">
                        <div class="portlet-header"><i class="fa fa-institution" aria-hidden="true"></i>&nbsp;<span>{{$company->company->name}}</span></div>
                        <div class="portlet-content">
                            <div class="company-info">
                                <ul class="list-group">
                                    <li class="list-group-item"><a target="_blank" href="{{url('company/'.$company->company->id)}}"><i class="fa fa-briefcase" aria-hidden="true"></i>&nbsp;<span>Dashboard</span></a></li>
                                    <li class="list-group-item"><a target="_blank" href="{{url('company/'.$company->company->id.'/projects')}}"><i class="fa fa-folder-open"></i>&nbsp;<span>Projects</span></a></li>
                                    <li class="list-group-item"><a target="_blank" href="{{url('company/'.$company->company->id.'/jobs')}}"><i class="fa fa-clipboard" aria-hidden="true"></i>&nbsp;<span>Jobs</span></a></li>
                                    <li class="list-group-item"><a target="_blank" href="{{url('quizPerCompany/'.$company->company->id)}}"><i class="glyphicon glyphicon-education"></i>&nbsp;<span>Test</span></a></li>
                                    <li class="list-group-item"><a target="_blank" href="{{url('tickets-admin')}}"><i class="fa fa-envelope"></i>&nbsp;<span>Tickets</span></a></li>
                                    <li class="list-group-item"><a target="_blank" href="{{url('employees/'.$company->company->id)}}"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;<span>Employees</span></a></li>
                                    <li class="list-group-item"><a target="_blank" href="{{url('positions/'.$company->company->id)}}"><i class="fa fa-flag" aria-hidden="true"></i>&nbsp;<span>Positions</span></a></li>
                                    <li class="list-group-item"><a target="_blank" href="{{url('payroll/'.$company->company->id)}}"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<span>Payroll</span></a></li>
                                    <li class="list-group-item"><a target="_blank" href="#"><i class="fa fa-share-alt" aria-hidden="true"></i>&nbsp;<span>Assign</span></a></li>
                                    <li class="list-group-item"><a target="_blank" href="{{url('companyLinks/'.$company->company->id)}}"><i class="fa fa-globe" aria-hidden="true">&nbsp;</i><span>Links</span></a></li>
                                </ul>
                            </div>
                            <div class="company-options pull-right">                                
                                <a href="#" class="btn btn-edit btn-sm btn-shadow edit-company"><i class="fa fa-pencil"></i> Edit</a>
                                <a href="#" class="btn btn-delete btn-sm btn-shadow delete-company" style="font-size: 16px!important;"><i class="fa fa-times" aria-hidden="true"></i> Delete</a>
                                <input class="company_id" type="hidden" value="{{$company->company->id}}"/>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="my_projects" class="tab-pane fade in">
        <div class="mini-space"></div>
        <div class="project_tab_options">
            <a href="#" id="add-project" class="btn btn-shadow btn-default add-project">
                <i class="fa fa-plus"></i> 
                <strong>New Project</strong>
            </a>
            <input class="company_id" type="hidden" value="{{$company_id}}"/>
        </div>
        <div class="project_container">
            @foreach($projects->chunk(2) as $chunk)
            <div class="project-row row">
                @foreach($chunk as $index => $project)
                <div class="col-md-6">
                    <div  class="box box-default">
                        <div class="box-container">
                            <div class="box-header toggle-subprojects" id="project-{{$project->project_id}}" data-toggle="collapse" data-target="#project-collapse-{{ $project->project_id }}">
                                <h3 class="box-title">{{$project->project_title}}</h3>
                                <input class="project_id" type="hidden" value="{{$project->project_id}}"/>
                                <input class="company_id" type="hidden" value="{{$project->company_id}}"/>
                            </div>
                            <div class="box-body">
                                <div id="project-collapse-{{ $project->project_id }}" class="box-content collapse">

                                </div><!--Box Container-->
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
        <div class="mini-space"></div>

        <div class="modal fade edit-modal" id="edit_project_form" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                </div>
            </div>
        </div>
    </div>
    <div id="my_jobs" class="tab-pane fade">
        <div class="jobs_container">
            @foreach($jobs as $job)
            <div class="row">
                <div class="col-xs-6">
                    {{$job->title}}
                </div>
                <div class="col-xs-6">
                    <input class="btn btn-assign btn-shadow btn-lg pull-right apply-to-job" type="button" value="Apply"/>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@stop
