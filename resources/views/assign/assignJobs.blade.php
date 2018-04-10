@extends('layouts.default')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="mini-space"></div>
        <div class="row">
            <div class="col-md-4">
                <div id="share_jobs_employees" class="tab-pane fade in active">
                    <div class="box box-default">
                        <div class="box-container">
                            <div class="box-header">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3 class="box-title">Employees</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <input id="search-field-employees" name="search-employees" type="text" class="form-control" placeholder="Search Employees">
                                        <input type="hidden" class="company_id" value="{{$company_id}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="box-content">
                                    <div id="assign_my_jobs_employees">
                                        @foreach($profiles as $profile)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">{{$profile->user->name}}</div>
                                            <div class="panel-body">
                                                <ul id="user-{{$profile->user_id}}" class="job-list-group list-group">
                                                    @foreach($jobs as $job)
                                                    @foreach($shared_jobs->where('user_id',$profile->user_id) as $shared_job)
                                                    @if($shared_job->job_id === $job->id)
                                                    <li id="job-{{$job->id}}" class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                {{$job->title}}
                                                            </div>
                                                            <div class="pull-right">
                                                                <a href="#" class="drag-handle">
                                                                    <i class="fa fa-arrows"></i>
                                                                </a>
                                                                <a href="#" class="unshare-job">
                                                                    <i class="fa fa-times"></i>
                                                                    <input class="job_id" type="hidden" value="{{$job->id}}"/>
                                                                    <input class="user_id" type="hidden" value="{{$profile->user_id}}"/>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endif
                                                    @endforeach
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endforeach
                                        {!!$profiles->render()!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-container">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-4">
                                    <h3 class="box-title">Companies</h3>
                                </div>
                                <div class="col-md-8">
                                    <input id="search-field-companies" name="search-companies" type="text" class="form-control" placeholder="Search Companies">
                                    <input type="hidden" class="company_id" value="{{$company_id}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="box-content">
                                <div id="share_jobs_companies">
                                    @foreach($user_companies as $company)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">{{$company->name}}</div>
                                        <div class="panel-body">
                                            <ul id="company-{{$company->id}}" class="job-list-group list-group">
                                                @foreach($jobs as $job)
                                                @foreach($shared_jobs_companies->where('company_id',$company->id) as $shared_job_company)
                                                @if($shared_job_company->job_id === $job->id)
                                                <li id="job-{{$job->id}}" class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <a id="shared-company-item-{{$shared_job_company->id}}" class="toggle-employees" data-toggle="collapse" href="#employee-collapse-{{$shared_job_company->id}}">
                                                                {{$job->title}}
                                                            </a>
                                                        </div>
                                                        <div class="pull-right">
                                                            <a href="#" class="drag-handle">
                                                                <i class="fa fa-arrows"></i>
                                                            </a>
                                                            <a href="#" class="unshare-job">
                                                                <i class="fa fa-times"></i>
                                                                <input class="job_id" type="hidden" value="{{$job->id}}"/>
                                                                <input class="company_id" type="hidden" value="{{$company->id}}"/>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div id="employee-collapse-{{$shared_job_company->id}}" class="employee-list collapse">

                                                        </div>
                                                    </div>
                                                </li>
                                                @endif
                                                @endforeach
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach
                                    {!!$user_companies->render()!!}
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mini-space"></div>
                <div id="jobs-container" class="box box-default">
                    <div class="box-container">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-2">
                                    <h3 class="box-title">Jobs</h3>
                                </div>
                                <div class="col-md-10">
                                    <input id="search-field-jobs" name="search-jobs" type="text" class="form-control" placeholder="Search Jobs">
                                    <input type="hidden" class="company_id" value="{{$company_id}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="box-content">
                                <div id="assign_my_jobs">
                                    <ul class="job-list-group list-group">
                                        @foreach($jobs as $job)
                                        <li id="job-{{$job->id}}" class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <a class="toggle-employees" data-toggle="collapse">
                                                        {{$job->title}}
                                                    </a>
                                                </div>
                                                <div class="pull-right">
                                                    <a href="#" class="drag-handle">
                                                        <i class="fa fa-arrows"></i>
                                                    </a>
                                                    <a href="#" class="unshare-job hidden">
                                                        <i class="fa fa-times"></i>
                                                        <input class="job_id" type="hidden" value="{{$job->id}}"/>
                                                        <input class="user_id" type="hidden" value=""/>
                                                        <input class="company_id" type="hidden" value=""/>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="employee-list collapse">

                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    {!!$jobs->render()!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop