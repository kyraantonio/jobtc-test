<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\Chat;
use App\Models\RecordedVideo;
use App\Models\Profile;
use App\Models\User;
use App\Models\Tag;
use Auth;
use Mail;

class DiscussionsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $user_id = Auth::user()->user_id;

        $company_id = Profile::where('user_id', $user_id)->pluck('company_id');

        $discussions = Discussion::where('company_id', $company_id)->get();

        $assets = ['discussions'];

        return view('discussions.index', [
            'discussions' => $discussions,
            'assets' => $assets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('discussions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user_id = Auth::user()->user_id;

        $company_id = Profile::where('user_id', $user_id)->pluck('company_id');

        $room_name = $request->input('room_name');

        $room_type = $request->input('room_type');


        $add_discussion_room = new Discussion([
            'owner_id' => $user_id,
            'company_id' => $company_id,
            'room_name' => $room_name,
            'room_type' => $room_type
        ]);
        $add_discussion_room->save();

        $room_details = json_encode(array('id' => $add_discussion_room->id, 'room_name' => $room_name, 'room_type' => $room_type), JSON_FORCE_OBJECT);

        return $room_details;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $assets = ['discussions-room','select'];

        $user_id = Auth::user()->user_id;

        $display_name = User::where('user_id', $user_id)->pluck('name');

        $room_type = Discussion::where('id', $id)->pluck('room_type');
        
        $recorded_videos = RecordedVideo::with(['tags' =>function($query) {
            $query->where('tag_type','=','discussions')->get();
        }])->where('module_id',$id)->where('module_type','discussions')->orderBy('created_at','desc')->paginate(4);
        
        $chat = Chat::where('module_type','discussions')->where('module_id',$id)->orderBy('created_at','desc')->get();
        
        return view('discussions.show', [
            'assets' => $assets,
            'display_name' => $display_name,
            'room_type' => $room_type,
            'room_number' => $id,
            'recorded_videos' => $recorded_videos,
            'chat' => $chat
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $discussion = Discussion::where('id', $id)->first();

        return view('discussions.edit', [
            'discussion' => $discussion
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $room_name = $request->input('room_name');
        $room_type = $request->input('room_type');

        $edit_discussion_room = Discussion::where('id', $id)->update([
            'room_name' => $room_name,
            'room_type' => $room_type,
        ]);



        $room_details = json_encode(array('id' => $id, 'room_name' => $room_name, 'room_type' => $room_type), JSON_FORCE_OBJECT);

        return $room_details;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $delete_discussion_room = Discussion::where('id', $id)->delete();

        return $id;
    }

    public function showPublicRoom($id) {
        $assets = ['discussions-room','select'];

        $discussion_room = Discussion::where('id', $id)->first();
    
        $recorded_videos = RecordedVideo::with(['tags' =>function($query) {
            $query->where('tag_type','=','discussions')->get();
        }])->where('module_id',$id)->where('module_type','discussions')->orderBy('created_at','desc')->paginate(4);
        
        $chat = Chat::where('module_type','discussions')->where('module_id',$id)->orderBy('created_at','desc')->get();
        
        //Public rooms can be accessed without logging in
        //If it's a private room but with a /public on the url, redirect them to 
        //the login page if not logged in
        if ($discussion_room->room_type === 'public') {

            if (Auth::check()) {
                $user_id = Auth::user()->user_id;

                $display_name = User::where('user_id', $user_id)->pluck('name');
            } else {
                $display_name = "Anonymous";
            }

            return view('discussions.show', [
                'assets' => $assets,
                'display_name' => $display_name,
                'room_type' => $discussion_room->room_type,
                'room_number' => $id,
                'recorded_videos' => $recorded_videos,
                'chat' => $chat
            ]);
        } else {
            if (Auth::check()) {
                $user_id = Auth::user()->user_id;

                $display_name = User::where('user_id', $user_id)->pluck('name');

                return redirect('discussions/' . $id)->with([
                            'display_name' => $display_name,
                            'room_type' => $discussion_room->room_type,
                            'room_number' => $id,
                            'recorded_videos' => $recorded_videos,
                            'chat' => $chat
                ]);
            } else {
                return redirect('login');
            }
        }
    }

    public function addParticipantForm() {
        return view('discussions.addParticipantForm');
    }
    
    public function displayNameForm() {
        return view('discussions.displayNameForm');
    }

    public function addParticipant(Request $request) {
        
        $user_id = Auth::user()->user_id;
        $to_email = $request->input('email');
        $room_url = $request->input('room_url');
        
        $from_email = User::where('user_id', $user_id)->first();
        
        Mail::queue('emails.addParticipantEmail', ['from_email' => $from_email, 'to_email' => $to_email, 'room_url' => $room_url], function ($message) use ($from_email, $to_email) {
            $message->from($from_email->email, 'Job.tc');
            $message->to($to_email);
            $message->subject('Job.tc Discussions');
        });
    }

}
