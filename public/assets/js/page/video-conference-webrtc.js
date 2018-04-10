/* 
 * Video Conferencing and Janus Web Gateway Recording
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
});

$('.delete-video').click(function () {
    var video_element = $(this).parent().parent().parent();
    var video_id = $(this).siblings('.video_id').val();

    var ajaxurl = public_path + 'deleteVideo';
    var formData = new FormData();

    formData.append('video_id', video_id);
    formData.append('_token', csrf_token);

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

//For Screenshare
var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
var hasExtension = false;

//var display_name = $('.add-comment-form .media-heading').text();
var display_name = $('.display_name').val() + '('+$('.user_type').val()+')';
var room_name_tmp = window.location.pathname;
var room_name = parseInt(room_name_tmp.substr(room_name_tmp.lastIndexOf('/') + 1));
var room_number = $('.room_number').val();
var csrf_token = $('._token').val();
var playing = false;
var playing_video = null;
var recording = false;
var nfo_id = null;
var tag_type = 'applicant';

var participant_count = 0;
var screenshare_count = 0;


var peerStream;
var localPeerId;
var screentest;
var sfutest;
var janusLocalScreenStream;
var isRecording = false;
var mainVideo;
var conversionProgress;
var conversionAttempts = 0;
var webrtc;

//Initialize Janus for recording
Janus.init({debug: "all", callback: function () {
            if (!Janus.isWebrtcSupported()) {
                bootbox.alert("No WebRTC support... ");
                return;
            }
            // Create session for Local Video
}});

//default media options
var mediaOptions = {
    audio: true,
    video: true
};

var audioDevices = [];
var videoDevices = [];
var audioInputSelect = document.querySelector('select#audio-input-list');
var videoSelect = document.querySelector('select#video-camera-list');
    navigator.mediaDevices.enumerateDevices().then(function (devices) {
      for (var i = 0; i !== devices.length; ++i) {
          var device = devices[i];
          if (device.kind === 'audioinput') {
              audioDevices.push(device);
              device.label = device.label || 'microphone ' + (audioDevices.length + 1);
              var option = document.createElement('option');
              option.value = device.deviceId;
              option.text = device.label || 'microphone ' + (audioDevices.length + 1);
              
              audioInputSelect.appendChild(option);
              $('#audio-input-list option').attr('data-content',"<i class='glyphicon glyphicon-volume-up'></i>");
              
              if(localStorage.getItem('audio') == null) {
                  
                  mediaOptions.audio = {
                      deviceId: device.deviceId
                  };
                  
                  console.log('Media Options Audio: '+mediaOptions.audio.deviceId);
              } else {
                  
                mediaOptions.audio = {
                      deviceId: localStorage.getItem('audio')
                  };  
                  
                $('#audio-input-list').val(localStorage.getItem('audio'));    
              }
              
          } else if (device.kind === 'videoinput') {
              device.label = device.label || 'camera ' + (videoDevices.length + 1);
              videoDevices.push(device);
              console.log(device);
              var option = document.createElement('option');
              option.value = device.deviceId;
              option.text = device.label || 'camera ' + (videoDevices.length + 1);
              videoSelect.appendChild(option);
              
              if(localStorage.getItem('video') == null) {
                  mediaOptions.video = {
                      deviceId: device.deviceId
                  };
                  
                  console.log('Media Options Video: '+mediaOptions.video.deviceId);
              } else {
                  
                mediaOptions.video = {
                      deviceId: localStorage.getItem('video')
                  };  
                  
                $('#video-camera-list').val(localStorage.getItem('video'));    
              }
          }
      }
});

//Make all video containers resizable
$( "#localVideoContainer" ).resizable({
    containment: "body",
    minHeight: 150,
    minWidth: 150,
    grid: 50
});

webrtc = new SimpleWebRTC({
                     // the id/element dom element that will hold "our" video
                    localVideoEl: 'localVideo',
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
                    //peerConnectionConfig:{ iceTransports: 'relay' },
                    mediaOptions: mediaOptions,
                    enableDataChannels: true,
                    detectSpeakingEvents: false,
                    nick: display_name,    
                    url: 'https://job.tc:9999'
            });

webrtc.startLocalVideo();

var localStream;
var localScreenStream;

var janus, sfutest, screentest, isLocal = 0, recordingId, session, formData;
var hasShareScreen = 0;
var janus_btn = $('.btn-video');
var currentRecordData, currentRecordUrl, interval;

var server = "https://extremefreedom.org:8089/janus";
var media_server_url = "extremefreedom.org";
var rec_dir = 'https://extremefreedom.org/recordings';

/*var server = "https://linux.me:8089/janus";
 var media_server_url = "linux.me";
 var rec_dir = 'https://linux.me/recordings';*/

//var server = "https://ubuntu-server.com:8089/janus";
//var media_server_url = "ubuntu-server.com";
//var rec_dir = 'https://ubuntu-server.com/recordings';



//var bandwidth = 1024 * 1024;
var bandwidth = 128 * 1024;
//var bandwidth = 0;
var janusConnected = 0, simpleRtcConnected = 0;
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

function randomString(len, charSet) {
    charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var randomString = '';
    for (var i = 0; i < len; i++) {
        var randomPoz = Math.floor(Math.random() * charSet.length);
        randomString += charSet.substring(randomPoz, randomPoz + 1);
    }
    return randomString;
}

function randomInteger(len, charSet) {
    charSet = charSet || '0123456789';
    var randomString = '';
    for (var i = 0; i < len; i++) {
        var randomPoz = Math.floor(Math.random() * charSet.length);
        randomString += charSet.substring(randomPoz, randomPoz + 1);
    }
    return randomString;
}

webrtc.on('localStream', function (stream) {
    console.log('this is the localstream : ' + JSON.stringify(stream));
    localStream = stream;
    mainVideo = stream;
    console.log(webrtc.webrtc.localStreams[0]);
});

/*For Video Sharing*/
// a peer video has been added
webrtc.on('videoAdded', function (video, peer) {
    console.log('video added', peer);
    peerStream = peer.stream;
    console.log(peerStream);
    var remotes = document.getElementById('remotes');
    var remoteVideo = document.getElementById('remoteVideo');
    var remoteScreen = document.getElementById('remoteScreen');
    
    //if (remotes) {
        video.id = 'container_' + webrtc.getDomId(peer);
        // suppress contextmenu
        video.oncontextmenu = function () {
            return false;
        };

        var dom_id = webrtc.getDomId(peer);
        if (dom_id.includes('screen')) {
            video.style.width = '535px';
            $(video).attr('controls', 'controls');
            remoteScreen.appendChild(video);
        } else {
            
            participant_count++;
            var user_id = $('.user_id').val();
            var user_type = $('.user_type').val();
            webrtc.sendToAll('userType', {user_type: user_type,user_id:user_id,video_container:'container_' + webrtc.getDomId(peer)});      
           
                        
            var videoTag = $('#localVideo')[0];
            
            
            
            var remoteVideoOptions = '<div class="row">'+
                                    '<div class="col-xs-12">'+
                                        '<div class="btn-group" role="group" aria-label="Remote Media Options">'+
                                            '<button class="btn record"><i class="material-icons">fiber_manual_record</i><span class="record-text"></span></button>'+
                                            '<button class="btn  stop-video"><i class="material-icons">videocam</i></button>'+            
                                            '<button class="btn  mute"><i class="material-icons">mic</i></button>'+
                                            '<button class="btn full-screen"><i class="material-icons">fullscreen</i></button>' +
                                            '<input class="participant_id" type="hidden" value="' + participant_count + '"/>' +
                                            '<input class="stream_id" type="hidden" value="' + webrtc.getDomId(peer) + '">' +
                                            '<input class="video_type" type="hidden" value="remote"/>' +
                                        '</div>'+
                                    '</div>'+
                                '</div>';
            
            
            var collapseContainer = '<div class="col-xs-6 remote-video" id="remoteVideo-' + participant_count + '"><div class="panel-group">'+
    '<div class="panel panel-default">'+
      '<div class="panel-heading">'+
        '<h4 class="panel-title">'+
          '<a data-toggle="collapse" href="#remote-video-collapse-'+participant_count+'">'+peer.nick+'</a>'+
        '</h4>'+
      '</div>'+
      '<div id="remote-video-collapse-'+participant_count+'" class="panel-collapse collapse in">'+
        '<div class="panel-body">'+
        '<div class="row">'+
            '<div class="col-xs-5">'+
                '<div class="blink hidden"><i class="fa fa-circle text-danger"></i>&nbsp;<span class="blink-text">Recording</span></div>'+
            '</div>'+
            '<div class="col-xs-7">'+
                '<div id="progress" class="progress hidden">'+
                    '<div style="color:#000;font-weight:bold" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Processing 0% Complete'+
                    '</div>'+
                    '</div>'+
                    '<input class="processing-percent" type="hidden" value="0"/>'+
            '</div>'+
        '</div>'+
        '<input class="participant_id" type="hidden" value="' + participant_count + '"/>' +
        '</div>'+
        '<div class="panel-footer">'+remoteVideoOptions+'</div>'+
      '</div>'+
    '</div>'+
  '</div></div>';
            
            var remoteVideoContainer = "<div class='col-xs-12' id='remoteVideo-" + participant_count + "'>" + remoteVideoOptions + "</div>";
            
            $('#remoteVideo').append(collapseContainer);
            $("#remote-video-collapse-" + participant_count+' .panel-body').prepend(video);
            
            $('#remoteVideo-'+participant_count).resizable({
                 containment: "body",
                 minHeight: 150,
                 minWidth: 150,
                 grid: 50
            });
            
             
                
            
        }

        //remotes.appendChild(container);
    //}
    // show the ice connection state
    if (peer && peer.pc) {
        var connstate = document.createElement('div');
        connstate.className = 'connectionstate';
        remoteVideo.appendChild(connstate);
        peer.pc.on('iceConnectionStateChange', function (event) {
            switch (peer.pc.iceConnectionState) {
                case 'checking':
                    connstate.innerText = 'Connecting to peer...';
                    
                    break;
                case 'connected':
                case 'completed': // on caller side
                    connstate.innerText = 'Connection established.';
                    connstate.remove();
                    if (janusConnected == 1) {
                        $('.janus-waiting').remove();
                    }
                    simpleRtcConnected = 1;
                    break;
                case 'disconnected':
                    connstate.innerText = 'Disconnected.';
                    break;
                case 'failed':
                    break;
                case 'closed':
                    connstate.innerText = 'Connection closed.';
                    connstate.remove();
                    break;
            }
        });
    }
});

// a peer video was removed
webrtc.on('videoRemoved', function (video, peer) {
    console.log('video removed ', peer);
    var remotes = document.getElementById('remotes');
    var remoteVideo = document.getElementById('remoteVideo');
    var remoteScreen = document.getElementById('remoteScreen');
    var el = document.getElementById(peer ? 'container_' + webrtc.getDomId(peer) : 'localScreenContainer');

    
        var dom_id = webrtc.getDomId(peer);
        if (dom_id.includes('video') && el) {
            console.log(el);
            //remoteVideo.removeChild(el);
            var remote_video_id = $('#container_' + webrtc.getDomId(peer)).parent().attr('id');
            var participant_id = $(video).siblings('.participant_id').val();
            console.log('participant_id: '+participant_id);
            $('#remoteVideo-'+participant_id).remove();
        }

        if (dom_id.includes('screen') && el) {
            remoteScreen.removeChild(el);
        }
    

    /*if (remotes && el) {
     remotes.removeChild(el);
     }*/
});

//local mute/unmute events
webrtc.on('audioOn', function () {
    // your local audio just turned on

});
webrtc.on('audioOff', function () {
    // your local audio just turned off

});
webrtc.on('videoOn', function () {
    // local video just turned on
});
webrtc.on('videoOff', function () {
    // local video just turned off
});

webrtc.on('stunservers', function () {
    //console.log('using a stun server');
});

webrtc.on('turnservers', function () {
    //console.log('using a turn server');
});

// local p2p/ice failure
webrtc.on('iceFailed', function (peer) {
    var pc = peer.pc;
    console.log('had local relay candidate', pc.hadLocalRelayCandidate);
    console.log('had remote relay candidate', pc.hadRemoteRelayCandidate);
});

// remote p2p/ice failure
webrtc.on('connectivityError', function (peer) {
    var pc = peer.pc;
    console.log('had local relay candidate', pc.hadLocalRelayCandidate);
    console.log('had remote relay candidate', pc.hadRemoteRelayCandidate);
});

// listen for mute and unmute events
webrtc.on('mute', function (data) { // show muted symbol
    webrtc.getPeers(data.id).forEach(function (peer) {
        if (data.name == 'audio') {
            $('#videocontainer_' + webrtc.getDomId(peer) + ' .muted').show();
        } else if (data.name == 'video') {
            $('#videocontainer_' + webrtc.getDomId(peer) + ' .paused').show();
            $('#videocontainer_' + webrtc.getDomId(peer) + ' video').hide();
        }
    });
});

webrtc.on('unmute', function (data) { // hide muted symbol
    webrtc.getPeers(data.id).forEach(function (peer) {
        if (data.name == 'audio') {
            $('#videocontainer_' + webrtc.getDomId(peer) + ' .muted').hide();
        } else if (data.name == 'video') {
            $('#videocontainer_' + webrtc.getDomId(peer) + ' video').show();
            $('#videocontainer_' + webrtc.getDomId(peer) + ' .paused').hide();
        }
    });
});


/*For Screensharing*/
// local screen obtained
webrtc.on('localScreenAdded', function (video) {
    /*video.onclick = function () {
     video.style.width = video.videoWidth + 'px';
     video.style.height = video.videoHeight + 'px';
     };*/
    //document.getElementById('localVideo').appendChild(video);
    //$('#localScreenContainer').show();
    video.id = '';
    //Get the local screen media stream object
    localScreenStream = webrtc.getLocalScreen();
    console.log('This is the local screenshare stream: ' + localScreenStream);

    $('#localScreen').append(video);
    hasShareScreen = 1;
});
// local screen removed
webrtc.on('localScreenRemoved', function (video) {
    document.getElementById('localScreen').removeChild(video);
    //$('#localScreenContainer').hide();
    $('#localScreen').html('');
    hasShareScreen = 0;
});

// we have to wait until it's ready
webrtc.on('readyToCall', function () {
    // you can name it anything
    //webrtc.joinRoom(room_name_tmp);
    console.log(room_name_tmp);
    console.log("Ready to Join Conference");
    //$('.interview-applicant').attr('disabled',false);
    
     // you can name it anything
    webrtc.joinRoom(room_name_tmp,function(){
        console.log('Joining Room');  
    });
    
});

webrtc.connection.on('message', function (data) {
    if (data.type === 'chat') {
        console.log('chat received' + JSON.stringify(data));
        var message = data.payload.message;
         var regex = /(https?:\/\/([-\w\.]+)+(:\d+)?(\/([-\w/_\.]*(\?\S+)?)?)?)/ig;
         
        // Replace plain text links by hyperlinks
        var replaced_text = message.replace(regex, "<a href='$1' target='_blank'>$1</a>");
        
        var chat_message = '<div class="row"><div class="col-xs-6">'+ data.payload.display_name + '</div><div class="col-xs-6"></div></div><div class="row"><div class="col-xs-8 chat-bubble-left">'+replaced_text+'</div></div>';
        $('.incoming-chat-sound').get(0).play();
        $('#message-log').prepend(chat_message);
        
        if($('#chat-box-container').hasClass("is-hidden") == true) {
            var chat_count = parseInt($('.chat-badge').text()) + 1;
            $('.chat-badge').text(chat_count);
            $('.toggle-panel-chat').effect('highlight');
        }
    }
    if(data.type === 'userType') {
        console.log('Received userType ' + data.payload.user_type);
        console.log('Received userID ' + data.payload.user_id);
        console.log('Received video ' + data.payload.video_id);
        //var remote_video_exists = $('#remoteVideo-'+participant_count).length;
        //console.log(remote_video_exists);
        //if(remote_video_exists > 0) {
        $('#remoteVideo-'+participant_count+' .panel-footer').find('.user_type').val(data.payload.user_type);
        $('#remoteVideo-'+participant_count+' .panel-footer').find('.user_id').val(data.payload.user_id);    
        //}
        
        
    }
   
});


//region Recording Area
//$(document).ready(function () {
    // Initialize the library (all console debuggers enabled)
    /*Janus.init({debug: "all", callback: function () {
            if (!Janus.isWebrtcSupported()) {
                bootbox.alert("No WebRTC support... ");
                return;
            }
            janusConnected = 1;
            // Create session for Local Video
            createJanusLocalStream();
            createJanusLocalScreenShare();
        }});*/
//});

socket.on('start-interview', function (data) {
    //var n = $.now();
    //var f = (isLocal ? data.local : data.remote);
    /*sfutest.send({
     'message': {
     'request': 'configure',
     'video-bitrate-max': bandwidth, // a quarter megabit
     'video-keyframe-interval': 15000 // 15 seconds
     }
     });*/

    /*sfutest.createOffer({
     // By default, it's sendrecv for audio and video..
     success: function(jsep) {
     Janus.debug(jsep);
     var body = {
     "request": "record",
     "name": n.toString(),
     "video": "stdres",
     "filename": f.toString()
     };
     sfutest.send({"message": body, "jsep": jsep});
     },
     stream: localStream,
     error: function(error) {
     sfutest.hangup();
     }
     });*/
});
socket.on('stop-interview', function (data) {
    /*var stop = { "request": "stop" };
     sfutest.send({ "message": stop });
     
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
     $('.janus-waiting').remove();
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
     }*/
});

socket.on('start-recording', function (data) {
    console.log('nfo_id' + nfo_id);
    recording = true;

    $('.is-recording').attr("value", "true");
    $('.session_id').attr("value", data);

    startRecordingLocalStream(data);
    if (hasShareScreen === 1) {
        startRecordingLocalScreenShare(data);
    }

    //Get Page type to determine if it's a company employee or applicant
    var room_type = $('.page_type').val();

    formData = new FormData();
    formData.append('session', data);
    formData.append('room_name', room_name);
    formData.append('room_type', room_type);
    formData.append('stream', sfutest.getId());
    formData.append('nfo_id', nfo_id);
    formData.append('rec_dir', rec_dir);
    formData.append('_token', csrf_token);

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
/*socket.on('stop-recording', function (data) {

    recording = false;

    $('.is-recording').attr("value", "false");

    var ajaxurl = public_path + 'stopRecording';

    formData.append('session', data);
    formData.append('nfo_id', nfo_id);
    formData.append('stream', sfutest.getId());

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
            console.log('Stopped Recording');
        },
        complete: function () {

        },
        error: function (xhr, status, error) {
            $('.save-progress').text('Recording failed');
        }
    }); //ajax

    var stop = {"request": "stop"};
    sfutest.send({"message": stop});
    screentest.send({"message": stop});
    sfutest.detach();
    screentest.detach();
    createJanusLocalStream();
    createJanusLocalScreenShare();
});*/
/*socket.on('save-video', function (data) {
    var ajaxurl = public_path + 'saveVideo';

    //Get Page type to determine if it's a company employee or applicant
    var room_type = $('.page_type').val();

    //Determine if it's a normal webcam video or a screenshare
    var video_type;

    formData = new FormData();
    formData.append('session', data);
    formData.append('room_name', room_name);
    formData.append('room_type', room_type);
    formData.append('stream', sfutest.getId());
    formData.append('rec_dir', rec_dir);
    formData.append('_token', csrf_token);
    formData.append('video_type', video_type);

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

    console.log("NFO id: " + sfutest.getId());

    saveNfo();

    if (hasShareScreen === 1) {
        saveScreenShareNfo();
    }

});/*
/*When video is successfully recorded, place it on the video archive*/
/*socket.on('add-video', function (data) {
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

});*/

//endregion

$('.interview-applicant').clickToggle(function () {
    $('.interview-applicant').addClass('btn-warning');
    $('.interview-applicant').removeClass('btn-success');
    $('.interview-applicant').children('span').text('Leave Conference');
    $('.interview-applicant').siblings('button').show();
    //webrtc.joinRoom(room_name_tmp);
    //connection.open(room_name);
    //connection.join(room_name);
    webrtc.startLocalVideo();

    /*if(recording === true) {
     startRecordingLocalStream(session);
     }*/
    //Check if room is being recorded
    //isRecording();

    $('.time-limit-conference').each(function (e) {
        $(this).after('<span class="janus-waiting" style="color: #f00;">Waiting for Remote...</span>');
    });
}, function () {
    $(this).addClass('btn-success');
    $(this).removeClass('btn-warning');
    $(this).children('span').text('Join Conference');
    $(this).siblings('button').hide();
    //$('#localVideo').children().remove();
    webrtc.leaveRoom(room_name_tmp);
    webrtc.stopLocalVideo();

    //Stop Recording if conference is left
    if (recording === true) {
        stopRecording();
    }

    $('#localVideo video').remove();
    $('#localScreen video').remove();
    $('.janus-waiting').remove();
});


$('.play-record').click(function () {

    var play_nfo_id = $(this).siblings('.nfo_id').val();

    console.log("nfo_id: " + play_nfo_id);

    $('#video-archive-item-' + play_nfo_id).remove();
    
    playing = true;
    var play = {"request": "play", "id": parseInt(play_nfo_id)};
    sfutest.send({"message": play});

});

$('.screen-share').clickToggle(function () {
    console.log('Starting Screensharing');
    $(this).find('span').text('Stop Screen Share');
    webrtc.shareScreen(function (err) {
        if (err) {
            console.log("Screensharing error :" + err);
            $('.screen-share').click();
            if (err == 'EXTENSION_UNAVAILABLE: NavigatorUserMediaError') {
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
        } else {
            console.log("Screensharing active");
            if (recording === true) {
                startRecordingLocalScreenShare(session);
            }
        }
    });
}, function () {
    $(this).find('span').text('Share Screen');
    webrtc.stopScreenShare();
    $('#localScreen').remove();
});


$('body').on('click','.mute',function(){
    var muteText = $(this).children('.material-icons').text();
    var video_type = $(this).siblings('.video_type').val();
    if(muteText == 'mic_off') {
        if(video_type == 'local') { 
            webrtc.unmute();
        } else {
            var video_id = 'container_'+$(this).siblings('.stream_id').val();
             var remoteVideo = document.getElementById(video_id);
             remoteVideo.volume = 1;
             
        }
        $(this).children('.material-icons').text('mic');   
        console.log('Mic On');
    } else {
        if(video_type == 'local') { 
            webrtc.mute();
        } else {
            var video_id = 'container_'+$(this).siblings('.stream_id').val();
             var remoteVideo = document.getElementById(video_id);
             remoteVideo.volume = 0;
        }
        $(this).children('.material-icons').text('mic_off');   
        console.log('Mic Off');
    }
});

$('body').on('click','.stop-video',function(){
    var muteText = $(this).children('.material-icons').text();
    var video_type = $(this).siblings('.video_type').val();
    if(muteText == 'videocam_off') {
        if(video_type == 'local') { 
            webrtc.resumeVideo();
        } else {
            var video_id = 'container_'+$(this).siblings('.stream_id').val();
             var remoteVideo = document.getElementById(video_id);
             remoteVideo.play();
             
        }
        $(this).children('.material-icons').text('videocam');   
        console.log('Video On');
    } else {
        if(video_type == 'local') { 
            webrtc.pauseVideo();
        } else {
            var video_id = 'container_'+$(this).siblings('.stream_id').val();
             var remoteVideo = document.getElementById(video_id);
             remoteVideo.pause();
        }
        $(this).children('.material-icons').text('videocam_off');   
        console.log('Video Off');
    }
});

$('body').on('click', '.full-screen', function () {
    var video_id = 'container_'+$(this).siblings('.stream_id').val();
    
    var localVideo = document.getElementById(video_id);

    // go full-screen
    if (localVideo.requestFullscreen) {
        localVideo.requestFullscreen();
    } else if (localVideo.webkitRequestFullscreen) {
        localVideo.webkitRequestFullscreen();
    } else if (localVideo.mozRequestFullScreen) {
        localVideo.mozRequestFullScreen();
    } else if (localVideo.msRequestFullscreen) {
        localVideo.msRequestFullscreen();
    }

    console.log('full screen video id: ' + video_id);
});

$('body').on('change','#video-camera-list',function(){
     //webrtc.stopLocalVideo();
     var selectedOption = $(this).val();
     console.log('selectedOption: '+selectedOption);
     console.log('Audio Changed');
     webrtc.leaveRoom();      
     webrtc.stopLocalVideo();
     localStorage.setItem('video',selectedOption);
      webrtc.config.media.video = {
        optional: [{sourceId: selectedOption}]
      }
      webrtc.startLocalVideo();
});

$('body').on('change','#audio-input-list',function(){
     //webrtc.stopLocalVideo();
     var selectedOption = $(this).val();
     console.log(localStorage.getItem('audio'));
     console.log('selectedOption: '+selectedOption);
     console.log('Audio Changed');
     webrtc.leaveRoom();      
     webrtc.stopLocalVideo(); 
     localStorage.setItem('audio',selectedOption);
      webrtc.config.media.audio = {
        optional: [{sourceId: selectedOption}]
      }
      webrtc.startLocalVideo();
});


$('body').on('click','.record',function(){
    var muteText = $(this).children('.material-icons').text();
    var video_type = $(this).siblings('.video_type').val();
    var video_title = "";
    if(muteText == 'fiber_manual_record') {
        if(video_type == 'local') { 
            mainVideo = localStream;
            var container = 'localVideoContainer';
            createJanusLocalStream(container,video_title);    
        } else if(video_type == 'localScreen') { 
            mainVideo = localScreenStream;
            var screenshare_id = $(this).siblings('.screenshare_id').val();
            var container = 'screenContainer-'+screenshare_id;
            createJanusLocalStream(container,video_title);        
        } else if(video_type == 'remoteScreen') {    
            
             var video_id = 'container_'+$(this).siblings('.stream_id').val();
             var screenshare_id = $(this).siblings('.screenshare_id').val();
             var remoteVideo = document.getElementById(video_id);
             mainVideo = $('#'+video_id)[0].srcObject;
             var container = 'screenContainer-'+screenshare_id;
             console.log(container);
             createJanusLocalStream(container,video_title);        
            
        } else {
             var video_id = 'container_'+$(this).siblings('.stream_id').val();
             var participant_id = $(this).siblings('.participant_id').val();
             var remoteVideo = document.getElementById(video_id);
             mainVideo = $('#'+video_id)[0].srcObject;
             var container = 'remoteVideo-'+participant_id;
             console.log(container);
             createJanusLocalStream(container,video_title);        
        }
        isRecording = true;
        $(this).css('background-color','orange');
        $(this).children('.material-icons').text('stop');
        //$(this).find('.record-text').text('Starting...');
        $(this).attr('disabled',true);
    } else {
        sfutest.send({"message": stop});
        sfutest.detach();
        isRecording = false;
        $(this).css('background-color','#d7efed');
        $(this).children('.material-icons').text('fiber_manual_record');
        //$(this).find('.record-text').text('Record');
        //$(this).text('Start Recording');
        $('.blink').addClass('hidden');    
    }
});

//For Lightbox
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox({
        alwaysShowClose: true
    });
});

function createJanusLocalStream(container,video_title,question_id) {
     console.log('question_id: '+question_id);
    janus = new Janus({
        server: server,
        success: function () {
            //Local Video
            janus.attach({
                plugin: "janus.plugin.recordplay",
                success: function (pluginHandle) {
                    sfutest = pluginHandle;
                    startRecordingLocalStream();
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
                    console.log("result: " + result);
                    if (result !== null && result !== undefined) {
                        if (result["status"] !== undefined && result["status"] !== null) {
                            var event = result["status"];
                            if (event === 'preparing') {
                                Janus.log("Preparing the recording playout :" + result["id"]);
                                playing_video = result["id"]
                                sfutest.createAnswer({
                                    jsep: jsep,
                                    media: {audioSend: false, videoSend: false}, // We want recvonly audio/video
                                    success: function (jsep) {
                                        Janus.debug("Got SDP!");
                                        Janus.debug(jsep);
                                        var body = {"request": "start"};
                                        sfutest.send({"message": body, "jsep": jsep});
                                    },
                                    error: function (error) {
                                        Janus.error("WebRTC error:", error);
                                        bootbox.alert("WebRTC error... " + JSON.stringify(error));
                                    }
                                });
                                if (result["warning"])
                                    bootbox.alert(result["warning"]);
                            }
                            else if (event === 'recording') {
                                // Got an ANSWER to our recording OFFER
                                if (jsep !== null && jsep !== undefined)
                                    sfutest.handleRemoteJsep({jsep: jsep});
                                var id = result["id"];
                                if (id !== null && id !== undefined) {
                                    Janus.log("The ID of the current recording is " + id);
                                    //Get the nfo id to map to the mjr file generated
                                    nfo_id = id;
                                    //$('.recording-loading-gif').remove();
                                    $('#'+container).find('.blink').removeClass('hidden');
                                    //$('#'+container).find('.record-text').text('Stop Recording');
                                    $('#'+container).find('.record').attr('disabled',false);
                                }
                            }
                            else if (event === 'slow_link') {
                                var uplink = result["uplink"];
                                if (uplink !== 0) {
                                    // Janus detected issues when receiving our media, let's slow down
                                    bandwidth = 128 * 1024;
                                    sfutest.send({
                                        'message': {
                                            'request': 'configure',
                                            'video-bitrate-max': bandwidth, // Reduce the bitrate
                                            'video-keyframe-interval': 15000 // Keep the 15 seconds key frame interval
                                        }
                                    });
                                }
                            }
                            else if (event === 'playing') {
                                Janus.log("Playout has started!");
                            }
                            else if (event === 'stopped') {
                                Janus.log("Session has stopped!");
                                //$('.blink').addClass('hidden');
                            } else if (event === 'done') {
                                $('#video-archive-item-' + playing_video).remove();
                                playing_video = null;
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
                    Janus.debug(" ::: Got a local stream :::");
                    Janus.debug(JSON.stringify(stream));
                    //if (playing === true)
                    //return;

                    //$('#localVideo').append('<video class="rounded centered" id="thevideo" width=320 height=240 autoplay muted="muted"/>');
                    //attachMediaStream($('#thevideo').get(0), stream);

                    //attachMediaStream($('#localVideo').find('video').get(0), stream);
                },
                onremotestream: function (stream) {
                    if (playing === false)
                        return;
                    Janus.debug(" ::: Got a remote stream :::" + JSON.stringify(stream));
                    $('.video-element-holder #' + playing_video).append('<video class="rounded centered" id="video-archive-item-' + playing_video + '" width=320 height=240 controls autoplay/>');

                    // Show the video, hide the spinner and show the resolution when we get a playing event
                    attachMediaStream($('#video-archive-item-' + playing_video).get(0), stream);

                },
                oncleanup: function () {
                    Janus.log(" ::: Got a cleanup notification :::");
                    var f = sfutest.getId();
                    var filename = 'localRecording-' + f.toString();
                    console.log('Converting file: '+filename);
                    
                    //question_id is an optional parameter, people can record via the record button on their hairline check
                    console.log('Create Janus Local Stream question_id: '+question_id);
                    //if (question_id === undefined) {
                        //convertJanusVideo(filename,container,video_title);
                    //} else {
                        convertJanusVideo(filename,container,video_title,question_id);
                    //}
                },
                detach: function() {
                    
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


function startRecordingLocalStream() {
   var n = $.now();
    recordingId = n + '-' + room_name;
    //var f = data + '-' + recordingId;
    var f = sfutest.getId();
    var filename = 'localRecording-' + f.toString();
    
    sfutest.createOffer({
        // By default, it's sendrecv for audio and video..
        success: function (jsep) {
            Janus.debug(jsep);
            var body = {
                "request": "record",
                "name": 'localRecording-' + f.toString(),
                "video": "hires",
                "filename": 'localRecording-' + f.toString()
            };
            sfutest.send({"message": body, "jsep": jsep});
            
        },
        //stream: localStream,
        stream: mainVideo,
        error: function (error) {
            sfutest.hangup();
            $('.blink').addClass('hidden');
        }
    });
}

function convertJanusVideo(filename,container,video_title,question_id) {
    
    console.log('question_id in convertJanusVideo: '+question_id);
    
    var subject_name = $('#'+container).find('.panel-title').text();
    
    $.ajax({
     url: public_path + 'convertApplicantsJanusVideo',
     data: {
        filename:filename,
        module_type:'applicants',
        module_id: room_number,
        display_name: display_name,
        video_title: video_title,
        subject_name: subject_name,
        question_id: question_id
     },
     type: "POST",
     beforeSend: function () {
        console.log('Sending Conversion signal');
        $('#'+container).find('.recording-status').removeClass('hidden');
        $('#'+container).find('.recording-status').text('Saving Video');
        
     },
     success: function (e) {
     $('#'+container).find('.recording-status').text('Video Saved. Processing Video');
     $('#'+container).find('.progress').removeClass('hidden');
     
     conversionProgress = window.setTimeout(function() { 
            getConversionProgress(filename,container);
     }, 1000);
     
     },
     complete: function () {
        console.log('Completed Conversion');
     },
     error: function (xhr, status, error) {
     console.log('Error:'+error);
     }
     });
    
}

var getConversionProgress = function(filename,container) {
    conversionAttempts++;
    $.ajax({
     url: public_path + 'getConversionProgress',
     data: {
         'filename': filename
     },
     type: "POST",
     beforeSend: function () {
        
     },
     success: function (data) {
        console.log($('.processing-percent').val(data));    
       $('#'+container).find('.progress-bar').css('width', data+'%').attr('aria-valuenow', data);
       $('#'+container).find('.progress-bar').html('Processing '+data+'% Complete');
       $('#'+container).find('.processing-percent').val(data);
       
       if(data == '100') {
           $('#'+container).find('.recording-status').text('Processing Completed');
           $('#video-archive').load($('.current-video-page').val()+' #video-archive',function(responseTxt, statusTxt, xhr) {
               videoTags(tag_type);
           });
           $('#'+container).find('.recording-status').addClass('hidden');
           $('#'+container).find('.progress').addClass('hidden');
           $('#'+container).find('.processing-percent').val("0");
           conversionAttempts = 0;
       } else
        if(conversionAttempts < 10 && data < 99) {    
        conversionProgress = window.setTimeout(function() { 
            getConversionProgress(filename,container); 
        }, 1000);    
       } else {
           conversionAttempts = 0;
           $('#'+container).find('.recording-status').addClass('hidden');
           $('#'+container).find('.progress').addClass('hidden');
           $('#'+container).find('.processing-percent').val("0");
           $('#video-archive').load($('.current-video-page').val()+' #video-archive',function(responseTxt, statusTxt, xhr) {
                videoTags(tag_type);
           });
       }
     },
     complete: function () {
        
     },
     error: function (xhr, status, error) {
        console.log('Error: retrying');
        conversionProgress = window.setTimeout(function() { 
            getConversionProgress(filename,container); 
        }, 1000);  
     }
     });

}

//For Video Archive Paginator
$('#video-archive-container').on('click','.pager-element',function(e){
    e.preventDefault();
    console.log($(this).attr('href'));
    $('.current-video-page').val($(this).attr('href'));
    $('#video-archive').load($(this).attr('href')+' #video-archive',function(responseTxt, statusTxt, xhr){
        videoTags(tag_type);
    
    });
});
$('#video-archive-container').on('click','.previous',function(e){
    e.preventDefault();
    console.log($(this).attr('href'));
    $('.current-video-page').val($(this).attr('href'));
    $('#video-archive').load($(this).attr('href')+' #video-archive',function(responseTxt, statusTxt, xhr){
        videoTags(tag_type);
    });
});
$('#video-archive-container').on('click','.next',function(e){
    e.preventDefault();
    console.log($(this).attr('href'));
    $('.current-video-page').val($(this).attr('href'));
    $('#video-archive').load($(this).attr('href')+' #video-archive',function(responseTxt, statusTxt, xhr){
        videoTags(tag_type)
    });
});

var chat_toggle = $('#chat-box-container').scotchPanel({
                    startOpened: false, // Required
                    containerSelector: '#applicant-posting-container',
                    direction: 'left',
                    duration: 300,
                    transition: 'ease',
                    //clickSelector: '.toggle-panel-chat',
                    distanceX: '30%',
                    enableEscapeKey: true
                });

//For Chat Toggling
$('.toggle-panel-chat').click(function(){
    if($(this).text() == 'Close Chat') {
        $('#chat-box-container').addClass('is-hidden');
        $(this).text('Open Chat');
        $(this).append('<span class="badge chat-badge">0</span>');
        
    } else {
        $('#chat-box-container').removeClass('is-hidden');
        $(this).text('Close Chat');    
        $(this).children('.chat-badge').remove();
    }
    chat_toggle.toggle();
});

function stopJanusRecording() {
        sfutest.send({"message": stop});
        sfutest.detach();   
}

//Initialize Video Tags
videoTags(tag_type);
function videoTags(tag_type) {
    //For Tags
$('.video-tags').tagEditor({
        maxTags: 9999,
        clickDelete: true,
        placeholder: 'Enter video tags ...',
        autocomplete: {
            delay: 0, // show suggestions immediately
            position: {collision: 'flip'}, // automatic menu position up/down
            source: public_path + 'getTags/' + $(this).siblings('.recorded_video_id') + '/' +tag_type
        },
        onChange: function (field, editor, tags) {
            var ajaxurl = public_path + 'addNewTag';

            var unique_id = $(field).siblings('.recorded_video_id').val();
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
}


///////////////////////////////////////////
//Old Code
///////////////////////////////////////////

function startRecording() {
    // bitrate and keyframe interval can be set at any time:
    // before, after, during recording
    //session = randomString(12);
    session = randomInteger(15);
    socket.emit('start-recording', session);

}
function stopRecording() {
    socket.emit('stop-recording', session);
}
function saveVideo() {
    socket.emit('save-video', session);
}

$('body').on('click', '.btn-video', function (e) {
    var timer_text = $(this).siblings('.timer-area').text();
    var original_time = $(this).siblings('.original_time').val();
    var question_id = $(this).siblings('.question_id').val();
    
    var time_array = timer_text.split(":");
    
    var minutes = '-' + time_array[0] + 'M';
    var seconds = '-' + time_array[1] + 'S';

    var until = minutes + ' ' + seconds;
   
   var timer_id = $(this).siblings('.timer-area').attr('id');
   
    var b = addMinutes(new Date(),time_array[0]); 
     
    //Applicant will always be the remote video. Only the Interviewer can record the applicant's video
    var remote_video_length = $('#video-conference-container .remote-video').length;   
    
    var user_id = $('.user_id').val();
    var user_type = $('.user_type').val();
   
if($(this).text() === 'Record Answer') {
    
if(user_id === room_number && user_type === 'applicant') {
        
        mainVideo = $('#localVideo')[0].srcObject;
        //var video_id = 'container_'+$(this).siblings('.stream_id').val();
        //var container = $('#'+remote_video_id).find('.stream_id').val();
        var container = 'localVideoContainer';
        var video_title = $('#question-'+question_id+' .box-title').text();
        console.log('Recording applicant');
        $(this).text('Stop Recording');
        $('#'+timer_id).countdown({until: b, format: 'MS', compact: true});
        $('#'+timer_id).countdown('resume');
        createJanusLocalStream(container,video_title,question_id);
        
} else {
        
//For Remote
if(remote_video_length != 0) {
        
    var remote_video_id = $('#video-conference-container .remote-video').attr('id');
    var remote_video_title = $('#'+remote_video_id+' .panel-title').text();
    
    for(i=0; i < remote_video_length; i++) {
            if(remote_video_title.includes('(applicant)')) {
                mainVideo = $('#'+remote_video_id+' .panel-body video')[0].srcObject;
                //var video_id = 'container_'+$(this).siblings('.stream_id').val();
                //var container = $('#'+remote_video_id).find('.stream_id').val();
                var container = remote_video_id;
                var video_title = $('#question-'+question_id+' .box-title').text();
                console.log('Recording applicant');
                $(this).text('Stop Recording');
                $('#'+timer_id).countdown({until: b, format: 'MS', compact: true});
                $('#'+timer_id).countdown('resume');
                createJanusLocalStream(container,video_title,question_id);
            }
    }
        
   
} else {
        $(this).siblings('.recording-status-text').append('<span>Applicant is offline</span>');
        $(this).siblings('.recording-status-text').find('span').fadeOut(1000);
}

    }
} else {
       $(this).text('Record Answer');
        sfutest.send({"message": stop});
        sfutest.detach();
        $('#'+timer_id).countdown('pause');
        $('#'+timer_id).countdown('destroy');
        console.log('original_time: '+original_time);
        $(this).siblings('.timer-area').text(original_time);
        $('.blink').addClass('hidden');
}    

    
});

function addMinutes(date, minutes) {
    return new Date(date.getTime() + minutes*60000);
}

$('body').on('change','.video-conference-points',function(){
   
   var question_id = $(this).siblings('.question_id').val();
   var applicant_id = $(this).siblings('.applicant_id').val();
   var video_id = $(this).siblings('.video_id').val();
   var score = $(this).val();
   console.log('score: '+score);
   console.log('video_id: '+video_id);
   console.log('question_id: '+question_id);
   console.log('applicant_id: '+applicant_id);
   $.ajax({
            url: public_path + 'updateInterviewQuestionScore/'+question_id,
            data: {
                score: score,
                applicant_id:applicant_id,
                video_id:video_id
            },
            type: "PUT",
            beforeSend: function () {

            },
            success: function (data) {
                
            },
            complete: function () {

            },
            error: function (xhr, status, error) {
                
            }
        });
    
});

$('body').on('click','.btn-edit-video-title',function(e){
    e.preventDefault();
    
    $(this).addClass('hidden');
    $(this).siblings('.btn-save-video-title').removeClass('hidden');
    $(this).parent().parent().find('.edit-title').removeClass('hidden');
    $(this).parent().parent().find('.video-label').addClass('hidden');
    $(this).siblings('.btn-delete-video').addClass('hidden');
});

$('body').on('click','.btn-save-video-title',function(e){
    var recorded_video_id = $(this).siblings('.recorded_video_id').val();
    var new_title = $(this).parent().parent().find('.edit-title').val();
    if(new_title !== "") {
        $(this).parent().parent().find('.video-label').text(new_title);    
    } else {
        $(this).parent().parent().find('.video-label').text('No Title');    
    }
    
    
    $(this).addClass('hidden');
    $(this).parent().parent().find('.edit-title').addClass('hidden');
    $(this).siblings('.btn-edit-video-title').removeClass('hidden');
    $(this).siblings('.btn-delete-video').removeClass('hidden');
    $(this).parent().parent().find('.video-label').removeClass('hidden');
    editRecordedVideo(new_title,recorded_video_id);
});

$('body').on('click','.btn-delete-video',function(e){
    e.preventDefault();
    var recorded_video_id = $(this).siblings('.recorded_video_id').val();
    //console.log(recorded_video_id);var message_object = '<div class="row"><div class="col-xs-6">'+ webrtc.config.nick + '</div><div class="col-xs-6"></div></div><div class="row"><div class="col-xs-8 chat-bubble-left">'+message+'</div></div>';
    var button = $(this);
    BootstrapDialog.confirm({
            title: 'Deleting Video',
            message: 'Are you sure?',
            type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
            btnOKLabel: 'Ok', // <-- Default value is 'OK',
            btnOKClass: 'btn-warning', // <-- If you didn't specify it, dialog type will be used,
            callback: function(result) {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if(result) {
                    button.attr('disabled','true');
                    button.text('Deleting');
                    deleteRecordedVideo(recorded_video_id,$(this));            
                }else {
                    
                }
            }
        });
});

$('body').on('click','.refresh-video-archive',function(e){
   e.preventDefault();
   refreshVideoArchive();
   $(this).text('Refreshing');
});

$('body').on('click','.refresh-interview-question-answers',function(e){
   e.preventDefault();
   
   var question_id = $(this).siblings('.question_id').val();
   
   refreshInterviewQuestions(question_id,$(this));
   $(this).text('Refreshing');
});

//Check if we have the Job.tc chrome extension if it's chrome
checkExtension();
function checkExtension() {
    if (typeof chrome !== "undefined" && typeof chrome.app !== "undefined" && chrome.app.isInstalled) {
        console.log('Job.tc extension is installed');
        hasExtension = true;
    }
}

/*function createJanusLocalStream() {
    janus = new Janus({
        server: server,
        success: function () {
            //Local Video
            janus.attach({
                plugin: "janus.plugin.recordplay",
                success: function (pluginHandle) {
                    sfutest = pluginHandle;
                    console.log('simpleRtcConnected: ' + simpleRtcConnected);
                    if (simpleRtcConnected == 1) {
                        janus_btn.removeClass('hidden');
                        $('.janus-waiting').remove();
                    }
                    janusConnected = 1;
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
                    console.log("result: " + result);
                    if (result !== null && result !== undefined) {
                        if (result["status"] !== undefined && result["status"] !== null) {
                            var event = result["status"];
                            if (event === 'preparing') {
                                Janus.log("Preparing the recording playout :" + result["id"]);
                                playing_video = result["id"]
                                sfutest.createAnswer({
                                    jsep: jsep,
                                    media: {audioSend: false, videoSend: false}, // We want recvonly audio/video
                                    success: function (jsep) {
                                        Janus.debug("Got SDP!");
                                        Janus.debug(jsep);
                                        var body = {"request": "start"};
                                        sfutest.send({"message": body, "jsep": jsep});
                                    },
                                    error: function (error) {
                                        Janus.error("WebRTC error:", error);
                                        bootbox.alert("WebRTC error... " + JSON.stringify(error));
                                    }
                                });
                                if (result["warning"])
                                    bootbox.alert(result["warning"]);
                            }
                            else if (event === 'recording') {
                                // Got an ANSWER to our recording OFFER
                                if (jsep !== null && jsep !== undefined)
                                    sfutest.handleRemoteJsep({jsep: jsep});
                                var id = result["id"];
                                if (id !== null && id !== undefined) {
                                    Janus.log("The ID of the current recording is " + id);
                                    //Get the nfo id to map to the mjr file generated
                                    nfo_id = id;

                                }
                            }
                            else if (event === 'slow_link') {
                                var uplink = result["uplink"];
                                if (uplink !== 0) {
                                    // Janus detected issues when receiving our media, let's slow down
                                    bandwidth = 128 * 1024;
                                    sfutest.send({
                                        'message': {
                                            'request': 'configure',
                                            'video-bitrate-max': bandwidth, // Reduce the bitrate
                                            'video-keyframe-interval': 15000 // Keep the 15 seconds key frame interval
                                        }
                                    });
                                }
                            }
                            else if (event === 'playing') {
                                Janus.log("Playout has started!");
                            }
                            else if (event === 'stopped') {
                                Janus.log("Session has stopped!");
                            } else if (event === 'done') {
                                $('#video-archive-item-' + playing_video).remove();
                                playing_video = null;
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
                    Janus.debug(" ::: Got a local stream :::");
                    Janus.debug(JSON.stringify(stream));
                    //if (playing === true)
                    //return;

                    //$('#localVideo').append('<video class="rounded centered" id="thevideo" width=320 height=240 autoplay muted="muted"/>');
                    //attachMediaStream($('#thevideo').get(0), stream);

                    //attachMediaStream($('#localVideo').find('video').get(0), stream);
                },
                onremotestream: function (stream) {
                    if (playing === false)
                        return;
                    Janus.debug(" ::: Got a remote stream :::" + JSON.stringify(stream));
                    $('.video-element-holder #' + playing_video).append('<video class="rounded centered" id="video-archive-item-' + playing_video + '" width=320 height=240 controls autoplay/>');

                    // Show the video, hide the spinner and show the resolution when we get a playing event
                    attachMediaStream($('#video-archive-item-' + playing_video).get(0), stream);

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
}*/

/*function startRecordingLocalStream(session_local) {
    var n = $.now();
    recordingId = n + '-' + room_name;
    //var f = data + '-' + recordingId;
    var f = session_local + '-' + sfutest.getId();
    
    //console.log(n);

    sfutest.createOffer({
        // By default, it's sendrecv for audio and video..
        success: function (jsep) {
            Janus.debug(jsep);
            var body = {
                "request": "record",
                //"name": n.toString(),
                "name": f.toString(),
                "video": "stdres",
                "filename": f.toString()
            };
            sfutest.send({"message": body, "jsep": jsep});
        },
        stream: localStream,
        error: function (error) {
            sfutest.hangup();
        }
    });
}*/

function startRecordingLocalScreenShare(data) {
    var n = $.now();
    recordingId = n + '-' + room_name;
    //var f = data + '-' + recordingId;
    var f = data + '-' + sfutest.getId();

    screentest.createOffer({
        // By default, it's sendrecv for audio and video..
        success: function (jsep) {
            Janus.debug(jsep);
            var body = {
                "request": "record",
                //"name": 'screenshare-' + n.toString(),
                "name": 'screenshare-' + f.toString(),
                "video": "stdres",
                "filename": 'screenshare-' + f.toString()
            };
            screentest.send({"message": body, "jsep": jsep});

        },
        stream: localScreenStream,
        error: function (error) {
            screentest.hangup();
        }
    });
}

function createJanusLocalScreenShare() {

    // Create another session for screen sharing(The screen takes up one user space in the room)
    janusscreen = new Janus(
            {
                server: server,
                success: function () {
                    // Attach to video room test plugin
                    janusscreen.attach(
                            {
                                plugin: "janus.plugin.recordplay",
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
                                },
                                onmessage: function (msg, jsep) {
                                    Janus.debug(" ::: Got a message (publisher) :::");
                                    Janus.debug(JSON.stringify(msg));
                                    var event = msg["videoroom"];
                                    Janus.debug("Event: " + event);
                                    if (event != undefined && event != null) {
                                        if (event === "joined") {
                                            myid = msg["id"];
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
                                    //$('#localVideo').append('<video class="rounded centered" id="myscreenshare" width="100%" autoplay muted="muted"/>');
                                    //attachMediaStream($('#myscreenshare').get(0), stream);
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

function saveNfo() {
    $.ajax({
        url: public_path + 'saveNfoJanus',
        data: {
            //local: data + '-' + sfutest.getId()
            stream: sfutest.getId(),
            session: session
        },
        type: "POST",
        beforeSend: function () {

        },
        success: function (e) {
            console.log('NFO generated');

        },
        complete: function () {

        },
        error: function (xhr, status, error) {
            console.log('Error: retrying');
        }
    });
}

function saveScreenShareNfo() {

    $.ajax({
        url: public_path + 'saveScreenShareNfoJanus',
        data: {
            //local: data + '-' + sfutest.getId()
            stream: sfutest.getId(),
            session: session
        },
        type: "POST",
        beforeSend: function () {

        },
        success: function (e) {
            console.log(e);
            console.log('Screenshare NFO generated');

        },
        complete: function () {

        },
        error: function (xhr, status, error) {
            console.log('Error: retrying');
        }
    });
}

function isRecording() {
    var session_id = $('.session_id').val();

    if (session_id !== "") {
        $.ajax({
            url: public_path + 'isRecording',
            data: {
                //local: data + '-' + sfutest.getId()
                session: session_id
            },
            type: "POST",
            beforeSend: function () {

            },
            success: function (data) {
                if (data === 'Yes') {
                    recording = true;

                    $('.is-recording').attr("value", "true");
                    $('.session_id').attr("value", data);

                    startRecordingLocalStream(data);
                    if (hasShareScreen === 1) {
                        startRecordingLocalScreenShare(data);
                    }

                    //Get Page type to determine if it's a company employee or applicant
                    var room_type = $('.page_type').val();

                    formData = new FormData();
                    formData.append('session', data);
                    formData.append('room_name', room_name);
                    formData.append('room_type', room_type);
                    formData.append('stream', sfutest.getId());
                    formData.append('rec_dir', rec_dir);
                    formData.append('_token', csrf_token);

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
                }
            },
            complete: function () {

            },
            error: function (xhr, status, error) {
                console.log('Error: retrying');
            }
        });
    }
}

function deleteRecordedVideo(recorded_video_id) {
    
    $.ajax({
     url: public_path + '/deleteRecordedVideo/'+recorded_video_id,
     type: "DELETE",
     beforeSend: function () {
        
     },
     success: function (e) {
     console.log('Deleted Video');
     refreshVideoArchive();
     },
     complete: function () {
        
     },
     error: function (xhr, status, error) {
     }
     });
    
}

function refreshVideoArchive() {
    $('#video-archive').load($('.current-video-page').val()+' #video-archive',function(responseTxt, statusTxt, xhr){
        $('.refresh-video-archive').text('Refresh Video Archive');
         videoTags(tag_type);
    });
}

function refreshInterviewQuestions(question_id,button){
   $('#question-collapse-answers-'+question_id).load($('.current-video-page').val()+' #question-collapse-answers-'+question_id,function(responseTxt, statusTxt, xhr){
        $(button).text('Refresh Answers');
    });
    
    
}

//For adding running history on interview questions
function addInterviewQuestionAnswer(module_type,module_id,question_id,video_id,score) {
    $.ajax({
     url: public_path + '/addInterviewQuestionAnswer',
     data: {
        module_type:module_type,
        module_id:module_id,
        question_id:question_id,
        video_id:video_id,
        score:score
     },
     type: "POST",
     beforeSend: function () {
        
     },
     success: function (e) {
     console.log('Added Interview Question Score');
     },
     complete: function () {
        
     },
     error: function (xhr, status, error) {
     }
     });
}