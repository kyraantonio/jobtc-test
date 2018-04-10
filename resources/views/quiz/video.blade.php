@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-xs-8 align-center">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Video Conference</div>
                    <div class="panel-body">
                        <div class="col-md-6" id="local-video"></div>
                        <div class="col-md-6" id="remote-video">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Share Screen</div>
                    <div class="panel-body">
                        <div class="col-md-12"  id="localScreenArea"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <input type="text" name="username" id="username" />
                <button class="btn btn-default btn-shadow publish-btn">
                    <i class="fa fa-play"></i>&nbsp;
                    <span>Publish</span>
                </button>
                <button class="btn btn-default btn-shadow record-btn">
                    <i class="fa fa-circle"></i>&nbsp;
                    <span>Record</span>
                </button>
                <button class="btn btn-default btn-shadow save-btn">
                    <i class="fa fa-square"></i>&nbsp;
                    <span>Save</span>
                </button>
                <button class="btn btn-default btn-shadow replay-save-btn">
                    <i class="fa fa-square"></i>&nbsp;
                    <span>Replay</span>
                </button>
                <button class="btn btn-default btn-shadow share-btn">
                    <i class="fa fa-share-alt"></i>&nbsp;
                    <span>Share</span>
                </button>
            </div>
        </div>
    </div>
    <div class="col-xs-4 align-center">
        <div class="panel panel-default">
            <div class="panel-heading">Video Replay</div>
            <div class="panel-body">
                <video id="replay-video" width="100%" controls="controls" autoplay="true">
                    Your browser does not support the video tag.
                </video>
                <div id="replay-janus-video"></div>
            </div>
        </div>
        <input type="text" name="video" value="101143085728269" id="video" />
        <button class="btn btn-default btn-shadow replay-btn">
            <i class="fa fa-play"></i>&nbsp;
            <span>Load</span>
        </button>
    </div>
</div>
@stop

@section('js_footer')
@parent

<style>
    #quiz-video,
    #quiz-video-play{
        height: 600px;
        width: 100%;
    }
</style>

<script>
    var janus;
    var server = "https://linux.me:8089/janus";
    var bandwidth = 1024 * 1024;
    var sharescreen;
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    var hasExtension = false;
    var shareScreenLoaded = 0;
    var screenVideo;
    var myUsername = null;
    var myId = null;
    var fileName = null;
    var capture = "screen";
    var role = null;
    var room = null;
    var source = null;

    $(function(e){
        /*$.janusApi({
            btnPublish: $('.publish-btn'),
            btnRecord: $('.record-btn'),
            btnSave: $('.save-btn'),
            btnReplay: $('.replay-save-btn'),
            btnStop: $('.stop-btn'),
            userNameInput: $('#username'),
            replayVideo: $('#replay-janus-video'),
            //replayInput: $('#video'),
            roomId: 8888,
            roomPin: "8888"
        });*/

        var webRtc = new SimpleWebRTC({
            // the id/element dom element that will hold "our" video
            localVideoEl: 'localScreen',
            // the id/element dom element that will hold remote videos
            remoteVideosEl: '',
            // immediately ask for camera access
            autoRequestMedia: false,
            debug: true,
            localVideo: {
                autoplay: true, // automatically play the video stream on the page
                mirror: false, // flip the local video to mirror mode (for UX)
                muted: true // mute local video stream to prevent echo
            },
            media: {
                video: {
                    mandatory: {
                        maxFrameRate: 15,
                        maxWidth: 535,
                        maxHeight: 480
                    }
                },
                audio: true
            },
            url: 'https://laravel.software:8888'
        });

        $('.share-btn').click(function(e){
            webRtc.shareScreen(function (err) {
                if (err) {
                    console.log("Screensharing error :" + err);
                    if (err == 'EXTENSION_UNAVAILABLE: NavigatorUserMediaError' ||
                        err == 'PERMISSION_DENIED: NavigatorUserMediaError') {
                        if (isChrome) {
                            if (hasExtension == false) {
                                BootstrapDialog.show({
                                    title: 'Extension not installed',
                                    message: 'Please install the plugin for screensharing. <a target="_blank" href="https://chrome.google.com/webstore/detail/jobtc-screensharing-exten/eciifjfhlbmnofcnnjhodcbjnfhjcelp/related">Install<a>',
                                    buttons: [{
                                        label: 'Close',
                                        action: function (dialog) {
                                            dialog.close();
                                        }
                                    }]
                                });
                            }
                        }
                    }
                }
                else {
                    console.log("Screensharing active");
                }
            });
            Janus.init({debug: "all", callback: function() {
                if(!Janus.isWebrtcSupported()) {
                    bootbox.alert("No WebRTC support... ");
                    return;
                }

                // Create session for Local Video
                janus = new Janus({
                    server: server,
                    success: function() {
                        // Create session for Local Video
                        janus.attach({
                            plugin: "janus.plugin.videoroom",
                            success: function(pluginHandle) {
                                sharescreen = pluginHandle;
                                shareScreenLoaded = 1;

                                var create = {
                                    "request": "create",
                                    "description": "tae",
                                    "bitrate": 0,
                                    "publishers": 1
                                };
                                sharescreen.send({
                                    "message": create,
                                    success: function(result) {
                                        var event = result["videoroom"];
                                        Janus.debug("Event: " + event);
                                        if(event != undefined && event != null) {
                                            // Our own screen sharing session has been created, join it
                                            room = result["room"];
                                            Janus.log("Screen sharing session created: " + room);
                                            var register = {
                                                "request": "join",
                                                "room": room,
                                                "ptype": "publisher",
                                                "display": "tae"
                                            };
                                            sharescreen.send({"message": register});
                                        }
                                    }
                                });
                            },
                            error: function(error) {
                                Janus.error("  -- Error attaching plugin...", error);
                                bootbox.alert("  -- Error attaching plugin... " + error);
                            },
                            consentDialog: function(on) {
                                Janus.debug("Consent dialog should be " + (on ? "on" : "off") + " now");
                            },
                            webrtcState: function(on) {
                                Janus.log("Janus says our WebRTC PeerConnection is " + (on ? "up" : "down") + " now");
                            },
                            onmessage: function(msg, jsep) {
                                Janus.debug(" ::: Got a message (publisher) :::");
                                Janus.debug(JSON.stringify(msg));
                                var event = msg["videoroom"];
                                Janus.debug("Event: " + event);
                                if(event != undefined && event != null) {
                                    if(event === "joined") {
                                        myId = msg["id"];
                                        Janus.log("Successfully joined room " + msg["room"] + " with ID " + myId);

                                        // This is our session, publish our stream
                                        Janus.debug("Negotiating WebRTC stream for our screen (capture " + capture + ")");
                                        sharescreen.createOffer({
                                            media: { video: capture, audio: false, videoRecv: false},	// Screen sharing doesn't work with audio, and Publishers are sendonly
                                            success: function(jsep) {
                                                Janus.debug("Got publisher SDP!");
                                                Janus.debug(jsep);
                                                var publish = { "request": "configure", "audio": true, "video": true };
                                                sharescreen.send({"message": publish, "jsep": jsep});
                                            },
                                            error: function(error) {
                                                Janus.error("WebRTC error:", error);
                                                bootbox.alert("WebRTC error... " + JSON.stringify(error));
                                            }
                                        });
                                    }
                                    else if(event === "event") {
                                        // Any feed to attach to?
                                        if(role === "listener" && msg["publishers"] !== undefined && msg["publishers"] !== null) {
                                            var list = msg["publishers"];
                                            Janus.debug("Got a list of available publishers/feeds:");
                                            Janus.debug(list);
                                        }
                                        else if(msg["leaving"] !== undefined && msg["leaving"] !== null) {
                                            // One of the publishers has gone away?
                                            var leaving = msg["leaving"];
                                            Janus.log("Publisher left: " + leaving);
                                            if(role === "listener" && msg["leaving"] === source) {
                                                bootbox.alert("The screen sharing session is over, the publisher left", function() {
                                                    location.reload();
                                                });
                                            }
                                        }
                                        else if(msg["error"] !== undefined && msg["error"] !== null) {
                                            bootbox.alert(msg["error"]);
                                        }
                                    }
                                }
                                if(jsep !== undefined && jsep !== null) {
                                    Janus.debug("Handling SDP as well...");
                                    Janus.debug(jsep);
                                    sharescreen.handleRemoteJsep({jsep: jsep});
                                }
                            },
                            onlocalstream: function(stream) {
                                Janus.debug(" ::: Got a local stream :::");
                                Janus.debug(JSON.stringify(stream));

                                $('#localScreenArea').append('<video class="hidden" id="janusScreenVideo" width="100%" height="100%" autoplay muted="muted"/>');
                                //attachMediaStream($('#screenVideo').get(0), stream);
                                attachMediaStream($('#janusScreenVideo').get(0), stream);
                            },
                            onremotestream: function(stream) {

                            },
                            oncleanup: function() {
                                Janus.log(" ::: Got a cleanup notification :::");
                            }
                        });
                    },
                    error: function(error) {
                        Janus.error(error);
                        bootbox.alert(error, function() {
                            location.reload();
                        });
                    },
                    destroyed: function() {
                        location.reload();
                    }
                });
            }});
        });
        $('.record-btn').click(function(e){
            fileName = "screenshare-" + $.now();
            if(shareScreenLoaded){
                sharescreen.send({
                    'message': {
                        "request": "configure",
                        "room": room,
                        "record": true,
                        "filename": "/var/www/html/recordings/" + fileName
                    }
                });
            }
        });
        $('.save-btn').click(function(e){
            if(shareScreenLoaded){
                sharescreen.send({
                    'message': {
                        "request": "configure",
                        "room": room,
                        "record": false,
                        "filename": "/var/www/html/recordings/" + fileName
                    }
                });

                $.ajax({
                    url: public_path + 'convertJanusVideo',
                    data: {
                        local: fileName,
                        audio: "no"
                    },
                    type: "POST",
                    beforeSend: function () {

                    },
                    success: function (e) {
                        console.log(e);
                        console.log('Files Converted to webm');
                    },
                    complete: function () {

                    },
                    error: function (xhr, status, error) {
                        console.log('Error: retrying');
                    }
                });
            }
        });

        webRtc.on('localScreenAdded', function (video) {
            video.onclick = function () {
                video.style.width = video.videoWidth + 'px';
                video.style.height = video.videoHeight + 'px';
            };
            video.style.width = '100%';
            video.style.height = '100%';
            screenVideo = video;
            $('#localScreenArea').append(screenVideo);
        });

        //Check if we have the Job.tc chrome extension if it's chrome
        checkExtension();
        function checkExtension() {
            if (typeof chrome !== "undefined" && typeof chrome.app !== "undefined" && chrome.app.isInstalled) {
                console.log('Job.tc extension is installed');
                hasExtension = true;
            }
        }
    });
</script>
@stop