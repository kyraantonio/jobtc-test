<label class='center-block taskgroup-title'>Employees</label>
<ul class="employee-list-group list-group">
    @if($employees->count() > 0)
    @foreach($employees as $employee)
    <li class="list-group-item">
        <div class="row">
            <div class="col-md-9">
                {{$employee->user->name}}
            </div>
            <div class="pull-right">
                @if(isset($shared_company_jobs_permissions))
                @if($shared_company_jobs_permissions->where('user_id',$employee->user_id)->count() > 0)
                <div class="btn btn-default btn-shadow bg-green job-permission">
                    <i class="fa fa-check" aria-hidden="true"></i>                                                                
                    <input class="user_id" type="hidden" value="{{$employee->user_id}}"/>
                    <input class="job_id" type="hidden" value="{{$job_id}}"/>
                    <input class="company_id" type="hidden" value="{{$employee->company_id}}"/>
                </div>
                @else
                <div class="btn btn-default btn-shadow bg-gray job-permission">
                    <i class="fa fa-plus" aria-hidden="true"></i>                                                                
                    <input class="user_id" type="hidden" value="{{$employee->user_id}}"/>
                    <input class="job_id" type="hidden" value="{{$job_id}}"/>
                    <input class="company_id" type="hidden" value="{{$employee->company_id}}"/>
                </div>
                @endif
                @endif
            </div>
        </div>
    </li>
    @endforeach
    @else
    <li class="list-group-item">
        No Employees Available for Sharing.
    </li>
    @endif
</ul>