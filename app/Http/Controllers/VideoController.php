<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\RecordedVideo;
use App\Models\InterviewQuestionAnswer;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoRoom;
use App\Models\VideoSession;
use App\Models\VideoTag;
use PhanAn\Remote\Remote;
use Auth;

class VideoController extends Controller {

    var $media_server;
    var $remote_connection;

    public function __construct() {
        $this->media_server = "extremefreedom.org";
        //$this->media_server = "ubuntu-server.com";
        $this->remote_connection = new Remote([
            'host' => $this->media_server,
            'port' => 22,
            'username' => 'root',
            'password' => '(radio5)'
        ]);
        /* $this->media_server = "linux.me";
          $this->remote_connection = new Remote([
          'host' => $this->media_server,
          'port' => 22,
          'username' => 'chimuel',
          'password' => 'GChimuel111491'
          ]); */
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    /* public function saveVideo(Request $request) {

      $page_type = $request->input('page_type');

      if ($page_type === 'applicant') {

      $applicant_id = $request->input('applicant_id');
      $job_id = $request->input('job_id');
      }

      if ($page_type === 'employee') {
      $user_id = Auth::user('user')->user_id;
      $employee_id = $request->input('employee_id');
      }


      $stream_id = $request->input('stream_id');
      $local_stream_id = $request->input('local_stream_id');
      $remote_stream_id = $request->input('remote_stream_id');
      $video_type = $request->input('video_type');
      $video_url = $request->input('video_url');
      $video_id = 0;
      $media_server = "laravel.software";

      //Connect to the media server
      $remote_connection = new Remote([
      'host' => $media_server,
      'port' => 22,
      'username' => 'root',
      'password' => '(radio5)',
      ]);

      if ($video_type === 'local') {

      //$clean_mkv_command = '/usr/bin/ffmpeg -y -threads 4 -i /var/www/recordings/' . $stream_id . '.mkv -vcodec copy -acodec copy /var/www/recordings/' . $stream_id . '.webm';
      //Convert the mkv to webm format(tried converting to vp9 webm but only gets the first 2 seconds if run using the exec command)
      $convert_to_webm_command = 'ffmpeg -y -i /var/www/recordings/' . $stream_id . '.mkv -c:v copy -b:v 1M -c:a libvorbis /var/www/recordings/' . $stream_id . '.webm';

      //Run the mkv file in ffmpeg to repair it(Since erizo makes an invalid mkv file for the html5 video tag)
      $run_command = $remote_connection->exec($convert_to_webm_command);
      } else {
      //Clean the local and remote files
      $clean_local_command = 'ffmpeg -y -threads 8 -i /var/www/recordings/' . $local_stream_id . '.mkv -c:v copy -crf 10 -b:v 0 -c:a libvorbis /var/www/recordings/' . $local_stream_id . '.webm 2> /dev/null';
      $clean_remote_command = 'ffmpeg -y -threads 8 -i /var/www/recordings/' . $remote_stream_id . '.mkv -c:v copy -crf 10 -b:v 0 -c:a libvorbis /var/www/recordings/' . $remote_stream_id . '.webm 2> /dev/null';

      //Merge them side by side
      //$merge_files_command = 'ffmpeg -y -i /var/www/recordings/'.$local_stream_id.'.webm -i /var/www/recordings/'.$remote_stream_id.'.webm -filter_complex "[0:v] setpts=PTS-STARTPTS,scale=iw*2:ih [bg];[1:v] setpts=PTS-STARTPTS [fg];[bg][fg] overlay=w;amerge,pan=stereo:c0<c0+c2:c1<c1+c3" /var/www/recordings/'.$local_stream_id.'.webm';
      //$merge_files_command = 'ffmpeg -y -threads 8 -i /var/www/recordings/' . $local_stream_id . '.webm -i /var/www/recordings/' . $remote_stream_id . '.webm -filter_complex "[0:v]scale=640:480[left];[1:v]scale=640:480[right];[0:a][1:a]amerge=inputs=2[a];[left][right]hstack[out]" -map [out] -map "[a]" /var/www/recordings/' . $local_stream_id . '.webm 2> /dev/null';

      //Run the scripts
      $run_command = $remote_connection->exec($clean_local_command . '; ' . $clean_remote_command . '; ' . $merge_files_command);
      //$run_command = $remote_connection->exec($clean_remote_command);
      //$run_command = $remote_connection->exec($merge_files_command);
      }
      //Check if video already exists
      $video_exists = Video::where('stream_id', $stream_id)->where('video_type', $video_type)->count();

      if ($video_exists === 0) {

      if ($page_type === 'applicant') {

      $video = new Video([
      'unique_id' => $applicant_id,
      'user_type' => 'applicant',
      'owner_id' => $job_id,
      'owner_type' => 'job',
      'stream_id' => $stream_id,
      'video_type' => $video_type,
      'video_url' => $video_url
      ]);

      $video->save();
      $video_id = $video->id;
      //Get all details as a JSON array

      $video_details = json_encode(array('video_url' => $video_url, 'video_id' => $video_id, 'applicant_id' => $applicant_id, 'job_id' => $job_id), JSON_FORCE_OBJECT);
      }

      if ($page_type === 'employee') {

      $video = new Video([
      'unique_id' => $employee_id,
      'user_type' => 'employee',
      'owner_id' => $user_id,
      'owner_type' => 'employee',
      'stream_id' => $stream_id,
      'video_type' => $video_type,
      'video_url' => $video_url
      ]);

      $video->save();
      $video_id = $video->id;

      //Get all details as a JSON array
      $video_details = json_encode(array('video_url' => $video_url, 'video_id' => $video_id, 'employee_id' => $employee_id, 'user_id' => $user_id), JSON_FORCE_OBJECT);
      }
      }



      return $video_details;
      } */

    public function startRecording(Request $request) {
        $session = $request->input('session');
        $nfo_id = $request->input('nfo_id');
        $room_type = $request->input('room_type');
        $room_name = $request->input('room_name');
        $stream = $request->input('stream');
        $rec_dir = $request->input('rec_dir');

        $video_room = new VideoRoom([
            'session_id' => $session,
            'nfo_id' => $nfo_id,
            'room_name' => $room_name,
            'room_type' => $room_type,
            'stream' => $stream,
            'rec_dir' => $rec_dir
        ]);
        $video_room->save();

        $video_sessions = new VideoSession([
            'session_id' => $session,
            'unique_id' => $room_name,
            'owner_type' => $room_type,
            'total_time' => '',
            'is_recording' => 'Yes'
        ]);
        $video_sessions->save();

        return "true";
    }

    public function stopRecording(Request $request) {
        $session = $request->input('session');
        $nfo_id = $request->input('nfo_id');
        $stream = $request->input('stream');

        $video_sessions = VideoSession::where('session_id', $session)->update([
            'total_time' => '',
            'is_recording' => 'No'
        ]);

        $video_rooms = VideoRoom::where('session_id', $session)->where('stream',$stream)->update([
            'nfo_id' => $nfo_id
        ]);
        
        return "true";
    }

    public function isRecording(Request $request) {
        $session = $request->input('session');
        
        $video_sessions = VideoSession::where('session_id', $session)->first();
        
        return $video_sessions->is_recording;
    }

    public function saveVideo(Request $request) {
        //Connect to the media server
        $remote_connection = $this->remote_connection;

        $session = $request->input('session');
        $room_type = $request->input('room_type');
        $room_name = $request->input('room_name');
        $stream = $request->input('stream');
        $rec_dir = $request->input('rec_dir');

        $video_extension = '.webm';
        $audio_extension = '.ogg';

        $video_url = $rec_dir . '/' . $session . '-' . $stream . '-final' . $video_extension;
        $audio_url = $rec_dir . '/' . $session . '-' . $stream . $audio_extension;

        $video_room = VideoRoom::where('session_id', $session)->first();

        $video_id = $video_room->id;

        $video_details = json_encode(array('video_id' => $video_id, 'video' => $video_url, 'audio' => $audio_url), JSON_FORCE_OBJECT);

        //For Main video
        //$convert_to_webm_command = '/opt/janus/bin/janus-pp-rec /var/www/html/recordings/' . $session . '-' . $stream . '-video.mjr /var/www/html/recordings/' . $session . '-' . $stream . '-video.webm';
        //$convert_to_ogg_command = '/opt/janus/bin/janus-pp-rec /var/www/html/recordings/' . $session . '-' . $stream . '-audio.mjr /var/www/html/recordings/' . $session . '-' . $stream . '-audio.ogg';
        //$merge_webm_and_ogg_command = 'ffmpeg -i /var/www/html/recordings/' . $stream . '.webm -i /var/www/html/recordings/' . $stream . '.ogg -c:v copy -c:a libvorbis -strict experimental /var/www/html/recordings/' . $stream . '-final.webm';
        //$merge_webm_and_ogg_command = 'ffmpeg -i /var/www/html/recordings/' . $session . '-' . $stream . '-video.webm -i /var/www/html/recordings/' . $session . '-' . $stream . '-audio.ogg -c:v copy -shortest /var/www/html/recordings/' . $session . '-' . $stream . '-final.webm';

        //For Screenshare video
        //$convert_screenshare_to_webm_command = '/opt/janus/bin/janus-pp-rec /var/www/html/recordings/screenshare-'. $session  .'-'. $stream .'-video.mjr /var/www/html/recordings/screenshare-'. $session . '-' . $stream . '-video.webm';
        //Execute main video scripts
        //$remote_connection->exec($convert_to_webm_command . ';' . $convert_to_ogg_command . ';' . $merge_webm_and_ogg_command);
        //$remote_connection->exec($merge_webm_and_ogg_command);
        //Execute main video scripts
        //$remote_connection->exec($convert_screenshare_to_webm_command);
        //$check_if_screenshare_exists = '[ -f /var/www/html/recordings/' . $session . '-screenshare-' . $stream . '-video.mjr ] && echo "File exists" || echo "File doesn not exist"';
        //$file_exists = $remote_connection->exec($check_if_screenshare_exists);
        //if ($file_exists === 'File exists') {
        //}

        return $video_details;
    }

    public function saveScreenShare() {

        //Connect to the media server
        $remote_connection = $this->remote_connection;

        $session = $request->input('session');
        $room_type = $request->input('room_type');
        $room_name = $request->input('room_name');
        $stream = $request->input('stream');
        $rec_dir = $request->input('rec_dir');

        $video_extension = '.webm';
        $audio_extension = '.ogg';

        $video_url = $rec_dir . '/' . $stream . '-final' . $video_extension;
        $audio_url = $rec_dir . '/' . $stream . $audio_extension;

        $video_room = VideoRoom::where('session_id', $session)->first();

        $video_id = $video_room->id;

        $video_details = json_encode(array('video_id' => $video_id, 'video' => $video_url, 'audio' => $audio_url), JSON_FORCE_OBJECT);

        //For Screenshare video
        $convert_screenshare_to_webm_command = '/opt/janus/bin/janus-pp-rec /var/www/html/recordings/screenshare-' . $session . '-' . $stream . '-video.mjr /var/www/html/recordings/screenshare-' . $session . '-' . $stream . '-video.webm';

        $remote_connection->exec($convert_screenshare_to_webm_command);


        return $video_details;
    }

    public function deleteVideo(Request $request) {
        $video_id = $request->input('video_id');

        $remote_connection = $this->remote_connection;

        $streams = VideoRoom::where('id', $video_id)->pluck('stream');
        $session = VideoRoom::where('id', $video_id)->pluck('session_id');


        $rec_dir = '/var/www/html/recordings/';
        $video_extension = '-video.webm';
        $audio_extension = '-audio.ogg';

        foreach (explode(",", $streams) as $stream) {

            $final_url = $rec_dir . $session . '-' . $stream . '-final' . $video_extension;
            $video_url = $rec_dir . $session . '-' . $stream . $video_extension;
            $audio_url = $rec_dir . $session . '-' . $stream . $audio_extension;
            $video_mjr_url = $rec_dir . $session . '-' . $stream . '-video.mjr';
            $audio_mjr_url = $rec_dir . $session . '-' . $stream . '-audio.mjr';

            $delete_final = 'rm ' . $final_url;
            $delete_webm = 'rm ' . $video_url;
            $delete_ogg = 'rm ' . $audio_url;
            $delete_video_mjr = 'rm ' . $video_mjr_url;
            $delete_audio_mjr = 'rm ' . $audio_mjr_url;

            $remote_connection->exec($delete_final);
            $remote_connection->exec($delete_webm);
            $remote_connection->exec($delete_ogg);
            $remote_connection->exec($delete_video_mjr);
            $remote_connection->exec($delete_audio_mjr);
        }

        $delete_video = VideoRoom::where('id', $video_id)->delete();

        return $video_id;
    }
    
    
    public function editRecordedVideo(Request $request, $id) {
        
        $title = $request->input('title');
        
        $update_recorded_video = RecordedVideo::where('id','=',$id)->update([
                'alias' => $title
            ]);
            
        return "true";    
    }
    
    public function deleteRecordedVideo(Request $request,$id) {
        
        //$module_type = $request->input('module_type');
        //$module_type = $request->input('module_id');
        $recorded_video_id = RecordedVideo::destroy($id);
        
        return "true";
    }
    

    public function addVideoTag(Request $request) {

        $user_id = $request->user()->id;
        $job_id = $request->input('job_id');
        $applicant_id = $request->input('applicant_id');
        $video_id = $request->input('video_id');
        $video_status = $request->input('video_status');

        $video_status_exists = VideoTag::where('job_id', $job_id)->where('applicant_id', $applicant_id)->where('user_id', $user_id)->where('video_id', $video_id)->count();

        if ($video_status_exists === 0) {

            $new_video_status = new VideoTag([
                'user_id' => $user_id,
                'job_id' => $job_id,
                'applicant_id' => $applicant_id,
                'video_id' => $video_id,
                'tags' => $video_status
            ]);

            $new_video_status->save();

            $video_status_item = VideoTag::where('id', $new_video_status->id)->first();
        } else {
            $update_video_status = VideoTag::where('job_id', $job_id)->where('applicant_id', $applicant_id)->where('user_id', $user_id)->where('video_id', $video_id)->update([
                'tags' => $video_status
            ]);
        }

        return "true";
    }

    public function getVideoTags(Request $request) {

        $term = $request->input('term');

        $entries = VideoTag::where('tags', 'like', '%' . $term . '%')->get();
        $tags = [];


        foreach ($entries as $entry) {
            $tags_string = explode(',', $entry->tags);
            foreach ($tags_string as $string) {
                $tags[] = $string;
            }
        }

        return $tags;
    }

    //janus API
    public function saveNfoJanus(Request $request) {
        $remote_connection = $this->remote_connection;

        $session_id = $request->input('session');
        $stream_id = $request->input('stream');

        $nfo = "echo '[" . $session_id . "]\nname = " . $session_id . '-' . $stream_id . "\n" .
                "date = " . date('Y-m-d H:i:s') . "\n" .
                "audio = " . $session_id . '-' . $stream_id . "-audio.mjr\n" .
                "video = " . $session_id . '-' . $stream_id . "-video.mjr' > /var/www/html/recordings/" . $session_id . ".nfo";
        $remote_connection->exec($nfo);
    }

    public function saveScreenShareNfoJanus(Request $request) {
        $remote_connection = $this->remote_connection;

        $session_id = $request->input('session');
        $stream_id = $request->input('stream');

        $nfo = "echo '[" . $session_id . "]\nname = " . $session_id . '-' . $stream_id . "\n" .
                "date = " . date('Y-m-d H:i:s') . "\n" .
                "audio = " . $session_id . '-' . $stream_id . "-audio.mjr\n" .
                "video = " . $session_id . '-' . $stream_id . "-video.mjr' > /var/www/html/recordings/screenshare-" . $session_id . ".nfo";
        $remote_connection->exec($nfo);
    }

    /* private function saveThisNfoJanus($id,$session) {
      $remote_connection = $this->remote_connection;

      $nfo = "echo '[" . $id . "]\nname = " . $session.'-'.$id . "\n" .
      "date = " . date('Y-m-d H:i:s') . "\n" .
      "audio = " . $session.'-'.$id . "-audio.mjr\n" .
      "video = " . $session.'-'.$id . "-video.mjr' > /var/www/html/recordings/" . $id . ".nfo";
      $remote_connection->exec($nfo);
      } */
    
    public function convertDiscussionsJanusVideo(Request $request) {
        $remote_connection = $this->remote_connection;
        
        if(Auth::check()) {
            $user_id = Auth::user()->user_id;
            $recorded_by = User::where('user_id',$user_id)->first()->name;
            
        } else {
            $user_id = 0;
            $recorded_by = $request->input('display_name');
        }
        
        
        $filename = $request->input('filename');
        $module_type = $request->input('module_type');
        $module_id = $request->input('module_id');
        $video_title = $request->input('video_title');
        $subject_name = $request->input('subject_name');
        
        $recordedVideo = new RecordedVideo([
            'filename' =>  $filename,
            'module_type' => $module_type,
            'module_id' => $module_id,
            'alias' => $video_title,
            'recorded_by' => $recorded_by,
            'user_id' => $user_id,
            'description' => '',
            'subject_name' => $subject_name
         ]);
        $recordedVideo->save();
        
        $convert_to_audio = '/opt/janus/bin/janus-pp-rec /var/www/html/recordings/' . $filename . '-audio.mjr /var/www/html/recordings/' . $filename . '-audio.opus';
        $remote_connection->exec($convert_to_audio);
        
        $convert_to_webm = '/opt/janus/bin/janus-pp-rec /var/www/html/recordings/' . $filename . '-video.mjr /var/www/html/recordings/' . $filename . '-video.webm';
        $remote_connection->exec($convert_to_webm);
        
        $generate_thumbnail = 'ffmpeg -i  /var/www/html/recordings/'.$filename.'-video.webm -vf  "thumbnail,scale=640:360" -frames:v 1  /var/www/html/recordings/'.$filename.'.png';
        $remote_connection->exec($generate_thumbnail);
        
        $check_audio_file_if_exists = 'test -f /var/www/html/recordings/'.$filename.'-audio.opus && echo "1" || echo "0"';
        $check_video_file_if_exists = 'test -f /var/www/html/recordings/'.$filename.'-video.webm && echo "1" || echo "0"';
        $video_exists = $remote_connection->exec($check_video_file_if_exists);
        $audio_exists = $remote_connection->exec($check_audio_file_if_exists);
        
        if($audio_exists == 1 && $video_exists == 1)    {
            $sync_audio_video = 'nohup ffmpeg -i /var/www/html/recordings/' . $filename . '-video.webm -i /var/www/html/recordings/' . $filename . '-audio.opus -c:v copy -c:a libvorbis -strict experimental /var/www/html/recordings/' . $filename . '.webm 1> /var/www/html/recordings/'.$filename.'.txt 2>&1 &';
            $remote_connection->exec($sync_audio_video);
        } elseif($audio_exists == 0 && $video_exists == 1) {
            $rename_video_file = 'nohup mv /var/www/html/recordings/'.$filename.'-video.webm /var/www/html/recordings/'.$filename.'.webm 1> /var/www/html/recordings/'.$filename.'.txt 2>&1 &';
            $remote_connection->exec($rename_video_file);
        } else {
            $convert_audio_file_to_webm = 'nohup ffmpeg -i /var/www/html/recordings/'.$filename.'-audio.opus -c:a libvorbis -strict experimental /var/www/html/recordings/' . $filename . '.webm 1> /var/www/html/recordings/'.$filename.'.txt 2>&1 &';
            $remote_connection->exec($convert_audio_file_to_webm);
        }
        
        
        return $audio_exists;
    }
    
    public function convertApplicantsJanusVideo(Request $request) {
        $remote_connection = $this->remote_connection;
        
        if(Auth::check()) {
            $user_id = Auth::user()->user_id;
            $recorded_by = User::where('user_id',$user_id)->first()->name;
            
        } else {
            $user_id = 0;
            $recorded_by = $request->input('display_name');
        }
        
        
        $filename = $request->input('filename');
        $module_type = $request->input('module_type');
        $module_id = $request->input('module_id');
        $video_title = $request->input('video_title');
        $subject_name = $request->input('subject_name');
        $question_id = $request->input('question_id');
        
        $recordedVideo = new RecordedVideo([
            'filename' =>  $filename,
            'module_type' => $module_type,
            'module_id' => $module_id,
            'alias' => $video_title,
            'recorded_by' => $recorded_by,
            'user_id' => $user_id,
            'description' => '',
            'subject_name' => $subject_name
         ]);
        $recordedVideo->save();
        
        if($question_id !== null) {
            $interview_question_answer = new InterviewQuestionAnswer([
                'question_id' => $question_id,
                'video_id' => $recordedVideo->id,
                'module_type' => $module_type,
                'module_id' => $module_id,
                'score' => 0,
                ]);
            $interview_question_answer->save();
        }
        
        $convert_to_audio = '/opt/janus/bin/janus-pp-rec /var/www/html/recordings/' . $filename . '-audio.mjr /var/www/html/recordings/' . $filename . '-audio.opus';
        $remote_connection->exec($convert_to_audio);
        
        $convert_to_webm = '/opt/janus/bin/janus-pp-rec /var/www/html/recordings/' . $filename . '-video.mjr /var/www/html/recordings/' . $filename . '-video.webm';
        $remote_connection->exec($convert_to_webm);
        
        $generate_thumbnail = 'ffmpeg -i  /var/www/html/recordings/'.$filename.'-video.webm -vf  "thumbnail,scale=640:360" -frames:v 1  /var/www/html/recordings/'.$filename.'.png';
        $remote_connection->exec($generate_thumbnail);
        
        $check_audio_file_if_exists = 'test -f /var/www/html/recordings/'.$filename.'-audio.opus && echo "1" || echo "0"';
        $check_video_file_if_exists = 'test -f /var/www/html/recordings/'.$filename.'-video.webm && echo "1" || echo "0"';
        $video_exists = $remote_connection->exec($check_video_file_if_exists);
        $audio_exists = $remote_connection->exec($check_audio_file_if_exists);
        
        if($audio_exists == 1 && $video_exists == 1)    {
            $sync_audio_video = 'nohup ffmpeg -i /var/www/html/recordings/' . $filename . '-video.webm -i /var/www/html/recordings/' . $filename . '-audio.opus -c:v copy -c:a libvorbis -strict experimental /var/www/html/recordings/' . $filename . '.webm 1> /var/www/html/recordings/'.$filename.'.txt 2>&1 &';
            $remote_connection->exec($sync_audio_video);
        } elseif($audio_exists == 0 && $video_exists == 1) {
            $rename_video_file = 'nohup mv /var/www/html/recordings/'.$filename.'-video.webm /var/www/html/recordings/'.$filename.'.webm 1> /var/www/html/recordings/'.$filename.'.txt 2>&1 &';
            $remote_connection->exec($rename_video_file);
        } else {
            $convert_audio_file_to_webm = 'nohup ffmpeg -i /var/www/html/recordings/'.$filename.'-audio.opus -c:a libvorbis -strict experimental /var/www/html/recordings/' . $filename . '.webm 1> /var/www/html/recordings/'.$filename.'.txt 2>&1 &';
            $remote_connection->exec($convert_audio_file_to_webm);
        }
        
        
        return $audio_exists;
    }
    
    
    public function getConversionProgress(Request $request) {
        $remote_connection = $this->remote_connection;
        
        $filename = $request->input('filename');
        
        $get_file = "cat /var/www/html/recordings/".$filename.'.txt';
        
        $content = $remote_connection->exec($get_file);
        
        if($content){
           //get duration of source
            preg_match("/Duration: (.*?), start:/", $content, $matches);

            $rawDuration = $matches[1];

            //rawDuration is in 00:00:00.00 format. This converts it to seconds.
            $ar = array_reverse(explode(":", $rawDuration));
            $duration = floatval($ar[0]);
            if (!empty($ar[1])) $duration += intval($ar[1]) * 60;
            if (!empty($ar[2])) $duration += intval($ar[2]) * 60 * 60;

            //get the time in the file that is already encoded
            preg_match_all("/time=(.*?) bitrate/", $content, $matches);

            $rawTime = array_pop($matches);

            //this is needed if there is more than one match
            if (is_array($rawTime)){$rawTime = array_pop($rawTime);}

            //rawTime is in 00:00:00.00 format. This converts it to seconds.
            $ar = array_reverse(explode(":", $rawTime));
            $time = floatval($ar[0]);
            if (!empty($ar[1])) $time += intval($ar[1]) * 60;
            if (!empty($ar[2])) $time += intval($ar[2]) * 60 * 60;

            //calculate the progress
            $progress = round(($time/$duration) * 100);

            //echo "Duration: " . $duration . "<br>";
            //echo "Current Time: " . $time . "<br>";
            //echo "Progress: " . $progress . "%";
            
            return $progress;
        }
    }
    
    
    
    public function convertJanusVideo(Request $request) {
        $hasAudio = 1;
        if ($request->input('audio')) {
            $hasAudio = $request->input('audio') == "no" ? 0 : 1;
            echo $hasAudio ? 'naa' : 'wla';
        }
        echo $request->input('local');

        if ($request->input('local')) {
            $this->convertThisJanusVideo($request->input('local'), $hasAudio);
        }
        if ($request->input('remote')) {
            $this->convertThisJanusVideo($request->input('remote'), $hasAudio);
        }
    }

    private function convertThisJanusVideo($id, $audio) {
        $remote_connection = $this->remote_connection;

        //convert to opus and webm
        if ($audio) {
            $convert_to_audio = '/opt/janus/bin/janus-pp-rec /var/www/html/recordings/' . $id . '-audio.mjr /var/www/html/recordings/' . $id . '-audio.opus';
            $remote_connection->exec($convert_to_audio);
        }
        $convert_to_webm = '/opt/janus/bin/janus-pp-rec /var/www/html/recordings/' . $id . '-video.mjr /var/www/html/recordings/' . $id . '-video.webm';
        $remote_connection->exec($convert_to_webm);

        if ($audio) {
            $sync_audio_video = 'ffmpeg -i /var/www/html/recordings/' . $id . '-video.webm -i /var/www/html/recordings/' . $id . '-audio.opus -c:v copy -c:a libvorbis -strict experimental /var/www/html/recordings/' . $id . '.webm';
            $remote_connection->exec($sync_audio_video);
        } else {
            $sync_audio_video = 'ffmpeg -i /var/www/html/recordings/' . $id . '-video.webm -c:v copy -c:a libvorbis -strict experimental /var/www/html/recordings/' . $id . '.webm';
            $remote_connection->exec($sync_audio_video);
        }


        if ($audio) {
            $delete_opus = 'rm -rf /var/www/html/recordings/' . $id . '-audio.opus';
            $remote_connection->exec($delete_opus);
        }
        $delete_webm = 'rm -rf /var/www/html/recordings/' . $id . '-video.webm';
        $remote_connection->exec($delete_webm);
    }

}
