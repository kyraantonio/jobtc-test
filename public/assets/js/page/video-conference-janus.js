/* 
 * Janus Web Gateway Client for Video Conferencing and Recording
 */

//Hide Conference buttons
$('.nav-tabs a[href="#video-tab"]').click(function () {
    var applicant_text = $('.interview-applicant span').text();
    if (applicant_text === 'Join Conference') {
        $('.interview-applicant').siblings('button').hide();
    }
});

//Load Video Archive Functions
$('.nav-tabs a[href="#video-archive-tab"]').click(function () {
    $('.video-status-container').tagEditor('destroy');
    $('.video-status-container').tagEditor({
        maxTags: 9999,
        clickDelete: true,
        placeholder: 'Enter video tags ...',
        autocomplete: {
            delay: 0, // show suggestions immediately
            position: {collision: 'flip'}, // automatic menu position up/down
            source: public_path + 'getTags/' + $(this).siblings('.video_id') + '/video'
        },
        onChange: function (field, editor, tags) {
            var ajaxurl = public_path + 'addNewTag';

            var unique_id = $(field).siblings('.video_id').val();
            var tag_type = 'video';
            var formData = new FormData();
            formData.append('unique_id', unique_id);
            formData.append('tag_type', tag_type);
            formData.append('tags', tags);
            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: formData,
                // THIS MUST BE DONE FOR FILE UPLOADING
                contentType: false,
                processData: false,
                beforeSend: function () {
                },
                success: function (data) {
                },
                error: function (xhr, status, error) {

                }
            }); //ajax
            //alert(tags);
        }
    });


    $('.delete-video').click(function () {
        var video_element = $(this).parent().parent().parent();
        var video_id = $(this).siblings('.video_id').val();

        var ajaxurl = public_path + 'deleteVideo';
        var formData = new FormData();

        formData.append('video_id', video_id);
        formData.append('_token',csrf_token);

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: formData,
            // THIS MUST BE DONE FOR FILE UPLOADING
            contentType: false,
            processData: false,
            beforeSend: function () {

            },
            success: function (data) {
                socket.emit('delete-video', data);
                video_element.remove();
            },
            complete: function () {

            },
            error: function (xhr, status, error) {
            }

        });
    });
});


//Click Toggle Function
$.fn.clickToggle = function (func1, func2) {
    var funcs = [func1, func2];
    this.data('toggleclicked', 0);
    this.click(function () {
        var data = $(this).data();
        var tc = data.toggleclicked;
        $.proxy(funcs[tc], this)();
        data.toggleclicked = (tc + 1) % 2;
    });
    return this;
};

//var server = "wss://ubuntu-server.com:8989/";
//var server = "https://ubuntu-server.com:8089/janus";
//var media_server_url = "ubuntu-server.com";
//var rec_dir = 'https://ubuntu-server.com/recordings';

var server = "https://laravel.software:8089/janus";
 var media_server_url = "laravel.software";
 var rec_dir = 'https://laravel.software/recordings';

var janus = null;
var sfutest = null;
var started = false;
var session = null;

var myusername = null;
var myid = null;
var mystream = null;
var remoteFeed = null;
var remotestreams = [];
var screentest = null;

var feeds = [];
var bitrateTimer = [];
//var bandwidth = 1024 * 1024;
var bandwidth = 128000; //0 is unlimited

var display_name = $('.add-comment-form .media-heading').text();
console.log(display_name);
var room_name_tmp = window.location.pathname;
var room_name = parseInt(room_name_tmp.substr(room_name_tmp.lastIndexOf('/') + 1));
var csrf_token = $('._token').val();


jQuery.janusApiMedia = function (k) {
    var thisOption = janusVideoResolutionList[k];
    var constraint = {
        audio: false,
        video: {
            deviceId: undefined,
            width: {exact: thisOption.width},
            height: {exact: thisOption.height}
        }
    };
    navigator
            .mediaDevices
            .getUserMedia(constraint)
            .then(function (mediaStream) {
                console.log('success');
            })
            .catch(function (error) {
                delete janusVideoResolutionList[k];
                console.log('failed');
            });
    //https://webrtchacks.github.io/WebRTC-Camera-Resolution/
};

var janusVideoResolutionList = [
    {
        "label": "hires",
        "width": 1280,
        "height": 720
    },
    {
        "label": "stdres",
        "width": 640,
        "height": 480
    },
    {
        "label": "stdres-16:9",
        "width": 640,
        "height": 360
    },
    {
        "label": "lowres",
        "width": 320,
        "height": 240
    },
    {
        "label": "lowres-16:9",
        "width": 320,
        "height": 180
    }
];

var currentRecordData, currentRecordUrl, interval, isLocal = 0;
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

$(document).ready(function () {
    // Initialize the library (all console debuggers enabled)
    Janus.init({debug: "all", callback: function () {
            // Use a button to start the demo
            $('.interview-applicant').clickToggle(function () {
                $('.interview-applicant').addClass('btn-warning');
                $('.interview-applicant').removeClass('btn-success');
                $('.interview-applicant').children('span').text('Leave Conference');
                $('.interview-applicant').siblings('button').show();
                if (started)
                    return;
                started = true;
                // Make sure the browser supports WebRTC
                if (!Janus.isWebrtcSupported()) {
                    bootbox.alert("No WebRTC support... ");
                    return;
                }
                // Create session
                janus = new Janus(
                        {
                            server: server,
                            success: function () {
                                // Attach to video room test plugin
                                janus.attach(
                                        {
                                            plugin: "janus.plugin.videoroom",
                                            success: function (pluginHandle) {
                                                $('#details').remove();
                                                sfutest = pluginHandle;
                                                Janus.log("Plugin attached! (" + sfutest.getPlugin() + ", id=" + sfutest.getId() + ")");
                                                Janus.log("  -- This is a publisher/manager");
                                                var createRoom = {
                                                    "request": "create",
                                                    "record": false,
                                                    "publishers": 10,
                                                    "room": room_name,
                                                    "bitrate": bandwidth
                                                };
                                                sfutest.send({"message": createRoom});
                                                var register = {"request": "join", "room": room_name, "ptype": "publisher", "display": display_name};
                                                myusername = display_name;
                                                sfutest.send({"message": register});
                                            },
                                            error: function (error) {
                                                Janus.error("  -- Error attaching plugin...", error);

                                            },
                                            consentDialog: function (on) {
                                                Janus.debug("Consent dialog should be " + (on ? "on" : "off") + " now");

                                            },
                                            mediaState: function (medium, on) {
                                                Janus.log("Janus " + (on ? "started" : "stopped") + " receiving our " + medium);
                                            },
                                            webrtcState: function (on) {
                                                Janus.log("Janus says our WebRTC PeerConnection is " + (on ? "up" : "down") + " now");

                                            },
                                            onmessage: function (msg, jsep) {
                                                Janus.debug(" ::: Got a message (publisher) :::");
                                                Janus.debug(JSON.stringify(msg));
                                                var event = msg["videoroom"];
                                                var result = msg["result"];
                                                Janus.debug("Event: " + event);
                                                if (event != undefined && event != null) {
                                                    if (event === "joined") {
                                                        // Publisher/manager created, negotiate WebRTC and attach to existing feeds, if any
                                                        myid = msg["id"];
                                                        Janus.log("Successfully joined room " + msg["room"] + " with ID " + myid);
                                                        publishOwnFeed(true);
                                                        // Any new feed to attach to?
                                                        if (msg["publishers"] !== undefined && msg["publishers"] !== null) {
                                                            var list = msg["publishers"];
                                                            Janus.debug("Got a list of available publishers/feeds:");
                                                            Janus.debug(list);
                                                            for (var f in list) {
                                                                var id = list[f]["id"];
                                                                var display = list[f]["display"];
                                                                Janus.debug("  >> [" + id + "] " + display);
                                                                if (display !== 'screenshare-' + sfutest.getId()) {
                                                                    newRemoteFeed(id, display)
                                                                }
                                                            }
                                                        }
                                                    } else if (event === "destroyed") {
                                                        // The room has been destroyed
                                                        Janus.warn("The room has been destroyed!");
                                                        bootbox.alert(error, function () {
                                                            //window.location.reload();
                                                        });
                                                    } else if (event === "event") {
                                                        // Any new feed to attach to?
                                                        if (msg["publishers"] !== undefined && msg["publishers"] !== null) {
                                                            var list = msg["publishers"];
                                                            Janus.debug("Got a list of available publishers/feeds:");
                                                            Janus.debug(list);
                                                            for (var f in list) {
                                                                var id = list[f]["id"];
                                                                var display = list[f]["display"];
                                                                Janus.debug("  >> [" + id + "] " + display);
                                                                if (display !== 'screenshare-' + sfutest.getId()) {
                                                                    newRemoteFeed(id, display)
                                                                }

                                                            }
                                                        } else if (msg["leaving"] !== undefined && msg["leaving"] !== null) {
                                                            // One of the publishers has gone away?
                                                            var leaving = msg["leaving"];
                                                            Janus.log("Publisher left: " + leaving);
                                                            var remoteFeed = null;
                                                            for (var i = 1; i < 6; i++) {
                                                                if (feeds[i] != null && feeds[i] != undefined && feeds[i].rfid == leaving) {
                                                                    remoteFeed = feeds[i];
                                                                    break;
                                                                }
                                                            }
                                                            if (remoteFeed != null) {
                                                                Janus.debug("Feed " + remoteFeed.rfid + " (" + remoteFeed.rfdisplay + ") has left the room, detaching");
                                                                feeds[remoteFeed.rfindex] = null;
                                                                remoteFeed.detach();
                                                                $('#remote-' + remoteFeed.rfindex).remove();
                                                            }
                                                        } else if (msg["unpublished"] !== undefined && msg["unpublished"] !== null) {
                                                            // One of the publishers has unpublished?
                                                            var unpublished = msg["unpublished"];
                                                            Janus.log("Publisher left: " + unpublished);
                                                            if (unpublished === 'ok') {
                                                                // That's us
                                                                sfutest.hangup();
                                                                return;
                                                            }
                                                            var remoteFeed = null;
                                                            for (var i = 1; i < 6; i++) {
                                                                if (feeds[i] != null && feeds[i] != undefined && feeds[i].rfid == unpublished) {
                                                                    remoteFeed = feeds[i];
                                                                    break;
                                                                }
                                                            }
                                                            if (remoteFeed != null) {
                                                                Janus.debug("Feed " + remoteFeed.rfid + " (" + remoteFeed.rfdisplay + ") has left the room, detaching");
                                                                feeds[remoteFeed.rfindex] = null;
                                                                remoteFeed.detach();
                                                                $('#remote-' + remoteFeed.rfindex).remove();
                                                            }
                                                        } else if (msg["error"] !== undefined && msg["error"] !== null) {
                                                            bootbox.alert(msg["error"]);
                                                        }
                                                    } else if (event === 'slow_link') {
                                                        // Janus detected issues when receiving our media, let's slow down
                                                        //bandwidth = parseInt(bandwidth / 1.5);
                                                        sfutest.send({
                                                            'message': {
                                                                'request': 'configure',
                                                                'video-bitrate-max': 128000, // Reduce the bitrate
                                                                'video-keyframe-interval': 30000 // Keep the 15 seconds key frame interval
                                                            }
                                                        });
                                                    }
                                                }
                                                if (jsep !== undefined && jsep !== null) {
                                                    Janus.debug("Handling SDP as well...");
                                                    Janus.debug(jsep);
                                                    sfutest.handleRemoteJsep({jsep: jsep});
                                                }
                                            },
                                            onlocalstream: function (stream) {
                                                Janus.debug(" ::: Got a local stream :::");
                                                mystream = stream;
                                                Janus.debug(JSON.stringify(stream));
                                                $('#localVideo').append('<video class="rounded centered" id="myvideo" width="100%" autoplay muted="muted"/>');
                                                attachMediaStream($('#myvideo').get(0), stream);
                                                var videoTracks = stream.getVideoTracks();
                                                if (videoTracks === null || videoTracks === undefined || videoTracks.length === 0) {
                                                    // No webcam
                                                    $('#localVideo').append(
                                                            '<div class="no-video-container">' +
                                                            '<i class="fa fa-video-camera fa-5 no-video-icon" style="height: 100%;"></i>' +
                                                            '<span class="no-video-text" style="font-size: 16px;">No webcam available</span>' +
                                                            '</div>');
                                                }

                                            },
                                            onremotestream: function (stream) {
                                                // The publisher stream is sendonly, we don't expect anything here
                                            },
                                            oncleanup: function () {
                                                Janus.log(" ::: Got a cleanup notification: we are unpublished now :::");
                                                mystream = null;
                                            }
                                        });
                            },
                            error: function (error) {
                                Janus.error(error);
                                bootbox.alert(error, function () {
                                    //window.location.reload();
                                });
                            },
                            destroyed: function () {
                                //window.location.reload();
                            }
                        });
            }, function () {
                $(this).addClass('btn-success');
                $(this).removeClass('btn-warning');
                $(this).children('span').text('Join Conference');
                $(this).siblings('button').hide();
                unpublishOwnFeed();
                removeRemoteFeed();
                janus.destroy();
                started = false;
            });
        }});


    $('.record-button').clickToggle(function () {
        $(this).addClass('btn-danger');
        $(this).removeClass('btn-default');
        $(this).find('i').css('color', 'orange');
        $(this).children('span').text('Stop Recording');
        $('.save-progress').text("Recording");
        startRecording(session);
    }, function () {
        $(this).addClass('btn-default');
        $(this).removeClass('btn-danger');
        $(this).find('i').css('color', 'green');
        $(this).children('span').text('Start Recording');
        $('.save-progress').text("");
        stopRecording(session);
        saveVideo();
    });

    $('.mute-button').clickToggle(function () {
        $(this).find('span').text('Unmute');
        sfutest.muteAudio();
    }, function () {
        $(this).find('span').text('Mute');
        sfutest.unmuteAudio();
    });

    $('.show-video-button').clickToggle(function () {
        $(this).find('span').text('Show Video');
        sfutest.muteVideo();
    }, function () {
        $(this).find('span').text('Stop Video');
        sfutest.unmuteVideo();
    });

    $('.screen-share').clickToggle(function () {
        $(this).find('span').text('Stop Screen Share');
        startScreenShare();
    }, function () {
        $(this).find('span').text('Share Screen');
        stopScreenShare();
    });

    $('body').on('click', '.btn-video', function (e) {
        var video_btn = $(this);
        var time_limit = $(this).parent().find('.time-limit-conference');
        var question_point = $(this).parent().find('.video-conference-points');

        if ($(this).data('status') == 1) {
            isLocal = 1;

            socket.emit('set-remote-id', remoteFeed.getId());
            socket.emit('start-interview', sfutest.getId());

            time_limit.timerStart();
            video_btn.data('status', 2);
            video_btn.html('Score Answer');
        }
        else if ($(this).data('status') == 2) {
            var test_id = $(this).data('test');
            var unique_id = $(this).data('unique');
            currentRecordUrl = public_path + 'quiz?id=' + test_id + '&p=exam';
            currentRecordData = {
                local_record_id: sfutest.getId(),
                record_id: remoteFeed.getId(),
                question_id: this.id,
                answer: '',
                result: 1,
                unique_id: unique_id,
                points: question_point.val(),
                video_conference: 1
            };

            socket.emit('stop-interview', sfutest.getId());

            //generate nfo file
            socket.emit('generate-nfo', sfutest.getId());

            clearInterval(interval);
            $(this).html('Record Answer');
            $(this).data('status', 1);
        }
    });
});

function publishOwnFeed(useAudio) {
    // Publish our stream
    //$('#publish').attr('disabled', true).unbind('click');
    sfutest.createOffer(
            {
                media: {audioRecv: true, videoRecv: true, audioSend: useAudio}, // Publishers are sendonly
                success: function (jsep) {
                    Janus.debug("Got publisher SDP!");
                    Janus.debug(jsep);
                    var publish = {"request": "configure", "audio": useAudio, "video": true};
                    sfutest.send({"message": publish, "jsep": jsep});
                },
                error: function (error) {
                    Janus.error("WebRTC error:", error);
                    if (useAudio) {
                        publishOwnFeed(false);
                    } else {
                        bootbox.alert("WebRTC error... " + JSON.stringify(error));
                        $('#publish').removeAttr('disabled').click(function () {
                            publishOwnFeed(true);
                        });
                    }
                }
            });
}

function unpublishOwnFeed() {
    // Unpublish our stream
    sfutest.detach();
    $('#localVideo').children().remove();
    var unpublish = {"request": "unpublish"};
    sfutest.send({"message": unpublish});
    $('.btn-video').addClass('hidden');
}

function removeRemoteFeed() {
    //remoteFeed.detach();
    $('#remoteVideo').children().remove();
    $('.btn-video').addClass('hidden');
}

function newRemoteFeed(id, display) {
    // A new feed has been published, create a new plugin handle and attach to it as a listener
    janus.attach(
            {
                plugin: "janus.plugin.videoroom",
                //iceServers: [{'username': 'turn.job.tc', 'credential': 'radio5', 'url': 'turn:159.203.91.188'}],
                success: function (pluginHandle) {
                    remoteFeed = pluginHandle;
                    Janus.log("Plugin attached! (" + remoteFeed.getPlugin() + ", id=" + remoteFeed.getId() + ")");
                    Janus.log("  -- This is a subscriber");
                    remotestreams.push(remoteFeed);
                    // We wait for the plugin to send us an offer
                    var listen = {"request": "join", "room": room_name, "ptype": "listener", "feed": id};
                    remoteFeed.send({"message": listen});
                },
                error: function (error) {
                    Janus.error("  -- Error attaching plugin...", error);
                },
                onmessage: function (msg, jsep) {
                    Janus.debug(" ::: Got a message (listener) :::");
                    Janus.debug(JSON.stringify(msg));
                    var event = msg["videoroom"];
                    Janus.debug("Event: " + event);
                    if (event != undefined && event != null) {
                        if (event === "attached") {
                            // Subscriber created and attached
                            for (var i = 1; i < 6; i++) {
                                if (feeds[i] === undefined || feeds[i] === null) {
                                    feeds[i] = remoteFeed;
                                    remoteFeed.rfindex = i;
                                    break;
                                }
                            }
                            remoteFeed.rfid = msg["id"];
                            remoteFeed.rfdisplay = msg["display"];
                            var target = document.getElementById('remoteVideo');
                            Janus.log("Successfully attached to feed " + remoteFeed.rfid + " (" + remoteFeed.rfdisplay + ") in room " + msg["room"]);
                            $('#remote' + remoteFeed.rfindex).html(target);

                        } else if (msg["error"] !== undefined && msg["error"] !== null) {
                            bootbox.alert(msg["error"]);
                        } else {
                            // What has just happened?
                        }
                    }
                    if (jsep !== undefined && jsep !== null) {
                        Janus.debug("Handling SDP as well...");
                        Janus.debug(jsep);
                        // Answer and attach
                        remoteFeed.createAnswer(
                                {
                                    jsep: jsep,
                                    media: {audioSend: false, videoSend: false}, // We want recvonly audio/video
                                    success: function (jsep) {
                                        Janus.debug("Got SDP!");
                                        Janus.debug(jsep);
                                        var body = {"request": "start", "room": room_name};
                                        remoteFeed.send({"message": body, "jsep": jsep});
                                    },
                                    error: function (error) {
                                        Janus.error("WebRTC error:", error);
                                        bootbox.alert("WebRTC error... " + JSON.stringify(error));
                                    }
                                });
                    }
                },
                webrtcState: function (on) {
                    Janus.log("Janus says this WebRTC PeerConnection (feed #" + remoteFeed.rfindex + ") is " + (on ? "up" : "down") + " now");
                },
                onlocalstream: function (stream) {
                    // The subscriber stream is recvonly, we don't expect anything here
                },
                onremotestream: function (stream) {
                    Janus.debug("Remote feed #" + remoteFeed.rfindex);
                    Janus.debug(JSON.stringify(stream));

                    console.log('Here appending the remote stream');
                    $('#remoteVideo').append('<video class="rounded centered" id="remote-' + remoteFeed.rfindex + '" width="100%" autoplay/>');
                    attachMediaStream($('#remote-' + remoteFeed.rfindex).get(0), stream);
                    var videoTracks = stream.getVideoTracks();

                    $('.btn-video').removeClass('hidden');
                },
                oncleanup: function () {
                    Janus.log(" ::: Got a cleanup notification (remote feed " + id + ") :::");

                    $('.btn-video').removeClass('hidden');
                }
            });
}

function startRecording() {
    // bitrate and keyframe interval can be set at any time: 
    // before, after, during recording
    session = randomString(12);
    socket.emit('start-recording', session);

}

function stopRecording() {
    socket.emit('stop-recording', session);
}

function shareScreen() {
    // Create a new room
    var desc = $('#desc').val();
    role = "publisher";
    var create = {"request": "create", "description": desc, "bitrate": 0, "publishers": 1};
    screentest.send({"message": create, success: function (result) {
            var event = result["videoroom"];
            Janus.debug("Event: " + event);
            if (event != undefined && event != null) {
                // Our own screen sharing session has been created, join it
                room = result["room"];
                Janus.log("Screen sharing session created: " + room_name);
                myusername = randomString(12);
                var register = {"request": "join", "room": room_name, "ptype": "publisher", "display": 'screenshare-' + sfutest.getId()};
                screentest.send({"message": register});
            }
        }});
}

function attachScreen() {
    // Attach to video room test plugin
    janus.attach(
            {
                plugin: "janus.plugin.videoroom",
                success: function (pluginHandle) {
                    $('#details').remove();
                    screentest = pluginHandle;
                    Janus.log("Plugin attached! (" + screentest.getPlugin() + ", id=" + screentest.getId() + ")");
                },
                error: function (error) {
                    Janus.error("  -- Error attaching plugin...", error);
                    bootbox.alert("Error attaching plugin... " + error);
                },
                consentDialog: function (on) {
                    Janus.debug("Consent dialog should be " + (on ? "on" : "off") + " now");
                },
                webrtcState: function (on) {
                    Janus.log("Janus says our WebRTC PeerConnection is " + (on ? "up" : "down") + " now");
                    bootbox.alert("Your screen sharing session just started: pass the <b>" + room + "</b> session identifier to those who want to attend.");
                },
                onmessage: function (msg, jsep) {
                    Janus.debug(" ::: Got a message (publisher) :::");
                    Janus.debug(JSON.stringify(msg));
                    var event = msg["videoroom"];
                    Janus.debug("Event: " + event);
                    if (event != undefined && event != null) {
                        if (event === "joined") {
                            myid = msg["id"];
                            $('#session').html(room);
                            $('#title').html(msg["description"]);
                            Janus.log("Successfully joined room " + msg["room"] + " with ID " + myid);
                            if (role === "publisher") {
                                // This is our session, publish our stream
                                Janus.debug("Negotiating WebRTC stream for our screen (capture " + capture + ")");
                                screentest.createOffer(
                                        {
                                            media: {video: capture, audio: false, videoRecv: false}, // Screen sharing doesn't work with audio, and Publishers are sendonly
                                            success: function (jsep) {
                                                Janus.debug("Got publisher SDP!");
                                                Janus.debug(jsep);
                                                var publish = {"request": "configure", "audio": true, "video": true};
                                                screentest.send({"message": publish, "jsep": jsep});
                                            },
                                            error: function (error) {
                                                Janus.error("WebRTC error:", error);
                                                bootbox.alert("WebRTC error... " + JSON.stringify(error));
                                            }
                                        });
                            } else {
                                // We're just watching a session, any feed to attach to?
                                if (msg["publishers"] !== undefined && msg["publishers"] !== null) {
                                    var list = msg["publishers"];
                                    Janus.debug("Got a list of available publishers/feeds:");
                                    Janus.debug(list);
                                    for (var f in list) {
                                        var id = list[f]["id"];
                                        var display = list[f]["display"];
                                        Janus.debug("  >> [" + id + "] " + display);
                                        newRemoteFeed(id, display)
                                    }
                                }
                            }
                        } else if (event === "event") {
                            // Any feed to attach to?
                            if (role === "listener" && msg["publishers"] !== undefined && msg["publishers"] !== null) {
                                var list = msg["publishers"];
                                Janus.debug("Got a list of available publishers/feeds:");
                                Janus.debug(list);
                                for (var f in list) {
                                    var id = list[f]["id"];
                                    var display = list[f]["display"];
                                    Janus.debug("  >> [" + id + "] " + display);
                                    newRemoteFeed(id, display)
                                }
                            } else if (msg["leaving"] !== undefined && msg["leaving"] !== null) {
                                // One of the publishers has gone away?
                                var leaving = msg["leaving"];
                                Janus.log("Publisher left: " + leaving);
                                if (role === "listener" && msg["leaving"] === source) {
                                    bootbox.alert("The screen sharing session is over, the publisher left", function () {
                                        window.location.reload();
                                    });
                                }
                            } else if (msg["error"] !== undefined && msg["error"] !== null) {
                                bootbox.alert(msg["error"]);
                            }
                        }
                    }
                    if (jsep !== undefined && jsep !== null) {
                        Janus.debug("Handling SDP as well...");
                        Janus.debug(jsep);
                        screentest.handleRemoteJsep({jsep: jsep});
                    }
                },
                onlocalstream: function (stream) {
                    Janus.debug(" ::: Got a local stream :::");
                    Janus.debug(JSON.stringify(stream));
                    $('#screenmenu').hide();
                    $('#room').removeClass('hide').show();
                    if ($('#screenvideo').length === 0) {
                        $('#screencapture').append('<video class="rounded centered" id="screenvideo" width="100%" height="100%" autoplay muted="muted"/>');
                    }
                    attachMediaStream($('#screenvideo').get(0), stream);
                    $("#screencapture").parent().block({
                        message: '<b>Publishing...</b>',
                        css: {
                            border: 'none',
                            backgroundColor: 'transparent',
                            color: 'white'
                        }
                    });
                },
                onremotestream: function (stream) {
                    // The publisher stream is sendonly, we don't expect anything here
                },
                oncleanup: function () {
                    Janus.log(" ::: Got a cleanup notification :::");
                    $('#screencapture').empty();
                    $("#screencapture").parent().unblock();
                    $('#room').hide();
                }
            });
}

function preShareScreen() {
    // Make sure HTTPS is being used
    if (window.location.protocol !== 'https:') {
        bootbox.alert('Sharing your screen only works on HTTPS: click <b><a href="#" onclick="return switchToHttps();">here</a></b> to try the https:// version of this page');
        $('#start').attr('disabled', true);
        return;
    }
    if (!Janus.isExtensionEnabled()) {
        bootbox.alert("You're using a recent version of Chrome but don't have the screensharing extension installed: click <b><a href='https://chrome.google.com/webstore/detail/janus-webrtc-screensharin/hapfgfdkleiggjjpfpenajgdnfckjpaj' target='_blank'>here</a></b> to do so", function () {
            window.location.reload();
        });
        return;
    }
    // Create a new room
    $('#desc').attr('disabled', true);
    $('#create').attr('disabled', true).unbind('click');
    $('#roomid').attr('disabled', true);
    $('#join').attr('disabled', true).unbind('click');
    if ($('#desc').val() === "") {
        bootbox.alert("Please insert a description for the room");
        $('#desc').removeAttr('disabled', true);
        $('#create').removeAttr('disabled', true).click(preShareScreen);
        $('#roomid').removeAttr('disabled', true);
        $('#join').removeAttr('disabled', true).click(joinScreen);
        return;
    }
    capture = "screen";
    if (navigator.mozGetUserMedia) {
        // Firefox needs a different constraint for screen and window sharing
        bootbox.dialog({
            title: "Share whole screen or a window?",
            message: "Firefox handles screensharing in a different way: are you going to share the whole screen, or would you rather pick a single window/application to share instead?",
            buttons: {
                screen: {
                    label: "Share screen",
                    className: "btn-primary",
                    callback: function () {
                        capture = "screen";
                        shareScreen();
                    }
                },
                window: {
                    label: "Pick a window",
                    className: "btn-success",
                    callback: function () {
                        capture = "window";
                        shareScreen();
                    }
                }
            },
            onEscape: function () {
                $('#desc').removeAttr('disabled', true);
                $('#create').removeAttr('disabled', true).click(preShareScreen);
                $('#roomid').removeAttr('disabled', true);
                $('#join').removeAttr('disabled', true).click(joinScreen);
            }
        });
    } else {
        shareScreen();
    }
}

function joinScreen() {
    // Join an existing screen sharing session
    role = "listener";
    myusername = randomString(12);
    var register = {"request": "join", "room": room_name, "ptype": role, "display": myusername};
    screentest.send({"message": register});
}

function startScreenShare() {
    // Create another session for screen sharing(The screen takes up one user space in the room)
    janus = new Janus(
            {
                server: server,
                success: function () {
                    // Attach to video room test plugin
                    janus.attach(
                            {
                                plugin: "janus.plugin.videoroom",
                                success: function (pluginHandle) {
                                    $('#details').remove();
                                    screentest = pluginHandle;
                                    Janus.log("Plugin attached! (" + screentest.getPlugin() + ", id=" + screentest.getId() + ")");
                                    // Prepare the username registration
                                    preShareScreen();
                                },
                                error: function (error) {
                                    Janus.error("  -- Error attaching plugin...", error);
                                    bootbox.alert("Error attaching plugin... " + error);
                                },
                                consentDialog: function (on) {
                                    Janus.debug("Consent dialog should be " + (on ? "on" : "off") + " now");
                                },
                                webrtcState: function (on) {
                                    Janus.log("Janus says our WebRTC PeerConnection is " + (on ? "up" : "down") + " now");
                                },
                                onmessage: function (msg, jsep) {
                                    Janus.debug(" ::: Got a message (publisher) :::");
                                    Janus.debug(JSON.stringify(msg));
                                    var event = msg["videoroom"];
                                    Janus.debug("Event: " + event);
                                    if (event != undefined && event != null) {
                                        if (event === "joined") {
                                            myid = msg["id"];
                                            $('#session').html(room);
                                            $('#title').html(msg["description"]);
                                            Janus.log("Successfully joined room " + msg["room"] + " with ID " + myid);
                                            if (role === "publisher") {
                                                // This is our session, publish our stream
                                                Janus.debug("Negotiating WebRTC stream for our screen (capture " + capture + ")");
                                                screentest.createOffer(
                                                        {
                                                            media: {video: capture, audio: false, videoRecv: false}, // Screen sharing doesn't work with audio, and Publishers are sendonly
                                                            success: function (jsep) {
                                                                Janus.debug("Got publisher SDP!");
                                                                Janus.debug(jsep);
                                                                var publish = {"request": "configure", "audio": true, "video": true};
                                                                screentest.send({"message": publish, "jsep": jsep});
                                                            },
                                                            error: function (error) {
                                                                Janus.error("WebRTC error:", error);
                                                                bootbox.alert("WebRTC error... " + JSON.stringify(error));
                                                            }
                                                        });
                                            } else {
                                                // We're just watching a session, any feed to attach to?
                                                if (msg["publishers"] !== undefined && msg["publishers"] !== null) {
                                                    var list = msg["publishers"];
                                                    Janus.debug("Got a list of available publishers/feeds:");
                                                    Janus.debug(list);
                                                    for (var f in list) {
                                                        var id = list[f]["id"];
                                                        var display = list[f]["display"];
                                                        Janus.debug("  >> [" + id + "] " + display);
                                                        newRemoteFeed(id, display)
                                                    }
                                                }
                                            }
                                        } else if (event === "event") {
                                            // Any feed to attach to?
                                            if (role === "listener" && msg["publishers"] !== undefined && msg["publishers"] !== null) {
                                                var list = msg["publishers"];
                                                Janus.debug("Got a list of available publishers/feeds:");
                                                Janus.debug(list);
                                                for (var f in list) {
                                                    var id = list[f]["id"];
                                                    var display = list[f]["display"];
                                                    Janus.debug("  >> [" + id + "] " + display);
                                                    newRemoteFeed(id, display)
                                                }
                                            } else if (msg["leaving"] !== undefined && msg["leaving"] !== null) {
                                                // One of the publishers has gone away?
                                                var leaving = msg["leaving"];
                                                Janus.log("Publisher left: " + leaving);
                                                if (role === "listener" && msg["leaving"] === source) {
                                                    bootbox.alert("The screen sharing session is over, the publisher left", function () {
                                                        window.location.reload();
                                                    });
                                                }
                                            } else if (msg["error"] !== undefined && msg["error"] !== null) {
                                                bootbox.alert(msg["error"]);
                                            }
                                        }
                                    }
                                    if (jsep !== undefined && jsep !== null) {
                                        Janus.debug("Handling SDP as well...");
                                        Janus.debug(jsep);
                                        screentest.handleRemoteJsep({jsep: jsep});
                                    }
                                },
                                onlocalstream: function (stream) {
                                    Janus.debug(" ::: Got a local stream :::");
                                    Janus.debug(JSON.stringify(stream));
                                    $('#localVideo').append('<video class="rounded centered" id="myscreenshare" width="100%" autoplay muted="muted"/>');
                                    attachMediaStream($('#myscreenshare').get(0), stream);
                                },
                                onremotestream: function (stream) {
                                    // The publisher stream is sendonly, we don't expect anything here
                                },
                                oncleanup: function () {
                                    Janus.log(" ::: Got a cleanup notification :::");
                                }
                            });
                },
                error: function (error) {
                    Janus.error(error);
                    bootbox.alert(error, function () {
                        window.location.reload();
                    });
                },
                destroyed: function () {
                    //window.location.reload();
                }
            });
}

function stopScreenShare() {
    // Unpublish screensharing
    var unpublish = {"request": "unpublish"};
    screentest.send({"message": unpublish});
    //screentest.detach();
    $('#myscreenshare').remove();
}

function saveVideo() {
    socket.emit('save-video', session);
}

function replayVideo(stream) {
    janus = new Janus({
        server: server,
        success: function () {
            // Attach to echo test plugin
            janus.attach({
                plugin: "janus.plugin.recordplay",
                success: function (pluginHandle) {
                    janusReplay = pluginHandle;
                    Janus.log("Plugin attached! (" + janusReplay.getPlugin() + ", id=" + janusReplay.getId() + ")");

                    btnReplay
                            .stop()
                            .on(janusOptions.btnTriggerEvent, function (e) {
                                if (janusOptions.replayInput) {
                                    if (replayInput.val()) {
                                        //update list first so that the record will be seen
                                        janusReplay.send({"message": {"request": "update"}});

                                        janusReplay.send({"message": {
                                                "request": "play",
                                                "id": parseInt(replayInput.val()),
                                                "video": janusOptions.resolution
                                            }});
                                    }
                                }
                                else {
                                    if (sfuLocalTest) {
                                        //update list first so that the record will be seen
                                        janusReplay.send({"message": {"request": "update"}});

                                        janusReplay.send({
                                            "message": {
                                                "request": "play",
                                                "id": parseInt(sfuLocalTest.getId()),
                                                "video": janusOptions.resolution
                                            }
                                        });
                                    }
                                }
                            });
                },
                error: function (error) {
                    Janus.error("  -- Error attaching plugin...", error);
                    bootbox.alert("  -- Error attaching plugin... " + error);
                },
                consentDialog: function (on) {
                    Janus.debug("Consent dialog should be " + (on ? "on" : "off") + " now");
                },
                webrtcState: function (on) {
                    Janus.log("Janus says our WebRTC PeerConnection is " + (on ? "up" : "down") + " now");
                },
                onmessage: function (msg, jsep) {
                    Janus.debug(" ::: Got a message :::");
                    Janus.debug(JSON.stringify(msg));
                    var result = msg["result"];
                    if (result !== null && result !== undefined) {
                        if (result["status"] !== undefined &&
                                result["status"] !== null) {
                            var event = result["status"];
                            console.log(event);
                            if (event === 'preparing') {
                                Janus.log("Preparing the recording playout");
                                janusReplay.createAnswer({
                                    jsep: jsep,
                                    media: {audioSend: false, videoSend: false}, // We want recvonly audio/video
                                    success: function (jsep) {
                                        Janus.debug("Got SDP!");
                                        Janus.debug(jsep);
                                        var body = {"request": "start"};
                                        janusReplay.send({"message": body, "jsep": jsep});
                                    },
                                    error: function (error) {
                                        Janus.error("WebRTC error:", error);
                                        bootbox.alert("WebRTC error... " + JSON.stringify(error));
                                    }
                                });
                                if (result["warning"]) {
                                    bootbox.alert(result["warning"]);
                                }
                            }
                            else if (event === 'playing') {
                                Janus.log("Playout has started!");
                            }
                            else if (event === 'stopped') {
                                Janus.log("Session has stopped!");
                            }
                        }
                    }
                    else {
                        // FIXME Error?
                        var error = msg["error"];
                        bootbox.alert(error);
                    }
                },
                onlocalstream: function (stream) {

                },
                onremotestream: function (stream) {
                    Janus.debug(" ::: Got a remote stream :::");
                    Janus.debug(JSON.stringify(stream));
                    replayVideo.append('<video id="replayVideo" width="100%" height="100%" autoplay />');
                    attachMediaStream($('#replayVideo').get(0), stream);
                },
                oncleanup: function () {
                    Janus.log(" ::: Got a cleanup notification :::");

                }
            });
        },
        error: function (error) {
            Janus.error(error);
            bootbox.alert(error, function () {
                location.reload();
            });
        },
        destroyed: function () {
            location.reload();
        }
    });
}

// Just an helper to generate random usernames
function randomString(len, charSet) {
    charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var randomString = '';
    for (var i = 0; i < len; i++) {
        var randomPoz = Math.floor(Math.random() * charSet.length);
        randomString += charSet.substring(randomPoz, randomPoz + 1);
    }
    return randomString;
}


/*Start recording for all streams connected to this room*/
socket.on('start-recording', function (data) {
    sfutest.send({
        'message': {
            "request": "configure",
            "room": room_name,
            "record": true,
            "filename": "/var/www/html/recordings/" + data + '-' + sfutest.getId()
        }
    });

    if (screentest !== null) {
        screentest.send({
            'message': {
                "request": "configure",
                "room": room_name,
                "record": true,
                "filename": "/var/www/html/recordings/" + data + "-screenshare-" + sfutest.getId()
            }
        });
    }

    //Get Page type to determine if it's a company employee or applicant
    var room_type = $('.page_type').val();

    formData = new FormData();
    formData.append('session', data);
    formData.append('room_name', room_name);
    formData.append('room_type', room_type);
    formData.append('stream', sfutest.getId());
    formData.append('rec_dir', rec_dir);
    formData.append('_token',csrf_token);

    var ajaxurl = public_path + 'startRecording';

    $.ajax({
        url: ajaxurl,
        type: "POST",
        data: formData,
        // THIS MUST BE DONE FOR FILE UPLOADING
        contentType: false,
        processData: false,
        beforeSend: function () {

        },
        success: function (data) {
            //$('.save-progress').text(data);
            //socket.emit('add-video', data);
            //$('.download-complete-sound').get(0).play();
            console.log('Added Session Data to database, Starting Recording');
        },
        complete: function () {

        },
        error: function (xhr, status, error) {
            $('.save-progress').text('Recording failed');
        }
    }); //ajax

});

socket.on('stop-recording', function (data) {
    sfutest.send({
        'message': {
            "request": "configure",
            "room": room_name,
            "record": false,
            "filename": "/var/www/html/recordings/" + data + '-' + sfutest.getId()
        }
    });
    if (screentest !== null) {
        screentest.send({
            'message': {
                "request": "configure",
                "room": room_name,
                "record": false,
                "filename": "/var/www/html/recordings/" + data + "-screenshare-" + sfutest.getId()
            }
        });
    }
});

socket.on('save-video', function (data) {
    var ajaxurl = public_path + 'saveVideo';

    //Get Page type to determine if it's a company employee or applicant
    var room_type = $('.page_type').val();

    formData = new FormData();
    formData.append('session', data);
    formData.append('room_name', room_name);
    formData.append('room_type', room_type);
    formData.append('stream', sfutest.getId());
    formData.append('rec_dir', rec_dir);
    formData.append('_token',csrf_token);

    $.ajax({
        url: ajaxurl,
        type: "POST",
        data: formData,
        // THIS MUST BE DONE FOR FILE UPLOADING
        contentType: false,
        processData: false,
        beforeSend: function () {

        },
        success: function (data) {
            //$('.save-progress').text(data);
            socket.emit('add-video', data);
            $('.download-complete-sound').get(0).play();

        },
        complete: function () {

        },
        error: function (xhr, status, error) {
            $('.save-progress').text('Recording failed');
            console.log('Error: retrying');
            socket.emit('stop-recording', sfutest);
        }
    }); //ajax
});

/*When video is successfully recorded, place it on the video archive*/
socket.on('add-video', function (data) {
    console.log(data);
    var json_data = JSON.parse(data);

    var element = '<div class="video-element-holder">' +
            '<div class="row">' +
            '<div class="col-xs-10">' +
            '<video id="video-archive-item-' + json_data.video_id + '" class="video-archive-item" controls="controls"  preload="metadata">' +
            'Your browser does not support the video tag.' +
            '<source src="' + json_data.video + '" type="video/webm">' +
            '</video>' +
            '</div>' +
            '<div class="col-xs-2">' +
            '<button class="btn btn-danger pull-right delete-video"><i class="fa fa-times"></i></button>' +
            '<input class="video_id" type="hidden" value="' + json_data.video_id + '"/>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-xs-12">' +
            '<textarea class="video-status-container">' +
            '</textarea>' +
            '<input class="video_id" type="hidden" value="' + json_data.video_id + '"/>' +
            '</div>' +
            '</div>' +
            '</div>';

    $('.video-page-container').prepend(element);

    $('.save-progress').text("Video Recorded");

});

//region Interview Area
socket.on('start-interview', function (data) {
    sfutest.send({
        'message': {
            "request": "configure",
            "room": room_name,
            "record": true,
            "filename": "/var/www/html/recordings/" + (isLocal ? data.local : data.remote)
        }
    });
});
socket.on('stop-interview', function (data) {
    sfutest.send({
        'message': {
            "request": "configure",
            "room": room_name,
            "record": false,
            "filename": "/var/www/html/recordings/" + (isLocal ? data.local : data.remote)
        }
    });
});
socket.on('generate-nfo', function (data) {
    //after save NFO
    if(isLocal) {
        $.ajax({
            url: public_path + 'convertJanusVideo',
            data: data,
            type: "POST",
            beforeSend: function () {

            },
            success: function (e) {
                console.log('Files Converted to webm');
                $.ajax({
                    url: currentRecordUrl,
                    data: currentRecordData,
                    method: "POST",
                    success: function (doc) {
                        socket.emit('add-interview', doc);
                        $('.download-complete-sound').get(0).play();
                    },
                    error: function (a, b, c) {

                    }
                });
            },
            complete: function () {

            },
            error: function (xhr, status, error) {
                console.log('Error: retrying');
            }
        });
        $.ajax({
            url: public_path + 'saveNfoJanus',
            data: data,
            type: "POST",
            beforeSend: function () {

            },
            success: function (e) {
                console.log(e);
                console.log('NFO generated');
            },
            complete: function () {

            },
            error: function (xhr, status, error) {
                console.log('Error: retrying');
            }
        });
    }
});
socket.on('add-interview', function (data) {
    var json_data = JSON.parse(data);
    var element =
        '<div class="video-element-holder">' +
            '<div class="row">' +
                '<div class="col-xs-5">' +
                    '<video id="video-archive-remote-item-' + json_data.id + '" class="video-archive-item" controls="controls"  preload="metadata" src="' + rec_dir + '/' + json_data.record_id + '.webm">' +
                        'Your browser does not support the video tag.' +
                    '</video>' +
                '</div>' +
                '<div class="col-xs-5">' +
                    '<video id="video-archive--local-item-' + json_data.id + '" class="video-archive-item" controls="controls"  preload="metadata" src="' + rec_dir + '/' + json_data.local_record_id + '.webm">' +
                        'Your browser does not support the video tag.' +
                    '</video>' +
                '</div>' +
                '<div class="col-xs-2">' +
                    '<button class="btn btn-danger btn-shadow pull-right delete-quiz-video"><i class="fa fa-times"></i></button>' +
                    '<input class="video_id" type="hidden" value="' + json_data.id + '"/>' +
                '</div>' +
            '</div>' +
            '<div class="row">' +
                '<div class="col-xs-12">' +
                    '<label>Applicant Score:</label>&nbsp;' + json_data.points +
                '</div>' +
            '</div>' +
        '</div>';
    $('.video-page-container').append(element);
});
//endregion