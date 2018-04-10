<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\LinkCategory;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Company;
use App\Models\CompanyDivision;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Profile;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Project;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TeamProject;
use App\Models\TeamCompany;
use App\Models\Task;
use App\Models\TaskChecklist;
use App\Models\TaskCheckListOrder;
use App\Models\TaskCheckListPermission;
use App\Models\TestPerApplicant;
use App\Models\TestPerJob;
use App\Models\Job;
use App\Models\ShareJob;
use App\Models\ShareJobCompany;
use App\Models\ShareJobCompanyPermission;
use App\Models\Test;
use App\Models\Module;
use App\Models\Permission;
use App\Models\PermissionUser;
use App\Models\PermissionRole;
use App\Models\Applicant;
use App\Models\Comment;
use App\Models\Link;
use App\Models\Note;
use Auth;
use View;
use Redirect;
use Validator;
use DB;
use Input;

class CompanyController extends BaseController {

    public function index(Request $request) {

        $user_id = Auth::user()->user_id;

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        $companies = Company::all();

        $profiles = Profile::all();

        $projects = Project::where('user_id', $user_id)->get();

        $assets = ['table', 'companies'];

        return View::make('company.index', [
                    'projects' => $projects,
                    'profiles' => $profiles,
                    'companies' => $companies,
                    'countries' => $countries_option,
                    'assets' => $assets
        ]);
    }

    public function show($company_id) {

        $projects = Project::where('company_id',$company_id)->orderBy('created_at', 'desc')->take(10)->get();

        $jobs = Job::where('company_id',$company_id)->orderBy('created_at', 'desc')->take(10)->get();
        
        $employees = Profile::with('user')->where('company_id',$company_id)->take(10)->get();
        
        $job_list = Job::where('company_id',$company_id)->lists('id');
        
        $applicants = Applicant::whereIn('job_id',$job_list)->orderBy('created_at','desc')->take(10)->get();
        
        $applicant_list = Applicant::whereIn('job_id',$job_list)->lists('id');
        
        $comments = Comment::with('applicant')->whereIn('unique_id',$applicant_list)
                ->where('belongs_to','applicant')
                ->orderBy('created_at','desc')
                ->take(10)
                ->get();

        $links = Link::where('company_id',$company_id)
                ->orderBy('created_at','desc')
                ->take(10)->get();

        $briefcases = Task::select(
                    'task.*','project.company_id'
                )
                ->leftJoin('project', 'task.project_id', '=', 'project.project_id')
                ->where('project.company_id',$company_id)
                ->orderBy('created_at','desc')
                ->take(10)->get();

        $items = TaskChecklist::select(
                    'task_check_list.*'
                )
                ->leftJoin('task', 'task_check_list.task_id', '=', 'task.task_id')
                ->leftJoin('project', 'task.project_id', '=', 'project.project_id')
                ->where('project.company_id',$company_id)
                ->orderBy('created_at','desc')
                ->take(10)->get();

        $tests = Test::where('test.company_id',$company_id)
                ->orderBy('created_at','desc')
                ->take(10)->get();

        $note = Note::where('belongs_to', '=', 'company')
            ->where('unique_id', '=', $company_id)
            ->first();

        $assets = ['companies', 'real-time'];

        return View::make('company.show', [
                    'projects' => $projects,
                    'jobs' => $jobs,
                    'employees' => $employees,
                    'applicants' => $applicants,
                    'comments' => $comments,
                    'links' => $links,
                    'briefcases' => $briefcases,
                    'items' => $items,
                    'tests' => $tests,
                    'note' => $note,
                    'company_id' => $company_id,
                    'assets' => $assets
        ]);
    }

    public function getCompanyModules($company_id) {

        //Getting Assign Project Data
        $user_id = Auth::user('user')->user_id;

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        $companies = Company::where('id', $company_id)->get();

        $teams = Team::with(['team_member' => function($query) use($company_id) {
                        $query->with('user')->where('company_id', $company_id)->get();
                    }])->get();

        $team_grouping = Project::with('team_project')->where('company_id', $company_id)->get();

        $profiles = Profile::where('company_id', $company_id)->get();

        $project_id_list = [];

        $company_id_list = [];

        //Add the current company to the company_id_list by default
        array_push($company_id_list, $company_id);

        //Get owned projects
        $owned_projects = Project::where('user_id', $user_id)->where('company_id', $company_id)->get();

        //Get Team Member projects
        $team_members = TeamMember::where('user_id', $user_id)->where('company_id', $company_id)->get();

        $team_projects = TeamProject::all();

        foreach ($owned_projects as $owned_project) {
            array_push($project_id_list, $owned_project->project_id);
        }

        //Use the team id to get the projects the users are involved with
        foreach ($team_members as $member) {
            foreach ($team_projects as $project) {
                if ($member->team_id === $project->team_id) {
                    array_push($project_id_list, $project->project_id);
                }
            }
        }

        //Get projects with their tasks and task permissions
        $projects = Project::with(['task' => function($query) {
                        $query->orderBy('task_title', 'asc')->get();
                    }], 'task_permission', 'company', 'user')
                ->whereIn('project_id', $project_id_list)
                ->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->get();

        $shared_projects = Project::with(['task' => function($query) {
                        $query->orderBy('task_title', 'asc')->get();
                    }], 'task_permission', 'company', 'user')
                ->whereIn('project_id', $project_id_list)
                ->get();

        $task_permissions = TaskCheckListPermission::where('user_id', $user_id)->get();

        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $company_id)
                ->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        $assets = ['companies', 'real-time'];

        return View::make('company.show', [
                    'company_id' => $company_id,
                    'projects' => $projects,
                    'shared_projects' => $shared_projects,
                    'task_permissions' => $task_permissions,
                    'profiles' => $profiles,
                    'companies' => $companies,
                    'teams' => $teams,
                    'team_grouping' => $team_grouping,
                    'countries' => $countries_option,
                    'module_permissions' => $module_permissions,
                    'assets' => $assets
        ]);
    }

    public function create() {
        return View::make('company.create');
    }

    public function edit($company_id) {
        $companies = Company::find($company_id);

        $countries_option = Country::orderBy('country_name', 'asc')
                ->lists('country_name', 'country_id')
                ->toArray();

        return View::make('company.edit', [
                    'companies' => $companies,
                    'countries' => $countries_option
        ]);
    }

    public function store(Request $request) {

        $user_id = Auth::user('user')->user_id;

        $validation = Validator::make(Input::all(), [
                    'name' => 'required|unique:companies',
                    'email' => 'required|email',
                    'country_id' => 'required'
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->messages());
        }

        //Save Company
        $companies = new Company;
        $companies->name = $request->input('name');
        $companies->email = $request->input('email');
        $companies->phone = $request->input('phone');
        $companies->number_of_employees = $request->input('number_of_employees');
        $companies->address_1 = $request->input('address_1');
        $companies->address_2 = $request->input('address_2');
        $companies->province = $request->input('province');
        $companies->zipcode = $request->input('zipcode');
        $companies->website = $request->input('website');
        $companies->country_id = $request->input('country_id');
        $companies->save();

        //Check if Company Division Exists
        /* $company_division_trim = trim($request->input('company_division'));
          $company_division_exists = CompanyDivision::where('division_name', $company_division_trim)->count();

          if ($company_division_exists > 0) {
          //Get Existing Company Division
          $company_divisions = CompanyDivision::where('division_name', $company_division_trim)->first();
          } else {
          //Save Company Division
          $company_divisions = new CompanyDivision();
          $company_divisions->company_id = $companies->id;
          $company_divisions->division_name = $company_division_trim;
          $company_divisions->save();
          } */

        //Check if Role already exists with the same company
        $role_exists = Role::where('name', 'Admin')->where('company_id', $companies->id)->count();

        if ($role_exists > 0) {

            $role = Role::where('name', 'Admin')->where('company_id', $companies->id)->first();
        } else {
            //Save this user's role as a super user of this company
            $admin = new Role();
            $admin->company_id = $companies->id;
            $admin->company_division_id = 0;
            $admin->name = 'Admin';
            $admin->slug = 'admin-' . $companies->id;
            $admin->description = 'Administrator';
            $admin->level = '1';
            $admin->save();

            $staff = new Role();
            $staff->company_id = $companies->id;
            $staff->company_division_id = 0;
            $staff->name = 'Staff';
            $staff->slug = 'staff-' . $companies->id;
            $staff->description = 'Staff';
            $staff->level = '2';
            $staff->save();

            $client = new Role();
            $client->company_id = $companies->id;
            $client->company_division_id = 0;
            $client->name = 'Client';
            $client->slug = 'client-' . $companies->id;
            $client->description = 'Client';
            $client->level = '3';
            $client->save();
        }

        //Map the company to the user's profile
        $profile = new Profile();
        $profile->user_id = $user_id;
        $profile->company_id = $companies->id;
        $profile->role_id = $admin->id;
        $profile->save();

        $user = User::where('user_id', $user_id)->first();


        $new_user_role = Role::where('company_id', 0)->first();

        $user->detachRole($new_user_role->id);
        $user->attachRole($admin->id);

        $no_company_profile = Profile::where('company_id', 0)->where('user_id', $user_id);
        $no_company_profile->delete();

        return Redirect::to('company/' . $companies->id)->withSuccess("Company added successfully!!");
    }

    public function update($company_id) {
        $companies = Company::find($company_id);

        $validation = Validator::make(Input::all(), [
                    'company_name' => 'required|unique:companies,company_name,' . $company_id . ',company_id',
                    'contact_person' => 'required',
                    'email' => 'required|email',
                    'zipcode' => 'numeric',
                    'country_id' => 'required'
        ]);

        if ($validation->fails()) {
            return Redirect::to('client')->withErrors($validation->messages());
        }
        $data = Input::all();
        $companies->fill($data);
        $companies->save();
        return Redirect::to('client')->withSuccess("Company updated successfully!!");
    }

    public function delete() {
        
    }

    public function destroy($company_id) {
        $company = Company::destroy($company_id);
        
       return "true";
    }

    //Create a team for a project,     
    public function createTeam(Request $request) {

        //Create a new team if that project isn't mapped to a team yet
        $team = new Team();
        $team_member = new TeamMember();
        $team_project = new TeamProject();

        $user_id = $request->input('user_id');
        $project_id = $request->input('project_id');
        $company_id = $request->input('company_id');

        $project_exists = Team::where('project_id', $project_id)->count();

        if ($project_exists > 0) {

            $team_id = Team::where('project_id', $project_id)->pluck('id');

            $team_member_exists = TeamMember::where('user_id', $user_id)->where('team_id', $team_id)->where('company_id', $company_id)->first();

            $team_project_exists = TeamProject::where('team_id', $team_id)->where('team_id', $team_id)->first();

            if (!$team_member_exists > 0) {
                $team_member->team_id = $team_id;
                $team_member->user_id = $user_id;
                $team_member->company_id = $company_id;
                $team_member->save();
            }

            if (!$team_project_exists > 0) {

                $team_project->team_id = $team_id;
                $team_project->project_id = $project_id;

                $team_project->save();
            }
        } else {

            //Save the project id as an new team
            $team->project_id = $project_id;
            $team->save();

            //Get the team id
            $team_id = $team->id;

            //Save the user as a team member
            $team_member->team_id = $team_id;
            $team_member->user_id = $user_id;
            $team_member->company_id = $company_id;
            $team_member->save();

            //Map Project to the team id    
            $team_project->team_id = $team_id;
            $team_project->project_id = $project_id;

            $team_project->save();
        }

        //Get projects with their tasks and task permissions
        $tasks = Task::where('project_id', $project_id)
                ->orderBy('task_title', 'asc')
                ->get();
        $task_permissions = TaskCheckListPermission::where('project_id', $project_id)->where('user_id', $user_id)->get();

        return view('company.partials._tasklist', [
            'tasks' => $tasks,
            'task_permissions' => $task_permissions,
            'project_id' => $project_id,
            'user_id' => $user_id,
            'company_id' => $company_id
        ]);
    }

    public function unassignTeamMember(Request $request) {

        $user_id = $request->input('user_id');
        $team_id = $request->input('team_id');
        $project_id = $request->input('project_id');

        //Delete team member from the Team Member table to unassign them from the project
        $team_member = TeamMember::where('user_id', $user_id)->where('team_id', $team_id);
        $team_member->delete();

        //Delete permissions from tasklists
        $permissions = TaskCheckListPermission::where('user_id', $user_id)->where('project_id', $project_id);
        $permissions->delete();
        return $user_id;
    }

    public function assignCompanyToTeam(Request $request) {

        $project_id = $request->input('project_id');
        $company_id = $request->input('company_id');

        $team_company = new TeamCompany();
        $team_company->project_id = $project_id;
        $team_company->company_id = $company_id;
        $team_company->save();

        //Get employees of the company except for the logged in user
        $employees = Profile::with('user')
                ->where('company_id', $company_id)
                ->get();

        return view('company.partials._projectemployeelist', [
            'employees' => $employees,
            'project_id' => $project_id,
            'company_id' => $company_id
        ]);
    }

    public function unassignCompanyFromTeam(Request $request) {
        $project_id = $request->input('project_id');
        $company_id = $request->input('company_id');

        $team_company = TeamCompany::where('project_id', $project_id)->where('company_id', $company_id);
        $team_company->delete();

        $team_project = TeamProject::where('project_id', $project_id)->first();

        //Remove company users from team
        $team_member = TeamMember::where('team_id', $team_project->team_id)->where('company_id', $company_id);
        $team_member->delete();

        //Remove the task check list permissions for for users on the unassigned companies
        $task_check_list_permissions = TaskCheckListPermission::where('company_id', $company_id)->where('project_id', $project_id);
        $task_check_list_permissions->delete();

        return "true";
    }

    public function assignTaskList(Request $request) {
        $user_id = $request->input('user_id');
        $task_id = $request->input('task_id');
        $project_id = $request->input('project_id');
        $company_id = $request->input('company_id');

        $task_list_permission = new TaskCheckListPermission();

        $task_list_permission->user_id = $user_id;
        $task_list_permission->task_id = $task_id;
        $task_list_permission->project_id = $project_id;
        $task_list_permission->company_id = $company_id;
        $task_list_permission->save();

        //Get Project Team
        $team_project = TeamProject::where('project_id', $project_id)->first();

        //Check if the user is already a team member for that project
        $is_team_member = TeamMember::where('user_id', $user_id)
                ->where('company_id', $company_id)
                ->where('team_id', $team_project->team_id)
                ->count();

        if ($is_team_member === 0) {

            $team_member = new TeamMember();
            $team_member->user_id = $user_id;
            $team_member->team_id = $team_project->team_id;
            $team_member->company_id = $company_id;
            $team_member->save();
        }

        return $user_id;
    }

    public function unassignTaskList(Request $request) {
        $user_id = $request->input('user_id');
        $task_id = $request->input('task_id');
        $project_id = $request->input('project_id');
        $company_id = $request->input('company_id');

        $task_list_permission = TaskCheckListPermission::where('user_id', $user_id)
                ->where('task_id', $task_id)
                ->where('project_id', $project_id)
                ->where('company_id', $company_id);
        $task_list_permission->delete();

        //Check if user still has tasks in this project
        $has_tasks = TaskCheckListPermission::where('user_id', $user_id)->where('project_id', $project_id)->count();
        if ($has_tasks === 0) {
            $team_member = TeamMember::where('user_id', $user_id)->where('company_id', $company_id);
            $team_member->delete();
        }

        return $user_id;
    }

    public function assignTestToApplicant(Request $request) {
        $test_id = $request->input('test_id');
        $applicant_id = $request->input('applicant_id');

        $test_per_applicant = new TestPerApplicant();
        $test_per_applicant->test_id = $test_id;
        $test_per_applicant->applicant_id = $applicant_id;
        $test_per_applicant->save();

        return $applicant_id;
    }

    public function unassignTestFromApplicant(Request $request) {
        $test_id = $request->input('test_id');
        $applicant_id = $request->input('applicant_id');

        $test_per_applicant = TestPerApplicant::where('test_id', $test_id)->where('applicant_id', $applicant_id);
        $test_per_applicant->delete();

        return $test_id;
    }

    public function assignTestToJob(Request $request) {
        $test_id = $request->input('test_id');
        $job_id = $request->input('job_id');

        $test_per_job = new TestPerJob();
        $test_per_job->test_id = $test_id;
        $test_per_job->job_id = $job_id;
        $test_per_job->save();

        return $job_id;
    }

    public function unassignTestFromJob(Request $request) {
        $test_id = $request->input('test_id');
        $job_id = $request->input('job_id');

        $test_per_job = TestPerJob::where('test_id', $test_id)->where('job_id', $job_id);
        $test_per_job->delete();

        return $test_id;
    }

    public function updateRole(Request $request) {
        $user_id = $request->input('user_id');
        $role_id = $request->input('role_id');
        $company_id = $request->input('company_id');

        $update_profile = Profile::where('user_id', $user_id)->where('company_id', $company_id);
        $update_profile->update([
            'role_id' => $role_id
        ]);

        $update_role = RoleUser::where('user_id', $user_id);
        $update_role->update([
            'role_id' => $role_id
        ]);

        return "true";
    }

    public function getChartData(Request $request, $id) {

        $company_users = Profile::with('user')->where('company_id', $id)->get();

        $authority_levels = Role::where('company_id', $id)->get();

        $chart_data = [];
        $count = 0;

        foreach ($authority_levels->where('level', 1) as $key => $level) {
            foreach ($company_users as $profile) {
                if ($profile->role_id === $level->id) {
                    $chart_data['name'][] = $profile->user->name;
                    $chart_data['title'][] = $level->name;
                    $chart_data['relationship'][] = 011;
                }
            }
        }

        foreach ($authority_levels->where('level', 2) as $level2) {
            foreach ($company_users as $profile) {
                if ($profile->role_id === $level2->level) {
                    $chart_data['children'][] = array(
                        'name' => $profile->user->name,
                        'title' => $level2->name,
                    );
                }
            }
        }


        return $chart_data;
    }

    public function getCompanyProjects(Request $request, $id) {

        $projects = Project::where('company_id', $id)->get();

        $project_array = [];

        foreach ($projects as $project) {
            array_push($project_array, $project->project_id);
        }

        return $project_array;
    }

    /* For Load on Demand Tabs */

    public function getJobsTab(Request $request, $id) {

        $user_id = Auth::user('user')->user_id;

        $my_jobs = Job::where('company_id', $id)->where('user_id', $user_id)->get();

        $shared_jobs_user = ShareJob::where('user_id', $user_id)->get();
        $shared_jobs_company = ShareJobCompany::where('company_id', $id)->get();


        $shared_jobs_list = [];

        foreach ($shared_jobs_user as $user_job) {
            array_push($shared_jobs_list, $user_job->job_id);
        }

        foreach ($shared_jobs_company as $company_job) {
            array_push($shared_jobs_list, $company_job->job_id);
        }

        $shared_jobs = Job::with('user')->whereIn('id', $shared_jobs_list)
                //->where('company_id','<>',$id)
                //->where('user_id','<>',$user_id)
                ->get();

        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $id)
                ->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        return view('company.partials._myjobslist', [
            'my_jobs' => $my_jobs,
            'shared_jobs' => $shared_jobs,
            'module_permissions' => $module_permissions,
            'company_id' => $id
        ]);
    }

    public function getEmployeesTab(Request $request, $id) {

        $user_id = Auth::user('user')->user_id;

        $profiles = Profile::where('company_id', $id)->get();

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $id)
                ->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();


        return view('company.partials._employees', [
            'profiles' => $profiles,
            'countries' => $countries_option,
            'module_permissions' => $module_permissions,
            'company_id' => $id
        ]);
    }

    public function getPositionsTab(Request $request, $id) {
        $user_id = Auth::user('user')->user_id;

        $positions = Role::where('company_id', $id)->get();
        $modules = Module::all();
        $permissions = Permission::all();
        $permission_role = PermissionRole::all();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        return view('company.partials._positionslist', [
            'positions' => $positions,
            'permissions' => $permissions,
            'permission_role' => $permission_role,
            'modules' => $modules,
            'module_permissions' => $module_permissions,
            'company_id' => $id
        ]);
    }

    public function getAssignTab(Request $request, $id) {

        //Getting Assign Project Data
        $user_id = Auth::user('user')->user_id;

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        $team_grouping = Project::with('team_project')->where('company_id', $id)->get();

        $profiles = Profile::where('company_id', $id)->get();

        $project_id_list = [];

        //Get owned projects
        $owned_projects = Project::where('user_id', $user_id)->where('company_id', $id)->get();

        $teams = Team::with(['team_member' => function($query) use($id) {
                        $query->with('user')->where('company_id', $id)->get();
                    }])->get();

        //Get Team Member projects
        $team_members = TeamMember::where('user_id', $user_id)->where('company_id', $id)->get();

        $team_projects = TeamProject::all();

        $team_companies = TeamCompany::where('company_id', '<>', $id)->get();

        foreach ($owned_projects as $owned_project) {
            array_push($project_id_list, $owned_project->project_id);
        }

        //Use the team id to get the projects the users are involved with
        foreach ($team_members as $member) {
            foreach ($team_projects as $project) {
                if ($member->team_id === $project->team_id) {
                    array_push($project_id_list, $project->project_id);
                }
            }
        }

        //Get projects with their tasks and task permissions
        $projects = Project::with(['task' => function($query) {
                        $query->orderBy('task_title', 'asc')->get();
                    }], 'task_permission', 'company', 'user')
                ->whereIn('project_id', $project_id_list)
                ->where('company_id', $id)
                ->where('user_id', $user_id)
                ->get();

        $shared_projects = Project::with(['task' => function($query) {
                        $query->orderBy('task_title', 'asc')->get();
                    }], 'task_permission', 'company', 'user')
                ->whereIn('project_id', $project_id_list)
                ->get();


        $user_companies = Company::with(['profile' => function($query) use($user_id) {
                        $query->where('user_id', $user_id)->get();
                    }])->where('id', '<>', $id)->where('id', '<>', 0)->get();

        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $id)
                ->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();


        return view('company.partials._assign', [
            'company_id' => $id,
            'projects' => $projects,
            'shared_projects' => $shared_projects,
            'profiles' => $profiles,
            'user_companies' => $user_companies,
            'teams' => $teams,
            'team_members' => $team_members,
            'team_grouping' => $team_grouping,
            'team_companies' => $team_companies,
            'countries' => $countries_option,
            'module_permissions' => $module_permissions
        ]);
    }

    public function getAssignProjectsTab(Request $request, $id) {

        //Getting Assign Project Data
        $user_id = Auth::user('user')->user_id;

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        $team_grouping = Project::with('team_project')->where('company_id', $id)->get();

        $profiles = Profile::where('company_id', $id)->get();

        $project_id_list = [];

        //Get owned projects
        $owned_projects = Project::where('user_id', $user_id)->where('company_id', $id)->get();

        $teams = Team::with(['team_member' => function($query) use($id) {
                        $query->with('user')->where('company_id', $id)->get();
                    }])->get();

        //Get Team Member projects
        $team_members = TeamMember::where('user_id', $user_id)->where('company_id', $id)->get();

        $team_projects = TeamProject::all();

        $team_companies = TeamCompany::where('company_id', '<>', $id)->get();

        foreach ($owned_projects as $owned_project) {
            array_push($project_id_list, $owned_project->project_id);
        }

        //Use the team id to get the projects the users are involved with
        foreach ($team_members as $member) {
            foreach ($team_projects as $project) {
                if ($member->team_id === $project->team_id) {
                    array_push($project_id_list, $project->project_id);
                }
            }
        }

        //Get projects with their tasks and task permissions
        $projects = Project::with(['task' => function($query) {
                        $query->orderBy('task_title', 'asc')->get();
                    }], 'task_permission', 'company', 'user')
                ->whereIn('project_id', $project_id_list)
                ->where('company_id', $id)
                ->where('user_id', $user_id)
                ->get();

        $shared_projects = Project::with(['task' => function($query) {
                        $query->orderBy('task_title', 'asc')->get();
                    }], 'task_permission', 'company', 'user')
                ->whereIn('project_id', $project_id_list)
                ->get();


        $user_companies = Company::with(['profile' => function($query) use($user_id) {
                        $query->where('user_id', $user_id)->get();
                    }])->where('id', '<>', $id)->where('id', '<>', 0)->get();


        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $id)
                ->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        return view('company.partials._projectlist', [
            'company_id' => $id,
            'projects' => $projects,
            'shared_projects' => $shared_projects,
            'profiles' => $profiles,
            'user_companies' => $user_companies,
            'teams' => $teams,
            'team_members' => $team_members,
            'team_grouping' => $team_grouping,
            'team_companies' => $team_companies,
            'countries' => $countries_option,
            'module_permissions' => $module_permissions
        ]);
    }

    public function getAssignTestsTab(Request $request, $id) {

        //Getting Assign Project Data
        $user_id = Auth::user('user')->user_id;

        //Get Jobs by company and user
        $jobs = Job::with('applicants')->where('user_id', $user_id)->where('company_id', $id)->get();

        $test_applicants = TestPerApplicant::all();

        $test_jobs = TestPerJob::all();

        $company_users = Profile::with('user')->where('company_id', $id)->get();

        $company_user_ids = [];

        //Get all tests by users within the company
        foreach ($company_users as $company_user) {
            array_push($company_user_ids, $company_user->user_id);
        }

        $tests = Test::whereIn('user_id', $company_user_ids)->get();

        $authority_levels = Role::where('company_id', $id)->orderBy('level', 'asc')->get();

        $task_permissions = TaskCheckListPermission::where('user_id', $user_id)->get();

        return view('company.partials._joblist', [
            'jobs' => $jobs,
            'tests' => $tests,
            'test_applicants' => $test_applicants,
            'test_jobs' => $test_jobs
        ]);
    }

    public function getAssignAuthorityLevelsTab(Request $request, $id) {
        $profiles = Profile::where('company_id', $id)->get();

        $company_users = Profile::with('user')->where('company_id', $id)->get();

        $authority_levels = Role::where('company_id', $id)->orderBy('level', 'asc')->get();

        return view('company.partials._rolelist', [
            'profiles' => $profiles,
            'company_users' => $company_users,
            'authority_levels' => $authority_levels
        ]);
    }

    public function getShareJobsTab(Request $request, $id) {

        $user_id = Auth::user('user')->user_id;

        $profiles = Profile::with('user')->where('company_id', $id)->where('user_id', '<>', $user_id)->get();

        /* $user_companies = Company::with(['profile' => function($query) use($user_id) {
          $query->where('user_id', $user_id)->get();
          }])->where('id','<>',$id)->get(); */

        $user_companies = Company::with('profile')->where('id', '<>', $id)->where('id', '<>', 0)->get();

        $jobs = Job::where('user_id', $user_id)->where('company_id', $id)->get();

        $shared_jobs = ShareJob::all();

        $shared_jobs_companies = ShareJobCompany::all();

        //Get company permissions
        //$shared_company_jobs_permissions = ShareJobCompanyPermission::with('jobs')->where('company_id',$id)->get();
        $shared_company_jobs_permissions = ShareJobCompanyPermission::with('jobs')->where('company_id', $id)->get();

        return view('company.partials._sharejobslist', [
            'profiles' => $profiles,
            'jobs' => $jobs,
            'user_companies' => $user_companies,
            'shared_jobs' => $shared_jobs,
            'shared_jobs_companies' => $shared_jobs_companies,
            'shared_company_jobs_permissions' => $shared_company_jobs_permissions
        ]);
    }

    public function shareJobToUser(Request $request) {

        $job_id = $request->input('job_id');
        $user_id = $request->input('user_id');

        $share_jobs = new ShareJob();
        $share_jobs->user_id = $user_id;
        $share_jobs->job_id = $job_id;
        $share_jobs->save();

        return "true";
    }

    public function unshareJobFromUser(Request $request) {

        $job_id = $request->input('job_id');
        $user_id = $request->input('user_id');

        $share_jobs = ShareJob::where('job_id', $job_id)->where('user_id', $user_id);
        $share_jobs->delete();

        return "true";
    }

    public function shareJobToCompany(Request $request) {
        $job_id = $request->input('job_id');
        $company_id = $request->input('company_id');

        $shared_jobs_companies = new ShareJobCompany();
        $shared_jobs_companies->job_id = $job_id;
        $shared_jobs_companies->company_id = $company_id;
        $shared_jobs_companies->save();

        return $shared_jobs_companies->id;
    }

    public function unshareJobFromCompany(Request $request) {

        $job_id = $request->input('job_id');
        $company_id = $request->input('company_id');

        $share_jobs_company = ShareJobCompany::where('job_id', $job_id)->where('company_id', $company_id);
        $share_jobs_company->delete();

        return "true";
    }

    public function getSubprojects(Request $request, $project_id, $company_id) {

        //Getting Assign Project Data
        $user_id = Auth::user('user')->user_id;

        $is_project_owner = Project::where('project_id', $project_id)
                ->where('user_id', $user_id)
                ->where('company_id', $company_id)
                ->count();

        $project = Project::where('project_id', $project_id)->first();
        $project_owner = $project->user_id;
        $project_company = $project->company_id;

        //Check if the user is the owner of the project and that user owns it in this company
        if ($is_project_owner > 0) {

            $tasks = Task::where('project_id', $project_id)->orderBy('task_title', 'asc')->get();
        } else {

            //Get task permissions first for logged in user and current company selected
            $task_permissions = TaskCheckListPermission::where('user_id', $user_id)
                    ->where('project_id', $project_id)
                    ->where('company_id', $company_id)
                    ->get();

            $task_ids = [];

            foreach ($task_permissions as $permission) {
                array_push($task_ids, $permission->task_id);
            }

            $tasks = Task::whereIn('task_id', $task_ids)->orderBy('task_title', 'asc')->get();
        }

        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $company_id)
                ->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        return view('company.partials._mytasklistitems', [
            'tasks' => $tasks,
            'project_id' => $project_id,
            'project_owner' => $project_owner,
            'module_permissions' => $module_permissions
        ]);
    }

    public function getSubprojectsForCompanyEmployee(Request $request, $user_id, $project_id, $company_id) {

        //Get projects with their tasks and task permissions
        $tasks = Task::where('project_id', $project_id)
                ->orderBy('task_title', 'asc')
                ->get();
        $task_permissions = TaskCheckListPermission::where('user_id', $user_id)->where('company_id', $company_id)->get();

        return view('company.partials._companytasklist', [
            'tasks' => $tasks,
            'task_permissions' => $task_permissions,
            'user_id' => $user_id,
            'project_id' => $project_id,
            'company_id' => $company_id
        ]);
    }

    public function getEmployees(Request $request, $company_id, $job_id) {

        $user_id = Auth::user('user')->user_id;

        //Get employees of the company except for the logged in user
        $employees = Profile::with('user')
                ->where('user_id', '<>', $user_id)
                ->where('company_id', $company_id)
                ->get();

        //Get company permissions
        $shared_company_jobs_permissions = ShareJobCompanyPermission::where('company_id', $company_id)->where('job_id', $job_id)->get();

        return view('company.partials._employeelist', [
            'employees' => $employees,
            'shared_company_jobs_permissions' => $shared_company_jobs_permissions,
            'job_id' => $job_id
        ]);
    }

    public function getCompanyEmployeesForProject(Request $request, $project_id, $company_id) {

        //Get employees of the company except for the logged in user
        $employees = Profile::with('user')
                ->where('company_id', $company_id)
                ->get();

        return view('company.partials._projectemployeelist', [
            'employees' => $employees,
            'project_id' => $project_id,
            'company_id' => $company_id
        ]);
    }

    public function shareToCompanyEmployee(Request $request) {

        $user_id = $request->input('user_id');
        $company_id = $request->input('company_id');
        $job_id = $request->input('job_id');


        $company_permission = new ShareJobCompanyPermission();
        $company_permission->user_id = $user_id;
        $company_permission->company_id = $company_id;
        $company_permission->job_id = $job_id;
        $company_permission->save();

        return "true";
    }

    public function unshareFromCompanyEmployee(Request $request) {

        $user_id = $request->input('user_id');
        $company_id = $request->input('company_id');
        $job_id = $request->input('job_id');


        $company_permission = ShareJobCompanyPermission::where('user_id', $user_id)->where('company_id', $company_id)->where('job_id', $job_id);
        $company_permission->delete();

        return "true";
    }

    public function companyLinks($company_id){
        
        $user_id = Auth::user('user')->user_id;
        $user = User::find($user_id);

        $links = Link::with('briefcases')->where('company_id',$company_id)->get();
        
        $categories = LinkCategory::all();
        
        $user_profile_role = Profile::where('user_id', $user_id)
            ->where('company_id', $company_id)
            ->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
            ->where('company_id', $company_id)
            ->where('user_id', $user_id)
            ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        $briefcase = Task::select(
            'task.task_title','task.task_id'
        )
            ->leftJoin('project', 'task.project_id', '=', 'project.project_id')
            ->where('project.company_id',$company_id)->get();
        

        $assets = ['companies'];

        return view(
            'company.partials._companylinks',[
                'links' => $links,
                'assets' => $assets,
                'user_id' => $user_id,
                'company_id' => $company_id,
                'categories' => $categories,
                'briefcase' => $briefcase,
                'module_permissions' => $module_permissions
            ]);
    }
    
    public function addCompanyForm(Request $request) {
        
        $countries = Country::orderBy('country_name', 'asc')
                ->lists('country_name', 'country_id')
                ->toArray();
        
        return view('forms.addCompanyForm',[
            'countries' => $countries
        ]);
    }
    
    public function editCompanyForm(Request $request,$id) {
        
        $companies = Company::find($id);
        
        $countries = Country::orderBy('country_name', 'asc')
                ->lists('country_name', 'country_id')
                ->toArray();
        
        return view('forms.addCompanyForm',[
            'companies' => $companies,
            'countries' => $countries
        ]);
    }
    
}

?>
