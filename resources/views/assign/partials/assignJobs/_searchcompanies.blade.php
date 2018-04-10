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
@endforeach
{!!$user_companies->render()!!}
