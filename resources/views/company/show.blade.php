@extends('layouts.default')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card-columns">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title"><a href="{{url('company/' . $company_id . '/projects')}}">Projects</a></h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                @foreach($projects as $project)
                                <tbody>
                                    @if(strlen($project->project_title) > 23)
                                    <tr>
                                        <td>
                                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$project->project_title}}" href="{{url('project/'.$project->project_id)}}">{{$project->project_title}}</a>
                                        </td>
                                    </tr>                                
                                    @else
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{url('project/'.$project->project_id)}}">{{$project->project_title}}</a>
                                        </td>
                                    </tr>                                    
                                    @endif
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer">
                            @if($module_permissions->where('slug','create.projects')->count() === 1)
                            <div class="center">
                                <a class="btn btn-info btn-sm" href="#add_project" data-toggle="modal"><span><i class="material-icons" aria-hidden="true">add</i> New Project</span></a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title"><a href="{{url('company/' . $company_id . '/jobs')}}">Jobs</a></h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                               @foreach($jobs as $job)
                                <tr>
                                    @if(strlen($job->title) > 23)
                                    <td>
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$job->title}}" href="{{url('job/'.$job->id)}}">{{$job->title}}</a>
                                    </td>
                                    @else
                                    <td>
                                        <a target="_blank" href="{{url('job/'.$job->id)}}">{{$job->title}}</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            @if($module_permissions->where('slug','create.jobs')->count() === 1)
                            <div class="center">
                                <a class="btn btn-info btn-sm" href="#add_job" data-toggle="modal"><span><i class="material-icons" aria-hidden="true">add</i> New Project</span></a>
                            </div>
                            @endif
                        </div>
                    </div>
                <!-- </div>
                <div class="col-lg-4 col-md-6 col-sm-6"> -->
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title"><a href="{{url('quizPerCompany/' . $company_id)}}">Tests</a></h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                @foreach($tests as $test)
                                <tr>
                                    @if(strlen($test->title) > 23)
                                    <td>
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$test->title}}" href="{{url('quiz/'. $test->id .'?p=review&company_id='.$test->company_id)}}">{{$test->title}}</a>
                                    </td>
                                    @else
                                    <td>
                                        <a target="_blank" href="{{url('quiz/'. $test->id .'?p=review&company_id='.$test->company_id)}}">{{$test->title}}</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title"><a href="{{url('employees/' . $company_id)}}">Employees</a></h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                @foreach($employees as $employee)
                                    @if(strlen($employee->user->name) > 23)
                                    <tr>
                                        <td>
                                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$employee->user->name}}" href="{{url('user/'.$employee->user_id.'/company/'.$employee->company_id)}}">{{$employee->user->name}}</a>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{url('user/'.$employee->user_id.'/company/'.$employee->company_id)}}">{{$employee->user->name}}</a>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>                                       
                            </table>
                        </div>
                    </div>
                      
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title"><a href="{{url('companyLinks/' . $company_id)}}">Links</a></h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                               @foreach($links as $link)
                                <tr>
                                    {{--*/ $parse_url = parse_url($link->url) /*--}}
                                    {{--*/ $url = empty($parse_url['scheme']) ? 'http://' . $link->url :  $link->url /*--}}
                                    @if(strlen($link->title) > 23)
                                    <td>
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$link->title}}" href="{{$url}}">{{$link->title}}</a>
                                    </td>
                                    @else
                                    <td>
                                        <a target="_blank" href="{{$url}}">{{$link->title}}</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div> 

                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">Applicants</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                               @foreach($applicants as $applicant)
                                <tr>
                                    @if(strlen($applicant->name) > 23)
                                    <td>
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$applicant->name}}" href="{{url('applicant/'.$applicant->id)}}">{{$applicant->name}}</a>
                                    </td>
                                    @else
                                    <td>
                                        <a target="_blank" href="{{url('applicant/'.$applicant->id)}}">{{$applicant->name}}</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Briefcase Items</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                               @foreach($items as $item)
                                <tr>
                                    @if(strlen($item->checklist_header) > 23)
                                    <td>
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$item->checklist_header}}" href="{{url('taskitem/'.$item->id)}}">{{$item->checklist_header}}</a>
                                    </td>
                                    @else
                                    <td>
                                        <a target="_blank" href="{{url('taskitem/'.$item->id)}}">{{$item->checklist_header}}</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">Comments</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                               @foreach($comments as $comment)
                                <tr>
                                    <td>
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{'<strong>' . $comment->applicant->name . '</strong><br/><strong>JOB:</strong> ' . $comment->applicant->job->title}}" href="{{url('applicant/'.$comment->applicant->id)}}">{{$comment->comment}}</a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Briefcase</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                               @foreach($briefcases as $briefcase)
                                <tr>
                                    @if(strlen($briefcase->task_title) > 23)
                                    <td>
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="{{$briefcase->task_title}}" href="{{url('briefcase/'.$briefcase->task_id)}}">{{$briefcase->task_title}}</a>
                                    </td>
                                    @else
                                    <td>
                                        <a target="_blank" href="{{url('briefcase/'.$briefcase->task_id)}}">{{$briefcase->task_title}}</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        @include('common.note',['note' => $note, 'belongs_to' => 'company', 'unique_id' => $company_id])
                    </div>

            </div>
        </div>
 </div>
</div>


@stop