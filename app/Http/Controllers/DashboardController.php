<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\BaseController;

use \Auth;
use Illuminate\Http\Request;
use \View;
use \Form;
use \Input;
use \Redirect;
use \DB;
use App\Models\Company;
use App\Models\User;
use App\Models\Profile;
use App\Models\Events;
use App\Models\Bug;
use App\Models\Project;
use App\Models\Job;
use App\Models\Ticket;
use App\Models\Task;
use App\Models\Billing;
use App\Models\Applicant;
use App\Models\ApplicantJob;

class DashboardController extends BaseController {

    public function index(Request $request) {

        $user_id = Auth::user('user')->user_id;

        $projects = Project::where('user_id', $user_id)->get();

        $companies = Profile::with('company')->where('user_id', $user_id)->get();
        
         $jobs = Job::all();
        
        $assets = ['dashboard', 'real-time'];

        return view('user.dashboard', [
            'projects' => $projects,
            'companies' => $companies,
            'jobs' =>  $jobs,
            'assets' => $assets,
            'company_id' => 0
        ]);
    }

    public function getJobPostings(Request $request) {

        $jobs = Job::all();

        return view('jobs.partials._dashboardjobpostings', [
            'jobs' => $jobs
        ]);
    }

    public function dashboardApplyToJob(Request $request) {

        $user_id = Auth::user('user')->user_id;
        $job_id = $request->input('job_id');

        $employee = User::where('user_id', $user_id)->first();

        $has_applicant_file = Applicant::where('email', $employee->email)->count();

        if ($has_applicant_file === 1) {

            $existing_applicant = Applicant::where('email', $employee->email)->first();

            //Add it to the pivot table
            $new_applicant_job = new ApplicantJob([
                'applicant_id' => $existing_applicant->id,
                'user_id' => $user_id,
                'job_id' => $job_id,
                'has_account' => 'Yes'
            ]);
            $new_applicant_job->save();
        } else {
            $new_applicant = new Applicant([
                'job_id' => $job_id,
                'name' => $employee->name,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'skype' => $employee->skype,
                'resume' => $employee->resume,
                'photo' => $employee->photo,
                'password' => $employee->password
            ]);
            $new_applicant->save();

            //Add it to the pivot table
            $new_applicant_job = new ApplicantJob([
                'applicant_id' => $new_applicant->id,
                'user_id' => $user_id,
                'job_id' => $job_id,
                'has_account' => 'Yes'
            ]);
            $new_applicant_job->save();
        }
        return "true";
    }

}
?>
