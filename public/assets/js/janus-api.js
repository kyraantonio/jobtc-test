var janus = null;
var janusReplay = null;
var janusFeed = [];
var janusOptions = null;
var janusSessionId = null;
var janusLocalVideo = null;
var janusMyVideo = null;
var janusRemoteVideo = null;
var janusReplayVideo = null;
var sfuLocalTest = null;
var sfuRemoteTest = null;
var sfuReplayTest = null;
var myStream = null;
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

jQuery.janusApi = function(opt) {
    var defaults = {
        server: "https://laravel.software:8089/janus",
        recording_dir: "https://laravel.software/recordings/",
        converter_url: public_path + "convertJanusVideo",
        save_nfo_url: public_path + 'saveNfoJanus',
        btnNoTrigger: false,
        btnPublish: null,
        btnUnpublish: null,
        btnRecord: null,
        btnSave: null,
        btnReplay: null,
        btnStop: null,
        btnTriggerEvent: 'click',
        pluginName: "janus.plugin.videoroom",
        localVideo: $('#local-video'),
        myVideo: '<video id="myVideo" width="100%" height="100%" autoplay muted="muted" />',
        removeVideo: $('#remote-video'),
        replayVideo: $('#replay-video'),
        userName: 'test',
        roomLabel: $('#room-label'),
        roomId: null,
        roomPin: null,
        userNameInput: null, //element where the username will come from ie input box
        replayInput: null,
        resolution: 'stdres',
        bandwidth: null,
        videoConvert: false,
        useVideoConverted: false
    };
    janusOptions = $.extend({}, defaults, opt);

    janusLocalVideo = janusOptions.localVideo;
    janusMyVideo = janusOptions.myVideo;
    janusRemoteVideo = janusOptions.removeVideo;
    janusReplayVideo = janusOptions.replayVideo;
    janusOptions.roomId = janusOptions.roomId ? janusOptions.roomId : 1234;

    Janus.init({
        debug: true, 
        callback: function() {
            // Make sure the browser supports WebRTC
            if(!Janus.isWebrtcSupported()) {
                bootbox.alert("No WebRTC support... ");
                return;
            }

            if(janusLocalVideo.length == 0){
                bootbox.alert("Video container cannot be found");
                return;
            }

            //check if label exist
            var roomLabel = janusOptions.roomLabel;
            if(roomLabel.length != 0){
                roomLabel.html(janusOptions.userName);
            }

            //if not trigger is needed execute session directly
            if(janusOptions.btnNoTrigger){
                $.janusApiCreateSession(janusOptions.server);
            }
            else{
                if(!janusOptions.btnPublish){
                    bootbox.alert("No button to trigger Janus");
                    return;
                }
    
                //button element pass to variable
                var btnPublish = janusOptions.btnPublish;
                //check if the btn exist
                if(btnPublish.length == 0){
                    bootbox.alert("Publish element doesn't exist");
                    return;
                }
                else{
                    btnPublish
                        .stop()
                        .on(janusOptions.btnTriggerEvent, function(e){
                            var userNameInput = janusOptions.userNameInput;
                            //check if user change the value
                            if(userNameInput != null) {
                                //check if element exist
                                if (userNameInput.length == 0) {
                                    bootbox.alert("Username input box doesn't exist");
                                    return;
                                }
                                else{
                                    //get value
                                    janusOptions.userName = userNameInput.val();
                                }
                            }
    
                            $.janusApiCreateSession(janusOptions.server);
                        });
                }

                if(janusOptions.btnUnpublish) {
                    var btnUnpublish = janusOptions.btnUnpublish;
                    //check if the btn exist
                    if (btnUnpublish.length == 0) {
                        bootbox.alert("Unpublish element doesn't exist");
                        return;
                    }
                    else {
                        btnUnpublish
                            .stop()
                            .on(janusOptions.btnTriggerEvent, function (e) {
                                if (janus) {
                                    $('#myVideo').remove();
                                    $.janusApiUnPublishOwnFeed();
                                    $.janusApiRemoveRemoteTest();
                                    janus.destroy();
                                }
                            });
                    }
                }
            }

            //check if save button exist
            if(janusOptions.btnSave){
                var btnSave = janusOptions.btnSave;
                //check if the btn exist
                if(btnPublish.length == 0){
                    bootbox.alert("Save element doesn't exist");
                    return;
                }
                else{
                    btnSave
                        .stop()
                        .on(janusOptions.btnTriggerEvent, function(e){
                            $.janusApiSave();
                        });
                }
            }

            //check if record button exist
            if(janusOptions.btnRecord){
                var btnRecord = janusOptions.btnRecord;
                //check if the btn exist
                if(btnPublish.length == 0){
                    bootbox.alert("Record element doesn't exist");
                    return;
                }
                else{
                    btnRecord
                        .stop()
                        .on(janusOptions.btnTriggerEvent, function(e){
                            $.janusApiRecord();
                        });
                }
            }

            //check if replay element exist
            if(janusOptions.replayVideo){
                var replayVideo = janusOptions.replayVideo;
                if(replayVideo.length != 0) {
                    //check if replay button exist
                    if (janusOptions.btnReplay) {
                        var btnReplay = janusOptions.btnReplay;
                        //check if the btn exist
                        if (btnReplay.length == 0) {
                            bootbox.alert("Replay element doesn't exist");
                            return;
                        }
                        else{
                            var replayInput = janusOptions.replayInput;
                            //check if the input exist
                            if (btnReplay.length == 0) {
                                bootbox.alert("Input element doesn't exist");
                                return;
                            }
                            else{
                                if(janusOptions.useVideoConverted && janusOptions.replayInput) {
                                    btnReplay
                                        .stop()
                                        .on(janusOptions.btnTriggerEvent, function (e) {
                                            if (replayInput.val()) {
                                                replayVideo.attr('src', janusOptions.recording_dir + replayInput.val() + '.webm');
                                            }
                                        });
                                }
                                else{
                                    $.janusApiReplaySession(janusOptions.server);
                                }
                            }
                        }
                    }
                }
            }
        }
    });
};

jQuery.janusApiCreateSession = function(server) {
    // Create session
    janus = new Janus({
        server: server,
        success: function() {
            $.janusApiSessionSuccess();
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
};

jQuery.janusApiSessionSuccess = function() {
    // Attach to video room test plugin
    janus.attach({
        plugin: janusOptions.pluginName,
        success: function (pluginHandle) {
            sfuLocalTest = pluginHandle;

            Janus.log("Plugin attached! (" + sfuLocalTest.getPlugin() + ", id=" + sfuLocalTest.getId() + ")");
            Janus.log("  -- This is a publisher/manager");

            //create room
            if(janusOptions.roomId){
                $.janusApiCreateRoom();
            }

            var register = {
                "request": "join",
                "room": janusOptions.roomId,
                "pin": janusOptions.roomPin,
                "ptype": "publisher",
                "display": janusOptions.userName
            };
            sfuLocalTest.send({ "message": register });
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
            Janus.debug("Event: " + event);
            if (event != undefined && event != null) {
                if (event === "joined") {
                    // Publisher/manager created, negotiate WebRTC and attach to existing janusFeed, if any
                    janusSessionId = msg["id"];
                    Janus.log("Successfully joined room " + msg["room"] + " with ID " + janusSessionId);
                    $.janusApiPublishOwnFeed(true);
                    // Any new feed to attach to?
                    if (msg["publishers"] !== undefined && msg["publishers"] !== null) {
                        var list = msg["publishers"];
                        Janus.debug("Got a list of available publishers/janusFeed:");
                        Janus.debug(list);
                        for (var f in list) {
                            var id = list[f]["id"];
                            var display = list[f]["display"];
                            Janus.debug("  >> [" + id + "] " + display);
                            $.janusApiNewRemoteTest(id, display)
                        }
                    }
                } 
                else if (event === "destroyed") {
                    // The room has been destroyed
                    Janus.warn("The room has been destroyed!");
                    bootbox.alert(error, function () {
                        location.reload();
                    });
                } 
                else if (event === "event") {
                    // Any new feed to attach to?
                    if (msg["publishers"] !== undefined && msg["publishers"] !== null) {
                        var list = msg["publishers"];
                        Janus.debug("Got a list of available publishers/janusFeed:");
                        Janus.debug(list);
                        for (var f in list) {
                            var id = list[f]["id"];
                            var display = list[f]["display"];
                            Janus.debug("  >> [" + id + "] " + display);
                            $.janusApiNewRemoteTest(id, display)
                        }
                    }
                    else if (msg["leaving"] !== undefined && msg["leaving"] !== null) {
                        // One of the publishers has gone away?
                        var leaving = msg["leaving"];
                        Janus.log("Publisher left: " + leaving);
                        for (var i = 1; i < 6; i++) {
                            if (janusFeed[i] != null && janusFeed[i] != undefined && janusFeed[i].rfid == leaving) {
                                sfuRemoteTest = janusFeed[i];
                                break;
                            }
                        }
                        if (sfuRemoteTest != null) {
                            Janus.debug("Feed " + sfuRemoteTest.rfid + " (" + sfuRemoteTest.rfdisplay + ") has left the room, detaching");
                            janusFeed[sfuRemoteTest.rfindex] = null;
                            sfuRemoteTest.detach();
                            $.janusApiRemoveRemoteTest();
                        }
                    }
                    else if (msg["unpublished"] !== undefined && msg["unpublished"] !== null) {
                        // One of the publishers has unpublished?
                        var unpublished = msg["unpublished"];
                        Janus.log("Publisher left: " + unpublished);
                        if (unpublished === 'ok') {
                            // That's us
                            sfuLocalTest.hangup();
                            return;
                        }
                        for (var i = 1; i < 6; i++) {
                            if (janusFeed[i] != null && janusFeed[i] != undefined && janusFeed[i].rfid == unpublished) {
                                sfuRemoteTest = janusFeed[i];
                                break;
                            }
                        }
                        if (sfuRemoteTest != null) {
                            Janus.debug("Feed " + sfuRemoteTest.rfid + " (" + sfuRemoteTest.rfdisplay + ") has left the room, detaching");
                            Janus.debug("Feed " + sfuRemoteTest.rfid + " (" + sfuRemoteTest.rfdisplay + ") has left the room, detaching");
                            janusFeed[sfuRemoteTest.rfindex] = null;
                            sfuRemoteTest.detach();
                            janusRemoteVideo.children().remove();
                        }
                    }
                    else if (msg["error"] !== undefined && msg["error"] !== null) {
                        bootbox.alert(msg["error"]);
                    }
                }
            }
            if (jsep !== undefined && jsep !== null) {
                Janus.debug("Handling SDP as well...");
                Janus.debug(jsep);
                sfuLocalTest.handleRemoteJsep({jsep: jsep});
            }
        },
        onlocalstream: function (stream) {
            Janus.debug(" ::: Got a local stream :::");
            myStream = stream;
            Janus.debug(JSON.stringify(stream));

            janusLocalVideo.append(janusMyVideo);
            attachMediaStream($('#myVideo').get(0), stream);

            var videoTracks = stream.getVideoTracks();
            if (videoTracks === null || videoTracks === undefined || videoTracks.length === 0) {
                // No webcam
                janusLocalVideo.append(
                    '<div class="no-video-container">' +
                    '<i class="fa fa-video-camera fa-5 no-video-icon" style="height: 100%;"></i>' +
                    '<span class="no-video-text" style="font-size: 16px;">No webcam available</span>' +
                    '</div>'
                );
            }
        },
        onremotestream: function (stream) {
            // The publisher stream is sendonly, we don't expect anything here
        },
        oncleanup: function () {
            Janus.log(" ::: Got a cleanup notification: we are unpublished now :::");
            myStream = null;
        }
    });
};

jQuery.janusApiPublishOwnFeed = function(useAudio){
    // Publish our stream
    sfuLocalTest.createOffer({
        media: {
            audioRecv: false, 
            videoRecv: false, 
            audioSend: useAudio, 
            videoSend: true, 
            video: janusOptions.resolution
        }, // Publishers are sendonly
        success: function (jsep) {
            Janus.debug("Got publisher SDP!");
            Janus.debug(jsep);
            var publish = {
                "request": "configure", 
                "audio": useAudio, 
                "video": true
            };
            sfuLocalTest.send({"message": publish, "jsep": jsep});
        },
        error: function (error) {
            Janus.error("WebRTC error:", error);
            if (useAudio) {
                $.janusApiPublishOwnFeed(false);
            } 
            else {
                bootbox.alert("WebRTC error... " + JSON.stringify(error));
                $('#publish').removeAttr('disabled').click(function () {
                    $.janusApiPublishOwnFeed(true);
                });
            }
        }
    });
};

jQuery.janusApiUnPublishOwnFeed = function(){
    // Unpublish our stream
    var unpublish = {"request": "unpublish"};
    sfuLocalTest.send({"message": unpublish});
};

jQuery.janusApiNewRemoteTest = function(id, display){
    // A new feed has been published, create a new plugin handle and attach to it as a listener
    janus.attach({
        plugin: janusOptions.pluginName,
        success: function (pluginHandle) {
            sfuRemoteTest = pluginHandle;
            Janus.log("Plugin attached! (" + sfuRemoteTest.getPlugin() + ", id=" + sfuRemoteTest.getId() + ")");
            Janus.log("  -- This is a subscriber");
            // We wait for the plugin to send us an offer
            var listen = {
                "request": "join",
                "room": janusOptions.roomId,
                "pin": janusOptions.roomPin,
                "ptype": "listener",
                "video": true,
                "audio": true,
                "feed": id
            };
            sfuRemoteTest.send({"message": listen});
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
                        if (janusFeed[i] === undefined || janusFeed[i] === null) {
                            janusFeed[i] = sfuRemoteTest;
                            sfuRemoteTest.rfindex = i;
                            break;
                        }
                    }
                    sfuRemoteTest.rfid = msg["id"];
                    sfuRemoteTest.rfdisplay = msg["display"];
                    if(sfuRemoteTest.spinner === undefined || sfuRemoteTest.spinner === null) {
                        var targetId = janusRemoteVideo.attr('id');
                        var target = document.getElementById(targetId);
                        sfuRemoteTest.spinner = new Spinner({top:100}).spin(target);
                    }
                    else {
                        sfuRemoteTest.spinner.spin();
                    }
                    Janus.log("Successfully attached to feed " + sfuRemoteTest.rfid + " (" + sfuRemoteTest.rfdisplay + ") in room " + msg["room"]);
                    janusRemoteVideo.removeClass('hide').show();
                } 
                else if (msg["error"] !== undefined && msg["error"] !== null) {
                    bootbox.alert(msg["error"]);
                } 
                else {
                    // What has just happened?
                }
            }
            if (jsep !== undefined && jsep !== null) {
                Janus.debug("Handling SDP as well...");
                Janus.debug(jsep);
                // Answer and attach
                sfuRemoteTest.createAnswer({
                    jsep: jsep,
                    media: { audioSend: false, videoSend: false }, // We want recvonly audio/video
                    success: function (jsep) {
                        Janus.debug("Got SDP!");
                        Janus.debug(jsep);
                        var body = {
                            "request": "start", 
                            "room": janusOptions.roomId
                        };
                        sfuRemoteTest.send({"message": body, "jsep": jsep});
                    },
                    error: function (error) {
                        Janus.error("WebRTC error:", error);
                        bootbox.alert("WebRTC error... " + JSON.stringify(error));
                    }
                });
            }
        },
        webrtcState: function (on) {
            Janus.log("Janus says this WebRTC PeerConnection (feed " + sfuRemoteTest.rfindex + ") is " + (on ? "up" : "down") + " now");
        },
        onlocalstream: function (stream) {
            // The subscriber stream is recvonly, we don't expect anything here
        },
        onremotestream: function (stream) {
            Janus.debug("Remote feed #" + sfuRemoteTest.rfindex);
            Janus.debug(JSON.stringify(stream));
            console.log('Here appending the remote stream');
            janusRemoteVideo.html('<video id="remote-' + sfuRemoteTest.rfindex + '" width="100%" height="100%" autoplay />');
            attachMediaStream($('#remote-' + sfuRemoteTest.rfindex).get(0), stream);

            var videoTracks = stream.getVideoTracks();
            if (videoTracks === null || videoTracks === undefined || videoTracks.length === 0) {
                // No webcam
                janusRemoteVideo.append(
                    '<div class="no-video-container">' +
                    '<i class="fa fa-video-camera fa-5 no-video-icon" style="height: 100%;"></i>' +
                    '<span class="no-video-text" style="font-size: 16px;">No webcam available</span>' +
                    '</div>'
                );
            }
        },
        oncleanup: function () {
            Janus.log(" ::: Got a cleanup notification (remote feed " + id + ") :::");
        }
    });
};

jQuery.janusApiRemoveRemoteTest = function(){
    janusRemoteVideo.children().remove();
};

jQuery.janusApiMedia = function(k){
    var thisOption = janusVideoResolutionList[k];
    var constraint = {
        audio: false,
        video: {
            deviceId: undefined,
            width: { exact: thisOption.width },
            height: { exact: thisOption.height }
        }
    };
    navigator
        .mediaDevices
        .getUserMedia(constraint)
        .then(function(mediaStream){
            console.log('success');
        })
        .catch(function (error) {
            delete janusVideoResolutionList[k];
            console.log('failed');
        });
    //https://webrtchacks.github.io/WebRTC-Camera-Resolution/
};

jQuery.janusApiCreateRoom = function(){
    var createRoom = {
        "request": "create",
        "record": false,
        "publishers": 2,
        "room": janusOptions.roomId,
        "pin": janusOptions.roomPin,
        "is_private": true,
        "bitrate": janusOptions.bandwidth ? bandwidth : 0
    };
    sfuLocalTest.send({"message": createRoom});
};

jQuery.janusApiRecord = function(){
    sfuLocalTest.send({
        'message': {
            "request": "configure",
            "room": janusOptions.roomId,
            "pin": janusOptions.roomPin,
            "record": true,
            "filename": "/var/www/html/recordings/" + sfuLocalTest.getId()
        }
    });
};

jQuery.janusApiSave = function(){
    var d = {
        local: sfuLocalTest.getId()
    };

    sfuLocalTest.send({
        'message': {
            "request": "configure",
            "room": janusOptions.roomId,
            "pin": janusOptions.roomPin,
            "record": false,
            "filename": "/var/www/html/recordings/" + sfuLocalTest.getId()
        }
    });

    //after save NFO
    $.ajax({
        url: janusOptions.save_nfo_url,
        data: d,
        type: "POST",
        beforeSend: function () {

        },
        success: function (data) {
            console.log('NFO generated');
        },
        complete: function () {

        },
        error: function (xhr, status, error) {
            console.log('Error: retrying');
        }
    });

    //after save merge video and audio into WEBM
    if(janusOptions.videoConvert) {
        $.ajax({
            url: janusOptions.converter_url,
            data: d,
            type: "POST",
            beforeSend: function () {

            },
            success: function (data) {
                console.log('merge audio and video');
            },
            complete: function () {

            },
            error: function (xhr, status, error) {
                console.log('Error: retrying');
            }
        });
    }
};

jQuery.janusApiReplaySession = function(server){
    var replayVideo = janusOptions.replayVideo;
    var btnReplay = janusOptions.btnReplay;
    var replayInput = janusOptions.replayInput;
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
                            if(janusOptions.replayInput) {
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
                            else{
                                if(sfuLocalTest) {
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
                            if(event === 'preparing') {
                                Janus.log("Preparing the recording playout");
                                janusReplay.createAnswer({
                                    jsep: jsep,
                                    media: { audioSend: false, videoSend: false },	// We want recvonly audio/video
                                    success: function(jsep) {
                                        Janus.debug("Got SDP!");
                                        Janus.debug(jsep);
                                        var body = { "request": "start" };
                                        janusReplay.send({"message": body, "jsep": jsep});
                                    },
                                    error: function(error) {
                                        Janus.error("WebRTC error:", error);
                                        bootbox.alert("WebRTC error... " + JSON.stringify(error));
                                    }
                                });
                                if(result["warning"]) {
                                    bootbox.alert(result["warning"]);
                                }
                            }
                            else if(event === 'playing') {
                                Janus.log("Playout has started!");
                            }
                            else if(event === 'stopped') {
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
};