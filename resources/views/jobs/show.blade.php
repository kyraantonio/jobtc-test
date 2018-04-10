@extends('layouts.default')
@section('content')
<div class="job-posting-container">
    <div class="row">
        @if(!Auth::check())
        <div class="col-md-12">
            @else
            <div class="col-md-6">
                @endif
                <div class="job-header">
                    <input name="job_id" class="job_id" type="hidden" value="{{$job->id}}"/>
                </div>
                @if(!Auth::check())
                <div class="job-logged-out">
                    @else
                    <div class="job">
                        @endif
                        <div class="job-info row">
                            <div class="col-md-12">
                                <div class="media">
                                    @if(!Auth::check())
                                    <input class="btn btn-assign btn-shadow btn-lg pull-right apply-to-job" type="button" value="Apply"/>
                                    @endif
                                    <div class="media-middle">
                                        <a target="_blank" href="{{url('job/'.$job->id)}}">
                                            @if($job->photo !== '')
                                            <img class="job-photo" src="{{url($job->photo)}}" alt="Job Photo">
                                            @endif
                                        </a>
                                        @if(Auth::check())
                                        <div class="pull-right">
                                            @if($job->applicants->count() > 1)
                                            <a class="view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$job->applicants->count()}} Applicants</a>
                                            <a class="view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$job->applicants->count()}} Applicants</a>
                                            @elseif ($job->applicants->count() === 1)
                                            <a class="view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$job->applicants->count()}} Applicant</a>
                                            <a class="view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$job->applicants->count()}} Applicant</a>
                                            @elseif ($job->applicants->count() === 0)
                                            <a class="view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;No Applicants</a>
                                            <a class="view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;No Applicants</a>
                                            @endif
                                            <input name="job_id" class="job_id" type="hidden" value="{{$job->id}}"/>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="media-body">
                                        <text class="media-heading"><a target="_blank" href="{{url('job/'.$job->id)}}">{{$job->title}}</a></text>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mini-space"></div>
                        <div class="row tasklist-row">
                            <div id="applicant-list-{{$count}}" class="applicant-list col-md-12">
                                <p class="job-description">{!! $job->description !!}</p>
                                <input class="token" name="_token" type="hidden" value="{{csrf_token()}}">
                            </div>
                            @if(Auth::check())
                            <div class="row" style="margin: 15px 0 45px;">
                                <div class="col-md-12">
                                    <div class="job-header pull-right">
                                        @if(Auth::user('user')->can('edit.jobs') && $module_permissions->where('slug','edit.jobs')->count() === 1)
                                        <a class="btn btn-edit btn-lg btn-shadow edit-job" data-toggle="modal" style="font-size: 18px;"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
                                        @endif
                                        @if(Auth::user('user')->can('delete.jobs') && $module_permissions->where('slug','delete.jobs')->count() === 1)
                                        <a class="btn btn-delete btn-lg btn-shadow delete-job" style="font-size: 18px;"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
                                        @endif
                                        <input name="job_id" class="job_id" type="hidden" value="{{$job->id}}"/>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(Auth::check() && Auth::user()->level() === 1 || Auth::check() && Auth::user()->user_id === $job->user_id)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div id="collapse-container-1" class="panel task-list">
                                            <div class="panel-heading task-header" id="notes-{{$job->id}}" data-toggle="collapse" data-target="#notes-collapse-{{ $job->id }}">
                                                <div class="row">
                                                    <h4 class="panel-title task-list-header">Notes</h4>
                                                </div>
                                            </div>
                                            <div id="notes-collapse-{{ $job->id }}" class="box-content collapse">
                                                <div class="panel-body">
                                                    <div class="panel-content">
                                                        <textarea id="job-notes">{{$job->notes}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse-container-2" class="panel task-list">
                                            <div class="panel-heading task-header" data-target="#collapse-1" role="tab" id="headingOne" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                                <div class="row">
                                                    <h4 class="panel-title task-list-header">Applicant Assessment Criteria</h4>
                                                </div>
                                            </div>
                                            <div id="collapse-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    <div class="panel-content">
                                                        <textarea class="form-control assessment-instruction" id="assessment-instruction">{{$job->criteria}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse-container-3" class="panel task-list">
                                            <div class="panel-heading task-header" data-target="#collapse-2" role="tab" id="headingOne" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                                <div class="row">
                                                    <h4 class="panel-title task-list-header">Assessment Scores</h4>
                                                </div>
                                            </div>
                                            <div id="collapse-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    <div class="panel-content" data-content="{{ url('quizAssessment/' . $job->id) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(Auth::check() && Auth::user()->level() === 1 || Auth::check() && Auth::user()->user_id === $job->user_id)
                 @if($applicants->total() > 1)
                <div class="text-center hidden-sm hidden-xs">
                    <ul class="pagination job-applicant-list-pager">
                        @if($applicants->currentPage() > 1)
                        <li><a class="pager-previous" href="{{url($applicants->previousPageUrl())}}" rel="previous">Previous</a></li>
                        @endif
                        @for($i = 1; $i <= $applicants->lastPage(); $i++)
                        @if($i === $applicants->currentPage())
                        <li class="active"><a id="pager-item-{{$i}}" class="pager-item" href="{{url($applicants->url($i))}}">{{$i}}</a></li>
                        @else
                        <li><a id="pager-item-{{$i}}" class="pager-item" href="{{url($applicants->url($i))}}">{{$i}}</a></li>
                        @endif
                        @endfor
                        @if($applicants->currentPage() < $applicants->lastPage())
                        <li><a class="pager-next" href="{{url($applicants->nextPageUrl())}}" rel="next">Next</a></li>
                        @endif
                    </ul>
                </div>
                <div class="text-center hidden-lg hidden-md">
                    <ul class="pagination job-applicant-list-pager">
                        @if($applicants->currentPage() > 1)
                        <li><a class="pager-previous-mobile" href="{{url($applicants->previousPageUrl())}}" rel="previous">Previous</a></li>
                        @endif
                        @for($i = 1; $i <= $applicants->lastPage(); $i++)
                        @if($i === $applicants->currentPage())
                        <li class="active"><a id="pager-item-mobile-{{$i}}" class="pager-item-mobile" href="{{url($applicants->url($i))}}">{{$i}}</a></li>
                        @else
                        <li><a id="pager-item-mobile-{{$i}}" class="pager-item-mobile" href="{{url($applicants->url($i))}}">{{$i}}</a></li>
                        @endif
                        @endfor
                        @if($applicants->currentPage() < $applicants->lastPage())
                        <li><a class="pager-next-mobile" href="{{url($applicants->nextPageUrl())}}" rel="next">Next</a></li>
                        @endif
                    </ul>
                </div>
                @endif
                @if(Auth::check())
                <div class="job-header">
                    <div>&nbsp;</div>
                </div>
                <div class="col-md-6 hidden-sm hidden-xs job-applicant-list-container">
                    @include('jobs.partials.applicantList')
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('js_footer')
@parent

<script>
    $(function(e){
        $('#collapse-2').on('show.bs.collapse', function () {
            var thisContent = $(this).find('.panel-content');
            $.ajax({
                method: 'get',
                url: thisContent.data('content'),
                success: function(data) {
                    thisContent.html(data);
                }
            });
        })
    });
</script>
@stop

