<div id="assign_my_jobs">
    @foreach($jobs as $job)
    <div id="job-container-{{$job->id}}" class="box box-default">
        <div class="box-container">
            <div class="box-header">
                <h3 class="box-title">{{$job->title}}</h3>
            </div>
            <div class="box-body">
                <div class="box-content">
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;All Applicants</div>
                        <div class="panel-body">
                            <ul id="job-{{$job->id}}" class="job-test-list list-group">
                                <li class="list-group-item">Drag a test here to make it available for all applicants in this job posting.</li>
                                @if($test_jobs
                                ->where('job_id',$job->id)
                                ->count() > 0)
                                @foreach($tests as $test)
                                @foreach($test_jobs as $test_job)
                                @if($test->id === $test_job->test_id
                                && $job->id === $test_job->job_id)
                                <li class="bg-gray list-group-item">
                                    {{$test->title}}
                                    <div class="pull-right">
                                        <div class="btn-group pull-right">
                                            <a href="#" class="drag-handle">
                                                <i class="fa fa-arrows"></i>
                                            </a>
                                            <a href="#" class="unassign-test">
                                                <i class="fa fa-times"></i>
                                                <input class="test_id" type="hidden" value="{{$test->id}}"/>
                                                <input class="applicant_id" type="hidden" value=""/>
                                                <input class="job_id" type="hidden" value="{{$job->id}}"/>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div id="assign_my_applicants-{{$job->id}}" class="assign_my_applicants">
                        <ul class="list-group">
                            @foreach($job->getApplicantsPaginated() as $applicant)
                            <li class="list-group-item">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;{{$applicant->name}}</div>
                                    <div class="panel-body">
                                        <ul id="applicant-{{$applicant->id}}" class="job-applicant-list list-group">
                                            @if($test_applicants
                                            ->where('applicant_id',$applicant->id)
                                            ->count() > 0)
                                            @foreach($tests as $test)
                                            @foreach($test_applicants as $test_applicant)
                                            @if($test->id === $test_applicant->test_id 
                                            && $applicant->id === $test_applicant->applicant_id)
                                            <li class="bg-gray list-group-item">
                                                {{$test->title}}
                                                <div class="pull-right">
                                                    <div class="btn-group pull-right">
                                                        <a href="#" class="drag-handle">
                                                            <i class="fa fa-arrows"></i>
                                                        </a>
                                                        <a href="#" class="unassign-test">
                                                            <i class="fa fa-times"></i>
                                                            <input class="test_id" type="hidden" value="{{$test->id}}"/>
                                                            <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                                                            <input class="job_id" type="hidden" value=""/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @if ($job->getApplicantsPaginated()->lastPage() > 1)
                        <ul class="pagination">
                            <li class="{{ ($job->getApplicantsPaginated()->currentPage() == 1) ? ' disabled' : '' }}">
                                <a href="{{ $job->getApplicantsPaginated()->url(1) }}&jobPage={{$jobs->currentPage()}}">Previous</a>
                            </li>
                            @for ($i = 1; $i <= $job->getApplicantsPaginated()->lastPage(); $i++)
                            <li class="{{ ($job->getApplicantsPaginated()->currentPage() == $i) ? ' active' : '' }}">
                                <a href="{{ $job->getApplicantsPaginated()->url($i) }}&jobPage={{$jobs->currentPage()}}">{{ $i }}</a>
                            </li>
                            @endfor
                            <li class="{{ ($job->getApplicantsPaginated()->currentPage() == $job->getApplicantsPaginated()->lastPage()) ? ' disabled' : '' }}">
                                <a href="{{ $job->getApplicantsPaginated()->url($job->getApplicantsPaginated()->currentPage()+1) }}&jobPage={{$jobs->currentPage()}}" >Next</a>
                            </li>
                        </ul>
                        @endif
                        <input type="hidden" class="job_id" value="{{$job->id}}" />
                        <input type="hidden" class="job_page" value="{{$jobs->currentPage()}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @if ($jobs->lastPage() > 1)
    <ul class="pagination">
        <li class="{{ ($jobs->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $jobs->url(1) }}">Previous</a>
        </li>
        @for ($i = 1; $i <= $jobs->lastPage(); $i++)
        <li class="{{ ($jobs->currentPage() == $i) ? ' active' : '' }}">
            <a href="{{ $jobs->url($i) }}">{{ $i }}</a>
        </li>
        @endfor
        <li class="{{ ($jobs->currentPage() == $jobs->lastPage()) ? ' disabled' : '' }}">
            <a href="{{ $jobs->url($jobs->currentPage()+1) }}" >Next</a>
        </li>
    </ul>
    @endif
</div>