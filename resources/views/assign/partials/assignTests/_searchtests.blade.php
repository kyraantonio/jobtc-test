<div id="assign_my_tests">
    <ul class="job-applicant-list list-group">
        @foreach($tests as $test)
        <li class="bg-gray list-group-item">
            {{$test->title}}
            <div class="pull-right">
                <div class="btn-group pull-right">
                    <a href="#" class="drag-handle">
                        <i class="fa fa-arrows"></i>
                    </a>
                    <a href="#" class="unassign-test hidden">
                        <i class="fa fa-times"></i>
                        <input class="test_id" type="hidden" value="{{$test->id}}"/>
                        <input class="applicant_id" type="hidden" value=""/>
                        <input class="job_id" type="hidden" value=""/>
                    </a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    {!! $tests->render() !!}
</div>