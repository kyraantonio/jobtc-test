<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;

use App\Models\Meeting;
use \View;
use \DB;
use \Input;
use \Redirect;
use \Auth;
use \Validator;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Traits\UserRoleTrait;

class MeetingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = ['calendar', 'date', 'select', 'magicSuggest', 'waiting'];

        return View::make('meeting.default', [
            'assets' => $assets
        ]);
    }

    public function meetingJson(){
        header("Content-type: application/json");

        //find user timezone and get current offset (like +08:00)
        $user_timezone = DB::table('timezone')
            //->where('timezone.timezone_id', '=', parent::getActiveUser()->timezone_id)
            ->pluck('timezone_name');
        date_default_timezone_set($user_timezone);
        $p = date('P');

        //set custom timezone
        if(isset($_GET['timezone'])) {
            date_default_timezone_set($_GET['timezone']);
        }

        $m = DB::table('meeting')
            ->select(DB::raw('
                fp_meeting.*,
                fp_meeting.attendees as attendees_id,
                fp_project.project_title,
                fp_meeting_type.type as meeting_type,
                fp_meeting_priority.priority as meeting_priority,
                DATE_FORMAT(fp_meeting.start_date, "%Y-%m-%dT%T' . $p . '") as start,
                DATE_FORMAT(fp_meeting.end_date, "%Y-%m-%dT%T' . $p . '") as end,
                IF(
                    fp_meeting.meeting_url != "",
                    CONCAT("<a href=\"", fp_meeting.meeting_url , "\">", fp_meeting.meeting_url, "</a>"),
                    ""
                ) as meeting_url
            '))
            ->leftJoin('project', 'project.project_id','=','meeting.project_id')
            ->leftJoin('meeting_type', 'meeting_type.id','=','meeting.type_id')
            ->leftJoin('meeting_priority', 'meeting_priority.id','=','meeting.priority_id')
            ->get();
        $meeting = array();
        $project_colors = array();
        if(count($m) > 0) {
            foreach ($m as $v) {
                //change the date and time from user timezone to the custom timezone
                $v->start = date('c', strtotime($v->start));
                $v->end = date('c', strtotime($v->end));

                $color = \App\Helpers\Helper::getRandomHexColor();
                if(array_key_exists($v->project_id, $project_colors)){
                    $color = $project_colors[$v->project_id];
                }
                else{
                    $project_colors[$v->project_id] = $color;
                }

                $v->color = $color;

                //if has attendees search and pass as variable into one string
                if($v->attendees_id) {
                    $attendees = json_decode($v->attendees_id);
                    $u = DB::table('user')
                        ->select(DB::raw('GROUP_CONCAT(name separator ", ") as attendees'))
                        ->whereIn('user_id', $attendees)
                        ->first('attendees');
                    $v->attendees = $u->attendees;
                }

                $meeting[] = $v;
            }
        }

        return response()->json($meeting);
    }

    public function meetingTimezone(){
        header("Content-type: application/json");

        $timezone = DB::table('timezone')
            ->select('timezone_name', 'timezone_id')
            ->get();
        $timezone = array_pluck($timezone, 'timezone_name', 'timezone_id');
        //get user timezone
        $current_timezone = array_key_exists(parent::getActiveUser()->timezone_id, $timezone) ?
            $timezone[parent::getActiveUser()->timezone_id] : '';

        return response()->json(array(
            'timezone' => $timezone,
            'current_timezone' => $current_timezone
        ));
    }

    private function getDropDown(&$data){
        $project = DB::table('project')
            ->select('project_id', 'project_title')
            ->get();
        $p = array_pluck($project, 'project_title', 'project_id');
        $data['project'] = array(0 => 'Select Project');
        $data['project'] += $p;

        $meeting_type = DB::table('meeting_type')
            ->select('id', 'type')
            ->get();
        $data['meeting_type'] = array_pluck($meeting_type, 'type', 'id');

        $meeting_priority = DB::table('meeting_priority')
            ->select('id', 'priority')
            ->get();
        $data['meeting_priority'] = array_pluck($meeting_priority, 'priority', 'id');

        $user = DB::table('user')
            ->select('user_id', 'name')
            ->get();
        $data['user'] = array_pluck($user, 'name', 'user_id');

        $team_member = DB::table('team_project')
            ->leftJoin('team_member', 'team_member.team_id', '=', 'team_project.team_id')
            ->select('project_id', 'user_id')
            ->get();
        $user_per_project = array();
        if(count($team_member) > 0){
            foreach($team_member as $v){
                $user_per_project[$v->project_id][] = $v->user_id;
            }
        }
        $data['user_per_project'] = json_encode($user_per_project);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['date'] = $_GET['date'];

        //call function drop down that would get all the data
        $this->getDropDown($data);

        return View::make('meeting.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_date = date('c', strtotime(str_replace("/", "-", Input::get('start_date'))));
        $end_date = date('c', strtotime(str_replace("/", "-", Input::get('end_date'))));

        $validation = Validator::make($request->all(), [
            'project_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'type_id' => 'required',
            'description' => 'required',
            'estimated_length' => 'required|numeric',
            'priority_id' => 'required',
        ]);

        if ($validation->fails()) {
            return Redirect::to('meeting')
                ->withInput()
                ->withErrors($validation->messages());
        }

        $meeting = new Meeting();
        $meeting->project_id = Input::get('project_id');
        $meeting->user_id = Auth::user()->user_id;
        $meeting->start_date = $start_date;
        $meeting->end_date = $end_date;
        $meeting->type_id = Input::get('type_id');
        $meeting->description = Input::get('description');
        $meeting->estimated_length = Input::get('estimated_length');
        $meeting->priority_id = Input::get('priority_id');
        $meeting->attendees = Input::get('attendees') ? json_encode(Input::get('attendees')) : '';
        $meeting->meeting_url = Input::get('meeting_url');
        $meeting->save();

        return Redirect::to('meeting')
                ->withSuccess("Meeting added successfully!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
        $data['event'] = Meeting::where('id', $id)
            ->first();

        $this->getDropDown($data);

        return View::make('meeting.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        if(Input::get('is_drag')){
            $start = strtotime(Input::get('start_date'));
            $end = strtotime(Input::get('end_date'));
            $new = strtotime(Input::get('new_date'));

            $datediff = $new - $start;
            $days_diff = floor($datediff/(60*60*24));


            $start_date = Input::get('new_date') . ' ' . date('H:i:s', $start);
            $end_date =  date('Y-m-d H:i:s', strtotime(Input::get('end_date') . ' ' . $days_diff . ' day'));

            $meeting->start_date = $start_date;
            $meeting->end_date = $end_date;
            $meeting->save();
        }
        else{
            $start_date = date('c', strtotime(str_replace("/", "-", Input::get('start_date'))));
            $end_date = date('c', strtotime(str_replace("/", "-", Input::get('end_date'))));

            $validation = Validator::make($request->all(), [
                'project_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'type_id' => 'required',
                'description' => 'required',
                'estimated_length' => 'required|numeric',
                'priority_id' => 'required',
            ]);

            if ($validation->fails()) {
                return Redirect::to('meeting')
                    ->withInput()
                    ->withErrors($validation->messages());
            }

            $meeting->project_id = Input::get('project_id');
            $meeting->start_date = $start_date;
            $meeting->end_date = $end_date;
            $meeting->type_id = Input::get('type_id');
            $meeting->description = Input::get('description');
            $meeting->estimated_length = Input::get('estimated_length');
            $meeting->priority_id = Input::get('priority_id');
            $meeting->attendees = Input::get('attendees') ? json_encode(Input::get('attendees')) : '';
            $meeting->meeting_url = Input::get('meeting_url');
            $meeting->save();

            return Redirect::to('meeting')
                ->withSuccess("Meeting edited successfully!!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
