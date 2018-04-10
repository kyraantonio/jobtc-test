<div class="col-md-12">
    <div class="row">
        <div class="col-md-8">
            <div class="panel-group test-group">
                <div class="box box-default">
                    <div class="box-container">
                        <div class="box-header">
                            <h3 class="box-title">{{ $tests_info->title }}</h3>
                            <div class="pull-right" style="margin-right: 10px;">
                                <a href="{{ url($company_id ? 'quizPerCompany/' . $company_id : 'quiz') }}" class="tc-icons">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="box-content">
                                <div class="slider-container">
                                    <div class="slider-div text-center active">
                                        <div class="slider-body">
                                            <span style="font-size: 23px;">{!! $tests_info->start_message !!}</span>
                                            <br />
                                            <button type="button" class="btn btn-shadow btn-submit btn-next">Start</button>
                                        </div>
                                    </div>
                                    @foreach($questions_info as $ref=>$v)
                                    <div class="slider-div">
                                        <div class="slider-body" style="{{ $v->question_type_id == 4 ? 'width: 800px;' : '' }}">
                                            <div class="form-group">
                                                <span style="font-size: 23px;">{!! $v->question !!}</span>
                                            </div>
                                            {!! $v->question_photo ?
                                                '<div class="form-group">' .
                                                HTML::image('/assets/img/question/' . $v->question_photo, '', array('style' => 'width: 100%;')) .
                                                '</div>' :
                                                ''
                                            !!}
                                            @if($v->question_type_id == 1)
                                                @foreach($v->question_choices as $k=>$c)
                                                    <div class="answer-area form-group">
                                                        <input type="radio" class="simple radio" name="answer[{{ $v->id }}]" id="radio-{{ $k }}-{{ $v->id }}" value="{{ $k }}" />
                                                        <label for="radio-{{ $k }}-{{ $v->id }}">{{ $c }}</label>
                                                    </div>
                                                @endforeach
                                            @elseif($v->question_type_id == 2)
                                                <div class="form-group">
                                                    <input type="text" name="answer[{{ $v->id }}]" class="form-control" placeholder="answer here..." />
                                                </div>
                                            @elseif($v->question_type_id == 3)
                                                <div class="form-group">
                                                    <textarea name="answer[{{ $v->id }}]" class="form-control summernote-editor" rows="3" placeholder="answer here..."></textarea>
                                                </div>
                                            @elseif($v->question_type_id == 4)
                                                <div class="quiz-video" id="quiz-video-{{ $v->id }}"></div>
                                            @endif
                                            <div class="text-center">
                                                <button type="button" data-type="{{ $v->question_type_id }}" class="btn btn-shadow btn-submit btn-next{{ $v->question_type_id == 4 ? ' hidden' : '' }}" id="{{ $v->id }}">Next</button>
                                                <button type="button" class="btn btn-shadow btn-timer time-limit hidden" data-length="{{ $v->length ? $v->length : '' }}">
                                                    <span class="timer-area">{{ $v->length ? date('i:s', strtotime($v->length)) : '' }}</span>
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="slider-div text-center">
                                        <div class="slider-body">
                                            <span style="font-size: 23px;">{!! $tests_info->completion_message !!}</span>
                                            @if($tests_info->completion_image)
                                                {!! HTML::image('/assets/shared-files/image/' . $tests_info->completion_image, '') !!}
                                            @endif
                                            @if($tests_info->completion_sound)
                                                @if(\App\Helpers\Helper::checkFileIsAudio($tests_info->completion_sound))
                                                    <audio class="player" src="{{ url() . '/assets/shared-files/sound/' . $tests_info->completion_sound }}"></audio>
                                                @endif
                                            @endif
                                            <br />
                                            <a class="btn btn-shadow btn-finish" href="{{ url('quiz/' . $v->test_id . '?p=review') }}">Complete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @include('quiz.result')
        </div>
    </div>
</div>

<style>
    .slider-container{
        display: table;
        margin: 0 auto;
    }
    .slider-div{
        height: 300px;
        display: none;
    }
    .slider-div.active{
        display: table-row;
    }
    .slider-body{
        padding: 15px;
        /*width: 500px;*/
        vertical-align: middle;
        display: table-cell;
    }
    .answer-area{
        margin-left: 20px;
        font-size: 19px;
    }
</style>

@section('js_footer')
@parent

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.7.3/summernote.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.7.3/summernote.min.js"></script>
{!!  HTML::script('assets/js/erizo.js')  !!}

<style>
    .note-editable{
        height: 400px;
    }
    .quiz-video{
        height: 600px;
        width: 100%;
    }
</style>
<script>
    var interval;
    $(function(e){
        var slider_div = $('.slider-div');
        var btn_next = $('.btn-next');
        var btn_prev = $('.btn-prev');
        var recordingId = '', room, localStream;

        //region Video
        var recordingUrl = "https://laravel.software/recordings/";
        var serverUrl = "https://laravel.software:3333/";

        var createToken = function (room_id, username, role, callback) {
            var req = new XMLHttpRequest();
            var url = serverUrl + 'createToken/';
            var body = {room_id: room_id, username: 'user', role: 'presenter'};
            req.onreadystatechange = function () {
                if (req.readyState === 4) {
                    callback(req.responseText);
                }
            };
            req.open('POST', url, true);
            req.setRequestHeader('Content-Type', 'application/json');
            req.send(JSON.stringify(body));
        };
        var createRoom = function (room_name, callback) {
            var req = new XMLHttpRequest();
            var url = serverUrl + 'createRoom/';
            var body = {room_name: room_name};
            req.onreadystatechange = function () {
                if (req.readyState === 4) {
                    callback(req.responseText);
                }
            };
            req.open('POST', url, true);
            req.setRequestHeader('Content-Type', 'application/json');
            req.send(JSON.stringify(body));
        };
        var saveVideo = function(localStreamId){
            var file_extension = '.webm';
            var video_url = recordingUrl + localStreamId + file_extension;

            var ajaxurl = public_path + 'quizSaveVideo';
            var formData = new FormData();
            formData.append('stream_id', localStreamId);
            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {

                },
                success: function (data) {
                    console.log('save video');
                },
                complete: function () {

                },
                error: function (xhr, status, error) {
                    console.log('Error: retrying');
                }
            }); //ajax
        };
        //endregion

        btn_next.click(function(e){
            var thisId = this.id;
            var type = $(this).data('type');
            var slider_div = $(this).closest('.slider-div');
            if(thisId){
                var thisElement = $('input[name="answer[' + thisId + ']"]');
                var answer =
                    type == 3 ?
                    $('textarea[name="answer[' + thisId + ']"]').summernote('code') :
                    (
                        thisElement.attr('type') == "radio" ?
                            $('input[name="answer[' + thisId + ']"]:checked').val() :
                            thisElement.val()
                    );
                var data = {
                   question_id: thisId,
                   answer: answer == undefined ? '' : answer
                };
                console.log(recordingId);
                if(recordingId){
                    room.stopRecording(recordingId, function(result, error){
                        if (result === undefined){
                            console.log("Error", error);
                        } else {
                            saveVideo(recordingId);
                            recordingId = '';
                        }
                    });
                    data.record_id = recordingId;
                    localStream.close();
                }
                $.ajax({
                    url: '{{ URL::to('quiz') . '?id=' . $tests_info->id }}&p=exam',
                    data: data,
                    method: "POST",
                    success: function(doc) {
                        slider_div.remove();
                    },
                    error: function(a, b, c){

                    }
                });
            }

            clearInterval(interval);
            $(this)
                .closest('.slider-div')
                .removeClass('active')
                .next('.slider-div')
                .addClass('active');

            var time_limit = $(this)
                .closest('.slider-div')
                .next('.slider-div')
                .find('.time-limit');
            var nextBtn = $(this)
                .closest('.slider-div')
                .next('.slider-div')
                .find('.btn-next');
            var quiz_video = $(this)
                .closest('.slider-div')
                .next('.slider-div')
                .find('.quiz-video');
            if(quiz_video.length != 0){
                createRoom("quiz-{{ Auth::user('user')->user_id }}", function (room_id) {
                    createToken(room_id, "user", "presenter", function (token) {
                        room = Erizo.Room({ token: token });

                        //region Record and Save Video
                        localStream = Erizo.Stream({ audio: true, video: true, data: true });
                        localStream.addEventListener("access-accepted", function () {
                            var subscribeToStreams = function (streams) {
                                for (var index in streams) {
                                    var stream = streams[index];
                                    if (localStream.getID() !== stream.getID()) {
                                        room.subscribe(stream);
                                    }
                                }
                            };

                            room.addEventListener("room-connected", function (roomEvent) {
                                room.publish(localStream);
                                subscribeToStreams(roomEvent.streams);
                            });

                            room.addEventListener("stream-subscribed", function(streamEvent) {
                                var stream = streamEvent.stream;
                                var div = document.createElement('div');
                                div.setAttribute("style", "width: 320px; height: 240px;");
                                div.setAttribute("id", "test" + stream.getID());

                                document.body.appendChild(div);
                                stream.play("test" + stream.getID());
                            });

                            room.addEventListener("stream-added", function (streamEvent) {
                                var streams = [];
                                streams.push(streamEvent.stream);
                                subscribeToStreams(streams);

                                room.startRecording(localStream, function(rId, error) {
                                    if (rId === undefined){
                                        console.log("Error", error);
                                    } else {
                                        recordingId = rId;
                                        console.log("Recording started, the id of the recording is ", rId);

                                        nextBtn.removeClass('hidden');
                                        if(time_limit.length != 0){
                                            console.log(recordingId);
                                            if(time_limit.data('length') != "00:00:00"){
                                                time_limit.removeClass('hidden');
                                                time_limit.timerStart();
                                            }
                                        }
                                    }
                                });
                            });

                            room.addEventListener("stream-removed", function (streamEvent) {
                                // Remove stream from DOM
                                var stream = streamEvent.stream;
                                if (stream.elementID !== undefined) {
                                    var element = document.getElementById(stream.elementID);
                                    document.body.removeChild(element);
                                }
                            });

                            room.connect();
                            localStream.play(quiz_video.attr('id'));
                        });
                        localStream.init();
                        //endregion
                    });
                });
            }
            else{
                if(time_limit.length != 0){
                    if(time_limit.data('length') != "00:00:00"){
                        time_limit.removeClass('hidden');
                        time_limit.timerStart();
                    }
                }
            }

            var player = $(this)
                .closest('.slider-div')
                .next('.slider-div')
                .find('.player');
            if(player.length != 0){
                var audio = player.get(0);
                audio.play();
            }
        });

        //region summer note
        var options = $.extend(true,
            {
                lang: '' ,
                codemirror: {
                    theme: 'monokai',
                    mode: 'text/html',
                    htmlMode: true,
                    lineWrapping: true
                }
            } ,
            {
                "toolbar": [
                    ["style", ["style"]],
                    ["font", ["bold", "underline", "italic", "clear"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["table", ["table"]],
                    ["insert", ["link", "picture", "video"]],
                    ["view", ["fullscreen", "codeview", "help"]]
                ]
            }
        );
        $("textarea.summernote-editor").summernote(options);
        //endregion
    });

    $.fn.timerStart = function(){
        var timer_btn = $(this);
        if(timer_btn.find('.timer-area').length == 0){
            timer_btn.prepend('<span class="timer-area" />');
        }
        var timer = timer_btn.find('.timer-area');
        var l = timer_btn.data('length');
        var a = l.split(':'); // split it at the colons

        var h = a[0];
        var m = parseInt(a[1]);
        var s = parseInt(a[2]);
        // minutes are worth 60 seconds. Hours are worth 60 minutes.
        var time_limit = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
        interval = setInterval(function(e){
            if(time_limit == 0){
                clearInterval(interval);
                timer_btn.parent().find('.btn-next').trigger('click');
            }

            m = Math.floor(time_limit/60); //Get remaining minutes
            s = time_limit - (m * 60);
            var time = (m < 10 ? '0' + m : m) + ":" + (s < 10 ? '0' + s : s);
            timer.html(time);

            time_limit --;
        }, 1000);
    };
</script>
@stop