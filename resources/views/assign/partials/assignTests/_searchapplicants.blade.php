@foreach($jobs as $job)
<div id="assign_my_applicants-{{$job->id}}" class="assign_my_applicants">
    <ul class="list-group">
        @foreach($applicants as $applicant)
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
    @if ($applicants->lastPage() > 1)
    <ul class="pagination">
        <li class="{{ ($applicants->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $applicants->url(1) }}&jobPage={{$jobs->currentPage()}}">Previous</a>
        </li>
        @for ($i = 1; $i <= $applicants->lastPage(); $i++)
        <li class="{{ ($applicants->currentPage() == $i) ? ' active' : '' }}">
            <a href="{{ $applicants->url($i) }}&jobPage={{$jobs->currentPage()}}">{{ $i }}</a>
        </li>
        @endfor
        <li class="{{ ($applicants->currentPage() == $applicants->lastPage()) ? ' disabled' : '' }}">
            <a href="{{ $applicants->url($applicants->currentPage()+1) }}&jobPage={{$jobs->currentPage()}}" >Next</a>
        </li>
    </ul>
    @endif
    <input type="hidden" class="job_id" value="{{$job->id}}" />
    <input type="hidden" class="job_page" value="{{$jobs->currentPage()}}">
</div>
@endforeach