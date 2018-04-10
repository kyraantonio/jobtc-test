@extends('layouts.default')
@section('content')
<div class="applicant-posting-container container-fluid">
    <div class="row">
        <div class="applicant-posting-info hidden-lg hidden-md hidden-sm">
            <div class="row">
                <div class="col-md-12">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                @if($profile->user->photo !== '' || $profile->user->photo !== NULL)
                                <img class="img-thumbnail media-object employee-photo" src="{{url($profile->user->photo)}}" alt="Employee Photo">
                                @else
                                <img class="img-thumbnail media-object employee-photo" src="{{url('assets/user/avatar.png')}}" alt="Employee Photo">
                                @endif
                            </a>
                        </div>
                        <div class="media-body media-right">
                            <a href="#" class="btn btn-default pull-right interview-applicant"><i class="fa fa-comment-o"></i></a>
                            <text class="media-heading">{{$profile->user->name}}</text>
                            <br />
                            <a href="tel:{{$profile->user->phone}}" class="applicant-phone">{{$profile->user->phone}}</a>
                            <br />
                            <a href="mailto:{{$profile->user->email}}" class="applicant-email">{{$profile->user->phone}}</a>
                            <br />
                            <text class="applicant-job-title">{{$role->name}}</text>
                            <br />
                            <text>{{date_format(date_create($profile->user->created_at),'M d,Y')}}</text>
                            <br />
                            <textarea class="status-container">
                            @if(isset($user_tags))            
                            {{$user_tags->tags}}
                            @endif
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div id="applicant-{{$count}}" class="applicant">
                <input class="token" name="_token" type="hidden" value="{{csrf_token()}}">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#resume-tab" aria-controls="home" role="tab" data-toggle="tab">Resume</a>
                    </li>
                    <li role="presentation">
                        <a href="#video-tab" aria-controls="profile" role="tab" data-toggle="tab">Video Conference</a>
                    </li>
                    <li role="presentation">
                        <a href="#video-archive-tab" aria-controls="profile" role="tab" data-toggle="tab">Video Archive</a>
                    </li>
                    <li role="presentation">
                        <a href="#tests-tab" aria-controls="profile" role="tab" data-toggle="tab">Tests</a>
                    </li>
                    <li role="presentation">
                        <a href="#notes-tab" aria-controls="profile" role="tab" data-toggle="tab">Notes</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="resume-tab">
                        <iframe class="applicant-posting-resume" src="https://docs.google.com/viewer?url={{url($profile->user->resume)}}&embedded=true"></iframe>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="video-tab">
                        <div class="video-conference-container">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="localVideoContainer">
                                        <div id="localVideo"></div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div id="remotes">
                                        <div id="remoteVideo"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="video-options text-center">
                                        <button class="btn btn-default btn-shadow mute-button"><i class="fa fa-microphone"></i>&nbsp;<span>Mute</span></button>
                                        <button class="btn btn-default btn-shadow show-video-button"><i class="fa fa-eye"></i>&nbsp;<span>Stop Video</span></button>
                                        <button class="btn btn-default btn-shadow record-button"><i class="fa fa-circle"></i>&nbsp;<span>Start Recording</span></button>
                                        <button href="#" class="btn btn-success btn-shadow interview-applicant"><i class="fa fa-phone"></i>&nbsp;<span>Join Conference</span></button>
                                        <div class="video-options-text pull-right">
                                            <text class="save-progress"></text>
                                            <text class="total-files"></text>
                                        </div>
                                    </div>
                                    <audio controls class="download-complete-sound" src="{{url('assets/sounds/download_complete.wav')}}"></audio>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="preview-video text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="video-archive-tab">
                        <div class="video-page-container">
                            @foreach($videos as $video)
                            <div class="video-element-holder">
                                <div class="row">
                                    <div class="col-xs-10">
                                        <video id="video-archive-item-{{$video->id}}" class="video-archive-item" controls="controls"  preload="metadata" src="{{url($video->video_url)}}">
                                            Your browser does not support the video tag.
                                            <!--source src="{{url($video->video_url)}}"-->
                                        </video>
                                    </div>
                                    <div class="col-xs-2">
                                        <button class="btn btn-danger btn-shadow pull-right delete-video"><i class="fa fa-times"></i></button>
                                        <input class="video_id" type="hidden" value="{{$video->id}}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <textarea class="video-status-container">
                                                {{$video->tags['tags']}}
                                        </textarea>
                                        <input class="video_id" type="hidden" value="{{$video->id}}"/>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tests-tab">

                    </div>
                    <div role="tabpanel" class="tab-pane" id="notes-tab">
                        <textarea id="employee-notes">{{$profile->user->notes}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="applicant-posting-info hidden-xs">
                <div class="row">
                    <div class="col-md-12">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    @if($profile->user->photo === '' || $profile->user->photo === NULL)
                                    <img class="img-thumbnail media-object profile-photo" src="{{url('/assets/user/default-avatar.jpg')}}" alt="Applicant Photo">
                                    @else
                                    <img class="img-thumbnail media-object profile-photo" src="{{url($profile->user->photo)}}" alt="Applicant Photo">
                                    @endif
                                </a>
                            </div>
                            <div class="media-body media-right">
                                <text class="media-heading">{{$profile->user->name}}</text>
                                <br />
                                <div class="employee-position">
                                    <i class="fa fa-flag" aria-hidden="true"></i>
                                    <text>{{$role->name}}</text>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="employee-email">
                                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                            <a href="mailto:{{$profile->user->email}}">{{$profile->user->email}}</a>
                                        </div>
                                        <div class="employee-phone">
                                            <i class="fa fa-phone-square" aria-hidden="true"></i>
                                            <a href="tel:{{$profile->user->phone}}">{{$profile->user->phone}}</a>
                                        </div>
                                        <div class="employee-skype">
                                            <i class="fa fa-skype" aria-hidden="true"></i>
                                            <a href="skype:{{$profile->user->skype}}" class="applicant-skype">{{$profile->user->skype}}</a>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="employee-address">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <text>{{$profile->user->address_1}}</text>
                                        </div>
                                        <div class="employee-address">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <text>{{$profile->user->address_2}}</text>
                                        </div>
                                        <div class="employee-address">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <text>{{$profile->user->zipcode}}</text>
                                        </div>
                                        <div class="employee-country">
                                            <i class="fa fa-globe" aria-hidden="true"></i>&nbsp;
                                            @if(isset($country))
                                            <text>{{$country->country_name}}</text>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <textarea class="status-container">
                      @if(isset($user_tags))            
                            {{$user_tags->tags}}
                            @endif                     
                    </textarea>
                </div>
            </div>
            @if(Auth::check('user'))
            <div class="mini-space"></div>
            <div id="comment-list-{{$profile->user->user_id}}" class="comment-list">
                @unless($comments->count() === 0)
                <div class="no-comment-notifier"></div>
                @else
                @foreach($comments as $comment)
                <div id="comment-item-{{$comment->comment_id}}" class="comment-item">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                @if(isset($comment->user->photo))
                                <img class="comment-photo" src="{{url($comment->user->photo)}}" alt="Employee Photo">
                                @else
                                <img class="comment-photo" src="{{url('assets/user/avatar.png')}}" alt="Employee Photo">
                                @endif
                            </a>
                            <text class="media-heading">{{$comment->user->name}}</text>
                        </div>
                        <div class="media-body media-right">

                            <p class="comment">{!!nl2br(e($comment->comment))!!}</p>
                        </div>
                        <input class="comment_id" type="hidden" value="{{$comment->comment_id}}">
                        <input class="user_id" type="hidden" value="{{$comment->user->user_id}}">
                    </div>
                    <table class="comment-utilities">
                        <tr>
                            <td><a href="#" class="delete-comment"><i class="fa fa-times"></i></a></td>
                        </tr>
                    </table>
                </div>
                <!--div class="mini-space"></div-->
                @endforeach
                @endunless
            </div>
            <div class="mini-space"></div>
            @include('forms.addCommentForm')
            @endif
        </div>
    </div>
</div>
<div class="mini-space"></div>
<input class="employee_id" type="hidden" value="{{$profile->user->user_id}}"/>
<input class="page_type" type="hidden" value="employee"/>
@stop