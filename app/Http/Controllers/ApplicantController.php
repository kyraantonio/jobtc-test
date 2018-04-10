<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
//use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\Job;
use App\Models\Applicant;
use App\Models\ApplicantTag;
use App\Models\Tag;
use App\Models\ApplicantRating;
use App\Models\Comment;
use App\Models\RecordedVideo;
use App\Models\InterviewQuestionAnswer;
use App\Models\Video;
use App\Models\VideoRoom;
use App\Models\VideoSession;
use App\Models\VideoTag;
use App\Models\Test;
use App\Models\TestPerApplicant;
use App\Models\TestPerJob;
use App\Models\Question;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TeamProject;
use App\Models\TaskCheckListPermission;
use App\Models\TestResultModel;
use App\Models\TestCompleted;
use App\Models\PermissionUser;
use App\Models\Permission;
use Elasticsearch\ClientBuilder as ES;
use Hash;
use Auth;
use Mail;

class ApplicantController extends Controller {

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
    public function show(Request $request, $id) {
        $applicant = Applicant::where('id', $id)->first();
        $display_name = "";
        if ($applicant !== NULL) {

            //Get logged in User
            if (Auth::check('user')) {
                $user_id = $request->user('user')->user_id;
                $display_name = $request->user('user')->name;

                $user_info = User::where('user_id', $user_id)->with('profile')->first();
                $user_type = "user";
                
                //$comments = Comment::with('user', 'profile')->where('applicant_id', $id)->orderBy('id', 'desc')->get();

                $comments = Comment::with('user')->where('belongs_to', 'applicant')->where('unique_id', $id)->orderBy('comment_id', 'desc')->get();
            } elseif (Auth::check('applicant') || !Auth::check()) {
                $user_id = $id;

                $user_info = Applicant::where('id', $id)->first();
                $display_name = $user_info->name;
                $user_type = "applicant";
                //$comments = Comment::with('applicant')->where('applicant_id', $id)->orderBy('id', 'desc')->get();
                //$comments = Applicant::with('comment')->where('id',$id)->orderBy('id', 'desc')->get();
                $comments = Comment::with('user', 'applicant')->where('belongs_to', 'applicant')->where('unique_id', $id)->orderBy('comment_id', 'desc')->get();
            }


            $job = Job::where('id', $applicant->job_id)->first();

            $statuses = Tag::where('unique_id', $id)
                    ->where('tag_type', 'applicant')
                    ->first();

            $prevApplicant = Applicant::where('id', '>', $id)->where('job_id', $applicant->job_id)->min('id');
            $nextApplicant = Applicant::where('id', '<', $id)->where('job_id', $applicant->job_id)->max('id');

            $rating = ApplicantRating::where('applicant_id', $id)->first();

            $quiz_videos = \DB::table('test_result')
                    ->select('test_result.*')
                    ->leftJoin('question', 'question.id', '=', 'test_result.question_id')
                    ->where('question.question_type_id', 4)
                    ->where('test_result.unique_id', $id)
                    ->where('test_result.belongs_to', 'applicant')
                    ->orderBy('test_result.id', 'desc')
                    ->get();

            /*$videos = Video::with(['tags' => function($query) {
                            $query->where('tag_type', 'video')->first();
                        }])->where('unique_id', $id)->where('user_type', 'applicant')->orderBy('id', 'desc')->get();*/
            $videos = VideoRoom::with(['tags' => function($query){
                $query->where('tag_type', 'video')->first();
            }])->where('room_name', $id)->where('room_type', 'applicant')->orderBy('id', 'desc')->get();
            //Get the test permissions
            
            $video_sessions = VideoSession::where('owner_type','applicant')->where('unique_id',$id)->where('is_recording','Yes')->first();
            
            $test_ids = [];
            $test_jobs = TestPerJob::where('job_id', $applicant->job_id)->get();
            $test_applicants = TestPerApplicant::where('applicant_id', $applicant->id)->get();
            $tests_completed = TestCompleted::where('unique_id', $applicant->id)
                    ->where('belongs_to', 'applicant')
                    ->get();


            foreach ($test_jobs as $test_job) {
                array_push($test_ids, $test_job->test_id);
            }

            foreach ($test_applicants as $test_applicant) {
                array_push($test_ids, $test_applicant->test_id);
            }

            //$test_ids = [21];
            $tests = Test::whereIn('id', array_unique($test_ids))->get();
            $slide_setting = \DB::table('test_slider')
                    ->where('job_id', '=', $applicant->job_id)
                    ->pluck('slider_setting');
            if ($slide_setting) {
                $slide_setting = json_decode($slide_setting);
            }

            $tests_tags = [];
            $tests_adjust_tags = [];
            $test_score_total = 0;
            if (count($tests) > 0) {
                foreach ($tests as $v) {
                    $v->total_points = 0;
                    $v->total_score = 0;
                    $tags = $v->default_tags ? explode(',', $v->default_tags) : array();
                    if (count($tags) > 0) {
                        foreach ($tags as $t) {
                            if (!array_key_exists(strtolower($t), $tests_tags)) {
                                $tests_tags[strtolower($t)] = 0;
                            }
                        }
                    } else {
                        if (!array_key_exists('general', $tests_tags)) {
                            $tests_tags['general'] = 0;
                        }
                    }

                    $result = \DB::table('test_result')
                            ->select(\DB::raw('
                            IF(fp_question.question_type_id IN (3,4), fp_test_result.points, fp_question.points) as points,
                            IF(fp_question.question_type_id IN (3,4), fp_question.max_point, fp_question.points) as score,
                            fp_test_result.result
                        '))
                            ->leftJoin('question', function($join) {
                                $join->on('question.id', '=', 'test_result.question_id')
                                ->on('question.test_id', '=', 'test_result.test_id');
                            })
                            ->where('test_result.test_id', '=', $v->id)
                            ->where('test_result.unique_id', '=', $applicant->id)
                            ->whereNotNull('question.id')
                            ->get();
                    if (count($result) > 0) {
                        foreach ($result as $r) {
                            $v->total_points += $r->score;
                            if ($r->result) {
                                $v->total_score += $r->points;
                                $test_score_total += $r->points;
                                if (count($tags) > 0) {
                                    foreach ($tags as $t) {
                                        $tests_tags[strtolower($t)] += $r->points;
                                    }
                                } else {
                                    $tests_tags['general'] += $r->points;
                                }
                            }
                        }

                        if (count($slide_setting) > 0) {
                            foreach ($slide_setting as $tag => $percentage) {
                                $points = array_key_exists($tag, $tests_tags) ? $tests_tags[$tag] : 0;
                                $adjustment = $points + ($points * $percentage / 100);
                                $tests_adjust_tags[$tag] = $adjustment;
                            }
                        }
                    }
                }
            }

            $questions = Question::whereIn('question.test_id', array_unique($test_ids))
                    ->orderBy('order', 'ASC')
                    ->get();

            $video_questions = [];
            if (count($questions) > 0) {
                foreach ($questions as $v) {
                    $v->question_choices = json_decode($v->question_choices);

                    $test_result = \DB::table('test_result')
                            ->select(\DB::raw(
                                            'fp_test_result.id as result_id,
                            fp_test_result.answer as result_answer,
                            fp_test_result.result,
                            fp_test_result.record_id,
                            fp_test_result.points as result_points'
                            ))
                            ->where('question_id', $v->id)
                            ->where('unique_id', $applicant->id)
                            ->get();
                    if (count($test_result) > 0) {
                        foreach ($test_result as $r) {
                            foreach ($r as $field => $value) {
                                $v->$field = $value;
                            }
                        }
                    }

                    if ($v->question_type_id == 4) {
                        $video_questions[] = $v;
                    }
                }
            }

            //This is for the Test Review(Will be put in place at a later date) --06/09/2016
            $r = TestResultModel::where('unique_id', $id)->where('belongs_to', 'applicant')->get();
            $review_result = array();
            if (count($r) > 0) {
                foreach ($r as $v) {
                    $review_result[$v->question_id] = (Object) array(
                                'answer' => $v->answer,
                                'result' => $v->result,
                    );
                }
            }

            $projects = Project::where('company_id',$job->company_id)
                ->lists('project_title', 'project_id')
                ->toArray();

            $permissions_list = [];

            $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $job->company_id)
                ->where('user_id', $user_id)
                ->get();

            foreach ($permissions_user as $role) {
                array_push($permissions_list, $role->permission_id);
            }

            $module_permissions = Permission::whereIn('id', $permissions_list)->get();
            
            $recorded_videos = RecordedVideo::where('module_type','=','applicants')->where('module_id','=',$id)->orderBy('created_at','desc')->paginate(4);
            
            $interview_question_answers = InterviewQuestionAnswer::where('module_type','=','applicants')->where('module_id','=',$id)->orderBy('created_at','desc')->get();
            
            $interview_question_answers_videos = RecordedVideo::where('module_type','=','applicants')->where('module_id','=',$id)->orderBy('created_at','desc')->get();
            
            $assets = ['applicants', 'real-time','quizzes','slider'];

            return view('applicants.show', [
                'display_name' => $display_name,
                'room_number' => $id,
                'room_type' => 'applicant',
                'applicant' => $applicant,
                'user_info' => $user_info,
                'user_type' => $user_type,
                'user_id' => $user_id,
                'comments' => $comments,
                'statuses' => $statuses,
                'job' => $job,
                'tests' => $tests,
                'tests_tags' => $tests_tags,
                'tests_adjust_tags' => $tests_adjust_tags,
                'test_score_total' => $test_score_total,
                'tests_completed' => $tests_completed,
                'review_result' => $review_result,
                'questions' => $questions,
                'video_questions' => $video_questions,
                'interview_question_answers' => $interview_question_answers,
                'interview_question_answers_videos' => $interview_question_answers_videos,
                'quiz_videos' => $quiz_videos,
                'previous_applicant' => $prevApplicant,
                'next_applicant' => $nextApplicant,
                'rating' => $rating,
                'recorded_videos' => $recorded_videos,
                'videos' => $videos,
                'video_sessions' => $video_sessions,
                'assets' => $assets,
                'count' => 0,
                'module_permissions' => $module_permissions,
                'projects' => $projects]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $applicant = Applicant::find($id);

        return view('forms.editApplicantForm', [
            'applicant' => $applicant
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
        //$applicant_id = $request->input('applicant_id');
        //$company_id = $request->input('company_id');

        $applicant = Applicant::where('id', $id);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            if (file_exists(public_path('assets/user/' . $photo->getClientOriginalName()))) {
                $photo_path = 'assets/user/' . $photo->getClientOriginalName();
            } else {
                $photo_save = $photo->move('assets/user/', $photo->getClientOriginalName());
                $photo_path = $photo_save->getPathname();
            }
        } else {
            $photo_path = Applicant::where('id', $id)->pluck('photo');

            if ($photo_path === '' || $photo_path === NULL) {
                $photo_path = 'assets/user/default-avatar.jpg';
            }
        }

        if ($request->hasFile('resume')) {
            $resume = $request->file('resume');
            if (file_exists(public_path('assets/user/resumes/' . $resume->getClientOriginalName()))) {
                $resume_path = 'assets/user/resumes/' . $resume->getClientOriginalName();
            } else {
                $resume_save = $resume->move('assets/user/resumes', $resume->getClientOriginalName());
                $resume_path = $resume_save->getPathname();
            }
        } else {
            $resume_path = Applicant::where('id', $id)->pluck('resume');
        }
        $post = [];
        if($request->input('name')){
            $post['name'] = $request->input('name');
        }
        if($request->input('email')){
            $post['email'] = $request->input('email');
        }
        if($request->input('phone')){
            $post['phone'] = $request->input('phone');
        }
        if($request->input('skype')){
            $post['skype'] = $request->input('skype');
        }
        if($request->hasFile('resume')){
            $post['photo'] = $photo_path;
        }
        if ($request->hasFile('photo')){
            $post['resume'] = $resume_path;
        }

        $applicant->update($post);

        //$data = array('photo' => $photo_path, 'resume' => $resume_path);
        //return json_encode($data);

        return redirect()->back();
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

    /* Edit Applicant Password Form */

    public function editApplicantPasswordForm(Request $request) {

        $applicant_id = $request->input('applicant_id');

        return view('forms.editApplicantPasswordForm', [
            'applicant_id' => $applicant_id
        ]);
    }

    public function checkApplicantPassword(Request $request) {

        $applicant_id = $request->input('applicant_id');
        $password = $request->input('current_password');

        $applicant = Applicant::where('id', $applicant_id)->first();

        if (Hash::check($password, $applicant->password)) {

            return "true";
        } else {
            return "false";
        }
    }

    public function editApplicantPassword(Request $request) {

        $applicant_id = $request->input('applicant_id');
        $new_password = bcrypt($request->input('new_password'));

        $applicant = Applicant::where('id', $applicant_id);
        $applicant->update([
            'password' => $new_password
        ]);

        return "true";
    }

    // /* Get Applicants */

    // public function getJobApplicants(Request $request, $id) {

    //     $agent = new Agent(array(), $request->header('User-Agent'));

    //     if ($agent->isMobile()) {
    //         $applicants = Applicant::with(['tags' => function ($query) {
    //                         $query->orderBy('created_at', 'desc');
    //                     }])->where('job_id', $id)->orderBy('created_at', 'desc')->get();

    //         return view('templates.show.applicantListMobile', ['applicants' => $applicants, 'count' => 0]);
    //     } else {
    //         $applicants = Applicant::with(['tags' => function ($query) {
    //                         $query->orderBy('created_at', 'desc');
    //                     }])->where('job_id', $id)->orderBy('created_at', 'desc')->paginate(5);

    //         return view('jobs.partials.applicantList', ['applicants' => $applicants, 'count' => 0]);
    //     }
    // }

    // public function getSearchApplicants(Request $request, $term) {

    //     $applicants_with_status = ApplicantTag::get();
    //     $applicant_id_array = [];

    //     $agent = new Agent(array(), $request->header('User-Agent'));

    //     foreach ($applicants_with_status as $applicant) {
    //         $statuses = explode(",", $applicant->tag);
    //         foreach ($statuses as $status) {
    //             if ($status === $term) {
    //                 $applicant_id_array[] = $applicant->applicant_id;
    //             }
    //         }
    //     }

    //     if ($agent->isMobile()) {
    //         $applicants = Applicant::with(['tags' => function ($query) {
    //                         $query->orderBy('created_at', 'desc');
    //                     }])->whereIn('id', $applicant_id_array)->orderBy('created_at', 'desc')->get();

    //         return view('templates.show.applicantListMobile', ['applicants' => $applicants, 'count' => 0]);
    //     } else {
    //         $applicants = Applicant::with(['tags' => function ($query) {
    //                         $query->orderBy('created_at', 'desc');
    //                     }])->whereIn('id', $applicant_id_array)->orderBy('created_at', 'desc')->paginate(5);

    //         $is_mobile = false;
    //         return view('applicants', ['applicants' => $applicants, 'is_mobile' => $is_mobile, 'count' => 0]);
    //     }
    // }

    // public function getApplicants(Request $request, $id) {
    //     $agent = new Agent(array(), $request->header('User-Agent'));

    //     if ($agent->isMobile()) {
    //         $is_mobile = 'true';
    //         $applicants = Applicant::with(['tags' => function ($query) {
    //                         $query->orderBy('created_at', 'desc');
    //                     }])->where('job_id', $id)->orderBy('created_at', 'desc')->get();

    //         return view('templates.show.applicantListMobile', ['applicants' => $applicants, 'count' => 0]);
    //     } else {
    //         $is_mobile = 'false';
    //         $applicants = Applicant::with(['tags' => function ($query) {
    //                         $query->orderBy('created_at', 'desc');
    //                     }])->where('job_id', $id)->orderBy('created_at', 'desc')->paginate(18);

    //         $job = Job::where('id', $id)->first();

    //         return view('applicants', ['applicants' => $applicants, 'job' => $job, 'is_mobile' => $is_mobile, 'count' => 0]);
    //     }
    // }

    // public function getApplicantPosting(Request $request, $id) {
    //     if (Auth::check("user") || Auth::viaRemember("user") || Auth::check("applicant") || Auth::viaRemember("applicant")) {
    //         $applicant = Applicant::where('id', $id)->first();

    //         if ($applicant !== NULL) {

    //             //Get logged in User
    //             if ($request->user() !== NULL) {
    //                 $user_id = $request->user()->id;

    //                 $user_info = User::where('id', $user_id)->with('profile')->first();

    //                 $comments = Comment::with('user', 'profile')->where('applicant_id', $id)->orderBy('id', 'desc')->get();
    //             } else {

    //                 $user_info = Applicant::where('id', $id)->first();

    //                 $comments = Comment::with('applicant')->where('applicant_id', $id)->orderBy('id', 'desc')->get();
    //                 //$comments = Applicant::with('comment')->where('id',$id)->orderBy('id', 'desc')->get();
    //             }


    //             $job = Job::where('id', $applicant->job_id)->first();

    //             $statuses = ApplicantTag::where('applicant_id', $id)->first();

    //             $prevApplicant = Applicant::where('id', '>', $id)->where('job_id', $applicant->job_id)->min('id');
    //             $nextApplicant = Applicant::where('id', '<', $id)->where('job_id', $applicant->job_id)->max('id');

    //             $rating = Rating::where('applicant_id', $id)->first();

    //             $videos = Video::with('video_statuses')->where('applicant_id', $id)->orderBy('id', 'desc')->get();

    //             $agent = new Agent(array(), $request->header('User-Agent'));

    //             if ($agent->isMobile()) {
    //                 $is_mobile = 'true';
    //             } else {
    //                 $is_mobile = 'false';
    //             }
    //             return view('templates.show.applicant', ['applicant' => $applicant, 'user_info' => $user_info, 'comments' => $comments, 'statuses' => $statuses, 'job' => $job, 'previous_applicant' => $prevApplicant, 'next_applicant' => $nextApplicant, 'rating' => $rating, 'videos' => $videos, 'is_mobile' => $is_mobile, 'count' => 0]);
    //         } else {

    //             return redirect()->route('dashboard');
    //         }
    //     } else {
    //         return redirect()->route('dashboard');
    //     }
    // }

    // public function deleteApplicant(Request $request) {
    //     $applicant_id = $request->input('applicant_id');

    //     Applicant::where('id', $applicant_id)->delete();
    //     $message = "Applicant Deleted";
    //     return $message;
    // }

    public function saveApplicantNotes(Request $request) {
        $applicant_id = $request->input('applicant_id');
        $notes = $request->input('notes');

        $applicant = Applicant::where('id', $applicant_id);
        $applicant->update([
            'notes' => $notes
        ]);

        return "true";
    }

    public function saveApplicantCriteria(Request $request) {
        $applicant_id = $request->input('applicant_id');
        $criteria = $request->input('criteria');

        $applicant = Applicant::where('id', $applicant_id);
        $applicant->update([
            'criteria' => $criteria
        ]);

        return "true";
    }

    public function hireApplicant(Request $request) {

        $applicant_id = $request->input('applicant_id');
        $company_id = $request->input('company_id');

        $applicant = Applicant::find($applicant_id);
        $applicant->update([
            'hired' => 'Yes'
        ]);

        //Add the applicant to the user table and set their company to the job posting company_id
        $user = new User();
        $user->password = $applicant->password;
        $user->name = $applicant->name;
        $user->email = $applicant->email;
        $user->phone = $applicant->phone;
        $user->photo = $applicant->photo;
        $user->resume = $applicant->resume;
        $user->address_1 = $applicant->address_1;
        $user->address_2 = $applicant->address_2;
        $user->zipcode = $applicant->zipcode;
        $user->country_id = $applicant->country_id;
        $user->skype = $applicant->skype;
        $user->facebook = $applicant->facebook;
        $user->linkedin = $applicant->linkedin;
        $user->notes = $applicant->notes;
        $user->user_status = 'Active';
        $user->save();

        //Create an index for searching
        $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();
        $params = array();
        $params['body'] = array(
            'name' => $applicant->name
        );
        $params['index'] = 'default';
        $params['type'] = 'employee';
        $params['id'] = $user->user_id;
        $results = $client->index($params);       //using Index() function to inject the data
        
        //Get the level 2 Role in the Role Table
        $role = Role::where('company_id', $company_id)->where('level', 2)->first();

        //Add the user as a level 2 user in the company
        $profile = new Profile();
        $profile->user_id = $user->user_id;
        $profile->company_id = $company_id;
        $profile->role_id = $role->id;
        $profile->save();

        //Attach the role to the user(gets added to role_user table)
        //$user->attachRole($role->id);
        $role_user = new RoleUser();
        $role_user->role_id = $role->id;
        $role_user->user_id = $user->user_id;
        $role_user->save();


        return "true";
    }

    public function fireApplicant(Request $request) {

        $applicant_id = $request->input('applicant_id');
        $company_id = $request->input('company_id');

        $applicant = Applicant::find($applicant_id);
        $applicant->update([
            'hired' => 'No'
        ]);

        //Get their user profile
        $user = User::where('email', $applicant->email)->first();
        $profile = Profile::where('user_id', $user->user_id)->where('company_id', $company_id)->first();

        //Detach the role from the user so they can't login using their user account
        //$user->detachRole($profile->role_id);
        $role_user = RoleUser::where('role_id', $profile->role_id)->where('user_id', $user->user_id)->first();
        $role_user->delete();

        //Remove from being assigned from a team
        $team_member_count = TeamMember::where('user_id', $user->user_id)->count();
        if ($team_member_count > 0) {
            $team = TeamMember::where('user_id', $user->user_id);
            $team->delete();
        }
        //Remove all task permissions for the user
        $task_check_list_permission_count = TaskCheckListPermission::where('user_id', $user->user_id)->count();

        if ($task_check_list_permission_count > 0) {
            $task_check_list_permission = TaskCheckListPermission::where('user_id', $user->user_id);
            $task_check_list_permission->delete();
        }

        //Delete them from the company
        $profile->delete();

        //Finally,delete the applicant's user account
        $user->delete();

        return "true";
    }

    public function getApplicantQuizResults(Request $request) {
        $applicant_id = $request->input('applicant_id');
        $quiz_id = $request->input('quiz_id');

        $questions_total = Question::where('test_id', $quiz_id)->count();

        //Get the total score
        $score = TestResultModel::where('unique_id', $applicant_id)
                        ->where('belongs_to', 'applicant')
                        ->where('test_id', $quiz_id)
                        ->where('result', '1')->count();

        $final_score = $score . ' / ' . $questions_total;

        //Set test as completed by this applicant
        $test_completed = new TestCompleted();
        $test_completed->test_id = $quiz_id;
        $test_completed->unique_id = $applicant_id;
        $test_completed->belongs_to = 'applicant';
        $test_completed->score = $score;
        $test_completed->total_score = $questions_total;
        $test_completed->save();

        //get Test
        $tests = Test::where('id', $quiz_id)->get();

        //Get Questions
        $questions = Question::where('test_id', $quiz_id)
                ->orderBy('order', 'ASC')
                ->get();

        if (count($questions) > 0) {
            foreach ($questions as $v) {
                $v->question_choices = json_decode($v->question_choices);
            }
        }

        //Get Review details
        $results = TestResultModel::where('test_id', $quiz_id)->get();
        $review_result = array();
        if (count($results) > 0) {
            foreach ($results as $v) {
                $review_result[$v->question_id] = (Object) array(
                            'answer' => $v->answer,
                            'result' => $v->result
                );
            }
        }

        $get_completed_test = TestCompleted::where('id', $test_completed->id)
                ->get();

        /* return view('applicants.partials._quizresults', [
          'tests' => $tests,
          'questions' => $questions,
          'review_result' => $review_result,
          'tests_completed' => $get_completed_test
          ]); */
        return $final_score;
    }
    
    public function updateInterviewQuestionScore(Request $request, $id) {
        
        $applicant_id = $request->input('applicant_id');
        
        $video_id = $request->input('video_id');
        
        $score = $request->input('score');
        
        $question = Question::where('id',$id)->first();
        
        $test_result_exists = TestResultModel::where('test_id',$question->test_id)->where('question_id',$question->id)->where('unique_id',$applicant_id)->where('belongs_to','applicant')->exists();
        
        if($test_result_exists) {
            
            $update_test_result = TestResultModel::where('test_id',$question->test_id)->where('question_id',$question->id)->where('unique_id',$applicant_id)->where('belongs_to','applicant')->update([
                'points' => $score
                ]);
            
            
        } else {
            
            $add_test_result = new TestResultModel([
                    'test_id' => $question->test_id,
                    'question_id' => $id,
                    'unique_id' => $applicant_id,
                    'belongs_to' => 'applicant',
                    'answer' => '',
                    'local_record_id' => '',
                    'record_id' => '',
                    'result' => 0,
                    'points' => $score
                ]);
            $add_test_result->save();
        }
        
        
        $update_interview_question_answer = InterviewQuestionAnswer::where('video_id',$video_id)->update([
            'score' => $score
            ]);
        
        return "true";        
    }
    
}
