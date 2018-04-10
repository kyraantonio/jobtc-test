/* 
 * Discussion Room scripts
 */

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

//Display name
var display_name = $('.display_name').val();


//Get Room name
var room_name_tmp = window.location.pathname;
var room_name = parseInt(room_name_tmp.substr(room_name_tmp.lastIndexOf('/') + 1));
var room_number = $('.room_number').val();
var tag_type = 'discussions';


console.log(room_name_tmp);

//For ScreenShare
var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
var hasExtension = false;


var screenshare_count = 0;
var participant_count = 0;

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
    containment: "#discussions-container",
    minHeight: 350,
    minWidth: 350,
    grid: 50
});

$( "#remoteVideo" ).sortable({
     stop: function(event, ui) {
         var video = ui.item.find('video').get(0);
        video.play();
    }
});
$( "#remoteVideo" ).disableSelection();

 webrtc = new SimpleWebRTC({
                     // the id/element dom element that will hold "our" video
                    localVideoEl: 'localVideoEl',
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



//Immediately start the local video upon entering this discussion room

//Check if room is public

/*if (display_name == 'Anonymous') {

    var display_name_form = public_path + '/displayNameForm';

    BootstrapDialog.show({
        title: 'Enter your name',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Ok',
                cssClass: 'btn-edit btn-shadow',
                action: function (dialog) {
                    var new_display_name = $('.new_display_name').val();
                    console.log('new_display_name: '+new_display_name);
                    $('.display_name').val(new_display_name);
                    webrtc.startLocalVideo();
                    webrtc.sendToAll('changeName', {display_name: new_display_name});
                    dialog.close();
                }
            }],
        data: {
            'pageToLoad': display_name_form
        },
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });
} else {
    
    webrtc.startLocalVideo();
}*/

webrtc.startLocalVideo();

webrtc.on('localStream', function (stream) {
    console.log('this is the localstream : ' + JSON.stringify(stream));
    localStream = stream;
    mainVideo = stream;
    console.log(webrtc.webrtc.localStreams[0]);
});

/*For Video Sharing*/
// a peer video has been added
webrtc.on('videoAdded', function (video, peer) {
    $('.incoming-user-sound').get(0).play();
    console.log('video added', peer.nick);
    peerStream = peer.stream;
    console.log(peer.stream);
    var remotes = document.getElementById('remotes');
    var remoteVideo = document.getElementById('remoteVideo');
    var remoteScreen = document.getElementById('remoteScreen');
    var videoTag = $('#localVideoEl')[0];
    if (remoteVideo) {
        video.id = 'container_' + webrtc.getDomId(peer);
        console.log(video.id);
        //video.style.width = '334px';
        video.style.width = '100%';
        // suppress contextmenu
        video.oncontextmenu = function () {
            return false;
        };

        var dom_id = webrtc.getDomId(peer);
        if (dom_id.includes('screen')) {
            screenshare_count++;
            localScreenStream = peer.stream;
            
            //video.style.width = '652px';
            //$(video).attr('controls', 'controls');
            /*var screenShareOptions = '<div class="screenshare_options">' +
                    '<button id="set-video-' + peer.stream.id + '" class="btn btn-small set-video">Set as Main Video</button>' +
                    '<button class="btn btn-small full-screen"><i class="fa fa-arrows-alt" aria-hidden="true"></i></button>' +
                    '<input class="screenshare_id" type="hidden" value="' + screenshare_count + '"/>' +
                    '<input class="stream_id" type="hidden" value="' + webrtc.getDomId(peer) + '">' +
                    '</div>';*/
             
             var screenShareOptions = '<div class="row">'+
                                    '<div class="col-xs-5">'+
                                        '<button class="btn record"><i class="material-icons">fiber_manual_record</i><span class="record-text">Record</span></button>'+
                                        '<input class="stream_id" type="hidden" value="' + webrtc.getDomId(peer) + '">' +
                                        '<input class="screenshare_id" type="hidden" value="' + screenshare_count + '"/>' +
                                        '<input class="video_type" type="hidden" value="remoteScreen"/>'+
                                    '</div>'+
                                    '<div class="col-xs-7">'+
                                        '<div class="btn-group" role="group" aria-label="Screen Media Options">'+
                                            '<button class="btn full-screen"><i class="material-icons">fullscreen</i></button>' +
                                            '<input class="screenshare_id" type="hidden" value="' + screenshare_count + '"/>' +
                                            '<input class="stream_id" type="hidden" value="' + webrtc.getDomId(peer) + '">' +
                                            '<input class="video_type" type="hidden" value="remoteScreen"/>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';        
                    
             var collapseContainer = '<div class="col-xs-4 remote-screen" id="screenContainer-' + screenshare_count + '"><div class="panel-group">'+
    '<div class="panel panel-default">'+
      '<div class="panel-heading">'+
        '<h4 class="panel-title">'+
          '<a data-toggle="collapse" href="#remote-screen-collapse-'+screenshare_count+'">'+peer.nick+' Screen</a>'+
        '</h4>'+
      '</div>'+
      '<div id="remote-screen-collapse-'+screenshare_count+'" class="panel-collapse collapse in">'+
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
        '<input class="screenshare_id" type="hidden" value="' + screenshare_count + '"/>' +
        '</div>'+
        '<div class="panel-footer">'+screenShareOptions+'</div>'+
      '</div>'+
    '</div>'+
  '</div></div>';                    
                    
            var screenContainer = "<div class='col-xs-6' id='screenContainer-" + screenshare_count + "'>" + screenShareOptions + "</div>";

            $("#remoteVideo").append(collapseContainer);
            //$('#screenContainer-' + screenshare_count).prepend(video);
            $("#remote-screen-collapse-" + screenshare_count+' .panel-body').prepend(video);
            
             $('#screenContainer-'+screenshare_count).resizable({
                 containment: "#discussions-container",
                 minHeight: 350,
                 minWidth: 350,
                 grid: 50
            });
            
              $('body').on('click','#set-video-'+peer.stream.id,function () {
    
                //video.style.height = '640px';
                //video.style.width = '1080px';
                video.id = 'remote-'+peer.stream.id;
                //$('#localVideo video').remove();
                //$('#localVideo').append(video);
                //document.getElementById('localScreen').removeChild(video);
                
                //$('#localVideoContainer').attr('class','col-xs-9');
                //$('#chat-box-container').attr('class','col-xs-3');
                //$('#localVideoEl').hide();
                //$('#localVideo').append(video);
                videoTag.srcObject = peer.stream;
                mainVideo = peer.stream;
                
                
                $(this).text('Reset Video');
                
                $(this).attr('id','reset-video-'+peer.stream.id);
                
                    
                //var localvideo = $('#localVideoEl').get(0);
                //localvideo.play();
                console.log('Setting as main video');
    });
    
    $('body').on('click','#reset-video-'+peer.stream.id,function(){
       console.log('Resetting Video'); 
       
       //$('#localVideoEl').show();
       //$('#remote-'+peer.stream.id).remove();
       $(this).attr('id','set-video-'+peer.stream.id);
       videoTag.srcObject = localStream;
       mainVideo = localStream;
       $(this).text('Set as Main Video');
       //$('#localVideo video').remove();
       //$('#localVideo').append(localStream);
       
    });
            
        } else {

            participant_count++;
                    
                
            var videoTag = $('#localVideoEl')[0];
            /*var remoteVideoOptions = '<div class="remote_video_options center-block">' +
                    '<button id="set-video-' + peer.stream.id + '" class="btn btn-small set-video">Set as Main Video</button>' +
                    '<button class="btn btn-small full-screen"><i class="fa fa-arrows-alt" aria-hidden="true"></i></button>' +
                    '<input class="participant_id" type="hidden" value="' + participant_count + '"/>' +
                    '<input class="stream_id" type="hidden" value="' + webrtc.getDomId(peer) + '">' +
                    '</div>';*/
            
            var remoteVideoOptions = '<div class="row">'+
                                    '<div class="col-xs-5">'+
                                        '<button class="btn record"><i class="material-icons">fiber_manual_record</i><span class="record-text">Record</span></button>'+
                                        '<input class="stream_id" type="hidden" value="' + webrtc.getDomId(peer) + '">' +
                                        '<input class="participant_id" type="hidden" value="' + participant_count + '"/>' +
                                        '<input class="video_type" type="hidden" value="remote" />'+
                                    '</div>'+
                                    '<div class="col-xs-7">'+
                                        '<div class="btn-group" role="group" aria-label="Remote Media Options">'+
                                            '<button class="btn  stop-video"><i class="material-icons">videocam</i></button>'+            
                                            '<button class="btn  mute"><i class="material-icons">mic</i></button>'+
                                            '<button class="btn full-screen"><i class="material-icons">fullscreen</i></button>' +
                                            '<input class="participant_id" type="hidden" value="' + participant_count + '"/>' +
                                            '<input class="stream_id" type="hidden" value="' + webrtc.getDomId(peer) + '">' +
                                            '<input class="video_type" type="hidden" value="remote"/>'
                                        '</div>'+
                                    '</div>'+
                                '</div>';
            
            
            var collapseContainer = '<div class="col-xs-3 remote-video" id="remoteVideo-' + participant_count + '"><div class="panel-group">'+
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
            
              $('body').on('click','#set-video-'+peer.stream.id,function () {
    
                //video.style.height = '640px';
                //video.style.width = '1080px';
                video.id = 'remote-'+peer.stream.id;
                //$('#localVideo video').remove();
                //$('#localVideo').append(video);
                //document.getElementById('localScreen').removeChild(video);
                
                //$('#localVideoContainer').attr('class','col-xs-9');
                //$('#chat-box-container').attr('class','col-xs-3');
                //$('#localVideoEl').hide();
                //$('#localVideo').append(video);
                //video.clone().appendTo('#localVideo');
                videoTag.srcObject = peer.stream;
                mainVideo = peer.stream;
                
                $(this).text('Reset Video');
                
                $(this).attr('id','reset-video-'+peer.stream.id);
                
                    
                var remotevideo = $('#remote-'+peer.stream.id).get(0);
                remotevideo.play();
                console.log('Setting as main video');
    });
    
    $('body').on('click','#reset-video-'+peer.stream.id,function(){
       console.log('Resetting Video'); 
       
       //$('#localVideoEl').show();
       //$('#remote-'+peer.stream.id).remove();
       $(this).attr('id','set-video-'+peer.stream.id);
       videoTag.srcObject = localStream;
       mainVideo = localStream;
       $(this).text('Set as Main Video');
       //$('#localVideo video').remove();
       //$('#localVideo').append(localStream);
       
    });
            console.log('hasAudio: '+JSON.stringify(mediaOptions.audio));
            console.log('hasVideo: '+JSON.stringify(mediaOptions.video));
            $("#remoteVideo").append(collapseContainer);
            //$("#remoteVideo-" + participant_count).prepend(video);
            $("#remote-video-collapse-" + participant_count+' .panel-body').prepend(video);
            
            $('#remoteVideo-'+participant_count).resizable({
                 containment: "#discussions-container",
                 minHeight: 350,
                 minWidth: 350,
                 grid: 50
            });
        }

        //remotes.appendChild(container);
    }
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

    // receiving an incoming filetransfer
    peer.on('fileTransfer', function (metadata, receiver) {
        console.log('incoming filetransfer', metadata.name, metadata);
        receiver.on('progress', function (bytesReceived) {
            console.log('receive progress', bytesReceived, 'out of', metadata.size);
        });
        // get notified when file is done
        receiver.on('receivedFile', function (file, metadata) {
            console.log('received file', metadata.name, metadata.size);
            console.log("file:" + file);

            var file_url = window.URL.createObjectURL(file);

            $("#message-log").prepend('<a href="' + file_url + '" download="' + metadata.name + '"><i class="fa fa-file" aria-hidden="true"></i>' + metadata.name + '</a><br />');

            // close the channel
            receiver.channel.close();
        });
        //filelist.appendChild(item);
    });

    // send a file
    $('#sendFile').change(function () {

        var file = this.files[0];
        var name = file.name;
        var size = file.size;
        var type = file.type;
        console.log("Sending File: " + name);
        console.log("Size: " + size);
        console.log("Type: " + type);
        //webrtc.sendToAll('fileTransfer', {name: name, size: size, type: type});
        $("#message-log").prepend('<text>Sending file: ' + name + ' ' + size + ' bytes</text>');
        var sender = peer.sendFile(file);
    });
});

// a peer video was removed
webrtc.on('videoRemoved', function (video, peer) {
    console.log('video removed ', peer);
    var remotes = document.getElementById('remotes');
    var remoteVideo = document.getElementById('remoteVideo');
    var remoteScreen = document.getElementById('remoteScreen');
    var el = document.getElementById(peer ? 'container_' + webrtc.getDomId(peer) : 'localScreenContainer');
    
    //if (remotes && el) {
        var dom_id = webrtc.getDomId(peer);
        if (dom_id.includes('video')) {
            //$('#remoteVideo').find('#remoteVideo-'+participant_count).remove();
            var remote_video_id = $('#container_' + webrtc.getDomId(peer)).parent().attr('id');
            var participant_id = $(video).siblings('.participant_id').val();
            console.log('participant_id: '+participant_id);
            $('#remoteVideo-'+participant_id).remove();
            //$('#remoteVideo-'+webrtc.getDomId(peer)).remove();
            //console.log($(el).parent().attr('id'));
            //remoteVideo.removeChild(el);
        }

        if (dom_id.includes('screen')) {
            //remoteScreen.removeChild(el);
            var remote_video_id = $('#container_' + webrtc.getDomId(peer)).parent().attr('id');
            var screenshare_id = $(video).siblings('.screenshare_id').val();
            $('#screenContainer-'+screenshare_id).remove();
            console.log('remote_video_id:' + remote_video_id);
            //$('#screenContainer-'+webrtc.getDomId(peer)).remove();
            
            //$('#' + remote_video_id).remove();
            //$(video).parent().remove();
            //console.log($(el).attr('id'));
            //remoteVideo.removeChild(el);
        }
    //}

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
            $('#container_' + webrtc.getDomId(peer) + ' .muted').show();
        } else if (data.name == 'video') {
            $('#container_' + webrtc.getDomId(peer) + ' .paused').show();
            $('#container_' + webrtc.getDomId(peer) + ' video').hide();
        }
    });
});

webrtc.on('unmute', function (data) { // hide muted symbol
    webrtc.getPeers(data.id).forEach(function (peer) {
        if (data.name == 'audio') {
            $('#videocontainer_' + webrtc.getDomId(peer) + ' .muted').hide();
        } else if (data.name == 'video') {
            $('#container_' + webrtc.getDomId(peer) + ' video').show();
            $('#container_' + webrtc.getDomId(peer) + ' .paused').hide();
        }
    });
});

// called when a peer is created
webrtc.on('createdPeer', function (peer) {
    console.log('createdPeer', peer.stream);
    
});

webrtc.on('localScreen', function (video) {
    console.log('created localScreen');
    console.log(webrtc.getDomId(video));
});

/*For Screensharing*/
// local screen obtained
webrtc.on('localScreenAdded', function (video) {
    //Get the local screen media stream object

    screenshare_count++;
    video.id = "localScreen-" + screenshare_count;
    video.class = "localScreen";
    localScreenStream = webrtc.getLocalScreen();
    console.log('This is the local screenshare stream: ' + JSON.stringify(video));
    //video.style.width = '334px';
    video.style.width = '100%';
    //$(video).attr('controls', 'controls');

    /*var screenShareOptions = '<div class="screenshare_options">' +
            '<button id="set-video-'+webrtc.getDomId(localScreenStream)+'" class="btn btn-small screen-set-video">Set as Main Video</button>' +
            '<button class="btn btn-small full-screen"><i class="fa fa-arrows-alt" aria-hidden="true"></i></button>' +
            '<button class="btn btn-small stop-screen-share">' +
            '<i class="fa fa-times" aria-hidden="true"></i>' +
            '</button>' +
            '<input class="screenshare_id" type="hidden" value="' + screenshare_count + '"/>' +
            '</div>';*/
            
     var screenShareOptions = '<div class="row">'+
                                    '<div class="col-xs-5">'+
                                        '<button class="btn record"><i class="material-icons">fiber_manual_record</i><span class="record-text">Record</span></button>'+
                                        '<input class="screenshare_id" type="hidden" value="' + screenshare_count + '"/>' +
                                        '<input class="video_type" type="hidden" value="localScreen"/>'+
                                    '</div>'+
                                    '<div class="col-xs-7">'+
                                        '<div class="btn-group" role="group" aria-label="Local Screen Media Options">'+
                                            '<button class="btn btn-small stop-screen-share">' +
                                            '<i class="material-icons">close</i>' +
                                            '</button>' +
                                            '<input class="screenshare_id" type="hidden" value="' + screenshare_count + '"/>' +
                                            '<input class="video_type" type="hidden" value="localScreen" />'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';                
            
            
      var collapseContainer = '<div class="col-xs-4 remote-screen" id="screenContainer-' + screenshare_count + '"><div class="panel-group">'+
    '<div class="panel panel-default">'+
      '<div class="panel-heading">'+
        '<h4 class="panel-title">'+
          '<a data-toggle="collapse" href="#remote-screen-collapse-'+screenshare_count+'">'+display_name+' Screen</a>'+
        '</h4>'+
      '</div>'+
      '<div id="remote-screen-collapse-'+screenshare_count+'" class="panel-collapse collapse in">'+
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
        '<input class="screenshare_id" type="hidden" value="' + screenshare_count + '"/>' +
        '</div>'+
        '<div class="panel-footer">'+screenShareOptions+'</div>'+
      '</div>'+
    '</div>'+
  '</div></div>';                            
            
    var screenContainer = "<div class='col-xs-12' id='screenContainer-" + screenshare_count + "'>" + screenShareOptions + "</div>";
    
    var videoTag = $('#localVideoEl')[0];    
      $('body').on('click','#set-video-'+webrtc.getDomId(localScreenStream),function () {
                
                //video.style.height = '640px';
                //video.style.width = '1080px';
                video.id = 'screen-'+webrtc.getDomId(localScreenStream);
                //$('#localVideo video').remove();
                //$('#localVideo').append(video);
                //document.getElementById('localScreen').removeChild(video);
                
                //$('#localVideoContainer').attr('class','col-xs-9');
                //$('#chat-box-container').attr('class','col-xs-3');
                //$('#localVideoEl').hide();
                //$('#localVideo').append(video);
                
                
                videoTag.srcObject = localScreenStream;
                mainVideo = localScreenStream;
                $(this).text('Reset Video');
                
                $(this).attr('id','reset-video-'+webrtc.getDomId(localScreenStream));
                
                    
                //var localvideo = $('#localVideo video').get(0);
                //localvideo.play();
                console.log('Setting as main video');
    });
    
    $('body').on('click','#reset-video-'+webrtc.getDomId(localScreenStream),function(){
       console.log('Resetting Video'); 
       
       //$('#localVideoEl').show();
       //$('#screen-'+webrtc.getDomId(localScreenStream)).remove();
       $(this).attr('id','set-video-'+webrtc.getDomId(localScreenStream));
       
        videoTag.srcObject = localStream;
        mainVideo = localStream;
       
       $(this).text('Set as Main Video');
       //$('#localVideo video').remove();
       //$('#localVideo').append(localStream);
       
    });
     
    //if(isRecording == false) {
        $("#remoteVideo").append(collapseContainer);
        $("#remote-screen-collapse-" + screenshare_count+' .panel-body').prepend(video);
        $('#screenContainer-'+screenshare_count).resizable({
                 containment: "#discussions-container",
                 minHeight: 350,
                 minWidth: 350,
                 grid: 50
        });
        //$('#screenContainer-' + screenshare_count).prepend(video);
        //$('#screenContainer-'+screenshare_count).append('<button class="btn btn-small stop-screen-share"><i class="fa fa-times" aria-hidden="true"></i></button>');
        //$('#screenContainer-'+screenshare_count).append('<input class="screenshare_id" type="hidden" value="'+screenshare_count+'"/>');
        hasShareScreen = 1;
    //}

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
    webrtc.joinRoom(room_name_tmp, function () {
        $('#localVideoOptions').removeClass('hidden');
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
    if(data.type === 'changeName') {
        console.log('Received displayName ' + data.payload.display_name);
    }
   
});

webrtc.on('channelMessage', function (peer, label, data) {
  if (data.type == 'setDisplayName') {
      var name = data.payload;
      console.log('Received displayName ' + name + ' from peer ' + peer.id);
  }
});

// local volume has changed
webrtc.on('volumeChange', function (volume, treshold) {
    //showVolume(document.getElementById('localVolume'), volume);
});

// remote volume has changed
webrtc.on('remoteVolumeChange', function (peer, volume) {
    //showVolume(document.getElementById('volume_' + peer.stream.id), volume);
    var this_id = $('#volume_' + peer.stream.id).siblings('.participant_id').val();
    
    if(volume >= -50) {
        //$('#remoteVideo-'+this_id+' .panel-heading').animate({'backgroundColor':'#42bcf4'},100).animate({'backgroundColor':'#f5f5f5'},100);  ;
    }
});

//For Recording
var server = "https://extremefreedom.org:8089/janus";
var media_server_url = "extremefreedom.org";
var rec_dir = 'https://extremefreedom.org/recordings';



//Remove video when the tab closes
window.addEventListener("beforeunload", function (e) {
    webrtc.leaveRoom(room_name_tmp);
    webrtc.stopLocalVideo();
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

$('.share-screen').click(function () {
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
        }
    });
});

$('body').on('click', '.stop-screen-share', function () {

    var screenshare_id = $('.screenshare_id').val();
    $('#screenContainer-' + screenshare_id).remove();
     webrtc.stopScreenShare();
     webrtc.leaveRoom(room_name_tmp);      
     webrtc.stopLocalVideo();
     webrtc.startLocalVideo();
    //This solves a bug related to screensharing(First screen share not being disposed properly)
    
    //webrtc.stopLocalVideo(); 
    //webrtc.startLocalVideo(); 
    console.log("Screensharing deactivated");
    //var stream = webrtc.getLocalScreen();
    //if (stream) {
        //stream.getTracks().forEach(function (track) { track.stop(); });
    //}
    //$('.localScreen').remove();
    //$('.stop-screen-share').remove();
});

$('#message').keyup(function () {
    var message = $("#message").val().length;
    if (message != 0) {
        $('#send-message').attr('disabled', false);
    } else {
        $('#send-message').attr('disabled', true);
    }
});

$('#send-message').click(function () {
    var message = $("#message").val();
    
    var regex = /(https?:\/\/([-\w\.]+)+(:\d+)?(\/([-\w/_\.]*(\?\S+)?)?)?)/ig;
        // Replace plain text links by hyperlinks
    var replaced_text = message.replace(regex, "<a href='$1' target='_blank'>$1</a>");

    //var message_object = '<text>' + webrtc.config.nick + " : " + message + '</text><br />';
    var message_object = '<div class="row"><div class="col-xs-6">'+ webrtc.config.nick + '</div><div class="col-xs-6"></div></div><div class="row"><div class="col-xs-8 chat-bubble-left">'+replaced_text+'</div></div>';
    
    $('#message-log').prepend(message_object);
    $("#message").val("");
    //webrtc.sendToAll('chat', {message: message, display_name: webrtc.config.nick});
    webrtc.sendToAll('chat', {message: message, display_name: display_name});
    saveMessage(display_name,replaced_text);
});

//Keypress events
$('body').keypress(function (e) {
    if (e.which == 13) {
        var message = $("#message").val();
          var regex = /(https?:\/\/([-\w\.]+)+(:\d+)?(\/([-\w/_\.]*(\?\S+)?)?)?)/ig;
        // Replace plain text links by hyperlinks
         var replaced_text = message.replace(regex, "<a href='$1' target='_blank'>$1</a>");
        if (message !== "") {
            //$('#message-log').prepend('<text>' + webrtc.config.nick + " : " + message + '</text><br />');
            var message_object = '<div class="row"><div class="col-xs-6">'+ webrtc.config.nick + '</div><div class="col-xs-6"></div></div><div class="row"><div class="col-xs-8 chat-bubble-left">'+replaced_text+'</div></div>';
            $('#message-log').prepend(message_object);
            $("#message").val("");
            //webrtc.sendToAll('chat', {message: message, display_name: webrtc.config.nick});
            webrtc.sendToAll('chat', {message: message, display_name: display_name});
            saveMessage(display_name,replaced_text);
        }
        return false;
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

$('.add-participant').click(function (e) {
    e.preventDefault();

    var add_participant_form = public_path + '/addParticipantForm';

    BootstrapDialog.show({
        title: 'Add Participant',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Send Invitation',
                cssClass: 'btn-edit btn-shadow',
                action: function (dialog) {
                    var ajaxurl = public_path + 'addParticipant';

                    var formData = new FormData();
                    var email = $('.email').val();
                    var room_url = window.location.href;

                    formData.append('email', email);
                    formData.append('room_url', room_url);
                    console.log(room_url);

                    var $button = this; // 'this' here is a jQuery object that wrapping the <button> DOM element.
                    $button.disable();
                    $button.spin();

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
                            dialog.close();
                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax
                }
            }, {
                label: 'Cancel',
                cssClass: 'btn-delete btn-shadow',
                action: function (dialog) {
                    dialog.close();
                }
            }],
        data: {
            'pageToLoad': add_participant_form
        },
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });

});

$('body').on('click','.record',function(){
    var muteText = $(this).children('.material-icons').text();
    var video_type = $(this).siblings('.video_type').val();
    console.log(muteText);
    console.log(video_type);
    if(muteText == 'fiber_manual_record') {
        if(video_type == 'local') { 
            mainVideo = localStream;
            var container = 'localVideoContainer';
            createJanusLocalStream(container);    
        } else if(video_type == 'localScreen') { 
            mainVideo = localScreenStream;
            var screenshare_id = $(this).siblings('.screenshare_id').val();
            var container = 'screenContainer-'+screenshare_id;
            createJanusLocalStream(container);    
        } else if(video_type == 'remoteScreen') {    
            
             var video_id = 'container_'+$(this).siblings('.stream_id').val();
             var screenshare_id = $(this).siblings('.screenshare_id').val();
             var remoteVideo = document.getElementById(video_id);
             mainVideo = $('#'+video_id)[0].srcObject;
             var container = 'screenContainer-'+screenshare_id;
             console.log(container);
             createJanusLocalStream(container);    
            
        } else {
             var video_id = 'container_'+$(this).siblings('.stream_id').val();
             var participant_id = $(this).siblings('.participant_id').val();
             var remoteVideo = document.getElementById(video_id);
             mainVideo = $('#'+video_id)[0].srcObject;
             var container = 'remoteVideo-'+participant_id;
             console.log(container);
             createJanusLocalStream(container);    
        }
        isRecording = true;
        $(this).css('background-color','orange');
        $(this).children('.material-icons').text('stop');
        $(this).find('.record-text').text('Starting...');
        $(this).attr('disabled',true);
    } else {
        sfutest.send({"message": stop});
        sfutest.detach();
        isRecording = false;
        $(this).css('background-color','#d7efed');
        $(this).children('.material-icons').text('fiber_manual_record');
        $(this).find('.record-text').text('Record');
        //$(this).text('Start Recording');
        $('.blink').addClass('hidden');    
    }
});

function createJanusLocalStream(container) {
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
                                    $('#'+container).find('.record-text').text('Stop Recording');
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
                    convertJanusVideo(filename,container);
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
                                    startRecordingLocalScreenShare();        
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
                                    
                                    //janusLocalScreenStream = stream;
                                    //startRecordingLocalScreenShare(stream);
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

function startRecordingLocalScreenShare() {
    var n = $.now();
    recordingId = n + '-' + room_name;
    //var f = data + '-' + recordingId;
    var f = screentest.getId();
    
    screentest.createOffer({
        // By default, it's sendrecv for audio and video..
        success: function (jsep) {
            Janus.debug(jsep);
            var body = {
                "request": "record",
                //"name": 'screenshare-' + n.toString(),
                "name": 'localRecording-' + f.toString(),
                "video": "hires",
                "filename": 'screenshare-' + f.toString()
            };
            screentest.send({"message": body, "jsep": jsep});

        },
        //stream: localStream,
        stream: mainVideo,
        error: function (error) {
            screentest.hangup();
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

function saveScreenShareNfo() {

    $.ajax({
        url: public_path + 'saveScreenShareNfoJanus',
        data: {
            //local: data + '-' + sfutest.getId()
            stream: screentest.getId(),
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


function convertJanusVideo(filename,container) {
    
    var subject_name = $('#'+container).find('.panel-title').text();
    
    $.ajax({
     url: public_path + 'convertDiscussionsJanusVideo',
     data: {
         'filename': filename,
         'module_type': 'discussions',
         'module_id': room_number,
         'display_name':display_name,
         'subject_name':subject_name,
         'video_title':""
     },
     type: "POST",
     beforeSend: function () {
        console.log('Sending Convertion signal');
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
               $('.video-tags').tagEditor({
                    maxTags: 9999,
                    clickDelete: true,
                    placeholder: 'Enter video tags ...',
                    autocomplete: {
                        delay: 0, // show suggestions immediately
                        position: {collision: 'flip'}, // automatic menu position up/down
                        source: public_path + 'getTags/' + $(this).siblings('.recorded_video_id') + '/discussions'
                    },
                    onChange: function (field, editor, tags) {
                    var ajaxurl = public_path + 'addNewTag';

                    var unique_id = $(field).siblings('.recorded_video_id').val();
                    var tag_type = 'discussions';
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
               $('.video-tags').tagEditor({
                    maxTags: 9999,
                    clickDelete: true,
                    placeholder: 'Enter video tags ...',
                    autocomplete: {
                        delay: 0, // show suggestions immediately
                        position: {collision: 'flip'}, // automatic menu position up/down
                        source: public_path + 'getTags/' + $(this).siblings('.recorded_video_id') + '/discussions'
                    },
                    onChange: function (field, editor, tags) {
                    var ajaxurl = public_path + 'addNewTag';

                    var unique_id = $(field).siblings('.recorded_video_id').val();
                    var tag_type = 'discussions';
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

function saveMessage(display_name,message) {
    
    $.ajax({
     url: public_path + 'chat',
     data: {
         'display_name': display_name,
         'module_type': 'discussions',
         'module_id': room_number,
         'message': message
     },
     type: "POST",
     beforeSend: function () {
        
     },
     success: function (e) {
     console.log('Saved Message');
   
     },
     complete: function () {
        
     },
     error: function (xhr, status, error) {
     }
     });
    
}

function editRecordedVideo(new_title,recorded_video_id) {
    $.ajax({
     url: public_path + '/editRecordedVideo/'+recorded_video_id,
     type: "PUT",
     data: {
       'title': new_title  
     },
     beforeSend: function () {
        
     },
     success: function (e) {
        console.log('Title Saved');
     },
     complete: function () {
        
     },
     error: function (xhr, status, error) {
     }
     });
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
         $('.video-tags').tagEditor({
        maxTags: 9999,
        clickDelete: true,
        placeholder: 'Enter video tags ...',
        autocomplete: {
            delay: 0, // show suggestions immediately
            position: {collision: 'flip'}, // automatic menu position up/down
            source: public_path + 'getTags/' + $(this).siblings('.recorded_video_id') + '/discussions'
        },
        onChange: function (field, editor, tags) {
            var ajaxurl = public_path + 'addNewTag';

            var unique_id = $(field).siblings('.recorded_video_id').val();
            var tag_type = 'discussions';
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
}


// helper function to show the volume
function showVolume(el, volume) {
    //console.log('showVolume', volume, el);
    if (!el) return;
    if (volume < -75) volume = -75; // -45 to -20 is
    if (volume > -10) volume = -10; // a good range
    el.value = volume;
}

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

var chat_toggle = $('#chat-box-container').scotchPanel({
                    startOpened: false, // Required
                    containerSelector: '#discussions-container',
                    direction: 'left',
                    duration: 300,
                    transition: 'ease',
                    //clickSelector: '.toggle-panel-chat',
                    distanceX: '25%',
                    enableEscapeKey: true
                });
                
/*var video_archive_toggle = $('#video-archive-container').scotchPanel({
                    containerSelector: '#video-archive-container',
                    direction: 'bottom',
                    duration: 300,
                    transition: 'ease',
                    //clickSelector: '.toggle-video-archive',
                    distanceX: '20%',
                    enableEscapeKey: true
                });                */

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


//For Video Archive Toggling
$('.toggle-video-archive').clickToggle(function(){
    //$('#video-archive-container').removeClass('hidden');
    $(this).text('Close Video Archive');
    //video_archive_toggle.toggle();
},function(){
    $(this).text('Open Video Archive');
    //video_archive_toggle.toggle();
});

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
        videoTags(tag_type);
    });
});

//For Lightbox
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox({
        alwaysShowClose: true
    });
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

$('body').on('click','.leave-discussion',function(e){
   e.preventDefault();
     webrtc.leaveRoom(room_name_tmp);      
      webrtc.stopLocalVideo(); 
$(this).attr('class','btn rejoin-discussion');
$(this).text('Rejoin Discussion');
   
})

$('body').on('click','.rejoin-discussion',function(e){
   e.preventDefault();
     //webrtc.leaveRoom();      
     webrtc.stopLocalVideo(); 
      webrtc.config.media.audio = true;
      webrtc.config.media.video = true;
      webrtc.startLocalVideo();

$(this).attr('class','btn leave-discussion');
$(this).text('Leave Discussion');   
})



//Initialize Video Tags
videoTags(tag_type);
