<?php

namespace App\Http\Controllers;

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
use App\Models\TaskCheckList;
use App\Models\TaskCheckListOrder;
use App\Models\TaskCheckListPermission;
use App\Models\TestPerApplicant;
use App\Models\TestPerJob;
use App\Models\Job;
use App\Models\Applicant;
use App\Models\ShareJob;
use App\Models\ShareJobCompany;
use App\Models\ShareJobCompanyPermission;
use App\Models\Test;
use App\Models\Module;
use App\Models\Permission;
use App\Models\PermissionUser;
use App\Models\PermissionRole;
use Auth;
use View;
use Redirect;
use Validator;
use DB;
use Input;

class AssignController extends Controller {

    public function assignProjects(Request $request, $id) {

        //Getting Assign Project Data
        $user_id = Auth::user('user')->user_id;

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        $team_grouping = Project::with('team_project')->where('company_id', $id)->get();

        $profiles = Profile::where('company_id', $id)->paginate(5);

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
                //->where('company_id', $id)
                //->where('user_id', $user_id)
                ->paginate(3);

        $shared_projects = Project::with(['task' => function($query) {
                        $query->orderBy('task_title', 'asc')->get();
                    }], 'task_permission', 'company', 'user')
                ->whereIn('project_id', $project_id_list)
                ->get();


        $user_companies = Company::with(['profile' => function($query) use($user_id) {
                        $query->where('user_id', $user_id)->get();
                    }])->where('id', '<>', $id)->where('id', '<>', 0)->paginate(5);


        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $id)
                ->first();

        $permissions_list = [];

        $permissions_role = PermissionRole::with('permission')
                ->where('company_id', $id)
                ->where('role_id', $user_profile_role->role_id)
                ->get();

        foreach ($permissions_role as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        //For Pagination, Max limit of visible pagination links
        $link_limit = 7;

        $assets = ['assign', 'real-time'];

        return view('assign.assignProjects', [
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
            'module_permissions' => $module_permissions,
            'assets' => $assets,
            'paginator' => $projects,
            'link_limit' => $link_limit
        ]);
    }

    public function AssignJobs(Request $request, $id) {

        $user_id = Auth::user('user')->user_id;

        $profiles = Profile::with('user')->where('company_id', $id)->where('user_id', '<>', $user_id)->paginate(3);

        /* $user_companies = Company::with(['profile' => function($query) use($user_id) {
          $query->where('user_id', $user_id)->get();
          }])->where('id','<>',$id)->get(); */

        $user_companies = Company::with('profile')->where('id', '<>', $id)->where('id', '<>', 0)->paginate(3);

        $jobs = Job::where('user_id', $user_id)->where('company_id', $id)->paginate(5);

        $shared_jobs = ShareJob::all();

        $shared_jobs_companies = ShareJobCompany::all();

        //Get company permissions
        //$shared_company_jobs_permissions = ShareJobCompanyPermission::with('jobs')->where('company_id',$id)->get();
        $shared_company_jobs_permissions = ShareJobCompanyPermission::with('jobs')->where('company_id', $id)->get();

        $assets = ['assign', 'real-time'];

        return view('assign.assignJobs', [
            'profiles' => $profiles,
            'jobs' => $jobs,
            'user_companies' => $user_companies,
            'shared_jobs' => $shared_jobs,
            'shared_jobs_companies' => $shared_jobs_companies,
            'shared_company_jobs_permissions' => $shared_company_jobs_permissions,
            'assets' => $assets,
            'company_id' => $id
        ]);
    }

    public function assignTests(Request $request, $id) {

        //Getting Assign Project Data
        $user_id = Auth::user('user')->user_id;

        //Get Jobs by company and user
        $jobs = Job::where('user_id', $user_id)->where('company_id', $id)->paginate(1,['*'],'jobPage');
        //$jobs->setRelation('applicants',$jobs->applicants()->paginate(3));
        
        $test_applicants = TestPerApplicant::all();

        $test_jobs = TestPerJob::all();

        $company_users = Profile::with('user')->where('company_id', $id)->get();

        $company_user_ids = [];

        //Get all tests by users within the company
        foreach ($company_users as $company_user) {
            array_push($company_user_ids, $company_user->user_id);
        }

        $tests = Test::whereIn('user_id', $company_user_ids)->paginate(13);

        $authority_levels = Role::where('company_id', $id)->orderBy('level', 'asc')->get();

        $task_permissions = TaskCheckListPermission::where('user_id', $user_id)->get();

        $link_limit = 7;

        $assets = ['assign', 'real-time'];

        return view('assign.assignTests', [
            'jobs' => $jobs,
            'tests' => $tests,
            'test_applicants' => $test_applicants,
            'test_jobs' => $test_jobs,
            'assets' => $assets,
            'company_id' => $id,
            'link_limit' => $link_limit
        ]);
    }

    public function assignAuthorityLevels(Request $request, $id) {
        $profiles = Profile::where('company_id', $id)->get();

        $company_users = Profile::with('user')->where('company_id', $id)->get();

        $authority_levels = Role::where('company_id', $id)->orderBy('level', 'asc')->get();

        $assets = ['assign', 'real-time'];

        return view('assign.assignAuthorityLevels', [
            'profiles' => $profiles,
            'company_users' => $company_users,
            'authority_levels' => $authority_levels,
            'assets' => $assets
        ]);
    }

}
