@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-md-6">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Inbox</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Sent</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="box box-success">
                            <div class="box-body chat" id="chat-box">
                                @foreach($inbox as $inbox_message)
                                    <div class="item">
                                        <img src="{{ \App\Helpers\Helper::getAvatar($inbox_message->from_username) }}"
                                             alt="user image" class="online"/>
                                        <p class="message">
                                            <a href="#" class="name">
                                                <small class="text-muted pull-right"><i
                                                            class="fa fa-clock-o"></i> {{ date("d M Y h:ia",strtotime($inbox_message->created_at)) }}
                                                </small>
                                                {{ $inbox_message->from_username }}
                                            </a>
                                            {!!  $inbox_message->message_content  !!}
                                        </p>

                                        @if($inbox_message->file)
                                            <div class="attachment">
                                                <h4>Attachment:</h4>
                                                <p class="filename">
                                                    {{ $inbox_message->file }}
                                                </p>
                                                <div class="pull-right">
                                                    <a href="{{ url('assets/message_attachment/'.$inbox_message->file) }}">
                                                        <button class="btn btn-primary btn-sm btn-flat">Open</button>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if(count($inbox)==0)
                            <div class='alert alert-danger'>
                                <i class='fa fa-ban'></i>
                                <strong>No message found!!</strong>
                            </div>
                        @endif

                    </div>
                    <div class="tab-pane" id="tab_2">
                        <div class="box box-success">
                            <div class="box-body chat" id="chat-box">
                                @foreach($sent as $sent_message)
                                    <div class="item">
                                        <img src="{{ \App\Helpers\Helper::getAvatar($sent_message->to_username) }}" alt="user image"
                                             class="online"/>
                                        <p class="message">
                                            <a href="#" class="name">
                                                <small class="text-muted pull-right"><i
                                                            class="fa fa-clock-o"></i> {{ date("d M Y h:ia",strtotime($sent_message->created_at)) }}
                                                </small>
                                                {{ $sent_message->to_username }}
                                            </a>
                                            {!!  $sent_message->message_content  !!}
                                        </p>

                                        @if($sent_message->file)
                                            <div class="attachment">
                                                <h4>Attachment:</h4>
                                                <p class="filename">
                                                    {{ $sent_message->file }}
                                                </p>
                                                <div class="pull-right">
                                                    <a href="{{ url('assets/message_attachment/'.$sent_message->file) }}">
                                                        <button class="btn btn-primary btn-sm btn-flat">Open</button>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if(count($sent)==0)
                            <div class='alert alert-danger'>
                                <i class='fa fa-ban'></i>
                                <strong>No message found!!</strong>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Send Message</h3>
                </div>
                {!!  Form::open(['files' => 'true', 'route' => 'message.store','class' => 'message-form'])  !!}
                <div class="box-body">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ \App\Helpers\Helper::getAvatar(Auth::user()->username) }}" class="img-circle"
                                 alt="User Image"/>
                        </div>
                        <div class="pull-left info">
                            <p style="color:black;">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        {!!  Form::select('to_username', [null=>'Message to'] + $users, '', ['class' => 'form-control',
                         'tabindex' => '1'] )  !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::input('text','message_subject','',['class' => 'form-control', 'placeholder' =>
                        'Subject', 'tabindex' => '2']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::textarea('message_content','',['size' => '30x8', 'class' => 'form-control textarea',
                        'placeholder' => 'Message Content', 'tabindex' => '3']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::input('file','file','') !!}
                    </div>
                </div>
                <div class="box-footer">
                    {!!  Form::submit('Send',['class' => 'btn btn-edit btn-shadow', 'tabindex' => '20'])  !!}
                </div>
                {!!  Form::close()  !!}
            </div>
        </div>
    </div>
@stop