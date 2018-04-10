
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
