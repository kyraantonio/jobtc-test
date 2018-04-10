var interval;
var slider_div = $('.slider-div');
var btn_next = $('.btn-next');
var btn_prev = $('.btn-prev');
var btn_finish = $('.btn-finish');

//For Written Question
$('.written_editor').each(function(e){
    CKEDITOR.replace(this.id, {
        height: '200px'
    });
});


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

slider_div.on('click','.btn-next',function (e) {
    console.log("clicked Button next");
    var thisId = this.id;
    console.log(thisId);
    var type = $(this).data('type');
    var slider_div = $(this).closest('.slider-div');
    if (thisId) {
        var thisElement = $('input[name="answer[' + thisId + ']"]');
        var answer =
            type == 3 ?
            CKEDITOR.instances['written_editor_' + thisId].getData() :
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
        var quiz_id = $(this).closest('.slider-container').find('.quiz_id').val();
        var ajaxUrl = public_path + 'quiz?id=' + quiz_id + '&p=exam';
        $.ajax({
            url: ajaxUrl,
            data: data,
            method: "POST",
            success: function (doc) {
                slider_div.remove();
            },
            error: function (a, b, c) {
                console.log(b.responseText);
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
        quiz_video.css({
            height: '600px',
            width: '725px'
        });
        var room_name = room_name_tmp.replace(/[^\w\s]/gi, '');
        createRoom(room_name, function (room_id) {
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
slider_div.on('click','.btn-finish',function (e) {
    var ajaxurl = public_path + 'getApplicantQuizResults';
    var slider_body = $(this).parent();
    
    var applicant_id = slider_body.find('.applicant_id').val();
    var quiz_id = slider_body.find('.quiz_id').val();
    
    var collapse_header = $('#test-'+quiz_id);
    var collapse_body = $('#test-collapse-'+quiz_id);
    
    var data = {
      'applicant_id' :  applicant_id,
      'quiz_id' : quiz_id
    };
      
    $.ajax({
        url: ajaxurl,
        data: data,
        method: "POST",
        success: function (data) {
           //collapse_header.append('<div class="btn pull-right">Score: '+data+'</div>');
           collapse_body.collapse('hide');
           collapse_body.removeAttr('id');
            //slider_body.parent().parent().html(data);
            //$.getScript(public_path+ "assets/js/page/quizsliderpagination.js"); 
        },
        error: function (a, b, c) {

        }
    });
});

slider_div.on('click','.btn-review-next',function (e) {
    $(this)
        .closest('.slider-div')
        .removeClass('active')
        .next('.slider-div')
        .addClass('active');

    var player = $(this)
        .closest('.slider-div')
        .next('.slider-div')
        .find('.player');
    if (player.length != 0) {
        var audio = player.get(0);
        audio.play();
    }

    savePoints(this.id);
});
slider_div.on('click','.btn-review-prev',function (e) {
    $(this)
        .closest('.slider-div')
        .removeClass('active')
        .prev('.slider-div')
        .addClass('active');
    savePoints(this.id);
});
function savePoints(thisId){
    if(thisId){
        var thisElement = $('input[name="points[' + thisId + ']"]');
        if(thisElement.length != 0){
            var data = {
                points: thisElement.val()
            };

            $.ajax({
                url: public_path + 'quiz/' + thisId + '?p=exam',
                data: data,
                method: "PATCH",
                success: function(doc) {
                    console.log(doc);
                },
                error: function(a, b, c){

                }
            });
        }
    }
};

//region summer note
var options = $.extend(true,
        {
            lang: '',
            codemirror: {
                theme: 'monokai',
                mode: 'text/html',
                htmlMode: true,
                lineWrapping: true
            }
        },
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

$.fn.timerStart = function () {
    var timer_btn = $(this);
    if (timer_btn.find('.timer-area').length == 0) {
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
    interval = setInterval(function (e) {
        if (time_limit == 0) {
            clearInterval(interval);
            timer_btn.parent().find('.btn-next').trigger('click');
            timer_btn.parent().find('.btn-video').trigger('click');
        }

        m = Math.floor(time_limit / 60); //Get remaining minutes
        s = time_limit - (m * 60);
        var time = (m < 10 ? '0' + m : m) + ":" + (s < 10 ? '0' + s : s);
        timer.html(time);
        time_limit--;
    }, 1000);
};