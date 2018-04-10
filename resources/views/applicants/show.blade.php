@extends('layouts.default')
@section('content')
<div id="applicant-posting-container" class="applicant-posting-container container-fluid">
    <div class="row">
        @if(Auth::user('user'))
        <div class="row single-applicant-pagination hidden-lg hidden-md hidden-sm">                   
            <div class="col-xs-7">
            </div>
            <div class="col-xs-2">
                @if($previous_applicant !== NULL)
                <a class="btn btn-default btn-shadow btn-lg pager-previous pull-left" href="{{url('/a/'.$previous_applicant)}}" rel="previous"><i class="fa fa-chevron-circle-left"></i>&nbsp;Previous</a>
                @endif
            </div>
            <div class="col-xs-3">
                @if($next_applicant !== NULL)
                <a class="btn btn-default btn-shadow btn-lg pager-next pull-right" href="{{url('/a/'.$next_applicant)}}" rel="next">Next&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
                @endif
            </div>
            <a href="#" class="btn btn-default btn-shadow pull-right close-applicant"><i class="fa fa-times"></i></a>
        </div>
        @endif
        <div class="mini-space"></div>
        <div class="applicant-posting-info hidden-lg hidden-md hidden-sm">
            <div class="row">
                <div class="col-md-12">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                @if($applicant->photo !== '' && file_exists(public_path() . '/' . $applicant->photo))
                                <img class="img-thumbnail media-object applicant-photo edit-applicant is-upload-document" data-toggle="tooltip" title="Upload Photo" src="{{url($applicant->photo)}}" alt="Applicant Photo">
                                @else
                                <img class="img-thumbnail media-object applicant-photo edit-applicant is-upload-document" data-toggle="tooltip" title="Upload Photo" src="{{url('assets/user/avatar.png')}}" alt="Applicant Photo">
                                @endif
                                <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                                <input class="company_id" type="hidden" value="{{$job->company_id}}"/>
                            </a>
                            @if(Auth::user('user'))
                            <div class="rating text-center"></div>
                            @endif
                        </div>
                        <div class="media-body media-right">
                            @if(Auth::user('user'))
                                <a href="#" class="btn btn-default pull-right interview-applicant"><i class="fa fa-comment-o"></i></a>
                                <text class="media-heading">{{$applicant->name}}&nbsp;<a href="{{$applicant->id}}" class="delete-applicant"><i class="fa fa-trash"></i></a></text>
                                @else
                                <text class="media-heading">{{$applicant->name}}</text>
                                <a class="btn btn-shadow btn-delete pull-right" href="{{ url('/logout') }}"><i class="glyphicon glyphicon-off"></i> Logout</a>
                                @endif
                                <br />
                                <a href="tel:{{$applicant->phone}}" class="applicant-phone">{{$applicant->phone}}</a>
                                <br />
                                <a href="mailto:{{$applicant->email}}" class="applicant-email">{{$applicant->email}}</a>
                                <br />
                                <text class="applicant-job-title">{{$job->title}}</text>
                                <br />
                                <text>{{date_format(date_create($applicant->created_at),'M d,Y')}}</text>
                            @if(Auth::user('user'))
                                <br />
                                <textarea class="status-container">
                                            @if(isset($statuses))
                                                {{$statuses->tags}}
                                            @endif
                                </textarea>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            @if(Auth::user('user'))
            <div class="row single-applicant-pagination hidden-xs">
                <div class="col-xs-7">
                    <a href="{{url('job/'.$job->id)}}" id="job-title" data-toggle="tooltip" title="{{$job->title}}"  data-placement="bottom" class="btn btn-shadow btn-default bg-gray btn-lg pull-right"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;{{$job->title}}</a>
                </div>
                <div class="col-xs-3">
                    @if($previous_applicant !== NULL)
                    <a class="btn btn-shadow btn-default btn-lg pager-previous pull-left" href="{{url('/a/'.$previous_applicant)}}" rel="previous"><i class="fa fa-chevron-circle-left"></i>&nbsp;Previous</a>
                    @endif
                </div>
                <div class="col-xs-2">
                    @if($next_applicant !== NULL)
                    <a class="btn btn-shadow btn-default btn-lg pager-next pull-right" href="{{url('/a/'.$next_applicant)}}" rel="next">Next&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
                    @endif
                </div>
                <div class="col-xs-1">
                    <!--a href="#" class="btn btn-default btn-lg close-applicant"><i class="fa fa-times"></i></a-->
                </div>
            </div>
            <div class="mini-space"></div>
            @endif
            <div id="applicant-{{$applicant->id}}" class="applicant-posting-info hidden-xs">
                <div class="row">
                    <div class="col-md-12">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    @if($applicant->photo !== '' && file_exists(public_path() . '/' . $applicant->photo))
                                    <img class="img-thumbnail media-object applicant-photo edit-applicant is-upload-document" data-toggle="tooltip" title="Upload Photo" src="{{url($applicant->photo)}}" alt="Applicant Photo">
                                    @else
                                    <img class="img-thumbnail media-object applicant-photo edit-applicant is-upload-document" data-toggle="tooltip" title="Upload Photo" src="{{url('assets/user/avatar.png')}}" alt="Applicant Photo">
                                    @endif
                                    <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                                    <input class="company_id" type="hidden" value="{{$job->company_id}}"/>
                                </a>
                                @if(Auth::user())
                                <div class="rating text-center"></div>
                                @endif
                            </div>
                            <div class="media-body media-right">
                                {{--*/ $display_move_btn = $applicant->hired === 'Yes' ? 'display:inline;' : 'display:none;' /*--}}
                                @if(Auth::user('user'))
                                <text class="media-heading">
                                    {{$applicant->name}}&nbsp;
                                    @if(Auth::user('user')->user_id === $job->user_id)
                                        @if($applicant->hired === 'No')
                                        <a href="#" class='pull-right btn btn-edit btn-shadow bg-light-blue-gradient hire'>Hire</a>
                                        <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                                        <input class="company_id" type="hidden" value="{{$job->company_id}}"/>
                                        @else
                                        <a href="#" class='pull-right btn btn-shadow bg-green hire'><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Hired</a>
                                        <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                                        <input class="company_id" type="hidden" value="{{$job->company_id}}"/>
                                        @endif
                                    @endif
                                </text>
                                @else
                                    <text class="media-heading applicant-name"><span>{{$applicant->name}}</span></text>
                                    @if(Auth::user('applicant'))
                                    <a class="btn btn-shadow btn-delete pull-right" href="{{ url('/logout') }}"><i class="glyphicon glyphicon-off"></i> Logout</a>
                                    @endif
                                @endif

                                <br />
                                <a href="tel:{{$applicant->phone}}" class="applicant-phone">{{$applicant->phone}}</a>
                                <br />
                                <a href="mailto:{{$applicant->email}}" class="applicant-email">{{$applicant->email}}</a>
                                <br />
                                <text>{{date_format(date_create($applicant->created_at),'M d,Y')}}</text>
                                <br />
                                @if(Auth::user('applicant'))
                                <div class="applicant-options">
                                    <a class="btn btn-edit btn-shadow bg-light-blue-gradient edit-applicant" href="#"><i class="fa fa-pencil" aria-hidden="true"></i>  Edit </a>
                                    <a class="btn btn-edit btn-shadow bg-light-blue-gradient edit-applicant-password" href="#">Change Password</a>
                                    <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                                    <input class="company_id" type="hidden" value="{{$job->company_id}}"/>
                                </div>
                                @endif
                                {{--Admin Option--}}
                                @if($module_permissions->where('slug','edit.applicants')->count() === 1)
                                <div class="applicant-options">
                                    {{--<a class="btn btn-edit btn-shadow bg-light-blue-gradient edit-applicant is-upload-document" href="#"><i class="fa fa-pencil" aria-hidden="true"></i>  Upload </a>--}}
                                    <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                                    <input class="company_id" type="hidden" value="{{$job->company_id}}"/>
                                </div>
                                @endif

                                <br />
                                @if(Auth::user('user'))
                                <textarea class="status-container">
                                            @if(isset($statuses))
                                            {{$statuses->tags}}
                                        @endif    
                                </textarea>
                                @endif
                                <a href="#move_applicant_{{ $applicant->id }}" class="pull-right move-btn btn btn-shadow btn-edit" style="{{ $display_move_btn }}" data-toggle="modal">Move</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{--region Move Applicant Modal--}}
                <div class="modal fade" id="move_applicant_{{ $applicant->id }}" tabindex="-1" role="basic" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                <h4 class="modal-title">Move to Briefcase</h4>
                            </div>
                            {!!  Form::open(['method' => 'POST','route' => ['task.store'],'class' => 'task-form'])  !!}
                            <div class="modal-body">
                                {!!  Form::hidden('belongs_to','project')  !!}
                                <div class="form-group">
                                    {!!  Form::select('unique_id',$projects, '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Project Name', 'tabindex' => '7'] )  !!}
                                </div>
                                <div class="form-group">
                                    {!!  Form::input('text','task_title', $applicant->name,['class' => 'form-control', 'placeholder' => 'Title', 'tabindex' => '1']) !!}
                                </div>
                                <div class="form-group">
                                    {!!  Form::textarea('task_description','',['size' => '30x3', 'class' => 'form-control',
                                    'placeholder' => 'Description', 'tabindex' => '2']) !!}
                                </div>
                                <div class="form-group">
                                    {!!  Form::input('text','due_date','',['class' => 'form-control form-control-inline
                                    input-medium date-picker', 'placeholder' => 'Due Date', 'tabindex' => '3', 'data-inputmask' => "'alias': 'dd-mm-yyyy'", 'data-mask' => 'true'])  !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group">
                                    {!!  Form::submit('Add',['class' => 'btn btn-shadow btn-edit', 'tabindex' => '5'])  !!}
                                </div>
                            </div>
                            {!!  Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="mini-space"></div>
            {{--*/ $collapse = $applicant->notes ? '' : '' /*--}}
            {{--*/ $str = str_replace('\\','/',$applicant->resume) /*--}}
            {{--*/ $file = explode('/',$str) /*--}}
            @if(Auth::check('user'))
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div id="collapse-container-1" class="panel task-list">
                            <div class="panel-heading task-header" id="notes-{{$applicant->id}}" data-toggle="collapse" data-target="#notes-collapse-{{ $applicant->id }}">
                                <div class="row">
                                    <h4 class="panel-title task-list-header">Notes</h4>
                                </div>
                            </div>
                            <div id="notes-collapse-{{ $applicant->id }}" class="box-content collapse">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <textarea id="applicant-notes" class="">{{$applicant->notes}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div id="collapse-container-1" class="panel task-list">
                            <div class="panel-heading task-header" id="notes-{{$applicant->id}}" data-toggle="collapse" data-target="#criteria-collapse-{{ $applicant->id }}">
                                <div class="row">
                                    <h4 class="panel-title task-list-header">Criteria</h4>
                                </div>
                            </div>
                            <div id="criteria-collapse-{{ $applicant->id }}" class="box-content collapse {{ $collapse }}">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <textarea id="assessment-instruction" data-job-id="{{ $job->id }}">{{$job->criteria}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div id="collapse-container-1" class="panel task-list">
                            <div class="panel-heading task-header" id="tests-{{$applicant->id}}" data-toggle="collapse" data-target="#tests-collapse-{{ $applicant->id }}">
                                <div class="row">
                                    <h4 class="panel-title task-list-header">Tests</h4>
                                </div>
                            </div>
                            <div id="tests-collapse-{{ $applicant->id }}" class="box-content collapse in">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        @include('applicants.partials._quizlist')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::check('user')|| Auth::check('applicant'))
            <div class="row">
                <div class="col-md-12">
                     <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div id="collapse-container-1" class="panel task-list">
                            <div class="panel-heading task-header" id="interview-questions-{{$applicant->id}}" data-toggle="collapse" data-target="#interview-questions-collapse-{{ $applicant->id }}">
                                <div class="row">
                                    <h4 class="panel-title task-list-header">Interview Questions</h4>
                                </div>
                            </div>
                            <div id="interview-questions-collapse-{{ $applicant->id }}" class="box-content collapse">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        @if(count($video_questions) > 0)
                                        @foreach($video_questions as $v)
                                <div class="tests-container">
                                    <div class="box box-default">
                                        <div class="box-container">
                                            <div class="box-header" id="question-{{ $v->id }}" data-toggle="collapse" data-target="#question-collapse-{{ $v->id }}">
                                                <h3 class="box-title">
                                                    <i class="fa fa-chevron-down" aria-hidden="true"></i>&nbsp;<?php
                                                    $v->question = preg_replace("/<\/*[a-z0-9\s\"'.=;:-]*>/i", "", $v->question);
                                                    echo $v->question;
                                                    ?>
                                                </h3>
                                                <div class="pull-right" style="margin-right: 10px;">
                                                    <strong>Time:</strong> {{ date('i:s', strtotime($v->length)) }}
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                @if(Auth::check('user'))
                                                <div id="question-collapse-{{$v->id}}" class="box-content collapse">
                                                    {!! $v->note !!}
                                                    <div class="form-inline">
                                                        <button type="button" class="btn btn-shadow btn-submit btn-video" data-status="1" data-test="{{ $v->test_id }}" data-unique="{{ $applicant->id }}" id="{{ $v->id }}">Record Answer</button>
                                                        <button type="button" class="btn refresh-interview-question-answers">Refresh Answers</button>
                                                        <div id="interview-questions-timer-{{$v->id}}" class="timer-area pull-right">{{ $v->length ? date('i:s', strtotime($v->length)) : '' }}</div>
                                                        <div class="recording-status-text"></div>
                                                        <input class="question_id" type="hidden" value="{{$v->id}}" />
                                                        <input class="original_time" type="hidden" value="{{$v->length ? date('i:s', strtotime($v->length)) : ''}}" />
                                                    </div>
                                                    <ul id="question-collapse-answers-{{$v->id}}" class="list-group">
                                                        @foreach($interview_question_answers->where('question_id',$v->id) as $answer)
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                            <div class="col-xs-9">
                                                            <a href="https://extremefreedom.org/recordings/{{$interview_question_answers_videos->where('id',$answer->video_id)->first()->filename}}.webm" data-toggle="lightbox" data-gallery="discussion-{{$room_number}}-gallery" data-type="url">
                                                                {{date('M d, Y H:i A', strtotime($interview_question_answers_videos->where('id',$answer->video_id)->first()->created_at))}}
                                                            </a>
                                                            </div>
                                                            <div class="col-xs-3">
                                                            <div class="input-group">
                                                                <input type="number" name="video-conference-points" id="{{ $answer->id }}" value="{{ $answer->score }}" step="1" max="{{ $v->max_point }}" class="form-control video-conference-points">
                                                                <div class="input-group-addon">/{{ $v->max_point }}</div>
                                                                <input class="question_id" type="hidden" value="{{$v->id}}" />
                                                                <input class="applicant_id" type="hidden" value="{{ $applicant->id }}" />
                                                                <input class="video_id" type="hidden" value="{{ $answer->video_id }}" />
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                                @if(Auth::check('applicant'))
                                                <div id="question-collapse-{{$v->id}}" class="box-content collapse">
                                                    <div class="form-inline">
                                                        <button type="button" class="btn btn-shadow btn-submit btn-video" data-status="1" data-test="{{ $v->test_id }}" data-unique="{{ $applicant->id }}" id="{{ $v->id }}">Record Answer</button>
                                                        <button type="button" class="btn refresh-interview-question-answers">Refresh Answers</button>
                                                        <div id="interview-questions-timer-{{$v->id}}" class="timer-area pull-right">{{ $v->length ? date('i:s', strtotime($v->length)) : '' }}</div>
                                                        <div class="recording-status-text"></div>
                                                        <input class="question_id" type="hidden" value="{{$v->id}}" />
                                                        <input class="original_time" type="hidden" value="{{$v->length ? date('i:s', strtotime($v->length)) : ''}}" />
                                                    </div>
                                                    <ul id="question-collapse-answers-{{$v->id}}" class="list-group">
                                                        @foreach($interview_question_answers as $answer)
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                            <div class="col-xs-8">
                                                            <a href="https://extremefreedom.org/recordings/{{$interview_question_answers_videos->where('id',$answer->video_id)->first()->filename}}.webm" data-toggle="lightbox" data-gallery="discussion-{{$room_number}}-gallery" data-type="url">
                                                                {{date('M d, Y H:i A', strtotime($interview_question_answers_videos->where('id',$answer->video_id)->first()->created_at))}}
                                                            </a>
                                                            </div>
                                                            <div class="col-xs-4">
                                                                {{ $answer->score }}/{{ $v->max_point }}
                                                            </div>
                                                        </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            @endif
            </div>
        <div class="col-xs-6 applicant">
            @if(Auth::check('user') || Auth::check('applicant'))
            
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="pill" href="#resume">Resume</a></li>
              <li><a data-toggle="pill" href="#video-conference">Video Conference</a></li>
            </ul>

            <div class="tab-content">
                <div id="resume" class="tab-pane fade in active">
                    @if(file_exists(public_path() .'/' . $str))
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{{ url('downloadFile?file=' . $str)}}" class="btn btn-edit btn-shadow" data-toggle="tooltip" title="Download {{end($file)}}" data-placement="right">
                            <i class="glyphicon glyphicon-file"></i> {{end($file)}}</a>
                        </div>
                    </div>
                    @endif
                    @if(pathinfo(url($str),PATHINFO_EXTENSION) === 'pdf') 
                    <iframe class="applicant-posting-resume" src="https://docs.google.com/viewer?url={{url($str)}}&embedded=true"></iframe>
                    @endif
                    @if(pathinfo(url($str),PATHINFO_EXTENSION) === 'docx' || pathinfo(url($str),PATHINFO_EXTENSION) === 'doc')
                    <iframe class="applicant-posting-resume" src="https://view.officeapps.live.com/op/view.aspx?src={{url($str)}}"></iframe>
                    @endif
                </div>    
              <div id="video-conference" class="tab-pane fade">
                <div class="row">
                <div class="col-xs-12">
                    <div id="video-conference-container" class="video-conference-container">
                            <div class="row" id="remoteVideo">
                                    <div class="col-xs-6" id="localVideoContainer">
                                <div class="panel-group">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">{{$display_name}}</h4>
                                            </div>
                                    <div class="panel-body">
                                            <video id="localVideo"></video>
                                            <div class="row">
                                                <div class="col-xs-5">
                                                    <div class="blink hidden"><i class="fa fa-circle text-danger"></i>&nbsp;<span class="blink-text">Recording</span></div>        
                                                </div>
                                                <div class="col-xs-7">
                                                  <div id="progress" class="progress hidden">
                                                  <div style="color:#000;font-weight:bold" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                      Processing 0% Complete
                                                  </div>
                                                  </div>
                                                <input class="processing-percent" type="hidden" value="0"/>        
                                                </div>
                                            </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="btn-group" role="group" aria-label="Local Media Options">
                                                    <button class="btn record"><i class="material-icons">fiber_manual_record</i><span class="record-text"></span></button>
                                                    <button class="btn  stop-video"><i class="material-icons">videocam</i></button>            
                                                    <button class="btn  mute"><i class="material-icons">mic</i></button>
                                                    <a class="btn toggle-media-options" data-toggle="collapse" href="#local-media-options"><i class="material-icons">settings</i></a>
                                                    <input class="video_type" type="hidden" value="local"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="local-media-options" class="panel-collapse collapse">
                            <div class="mini-space"></div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    <i class="material-icons">videocam</i>
                                </span>
                                <select id="video-camera-list" class="btn form-control" data-show-icon="true"></select>       
                            </div>
                            <div class="mini-space"></div>
                            <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon2">
                                        <i class="material-icons">mic</i>    
                                    </span>
                                    <select id="audio-input-list" class="btn form-control" data-show-icon="true"></select>                        
                            </div>
                            </div>
                                    </div>
                                </div>
                            </div>
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
    <div id="chat-box-container">
        <div class="mini-space"></div>
        <div class="chat-box">
              <div id="comment-list-{{$applicant->id}}" class="comment-list">
                @unless($comments->count())
                <div class="no-comment-notifier"></div>
                @else
                @foreach($comments as $comment)
                <div id="comment-item-{{$comment->comment_id}}" class="comment-item">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                @if(isset($comment->user->photo) && file_exists(public_path().'/'.$comment->user->photo))
                                <img class="comment-photo" src="{{url($comment->user->photo)}}" alt="Employee Photo">
                                @elseif(isset($comment->applicant->photo) && file_exists(public_path().'/'.$comment->applicant->photo))
                                <img class="comment-photo" src="{{url($comment->applicant->photo)}}" alt="Employee Photo">
                                @else
                                <img class="comment-photo" src="{{url('assets/user/avatar.png')}}" alt="Employee Photo">
                                @endif
                            </a>
                            @if(isset($comment->user->name))
                            <text class="media-heading">{{$comment->user->name}}</text>
                            @else
                            <text class="media-heading">{{$comment->applicant->name}}</text>
                            @endif
                        </div>
                        <div class="media-body media-right">

                            <p class="comment">{!!nl2br(e($comment->comment))!!}</p>
                        </div>
                        <input class="comment_id" type="hidden" value="{{$comment->comment_id}}">
                        <input class="applicant_id" type="hidden" value="{{$comment->applicant->applicant_id}}">
                    </div>
                    @if($user_info->commenter_id === $comment->user_id && Auth::check("user") 
                    || $comment->commenter_id === 0 && Auth::check("applicant"))
                    <table class="comment-utilities">
                        <tr>
                            <td><a href="#" class="delete-comment"><i class="fa fa-times"></i></a></td>
                        </tr>
                    </table>
                    @endif
                </div>
                <!--div class="mini-space"></div-->
                @endforeach
                @endunless
            </div>
            <div class="mini-space"></div>
            @include('forms.addCommentForm')
        </div>
    </div>
</div>
<div class="mini-space"></div>
<input class="applicant_score" type="hidden" value="{{$rating->score or ''}}"/>
<input class="page_applicant_id" type="hidden" value="{{$applicant->id}}"/>
<input class="job_id" type="hidden" value="{{$applicant->job_id}}"/>
<input class="page_type" type="hidden" value="applicant"/>
<input class="_token" type="hidden" value="{{csrf_token()}}"/>

<div class="footer">
    <div class="panel-group" id="accordion2">
        <div class="panel">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-12">
                  <button class="btn toggle-panel-chat">Open Chat<span class="badge chat-badge">0</span></button>
                  <button data-toggle="collapse" data-parent="#accordion2" href="#video-archive-container" class="btn toggle-video-archive">Open Video Archive</button>
                  </div>
              </div>
              </div>
          <div id="video-archive-container" class="panel-collapse collapse">
             <div id="video-archive">
              <div class="row" class="panel-body">
              @if($recorded_videos->count() > 0)
              @foreach($recorded_videos as $video)
              <div class="video-archive-element col-xs-3">
                  <div class="row video-subject-name">
                      <div class="col-xs-12 subject-name-container">
                          <span class="subject_name">{{$video->subject_name}}</span>
                      </div>
                  </div>
                  <div class="row video-title">
                      <div class="col-xs-10">
                      @if($video->alias == "")
                      <label class="video-label">No Title</label>
                      <input class="form-control edit-title hidden" type="text" value="" placeholder="Enter new title"/>
                      @else
                      <label class="video-label">{{$video->alias}}</label>
                      <input class="form-control edit-title hidden" type="text" value="{{$video->alias}}" placeholder="Enter new title"/>
                      @endif
                      </div>
                      <div class="col-xs-2">
                      <a class="btn-edit-video-title"><i class="material-icons">mode_edit</i></a>
                      <a class="btn-save-video-title hidden"><i class="material-icons">done</i></a>
                      <a class="btn-delete-video"><i class="material-icons">delete_forever</i></a>
                      <input class="recorded_video_id" type="hidden" value="{{$video->id}}"/>
                      </div>
                  </div>
                  
                  <a id="container_{{$video->filename}}" href="https://extremefreedom.org/recordings/{{$video->filename}}.webm" data-toggle="lightbox" data-gallery="discussion-{{$room_number}}-gallery" data-type="url">
                  <img class="img-responsive" src="https://extremefreedom.org/recordings/{{$video->filename}}.png">
                  </a>
                  <div class="row video-archive-item-options center-block">
                      <div class="col-xs-12">
                            <input class="form-control video-tags" type="text" name="tags" placeholder="Enter Tags" value="{{$video->tags['tags']}}">
                            <input class="recorded_video_id" type="hidden" value="{{$video->id}}"/>
                      </div>
                  </div>
                  <div class="row video-archive-item-details">
                      <div class="col-xs-6 recorded_on">{{date('M d, Y H:i A', strtotime($video->created_at))}}</div>
                      <div class="col-xs-6">
                          <span class="recorded_by pull-right">By: {{$video->recorded_by}}</span>
                          </div>
                  </div>
              </div>
              @endforeach
              @else
              <div class="chat-bubble">No Videos&nbsp;<button class="btn refresh-video-archive">Refresh Video Archive</button></div>
              @endif
              </div>
              <div class="panel-footer pagination-footer">
                @if($recorded_videos->count() > 0)
                <ul class="pagination">
                    @if($recorded_videos->currentPage() != 1) 
                    <li><a class="previous" href="{{$recorded_videos->previousPageUrl()}}">Previous</a></li>
                    @endif
                    @for($i = 1; $i <= $recorded_videos->lastPage(); $i++)
                    @if($recorded_videos->currentPage() == $i) 
                    @if($recorded_videos->lastPage() > 1)
                    <li class="active"><a class="pager-element" href="{{$recorded_videos->url($i)}}">{{$i}}</a></li>
                    @endif
                    @else
                    <li ><a class="pager-element" href="{{$recorded_videos->url($i)}}">{{$i}}</a></li>
                    @endif
                    @endfor
                    @if($recorded_videos->currentPage() != $recorded_videos->lastPage()) 
                    <li><a class="next" href="{{$recorded_videos->nextPageUrl()}}">Next</a></li>
                    @endif
                </ul>
                <button class="btn refresh-video-archive">Refresh Video Archive</button>
                @endif
                </div>
</div>
<input class="current-video-page" type="hidden" value="{{$recorded_videos->url($recorded_videos->currentPage())}}"/>
</div>
</div>
</div>
</div>
<input class="user_id" type="hidden" value="{{$user_id}}"/>
<input class="user_type" type="hidden" value="{{$user_type}}"/>
<input class="display_name" type="hidden" value="{{$display_name}}"/>
<input class="room_type" type="hidden" value="{{$room_type}}"/>
<input class="room_number" type="hidden" value="{{$room_number}}"/>
@stop
