<div class="row">
    <div class="col-md-6">
        <div class="mini-space"></div>
        <ul id="share_jobs_tabs" class="nav nav-tabs">
            <li class="active"><a data-toggle="pill" href="#share_jobs_employees">Employees</a></li>
            <li><a data-toggle="pill" href="#share_jobs_companies">Companies</a></li>
        </ul>
        <div class="tab-content">
            <div id="share_jobs_employees" class="tab-pane fade in active">
                @foreach($profiles as $profile)
                <div class="box box-default">
                    <div class="box-container">
                        <div class="box-header">
                            <h3 class="box-title">{{$profile->user->name}}</h3>
                        </div>
                        <div class="box-body">
                            <div class="box-content">
                                <ul id="user-{{$profile->user_id}}" class="job-list-group list-group">
                                    @foreach($jobs as $job)
                                    @foreach($shared_jobs->where('user_id',$profile->user_id) as $shared_job)
                                    @if($shared_job->job_id === $job->id)
                                    <li id="job-{{$job->id}}" class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <i class="pull-left fa fa-chevron-down" aria-hidden="true"></i>
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
                    </div>
                </div>
                @endforeach
            </div>
            <div id="share_jobs_companies" class="tab-pane fade in ">
                @foreach($user_companies as $company)
                <div class="box box-default">
                    <div class="box-container">
                        <div class="box-header">
                            <h3 class="box-title">{{$company->name}}</h3>
                        </div>
                        <div class="box-body">
                            <div class="box-content">
                                <ul id="company-{{$company->id}}" class="job-list-group list-group">
                                    @foreach($jobs as $job)
                                    @foreach($shared_jobs_companies->where('company_id',$company->id) as $shared_job_company)
                                    @if($shared_job_company->job_id === $job->id)
                                    <li id="job-{{$job->id}}" class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <a id="shared-company-item-{{$shared_job_company->id}}" class="toggle-employees" data-toggle="collapse" href="#employee-collapse-{{$shared_job_company->id}}">
                                                    <i class="pull-left fa fa-chevron-down" aria-hidden="true"></i>
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
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mini-space"></div>
        <div id="jobs-container" class="box box-default">
            <div class="box-container">
                <div class="box-header">
                    <h3 class="box-title">Jobs</h3>
                </div>
                <div class="box-body">
                    <div class="box-content">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>