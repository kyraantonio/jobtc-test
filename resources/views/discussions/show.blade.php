@extends('layouts.default')
@section('content')
<?php
/*
 * Discussions room page
 */
?>
<div class="topbar">
<div id="localVideoOptions">            
            <button class="btn add-participant"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add Participant</button>
            <button class="btn share-screen"><i class="fa fa-desktop" aria-hidden="true"></i>&nbsp;Share Screen</button>
            <button class="btn leave-discussion"><i class="fa fa-sign-out" aria-hidden="true"></i>Leave Discussion</button>
</div>
</div>
<div id="discussions-container">

<div id="video-container">
        <div class="row-fluid" id="remoteVideo">
            <div id="localVideoContainer" class="col-xs-3 localVideoContainer">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{$display_name}}</h4>
                        </div>
                            <div class="panel-body">
                                <video id="localVideoEl"></video>
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
                                    <div class="col-xs-5">
                                        <button class="btn record"><i class="material-icons">fiber_manual_record</i><span class="record-text">Record</span></button>
                                        <input class="video_type" type="hidden" value="local"/>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="btn-group" role="group" aria-label="Local Media Options">
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
<div id="chat-box-container">
        <div class="chat-box">
            <div class="panel panel-default">
                <div id="message-log" class="panel-body">
                    @if($chat->count() > 0)
                    @foreach($chat as $message)
                    <div class="row">
                        <div class="col-xs-6 sender-name">
                            {{$message->display_name}}:
                        </div>
                        <div class="col-xs-6 text-right date-sent">
                            {{
                            date_format(date_create($message->created_at),"M d H:i")
                            }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-10 chat-bubble-left">
                            {!! $message->message !!}        
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="message" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" disabled="disabled" id="send-message">Send</button>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <label class="btn btn-sm browse-btn">
                                <i class="fa fa-file" aria-hidden="true" for="sendFile"></i>
                                <input id="sendFile" type="file" class="btn btn-warning btn-sm" value="Send File" />
                            </label>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<input class="display_name" type="hidden" value="{{$display_name}}"/>
<input class="room_type" type="hidden" value="{{$room_type}}"/>
<input class="room_number" type="hidden" value="{{$room_number}}"/>
</div>

<div class="footer">
    <div class="panel-group discussion-nav" id="accordion">
        <div class="panel">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-12">
                  <button class="btn toggle-panel-chat">Open Chat<span class="badge chat-badge">0</span></button>
                  <button data-toggle="collapse" data-parent="#accordion" href="#video-archive-container" class="btn toggle-video-archive">Open Video Archive</button>
                  </div>
              </div>
              </div>
          <div id="video-archive-container" class="panel-collapse collapse">
             <div id="video-archive">
              <div class="row video-archive-body" class="panel-body">
              @if($recorded_videos->count() > 0)
              @foreach($recorded_videos as $video)
              <!--<div class="video-archive-element col-xs-3">-->
              <div class="video-archive-element">
                  <div class="row video-subject-name">
                      <div class="col-xs-12 subject-name-container">
                          <span class="subject_name">{{$video->subject_name}}</span>
                      </div>
                  </div>
                  <a id="container_{{$video->filename}}" href="https://extremefreedom.org/recordings/{{$video->filename}}.webm" data-toggle="lightbox" data-gallery="discussion-{{$room_number}}-gallery" data-type="url">
                  <img class="img-responsive" src="https://extremefreedom.org/recordings/{{$video->filename}}.png">
                  </a>
                  <div class="row video-title">
                      <div class="col-xs-8">
                      @if($video->alias == "")
                      <label class="video-label">No Title</label>
                      <input class="form-control edit-title hidden" type="text" value="" placeholder="Enter new title"/>
                      @else
                      <label class="video-label">{{$video->alias}}</label>
                      <input class="form-control edit-title hidden" type="text" value="{{$video->alias}}" placeholder="Enter new title"/>
                      @endif
                      </div>
                      <div class="col-xs-4 text-right">
                      <a class="btn-edit-video-title"><i class="material-icons">mode_edit</i></a>
                      <a class="btn-save-video-title hidden"><i class="material-icons">done</i></a>
                      <a class="btn-delete-video"><i class="material-icons">delete_forever</i></a>
                      <input class="recorded_video_id" type="hidden" value="{{$video->id}}"/>
                      </div>
                  </div>
                  <div class="row video-archive-item-options center-block">
                      <!--<div class="col-xs-12">-->
                            <input class="form-control video-tags" type="text" name="tags" placeholder="Enter Tags" value="{{$video->tags['tags']}}">
                            <input class="recorded_video_id" type="hidden" value="{{$video->id}}"/>
                      <!--</div>-->
                  </div>
                  <!--<div class="row video-archive-item-details">
                      <div class="col-xs-6 recorded_on">{{date('M d, Y H:i A', strtotime($video->created_at))}}</div>
                      <div class="col-xs-6 ">
                          <span class="recorded_by pull-right">By: {{$video->recorded_by}}</span>
                          </div>
                  </div>-->
                  <div class="row video-archive-item-details">{{date('M d, Y H:i A', strtotime($video->created_at))}} &middot; By: {{$video->recorded_by}}</div>
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
</div>
<audio controls class="incoming-chat-sound hidden" src="{{url('assets/sounds/chat-chime-sound.wav')}}"></audio>
<audio controls class="incoming-user-sound hidden" src="{{url('assets/sounds/incoming-user-bell.wav')}}"></audio>
@stop