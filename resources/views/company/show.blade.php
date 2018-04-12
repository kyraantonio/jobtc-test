@extends('layouts.default')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <div class="card-columns">
                <!-- <div class="col-lg-4 col-md-6 col-sm-6"> -->
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title"><a href="{{url('company/' . $company_id . '/projects')}}">Projects</a></h4>
                        </div>
                        <div class="portlet-content">
                            <ul class='list-group'>
                                @foreach($projects as $project)
                                <li class='list-group-item'>
                                    @if(strlen($project->project_title) > 23)
                                    <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$project->project_title}}" href="{{url('project/'.$project->project_id)}}">{{$project->project_title}}</a>
                                    @else
                                    <a target="_blank" href="{{url('project/'.$project->project_id)}}">{{$project->project_title}}</a>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                <!-- </div> -->
                <!-- <div class="col-lg-4 col-md-6 col-sm-6"> -->
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title"><a href="{{url('company/' . $company_id . '/jobs')}}">Jobs</a></h4>
                        </div>
                        <div class="portlet-content">
                            <ul class='list-group'>
                               @foreach($jobs as $job)
                                <li class='list-group-item'>
                                    @if(strlen($job->title) > 23)
                                    <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$job->title}}" href="{{url('job/'.$job->id)}}">{{$job->title}}</a>
                                    @else
                                    <a target="_blank" href="{{url('job/'.$job->id)}}">{{$job->title}}</a>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                <!-- </div>
                <div class="col-lg-4 col-md-6 col-sm-6"> -->
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title"><a href="{{url('quizPerCompany/' . $company_id)}}">Tests</a></h4>
                        </div>
                        <div class="portlet-content">
                            <ul class='list-group'>
                                @foreach($tests as $test)
                                <li class='list-group-item'>
                                    @if(strlen($test->title) > 23)
                                    <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$test->title}}" href="{{url('quiz/'. $test->id .'?p=review&company_id='.$test->company_id)}}">{{$test->title}}</a>
                                    @else
                                    <a target="_blank" href="{{url('quiz/'. $test->id .'?p=review&company_id='.$test->company_id)}}">{{$test->title}}</a>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                            <div class="card">
                                <div class="card-header card-header-info">
                                    <h4 class="card-title"><a href="{{url('employees/' . $company_id)}}">Employees</a></h4>
                                </div>
                                <div class="portlet-content">
                                    <ul class='list-group'>
                                       @foreach($employees as $employee)
                                        <li class='list-group-item'>
                                            @if(strlen($employee->user->name) > 23)
                                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$employee->user->name}}" href="{{url('user/'.$employee->user_id.'/company/'.$employee->company_id)}}">{{$employee->user->name}}</a>
                                            @else
                                            <a target="_blank" href="{{url('user/'.$employee->user_id.'/company/'.$employee->company_id)}}">{{$employee->user->name}}</a>
                                            @endif

                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                      
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title"><a href="{{url('companyLinks/' . $company_id)}}">Links</a></h4>
                                </div>
                                <div class="portlet-content">
                                    <ul class='list-group'>
                                       @foreach($links as $link)
                                        <li class='list-group-item'>
                                            {{--*/ $parse_url = parse_url($link->url) /*--}}
                                            {{--*/ $url = empty($parse_url['scheme']) ? 'http://' . $link->url :  $link->url /*--}}
                                            @if(strlen($link->title) > 23)
                                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$link->title}}" href="{{$url}}">{{$link->title}}</a>
                                            @else
                                            <a target="_blank" href="{{$url}}">{{$link->title}}</a>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div> 

                            <div class="card">
                                <div class="card-header card-header-rose">
                                    <h4 class="card-title">Applicants</h4>
                                </div>
                                <div class="portlet-content">
                                    <ul class='list-group'>
                                       @foreach($applicants as $applicant)
                                        <li class='list-group-item'>
                                            @if(strlen($applicant->name) > 23)
                                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$applicant->name}}" href="{{url('applicant/'.$applicant->id)}}">{{$applicant->name}}</a>
                                            @else
                                            <a target="_blank" href="{{url('applicant/'.$applicant->id)}}">{{$applicant->name}}</a>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header card-header-warning">
                                    <h4 class="card-title">Briefcase Items</h4>
                                </div>
                                <div class="portlet-content">
                                    <ul class='list-group'>
                                       @foreach($items as $item)
                                        <li class='list-group-item'>
                                            @if(strlen($item->checklist_header) > 23)
                                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$item->checklist_header}}" href="{{url('taskitem/'.$item->id)}}">{{$item->checklist_header}}</a>
                                            @else
                                            <a target="_blank" href="{{url('taskitem/'.$item->id)}}">{{$item->checklist_header}}</a>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header card-header-danger">
                                    <h4 class="card-title">Comments</h4>
                                </div>
                                <div class="portlet-content">
                                    <ul class='list-group'>
                                       @foreach($comments as $comment)
                                        <li class='list-group-item'>
                                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{'<strong>' . $comment->applicant->name . '</strong><br/><strong>JOB:</strong> ' . $comment->applicant->job->title}}" href="{{url('applicant/'.$comment->applicant->id)}}">{{$comment->comment}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header card-header-success">
                                    <h4 class="card-title">Briefcase</h4>
                                </div>
                                <div class="portlet-content">
                                    <ul class='list-group'>
                                       @foreach($briefcases as $briefcase)
                                        <li class='list-group-item'>
                                            @if(strlen($briefcase->task_title) > 23)
                                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$briefcase->task_title}}" href="{{url('briefcase/'.$briefcase->task_id)}}">{{$briefcase->task_title}}</a>
                                            @else
                                            <a target="_blank" href="{{url('briefcase/'.$briefcase->task_id)}}">{{$briefcase->task_title}}</a>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                @include('common.note',['note' => $note, 'belongs_to' => 'company', 'unique_id' => $company_id])
                            </div>

                        </div>
                </div>
        </div>
    </div>
</div>


@stop