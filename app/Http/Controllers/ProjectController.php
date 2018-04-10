<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests;
use App\Models\Project;
use App\Models\User;
use App\Models\Company;
use App\Models\AssignedUser;
use App\Models\Note;
use App\Models\Attachment;
use App\Models\Task;
use App\Models\TaskChecklist;
use App\Models\TaskChecklistOrder;
use App\Models\TaskCheckListPermission;
use App\Models\Timer;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TeamProject;
use App\Models\TeamCompany;
use App\Models\Permission;
use App\Models\PermissionUser;
use \DB;
use \Auth;
use \View;
use \Validator;
use \Input;
use \Redirect;
use Elasticsearch\ClientBuilder as ES;

class ProjectController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        if (parent::userHasRole('admin')) {
            $projects = Project::all();
        } elseif (parent::userHasRole('client')) {
            $projects = DB::table('project')
                    ->where('user_id', '=', Auth::user()->user_id)
                    ->get();
        } elseif (parent::userHasRole('Staff')) {
            $projects = DB::table('project')
                    ->join('assigned_user', 'assigned_user.unique_id', '=', 'project.project_id')
                    ->where('belongs_to', '=', 'project')
                    ->where('username', '=', Auth::user()->username)
                    ->get();
        }

        $user = User::orderBy('name', 'asc')
                ->lists('name', 'user_id');

        $client_options = Company::orderBy('name', 'asc')
                ->lists('name', 'id')
                ->toArray();

        $assets = ['table', 'datepicker'];

        return view('project.index', [
            'projects' => $projects,
            'companies' => $client_options,
            'users' => $user,
            'assets' => $assets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
        $validation = Validator::make($request->all(), [
                    'project_title' => 'required|unique:project',
                    'start_date' => 'date_format:"d-m-Y"',
                    'deadline' => 'date_format:"d-m-Y"|after:start_date',
                    'rate_value' => 'numeric'
        ]);

        if ($validation->fails()) {
            return redirect()->back();
        }

        $project = new Project();
        $project->project_title = $request->input('project_title');
        $project->account = $request->input('account');
        $project->currency = $request->input('currency');
        $project->project_type = $request->input('project_type');
        $project->user_id = Auth::user('user')->user_id;
        $project->company_id = $request->input('company_id');
        $project->start_date = date("Y-m-d H:i:s", strtotime($request->input('start_date')));
        $project->deadline = date("Y-m-d H:i:s", strtotime($request->input('deadline')));
        $project->project_description = $request->input('project_description');
        $project->rate_type = $request->input('rate_type');
        $project->rate_value = $request->input('rate_value');
        $project->save();

        $update_project_ref = Project::find($project->project_id);
        $update_project_ref->ref_no = $project->project_id;
        $update_project_ref->save();

        //Create an index for searching
        $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();
        $params = array();
        $params['body'] = array(
            'project_title' => $project->project_title,
        );
        $params['index'] = 'default';
        $params['type'] = 'project';
        $params['id'] = $project->project_id;
        $results = $client->index($params);       //using Index() function to inject the data

        return redirect()->route('project.show', $project->project_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $user_id = Auth::user('user')->user_id;

        $user_authority = User::find($user_id);

        $project = Project::find($id);
        if ($user_authority->level() === 1) {
            $project = Project::find($id);
        } elseif ($user_authority->level() > 1) {
            $project = Project::find($id);
        }

        if (!$project) {
            return redirect()->route('project.show', $id);
        }

        $assignedUser = AssignedUser::where('belongs_to', '=', 'project')
                ->where('unique_id', '=', $id)
                ->get();

        $assign_username = User::lists('name', 'user_id')
                ->toArray();

        $user = User::orderBy('name', 'asc')
                ->pluck('name', 'email');

        $client_options = Company::orderBy('name', 'asc')
                ->get();

        $note = Note::where('belongs_to', '=', 'project')
                ->where('unique_id', '=', $id)
                ->first();

        $comment = DB::table('comment')
                ->where('belongs_to', '=', 'project')
                ->where('unique_id', '=', $id)
                ->orderBy('comment.created_at', 'desc')
                ->get();

        $attachment = Attachment::where('belongs_to', '=', 'project')
                ->where('unique_id', '=', $id)
                ->orderBy('created_at', 'desc')
                ->get();

        $task = Task::where('project_id', $id)
                ->orderBy('task_title', 'asc')
                ->get();

        $task_permissions = TaskCheckListPermission::where('project_id', $id)->where('user_id', $user_id)->get();

        $teams = Team::with(['team_member' => function($query) {
                        $query->with('user')->get();
                    }])->get();

        //Get Team Member projects
        $team_members = TeamMember::where('user_id', $user_id)->get();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $project->company_id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        $project_owner = $project->user_id;

        $assets = ['projects', 'datepicker'];

        return view('project.show', [
            'project' => $project,
            'companies' => $client_options,
            'teams' => $teams,
            'note' => $note,
            'users' => $user,
            'comments' => $comment,
            'attachments' => $attachment,
            'tasks' => $task,
            'task_permissions' => $task_permissions,
            'assignedUsers' => $assignedUser,
            'assign_username' => $assign_username,
            'module_permissions' => $module_permissions,
            'assets' => $assets,
            'project_owner' => $project_owner
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
        $project = Project::find($id);
        $client_options = Company::orderBy('name', 'asc')
                ->lists('name', 'id');

        $user = User::orderBy('name', 'asc')
                ->lists('name', 'email');

        return view('project.edit', [
            'project' => $project,
            'clients' => $client_options,
            'users' => $user
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
        //
        $project = Project::find($id);

        $project->project_title = $request->input('project_title');
        $project->account = $request->input('account');
        $project->currency = $request->input('currency');
        $project->project_type = $request->input('project_type');
        $project->company_id = $request->input('company_id');
        $project->start_date = date("Y-m-d H:i:s", strtotime($request->input('start_date')));
        $project->deadline = date("Y-m-d H:i:s", strtotime($request->input('deadline')));
        $project->project_description = $request->input('project_description');
        $project->rate_type = $request->input('rate_type');
        $project->rate_value = $request->input('rate_value');
        $project->save();

        //Update the index for searching
        $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();
        $params = array();
        $params['body'] = array(
            'doc' => [
                'project_title' => $project->project_title
            ]
        );
        $params['index'] = 'default';
        $params['type'] = 'project';
        $params['id'] = $project->project_id;
        $results = $client->update($params);       //using Index() function to inject the data

        return $project->project_title;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        $project = Project::find($id);

        if (!$project || !parent::userHasRole('Admin'))
            return redirect()->route('project.show', $id);

        DB::table('assigned_user')
                ->where('belongs_to', '=', 'project')
                ->where('unique_id', '=', $id)->delete();

        $attachments = DB::table('attachment')
                        ->where('belongs_to', '=', 'project')
                        ->where('unique_id', '=', $id)->get();

        foreach ($attachments as $attachment)
            File::delete('assets/attachment_files/' . $attachment->file);

        DB::table('attachment')
                ->where('belongs_to', '=', 'project')
                ->where('unique_id', '=', $id)->delete();

        DB::table('comment')
                ->where('belongs_to', '=', 'project')
                ->where('unique_id', '=', $id)->delete();

        DB::table('notes')
                ->where('belongs_to', '=', 'project')
                ->where('unique_id', '=', $id)->delete();

        DB::table('task')
                ->where('belongs_to', '=', 'project')
                ->where('unique_id', '=', $id)->delete();

        DB::table('timer')
                ->where('project_id', '=', $id)->delete();

        $project->delete();

        return redirect()->back();
    }

    public function delete(Request $request) {

        $project_id = $request->input('project_id');

        //First get the tasks inside the project
        $task_count = Task::where('project_id', $project_id)->count();
        $task_ids = Task::where('project_id', $project_id)->get();
        $task_ids_array = [];

        foreach ($task_ids as $id) {
            array_push($task_ids_array, $id);
        }

        //Then delete the task list order
        $task_check_list_order_count = TaskChecklistOrder::whereIn('task_id', $task_ids_array)->count();
        if ($task_check_list_order_count > 0 && $task_count > 0) {
            $task_check_list_order = TaskChecklistOrder::whereIn('task_id', $task_ids_array);
            $task_check_list_order->delete();
        }

        //Then delete the task list permissions
        $task_check_list_permissions_count = TaskCheckListPermission::whereIn('task_id', $task_ids_array)->count();
        if ($task_check_list_permissions_count > 0 && $task_count > 0) {
            $task_check_list_permissions = TaskCheckListPermission::whereIn('task_id', $task_ids_array);
            $task_check_list_permissions->delete();
        }

        //Then delete the task list items themselves
        $task_check_list_items_count = TaskChecklist::whereIn('task_id', $task_ids_array)->count();
        if ($task_check_list_items_count > 0 && $task_count > 0) {
            $task_check_list_items = TaskChecklist::whereIn('task_id', $task_ids_array);
            $task_check_list_items->delete();
        }
        //Then delete the project tasks
        if ($task_count > 0) {
            $tasks = Task::where('project_id', $project_id);
            $tasks->delete();
        }

        //Then unmap the companies that are mapped to these projects
        $team_companies_count = TeamCompany::where('project_id', $project_id)->count();
        if ($team_companies_count > 0) {
            $team_companies = TeamCompany::where('project_id', $project_id);
            $team_companies->delete();
        }
        
        $project = Project::where('project_id', $project_id);
        
         //Delete the index for searching
        $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();
        $params = array();
        
        $params['index'] = 'default';
        $params['type'] = 'project';
        $params['id'] = $project->pluck('project_id');
        $results = $client->delete($params);       //using Index() function to inject the data
        
        //Then finally delete the project
        $project->delete();

      
        
        return "true";
    }

    public function startTimer() {

        $project = Project::find(Input::get('project_id'));

        $timer_check = Timer::where('project_id', '=', Input::get('project_id'))
                ->where('end_time', '=', null)
                ->first();

        $validation = Validator::make(Input::all(), [
                    'project_id' => 'required'
        ]);

        if ($validation->fails()) {
            return redirect()->back();
        } elseif (!$project) {
            return redirect()->back();
        } elseif ($timer_check) {
            return redirect()->back();
        }

        $timer = new Timer;
        $data = Input::all();
        $data['username'] = Auth::user()->username;
        $data['start_time'] = date("Y-m-d H:i:s", time());
        $timer->fill($data);
        $timer->save();

        return redirect()->back();
    }

    public function endTimer() {

        $project = Project::find(Input::get('project_id'));

        $timer_check = Timer::where('project_id', '=', Input::get('project_id'))
                ->where('end_time', '=', null)
                ->first();

        $validation = Validator::make(Input::all(), [
                    'project_id' => 'required'
        ]);

        $timer = Timer::find(Input::get('timer_id'));

        if ($validation->fails()) {
            return redirect()->back();
        } elseif (!$project) {
            return redirect()->back();
        } elseif (!$timer_check) {
            return redirect()->back();
        } elseif (!$timer) {
            return redirect()->back();
        }

        $data = Input::all();
        $data['end_time'] = date("Y-m-d H:i:s", time());
        $timer->fill($data);
        $timer->save();

        return redirect()->back();
    }

    public function deleteTimer() {
        $timer = Timer::find(Input::get('timer_id'));

        if (!$timer || !parent::userHasRole('Admin'))
            return redirect()->back();

        $timer->delete(Input::get('timer_id'));
        return redirect()->back();
    }

    public function updateProgress() {

        $project = Project::find(Input::get('project_id'));

        $validation = Validator::make(Input::all(), [
                    'project_id' => 'required',
                    'project_progress' => 'required|integer|max:100|min:0'
        ]);

        if ($validation->fails()) {
            return redirect()->back();
        } elseif (!$project) {
            return redirect()->back();
        }

        $project->project_progress = Input::get('project_progress');
        $project->save();

        return redirect()->back();
    }

    public function addProjectForm() {
        return view('forms.addProjectForm');
    }

    public function addProject(Request $request) {

        $user_id = Auth::user('user')->user_id;
        $company_id = $request->input('company_id');
        $project_title = $request->input('project_title');

        $project = new Project();
        $project->project_title = $project_title;
        $project->account = '';
        $project->currency = '';
        $project->project_type = 'Standard';
        $project->user_id = $user_id;
        $project->company_id = $company_id;
        $project->project_description = '';
        $project->rate_type = '';
        $project->rate_value = 0;
        $project->save();

        $update_project_ref = Project::find($project->project_id);
        $update_project_ref->ref_no = $project->project_id;
        $update_project_ref->save();

        //Create an index for searching
        $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();
        $params = array();
        $params['body'] = array(
            'project_title' => $project_title
        );
        $params['index'] = 'default';
        $params['type'] = 'project';
        $params['id'] = $project->project_id;
        $results = $client->index($params);       //using Index() function to inject the data

        return view('project.partials._newproject', [
            'project' => $project,
            'company_id' => $company_id
        ]);
    }

    public function getCompanyProjects($company_id) {

        $projects = Project::where('company_id', $company_id)->get();
        $assets = ['projects'];

        return view('project.index', [
            'projects' => $projects,
            'assets' => $assets,
            'company_id' => $company_id
        ]);
    }

}
