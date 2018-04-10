<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;

use App\Models\Accounts;
use App\Models\TeamMember;
use \View;
use \DB;
use \Input;
use \Redirect;
use \Auth;
use \Validator;
use App\Models\User;
use App\Models\Team;
use App\Models\TeamProject;
use \Mail;
use Hash;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TeamBuilderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = ['calendar', 'magicSuggest', 'waiting'];

        $team = DB::table('team')
            ->get();
        if(count($team) > 0){
            foreach($team as $v){
                $v->member = TeamMember::select(DB::raw(
                    'fp_team_member.id,
                    fp_team_member.user_id,
                    fp_user.name as name,
                    fp_user.email'
                ))
                ->leftJoin('user', 'user.user_id', '=', 'team_member.user_id')
                ->where('team_member.team_id', '=', $v->id)
                ->get();

                $v->projects = TeamProject::select(DB::raw('fp_project.project_id, fp_project.project_title'))
                    ->leftJoin('project', 'project.project_id', '=', 'team_project.project_id')
                    ->where('team_project.team_id', '=', $v->id)
                    ->get();
            }
        }

        return View::make('teamBuilder.default', [
            'assets' => $assets,
            'team' => $team
        ]);
    }

    public function teamBuilderJson(){
        header("Content-type: application/json");

        $t = DB::table('team')
            ->select('id','title')
            ->get();
        $team = array(array('id' => 0,'title' => ''));
        $team = array_merge($team, $t);

        return response()->json($team);
    }

    public function teamBuilderUserJson(){
        //header("Content-type: application/json");

        $team_id = isset($_GET['t']) ? $_GET['t'] : '';
        $existing_user = array();
        if($team_id){
            $e = TeamMember::select('user_id')
                ->where('team_id', '=', $team_id)
                ->get();
            $existing_user = array_pluck($e, 'user_id');
        }

        $r = DB::table('user')
            ->select(DB::raw(
                'user_id as id,
                name,
                email,
                photo'
            ))
            ->whereIn('user_id', $existing_user)
            ->get();
        $user = array(array('id' => 0, 'name' => '','email' => '', 'photo' => ''));
        $user = array_merge($user, $r);

        return response()->json($user);
    }

    public function teamBuilderExistingUserJson(){
        header("Content-type: application/json");

        $team_id = isset($_GET['t']) ? $_GET['t'] : '';
        $existing_user = array();
        if($team_id){
            $e = TeamMember::select('user_id')
                ->where('team_id', '=', $team_id)
                ->get();
            $existing_user = array_pluck($e, 'user_id');
        }

        $r = User::select(DB::raw(
                'user_id as id,
                    name,
                    email,
                    photo'
            ))
            ->whereNotIn('user_id', $existing_user)
            ->get();

        return response()->json($r);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assets = [];
        $project = array();
        $role = array();
        $team = array();
        $company = array();
        $account = array();

        $page = isset($_GET['p']) ? $_GET['p'] : 'member';
        $team_id = isset($_GET['id']) ? $_GET['id'] : '';

        if($page == 'team'){

        }
        else if($page == 'member'){
            $r = DB::table('roles')
                ->select('id', 'name')
                ->get();
            $role = array_pluck($r, 'name', 'id');

            $t = DB::table('team')
                ->select('id', 'title')
                ->where('id', '!=', $team_id)
                ->where(DB::raw('(
                    SELECT count(fp_team_member.id)
                    FROM fp_team_member
                    WHERE
                        fp_team_member.team_id = fp_team.id
                )'), '!=', 0)
                ->get();
            $team = array_pluck($t, 'title', 'id');

            $c = DB::table('client')
                ->select('client_id', 'company_name')
                ->get();
            $company = array('' => 'Select Company');
            $company += array_pluck($c, 'company_name', 'client_id');

            $a = DB::table('accounts')
                ->select('id', 'account_name')
                ->get();
            $account = array('' => 'Select Account');
            $account += array_pluck($a, 'account_name', 'id');
        }
        else if($page == 'project'){
            $e = DB::table('team_project')
                ->select('project_id')
                ->get();
            $existing_project = array_pluck($e, 'project_id');

            $project = DB::table('project')
                ->select('project_id', 'project_title')
                ->whereNotIn('project_id', $existing_project)
                ->get();
            $project = array_pluck($project, 'project_title', 'project_id');
        }

        return View::make('teamBuilder.' . $page . '.create', [
            'assets' => $assets,
            'project' => $project,
            'role' => $role,
            'team' => $team,
            'team_id' => $team_id,
            'company' => $company,
            'account' => $account
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = isset($_GET['p']) ? $_GET['p'] : 'member';

        if($page == 'team') {
            $validation = Validator::make($request->all(), [
                'title' => 'required'
            ]);

            if ($validation->fails()) {
                return Redirect::to('teamBuilder')
                    ->withInput()
                    ->withErrors($validation->messages());
            }

            $meeting = new Team();
            $meeting->author_id = Auth::user()->user_id;
            $meeting->title = Input::get('title');
            $meeting->save();

            return Redirect::to('teamBuilder')
                ->withSuccess("Team added successfully!!");
        }
        else if($page == 'member'){
            $type = isset($_GET['t']) ? $_GET['t'] : '';

            if($type == "existing"){
                $userId = Input::get('user');
                if(count($userId) > 0){
                    foreach($userId as $v){
                        $meeting = new TeamMember();
                        $meeting->created_by = Auth::user()->user_id;
                        $meeting->team_id = Input::get('team_id');
                        $meeting->user_id = $v;
                        $meeting->save();
                    }
                }
            }
            else if($type == "duplicate"){
                $duplicate_id = Input::get('duplicate_id');
                $t = DB::table('team_member')
                    ->select('user_id')
                    ->where('team_id', '=', $duplicate_id)
                    ->get();
                if(count($t) > 0){
                    foreach($t as $v){
                        $team_member = DB::table('team_member')
                            ->where('team_id', '=', Input::get('team_id'))
                            ->where('user_id', '=', $v->user_id)
                            ->first();

                        if (is_null($team_member)) {
                            $meeting = new TeamMember();
                            $meeting->created_by = Auth::user()->user_id;
                            $meeting->team_id = Input::get('team_id');
                            $meeting->user_id = $v->user_id;
                            $meeting->save();
                        }
                    }
                }
            }
            else if($type == "create"){
                $validation = Validator::make($request->all(), [
                    'role_id' => 'required',
                    'name' => 'required',
                    'email' => 'email|required',
                    //'username' => 'required',
                    'password' => 'required'
                ]);

                if ($validation->fails()) {
                    return Redirect::to('teamBuilder')
                        ->withInput()
                        ->withErrors($validation->messages());
                }

                $user = new User();
                $user->name = Input::get('name');
                $user->email = Input::get('email');
                $user->phone = Input::get('phone');
                $user->user_status = 'Active';
                //$user->username = Input::get('username');
                $user->password = Hash::make(Input::get('password'));
                //$user->client_id = Input::get('company_id') ? Input::get('company_id') : null;
                //$user->accounts_id = Input::get('account_id') ? Input::get('account_id') : null;
                $user->save();

                $user->attachRole(Input::get('role_id'));

                $meeting = new TeamMember();
                $meeting->created_by = Auth::user()->user_id;
                $meeting->team_id = Input::get('team_id');
                $meeting->user_id = $user->user_id;
                $meeting->save();

                $role = DB::table('roles')
                    ->where('id', '=', Input::get('role_id'))
                    ->pluck('name');
                $company = DB::table('client')
                    ->where('client_id', '=', Input::get('company_id'))
                    ->pluck('company_name');
                $account = DB::table('accounts')
                    ->where('id', '=', Input::get('account_id'))
                    ->pluck('account_name');

                Mail::send(
                    'teamBuilder.member.mail',
                    [
                        'role' => $role,
                        'name' => Input::get('name'),
                        'email' => Input::get('email'),
                        //'username' => Input::get('username'),
                        'password' => Input::get('password'),
                        'phone' => Input::get('phone'),
                        'company' => $company,
                        'account' => $account
                    ],
                    function($message){
                        $message->from('admin@job.tc', 'System Admin');
                        $message->to(Input::get('email'), Input::get('name'))->subject('Registration Notification');
                    }
                );
            }
        }
        else if($page == 'project'){
            $team_id = isset($_GET['t']) ? $_GET['t'] : '';

            $validation = Validator::make($request->all(), [
                'project_id' => 'required'
            ]);

            if ($validation->fails()) {
                return Redirect::to('teamBuilder')
                    ->withInput()
                    ->withErrors($validation->messages());
            }

            $meeting = new TeamProject();
            $meeting->team_id = $team_id;
            $meeting->project_id = Input::get('project_id');
            $meeting->save();

            return Redirect::to('teamBuilder')
                ->withSuccess("Project added successfully!!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assets = [];
        $team = array();
        $page = isset($_GET['p']) ? $_GET['p'] : 'member';

        if($page == 'team'){
            $team = Team::find($id)
                ->first();
        }
        else if($page == 'member'){

        }
        else if($page == 'project'){

        }

        return View::make('teamBuilder.' . $page . '.edit', [
            'assets' => $assets,
            'team_id' => $id,
            'team' => $team,
        ]);
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
        $page = isset($_GET['p']) ? $_GET['p'] : 'member';

        if($page == 'team') {
            $validation = Validator::make($request->all(), [
                'title' => 'required'
            ]);

            if ($validation->fails()) {
                return Redirect::to('teamBuilder')
                    ->withInput()
                    ->withErrors($validation->messages());
            }

            $meeting = Team::find($id);
            $meeting->title = Input::get('title');
            $meeting->save();

            return Redirect::to('teamBuilder')
                ->withSuccess("Team updated successfully!!");
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
        $page = isset($_GET['p']) ? $_GET['p'] : 'member';

        if($page == 'team') {
            DB::table('team')
                ->where('id', '=', $id)
                ->delete();
            DB::table('team_member')
                ->where('team_id', '=', $id)
                ->delete();
            DB::table('team_project')
                ->where('team_id', '=', $id)
                ->delete();
        }
        else if($page == 'member') {
            DB::table('team_member')
                ->where('id', '=', $id)
                ->delete();
        }
        else if($page == 'project') {
            DB::table('team_project')
                ->where('id', '=', $id)
                ->delete();
        }
    }
}
