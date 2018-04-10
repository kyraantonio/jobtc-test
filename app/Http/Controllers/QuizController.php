<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\BaseController;
use App\Models\TestPerApplicant;
use App\Models\TestPerJob;
use App\Models\Applicant;
use \View;
use \DB;
use \Validator;
use \Input;
use \Redirect;
use \Auth;
use App\Models\Test;
use App\Models\TestCompleted;
use App\Models\TestPersonal;
use App\Models\TestCommunity;
use App\Models\Question;
use App\Models\TestResultModel;
use App\Models\TestSlider;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Elasticsearch\ClientBuilder as ES;
use PhanAn\Remote\Remote;
use App\Models\Profile;
use App\Models\PermissionUser;

class QuizController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = [
            'assets' => ['input-mask', 'waiting', 'select', 'tags'],
            'page' => 'quiz',
            'test_permissions' => []
        ];
        $this->setData($data);

        return View::make('quiz.default', $data);
    }

    private function setData(&$data, $company_id = '') {
        $t = DB::table('question_type')
            ->select('id', 'type')
            ->get();
        $question_type = array_pluck($t, 'type', 'id');
        $data['question_type'] = $question_type;
        $result = DB::table('test_result')
            ->select(DB::raw(
                'fp_test.id as test_id,
                fp_test.title,
                fp_user.name,
                SUM(
                    IF(
                        fp_test_result.result = 1,
                        IF(
                            fp_question.question_type_id IN (3,4),
                            fp_test_result.points,
                            fp_question.points
                        ),
                        0
                    )
                ) as score,
                SUM(
                    IF(
                        fp_question.question_type_id IN (3,4),
                        fp_question.max_point,
                        fp_question.points
                    )
                ) as total_question'
            ))
            ->groupBy('test_result.unique_id', 'test_result.test_id')
            ->leftJoin('question', 'question.id', '=', 'test_result.question_id')
            ->leftJoin('test', 'test.id', '=', 'test_result.test_id')
            ->leftJoin('user', 'user.user_id', '=', 'test_result.unique_id')
            ->orderBy('test_result.created_at', 'asc')
            ->whereNotNull('user.user_id')
            ->whereNotNull('test.id')
            ->get();
        $data['result'] = $result;

        $testQuery = DB::table('test_personal')
            ->select(DB::raw('
                fp_test.*,
                (
                    SELECT count(fp_test_result.id) > 0
                    FROM fp_test_result
                    WHERE
                        fp_test_result.test_id = fp_test.id AND
                        fp_test_result.unique_id = ' . Auth::user('user')->user_id . '
                ) as review_only,
                fp_test_personal.id as version_id,
                fp_test_personal.version,
                fp_test_personal.order,
                fp_test_personal.parent_test_id,
                fp_user.name
            '))
            ->leftJoin('test', 'test.id', '=', 'test_personal.test_id')
            ->leftJoin('user', 'user.user_id', '=', 'test.user_id')
            ->orderBy('test_personal.order', 'asc')
            ->whereNotNull('test_personal.test_id')
            ->whereNotNull('test.id')
            ->where('test_personal.user_id', '=', Auth::user('user')->user_id);
        if($company_id){
            $testQuery->where('test.company_id', '=', $company_id);
        }
        $test = $testQuery->get();
        if (count($test) > 0) {
            foreach ($test as $t) {
                $t->total_time = 0;
                $questions = DB::table('question')
                    ->where('test_id', '=', $t->id)
                    ->orderBy('order', 'ASC')
                    ->get();
                if (count($questions) > 0) {
                    foreach ($questions as $q) {
                        sscanf($q->length, "%d:%d:%d", $hours, $minutes, $seconds);
                        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                        $t->total_time += $time_seconds;
                        $q->question_choices = json_decode($q->question_choices);
                    }
                }
                $t->question = $questions;

                $score = 0;
                $taker_count = 0;
                if (count($result) > 0) {
                    foreach ($result as $r) {
                        if ($r->test_id == $t->id) {
                            $average = $r->score > 0 ? $r->score / $r->total_question : $r->score;
                            $average *= 100;
                            $average = (float) number_format($average);
                            $score += $average;
                            $taker_count ++;
                        }
                    }
                }
                $t->average = $score > 0 ? number_format($score / $taker_count) : $score;
                $t->average .= '%';
            }
        }
        $data['test'] = $test;

        $data['test_community'] = $this->getTestCommunity([], $result);

        //get shared files
        $file_dir = public_path() . '/assets/shared-files';
        $files = is_dir($file_dir) ? \File::allFiles($file_dir) : array();
        $data['files'] = $files;

        $trigger = isset($_GET['trigger']) ? $_GET['trigger'] : '';
        $data['triggerTest'] = $trigger;

        $data['test_limit'] = 6;

        $this->getTestPermission($data, $company_id);
    }

    private function getTestCommunity($id = [], $result = []){
        $query = DB::table('test_community')
            ->select(DB::raw('
                fp_test.*,
                (
                    SELECT count(fp_test_result.id) > 0
                    FROM fp_test_result
                    WHERE
                        fp_test_result.test_id = fp_test.id AND
                        fp_test_result.unique_id = ' . Auth::user('user')->user_id . '
                ) as review_only,
                fp_test_community.id as version_id,
                fp_test_community.version,
                fp_test_community.order,
                fp_test_community.parent_test_id,
                fp_user.name
            '))
            ->leftJoin('test', 'test.id', '=', 'test_community.test_id')
            ->leftJoin('user', 'user.user_id', '=', 'test.user_id')
            ->orderByRaw('fp_test_community.order = 0')
            ->orderBy('test_community.order', 'asc')
            ->whereNotNull('test_community.test_id')
            ->whereNotNull('test.id');
        if(count($id) > 0){
            $query->whereIn('test_community.id', $id);
        }
        $test_community = $query->get();
        if (count($test_community) > 0) {
            foreach ($test_community as $t) {
                $t->total_time = 0;
                $questions = DB::table('question')
                    ->where('test_id', '=', $t->id)
                    ->orderBy('order', 'ASC')
                    ->get();
                if (count($questions) > 0) {
                    foreach ($questions as $q) {
                        sscanf($q->length, "%d:%d:%d", $hours, $minutes, $seconds);
                        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                        $t->total_time += $time_seconds;
                        $q->question_choices = json_decode($q->question_choices);
                    }
                }
                $t->question = $questions;

                //comment not used for now
                /*$score = 0;
                $taker_count = 0;
                if (count($result) > 0) {
                    foreach ($result as $r) {
                        if ($r->test_id == $t->id) {
                            $average = $r->score > 0 ? $r->score / $r->total_question : $r->score;
                            $average *= 100;
                            $average = (float) number_format($average);
                            $score += $average;
                            $taker_count ++;
                        }
                    }
                }
                $t->average = $score > 0 ? number_format($score / $taker_count) : $score;
                $t->average .= '%';*/
            }
        }
        return $test_community;
    }

    private function getTestPermission(&$data, $company_id){
        $company_id = isset($_GET['company_id']) ? $_GET['company_id'] : $company_id;
        $data['company_id'] = $company_id;

        $user_id = Auth::user('user_id')->user_id;
        $test_permissions = DB::table('permission_user')
            ->leftJoin('permissions', 'permissions.id', '=', 'permission_user.permission_id')
            ->select('permissions.slug')
            ->where('permission_user.company_id', $company_id)
            ->where('permission_user.user_id', $user_id)
            ->whereIn('permissions.description', array('Tests', 'Questions'))
            ->groupBy('permissions.id')
            ->lists('slug');
        $data['test_permissions'] = $test_permissions;
    }

    public function quizPerCompany($id) {
        $data = [
            'assets' => ['input-mask', 'waiting', 'select', 'tags'],
            'page' => 'quiz'
        ];
        $this->setData($data, $id);

        return View::make('quiz.default', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $page = isset($_GET['p']) ? $_GET['p'] : 'test';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $trigger = isset($_GET['trigger']) ? $_GET['trigger'] : 0;

        $test_info = DB::table('test')
            ->where('id', '=', $id)
            ->first();

        $data = [
            'assets' => ['input-mask', 'waiting'],
            'page' => 'edit',
            'test_id' => $id,
            'test_info' => $test_info,
            'trigger' => $trigger
        ];
        $this->setData($data);

        //get shared files
        $file_dir = public_path() . '/assets/shared-files';
        $image_files = \File::allFiles($file_dir . '/image');
        $data['image_files'] = $image_files;
        $sound_files = \File::allFiles($file_dir . '/sound');
        $data['sound_files'] = $sound_files;

        return View::make('quiz.' . $page . '.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $page = isset($_GET['p']) ? $_GET['p'] : 'test';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $trigger = isset($_GET['trigger']) ? $_GET['trigger'] : 0;
        $isStay = isset($_GET['stay']) ? $_GET['stay'] : 0;
        $company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';
        $label = '';
        $video_details = array();

        $validation = '';
        if ($page == "test") {
            $label = 'Test';
            $validation = Validator::make($request->all(), [
                        'title' => 'required',
                        'description' => 'required',
                        'start_message' => 'required',
                        'completion_message' => 'required'
            ]);
        }
        else if ($page == "question") {
            $label = 'Question';
            $required = [
                'question_type_id' => 'required',
                'question' => 'required'
            ];
            if (Input::get('question_type_id') != 3) {
                $required['points'] = 'required';
            }

            $validation = Validator::make($request->all(), $required);
        }
        else if ($page == "exam") {
            $label = 'Exam';
            $validation = Validator::make($request->all(), [
            ]);
        }

        if ($validation->fails()) {
            return Redirect::to('quiz')
                ->withInput()
                ->withErrors($validation->messages());
        }

        DB::beginTransaction();

        try {
            if ($page == "test") {
                $test = new Test();
                $test->user_id = Auth::user()->user_id;
                if($company_id){
                    $test->company_id = $company_id;
                }
                $test->title = Input::get('title');
                $test->description = Input::get('description');
                $test->start_message = Input::get('start_message');
                $test->completion_message = Input::get('completion_message');
                $test->default_time = Input::get('default_time') ? '00:' . Input::get('default_time') : '';
                $test->completion_image = Input::get('completion_image');
                $test->completion_sound = Input::get('completion_sound');
                $test->default_tags = Input::get('default_tags');
                $test->default_points = Input::get('default_points');
                $test->default_question_type_id = Input::get('default_question_type_id');
                $test->save();

                if($test->id) {
                    $personal = new TestPersonal();
                    $personal->user_id = Auth::user()->user_id;
                    $personal->test_id = $test->id;
                    $personal->order = 1;
                    $personal->parent_test_id = $test->id;
                    $personal->save();
                }

                if (Input::file('completion_image_upload')) {
                    $shared_dir = public_path() . '/assets/shared-files/image/';
                    if(!is_dir($shared_dir)){
                        mkdir($shared_dir, 0777, TRUE);
                    }

                    $fileName = Input::file('completion_image_upload')->getClientOriginalName();

                    Input::file('completion_image_upload')->move($shared_dir, $fileName);

                    DB::table('test')
                        ->where('id', '=', $test->id)
                        ->update(['completion_image' => $fileName]);
                }
                if (Input::file('completion_sound_upload')) {
                    $shared_dir = public_path() . '/assets/shared-files/sound/';
                    if(!is_dir($shared_dir)){
                        mkdir($shared_dir, 0777, TRUE);
                    }

                    $fileName = Input::file('completion_sound_upload')->getClientOriginalName();

                    Input::file('completion_sound_upload')->move($shared_dir, $fileName);

                    DB::table('test')
                        ->where('id', '=', $test->id)
                        ->update(['completion_sound' => $fileName]);
                }
                if (Input::file('test_photo')) {
                    $photo_dir = public_path() . '/assets/img/test/';
                    if (!is_dir($photo_dir)) {
                        mkdir($photo_dir, 0777, TRUE);
                    }

                    $extension = Input::file('test_photo')->getClientOriginalExtension();
                    $fileName = $test->id . "." . $extension;

                    Input::file('test_photo')->move($photo_dir, $fileName);

                    DB::table('test')
                            ->where('id', '=', $test->id)
                            ->update(['test_photo' => $fileName]);
                }
            }
            else if ($page == "question") {
                $question = new Question();
                $question->test_id = $id;
                $question->question_type_id = Input::get('question_type_id');
                $question->question = Input::get('question');
                $question->question_choices = Input::has('question_choices') ? json_encode(Input::get('question_choices')) : '[]';
                $question->question_answer = Input::get('question_answer');
                $question->length = Input::get('length') ? '00:' . Input::get('length') : '';
                if(Input::get('points')) {
                    $question->points = Input::get('points');
                }
                $question->explanation = Input::get('explanation');
                if(Input::get('note')) {
                    $question->note = Input::get('note');
                }
                if(Input::get('marking_criteria')) {
                    $question->marking_criteria = Input::get('marking_criteria');
                }
                if(Input::get('max_point')) {
                    $question->max_point = Input::get('max_point');
                }
                if(Input::get('question_tags')) {
                    $question->question_tags = Input::get('question_tags');
                }
                $question->save();

                $file_key = 'question_photo';
                if (Input::file('question_photo')) {
                    $photo_dir = public_path() . '/assets/img/question/';
                    if (!is_dir($photo_dir)) {
                        mkdir($photo_dir, 0777, TRUE);
                    }

                    $extension = Input::file($file_key)->getClientOriginalExtension();
                    $fileName = $question->id . "." . $extension;
                    Input::file('question_photo')->move($photo_dir, $fileName);

                    DB::table('question')
                        ->where('id', '=', $question->id)
                        ->update(['question_photo' => $fileName]);
                }
            }
            else if ($page == "exam") {
                $q = Question::where('id', Input::get('question_id'))
                        ->first();

                $r = in_array($q->question_type_id, array(3,4)) ?
                    (Input::get('result') ? Input::get('result') : 0) :
                    (
                        $q->question_type_id == 1 ?
                        ($q->question_answer == Input::get('answer') ? 1 : 0) :
                        (strtolower($q->question_answer) == strtolower(Input::get('answer')) ? 1 : 0)
                    );

                $unique_id =
                    Input::get('unique_id') ?
                    Input::get('unique_id') :
                    (
                        Auth::check('user') ?
                        Auth::user('user')->user_id :
                        (Auth::check('applicant') ? Auth::user('applicant')->id : '')
                    );

                if(Input::get('video_conference')){
                    $result = new TestResultModel();
                    $result->test_id = $id;
                    $result->question_id = Input::get('question_id');

                    if (Input::get('unique_id')) {
                        $result->unique_id = Input::get('unique_id');
                        $result->belongs_to = 'applicant';
                    }
                    else {
                        if (Auth::check('user')) {
                            $result->unique_id = Auth::user('user')->user_id;
                            $result->belongs_to = 'employee';
                        }
                        if (Auth::check('applicant')) {
                            $result->unique_id = Auth::user('applicant')->id;
                            $result->belongs_to = 'applicant';
                        }
                    }

                    $result->answer = Input::get('answer');
                    if (Input::get('record_id')) {
                        $result->record_id = Input::get('record_id');
                    }
                    if (Input::get('local_record_id')) {
                        $result->local_record_id = Input::get('local_record_id');
                    }
                    if (Input::get('points')) {
                        $result->points = Input::get('points');
                    }
                    $result->result = $r;
                    $result->save();
                    $video_details = $result;
                }
                else {
                    $resultExist = $unique_id ?
                        TestResultModel::where('question_id', Input::get('question_id'))
                            ->where('unique_id', $unique_id)
                            ->count() > 1 : 1;
                    if (!$resultExist) {
                        $result = new TestResultModel();
                        $result->test_id = $id;
                        $result->question_id = Input::get('question_id');

                        if (Input::get('unique_id')) {
                            $result->unique_id = Input::get('unique_id');
                            $result->belongs_to = 'applicant';
                        } else {
                            if (Auth::check('user')) {
                                $result->unique_id = Auth::user('user')->user_id;
                                $result->belongs_to = 'employee';
                            }

                            if (Auth::check('applicant')) {
                                $result->unique_id = Auth::user('applicant')->id;
                                $result->belongs_to = 'applicant';
                            }
                        }

                        $result->answer = Input::get('answer');
                        if (Input::get('record_id')) {
                            $result->record_id = Input::get('record_id');
                        }
                        if (Input::get('points')) {
                            $result->points = Input::get('points');
                        }
                        $result->result = $r;
                        $result->save();
                    }
                }
            }

            DB::commit();

            if ($page == "exam") {
                if(Input::get('video_conference')){
                    return $video_details;
                }
            }

            $url = $company_id ?
                'quizPerCompany/' . $company_id . ($trigger ? '?trigger=' . $id : '') :
                'quiz' . ($trigger ? '?trigger=' . $id : '');
            return Redirect::to($url)
                ->withSuccess($label . " added successfully!");
        } catch (\Exception $e) {
            DB::rollback();

            return Redirect::to('quiz')
                ->withErrors($label . " failure when adding!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $page = isset($_GET['p']) ? $_GET['p'] : 'view';

        //region if already taken the exam redirect to review page
        if (Auth::check('user')) {
            $taken_question = DB::table('test_result')
                ->where('test_id', '=', $id)
                ->where('unique_id', '=', Auth::user('user')->user_id)
                ->where('belongs_to','employee')
                ->count();
        }
        
        if (Auth::check('applicant')) {
            $taken_question = DB::table('test_result')
                ->where('test_id', '=', $id)
                ->where('unique_id', '=', Auth::user('applicant')->id)
                ->where('belongs_to','applicant')
                ->count();
        }

        $total_question = DB::table('question')
            ->where('test_id', '=', $id)
            ->count();
        $hasTaken = $taken_question == $total_question;
        if ($hasTaken && $page != 'review') {
            return Redirect::to('quiz/' . $id . '?p=review');
        }
        //endregion

        $data = [
            'assets' => ['slider', 'waiting'],
            'page' => $page
        ];
        $this->setData($data);

        $tests_info = DB::table('test')
            ->where('id', '=', $id)
            ->first();
        $questions_info = array();
        if ($page == 'review') {
            $questions_info = DB::table('question')
                ->select(DB::raw(
                    'fp_question.*,
                    fp_test_result.id as result_id,
                    fp_test_result.answer as result_answer,
                    fp_test_result.result,
                    fp_test_result.record_id,
                    fp_test_result.points as result_points'
                ))
                ->leftJoin('test_result', 'test_result.question_id', '=', 'question.id')
                ->where('test_result.test_id', '=', $id)
                ->where('test_result.unique_id', '=', Auth::user()->user_id)
                ->whereNotNull('question.id')
                ->orderBy('question.order', 'ASC')
                ->get();
        }
        else {
            $questions_info = DB::table('question')
                ->where('test_id', '=', $id)
                ->whereRaw('
                    (
                        SELECT count(fp_test_result.id)
                        FROM fp_test_result
                        WHERE
                            fp_test_result.question_id = fp_question.id AND
                            fp_test_result.unique_id = ' . Auth::user()->user_id . '
                    ) = 0
                ')
                ->orderBy('order', 'ASC')
                ->get();
        }

        $tests_info->tags_array = $tests_info->default_tags ?
            explode(',', $tests_info->default_tags) : array();
        if (count($questions_info) > 0) {
            foreach ($questions_info as $v) {
                $v->question_choices = json_decode($v->question_choices);
            }
        }
        $data['tests_info'] = $tests_info;
        $data['questions_info'] = $questions_info;

        $view = isset($_GET['mini']) ? 'quiz.mini' : 'quiz.default';
        return View::make($view, $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $page = isset($_GET['p']) ? $_GET['p'] : 'test';
        $data = [
            'assets' => ['input-mask', 'waiting'],
            'page' => 'edit'
        ];
        $this->setData($data);

        //get shared files
        $file_dir = public_path() . '/assets/shared-files';
        $image_files = \File::allFiles($file_dir . '/image');
        $data['image_files'] = $image_files;
        $sound_files = \File::allFiles($file_dir . '/sound');
        $data['sound_files'] = $sound_files;

        if($page == "test") {
            $tests_info = DB::table('test')
                    ->where('id', '=', $id)
                    ->first();
            $data['tests_info'] = $tests_info;
        } else {
            $questions_info = DB::table('question')
                    ->where('id', '=', $id)
                    ->first();
            $data['questions_info'] = $questions_info;
        }

        return View::make('quiz.' . $page . '.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $page = isset($_GET['p']) ? $_GET['p'] : 'test';
        $company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';

        $validation = '';
        if ($page == "test") {
            $validation = Validator::make($request->all(), [
                        'title' => 'required',
                        'description' => 'required',
                        'start_message' => 'required',
                        'completion_message' => 'required'
            ]);
        }
        else if($page == "question"){
            $validation = Validator::make($request->all(), [
                'question_type_id' => 'required',
                'question' => 'required'
            ]);
            if(Input::get('question_type_id') != 3){
                $required['points'] = 'required';
            }
        }
        else if($page == "exam") {
            $validation = Validator::make($request->all(), [
            ]);
        }
        if ($validation->fails()) {
            return Redirect::to('quiz')
                ->withInput()
                ->withErrors($validation->messages());
        }

        DB::beginTransaction();

        try {
            if ($page == "test") {
                $test = Test::find($id);
                if($company_id){
                    $test->company_id = $company_id;
                }
                $test->title = Input::get('title');
                $test->description = Input::get('description');
                $test->start_message = Input::get('start_message');
                $test->completion_message = Input::get('completion_message');
                $test->default_time = Input::get('default_time') ? '00:' . Input::get('default_time') : '';
                $test->completion_image = Input::get('completion_image');
                $test->completion_sound = Input::get('completion_sound');
                $test->default_tags = Input::get('default_tags');
                $test->default_points = Input::get('default_points');
                $test->default_question_type_id = Input::get('default_question_type_id');
                $test->save();

                //update to elastic search
                $community = TestCommunity::where('test_id', '=', $test->id)->get();
                if(count($community) > 0){
                    foreach($community as $v){
                        $community = (Object)$test->getOriginal();
                        $community->author_id = $community->user_id;
                        unset($community->id);
                        unset($community->user_id);
                        unset($community->version);
                        unset($community->created_at);
                        unset($community->updated_at);
                        unset($community->order);
                        $this->quizElasticSearch($v->id, 2, (array)$community);
                    }
                }

                if (Input::file('completion_image_upload')) {
                    $shared_dir = public_path() . '/assets/shared-files/image/';
                    if(!is_dir($shared_dir)){
                        mkdir($shared_dir, 0777, TRUE);
                    }

                    $fileName = Input::file('completion_image_upload')->getClientOriginalName();

                    Input::file('completion_image_upload')->move($shared_dir, $fileName);

                    DB::table('test')
                        ->where('id', '=', $test->id)
                        ->update(['completion_image' => $fileName]);
                }
                if (Input::file('completion_sound_upload')) {
                    $shared_dir = public_path() . '/assets/shared-files/sound/';
                    if(!is_dir($shared_dir)){
                        mkdir($shared_dir, 0777, TRUE);
                    }

                    $fileName = Input::file('completion_sound_upload')->getClientOriginalName();

                    Input::file('completion_sound_upload')->move($shared_dir, $fileName);

                    DB::table('test')
                        ->where('id', '=', $test->id)
                        ->update(['completion_sound' => $fileName]);
                }
                if (Input::file('test_photo')) {
                    $photo_dir = public_path() . '/assets/img/test/';
                    if (!is_dir($photo_dir)) {
                        mkdir($photo_dir, 0777, TRUE);
                    }

                    $extension = Input::file('test_photo')->getClientOriginalExtension();
                    $fileName = $test->id . "." . $extension;
                    Input::file('test_photo')->move($photo_dir, $fileName);

                    DB::table('test')
                            ->where('id', '=', $test->id)
                            ->update(['test_photo' => $fileName]);
                }
            }
            else if($page == "question"){
                $question = Question::find($id);
                $question->question_type_id = Input::get('question_type_id');
                $question->question = Input::get('question');
                $question->question_choices = Input::has('question_choices') ? json_encode(Input::get('question_choices')) : '[]';
                $question->question_answer = Input::get('question_answer');
                $question->length = Input::get('length') ? '00:' . Input::get('length') : '';
                if(Input::get('points')) {
                    $question->points = Input::get('points');
                }
                $question->explanation = Input::get('explanation');
                if(Input::get('note')) {
                    $question->note = Input::get('note');
                }
                if(Input::get('marking_criteria')) {
                    $question->marking_criteria = Input::get('marking_criteria');
                }
                if(Input::get('max_point')) {
                    $question->max_point = Input::get('max_point');
                }
                if (Input::get('clear_photo')) {
                    $photo_dir = public_path() . '/assets/img/question/';
                    $photo_dir .= $question->question_photo;
                    if (file_exists($photo_dir)) {
                        unlink($photo_dir);
                        $question->question_photo = '';
                    }
                }
                $question->save();

                $file_key = 'question_photo';
                if (Input::file('question_photo')) {
                    $photo_dir = public_path() . '/assets/img/question/';
                    if (!is_dir($photo_dir)) {
                        mkdir($photo_dir, 0777, TRUE);
                    }

                    $extension = Input::file($file_key)->getClientOriginalExtension();
                    $fileName = $question->id . "." . $extension;
                    Input::file('question_photo')->move($photo_dir, $fileName);

                    DB::table('question')
                            ->where('id', '=', $id)
                            ->update(['question_photo' => $fileName]);
                }
            }
            else if($page == "exam") {
                $result = TestResultModel::find($id);
                $result->result = 1;
                $result->points = Input::get('points');
                $result->save();
            }

            DB::commit();

            if($page == "exam"){
                return 1;
            }
            $url = $company_id ?
                'quizPerCompany/' . $company_id :
                'quiz';
            return Redirect::to($url)
                ->withSuccess(($page == "test" ? "Test" : "Question") . " updated successfully!");
        }
        catch (\Exception $e) {
            DB::rollback();

            if($page == "exam"){
                return 1;
            }
            return Redirect::to('quiz')
                ->withErrors(($page == "test" ? "Test" : "Question") . " failure when adding!");
        }
    }

    /**
     * Update test sort the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function testSort(Request $request) {
        $validation = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required'
        ]);
        if ($validation->fails()) {
            echo 0;
        }

        if (count(Input::get('id')) > 0) {
            $order = 1;
            foreach (Input::get('id') as $id) {
                if(Input::get('type') == 1) {
                    $test = TestPersonal::find($id);
                    $test->order = $order;
                    $test->save();
                }
                else if(Input::get('type') == 2) {
                    $test = TestCommunity::find($id);
                    $test->order = $order;
                    $test->save();

                    //update to elastic search
                    $this->quizElasticSearch($id, 2, [
                        'order' => $order
                    ]);
                }

                $order ++;
            }
        }
    }

    /**
     * Update question sort the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function questionSort(Request $request) {
        $validation = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validation->fails()) {
            echo 0;
        }

        if (count(Input::get('id')) > 0) {
            $order = 1;
            foreach (Input::get('id') as $id) {
                $test = Question::find($id);
                $test->order = $order;
                $test->save();

                $order ++;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $t = isset($_GET['t']) ? $_GET['t'] : 1;
        if ($t == 1) {
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $table = $type == 2 ? 'test_community' : 'test_personal';
            DB::table($table)
                ->where('id', '=', $id)
                ->delete();

            if($type == 2) {
                //delete to elastic search
                $this->quizElasticSearch($id, 3);
            }
        }
        else if ($t == 2) {
            DB::table('question')
                ->where('id', '=', $id)
                ->delete();
        }
        else if ($t == 3) {
            $file = isset($_GET['f']) ? $_GET['f'] : '';
            if($file) {
                DB::table('test')
                    ->where('completion_image', '=', $file)
                    ->update(['completion_image' => '']);
                unlink(public_path() . '/assets/shared-files/image/' . $file);
            }
        }
        else if ($t == 4) {
            $file = isset($_GET['f']) ? $_GET['f'] : '';
            if($file) {
                DB::table('test')
                    ->where('completion_sound', '=', $file)
                    ->update(['completion_sound' => '']);
                unlink(public_path() . '/assets/shared-files/sound/' . $file);
            }
        }
    }

    //User Slider Area
    public function userSlider(Request $request, $id){
        $user = DB::table('test_result')
            ->select(DB::raw('
                fp_user.user_id,
                fp_user.name,
                fp_user.photo,
                fp_test.default_tags,
                MIN(fp_test_result.id) as min_id,
                SUM(
                    iF(
                        fp_test_result.result = 1,
                        IF(
                            fp_question.question_type_id IN (3,4),
                            fp_test_result.points,
                            fp_question.points
                        ),
                        0
                    )
                ) as total_score,
                SUM(IF(fp_question.question_type_id IN (3,4), fp_question.max_point, fp_question.points)) as total_points
            '))
            ->groupBy('test_result.unique_id')
            ->leftJoin('test', 'test.id', '=', 'test_result.test_id')
            ->leftJoin('question', 'question.id', '=', 'test_result.question_id')
            ->leftJoin('user', 'user.user_id', '=', 'test_result.unique_id')
            ->whereNotNull('user.user_id')
            ->where('test_result.test_id', '=', $id)
            ->orderBy('min_id', 'DESC')
            ->get();

        if(count($user) > 0){
            foreach($user as $v){
                $v->points_tags_total = 0;

                $tags_array = $v->default_tags ? explode(',', $v->default_tags) : array();
                if(count($tags_array) > 0){
                    foreach($tags_array as $t){
                        $v->tags[$t] = 0;
                    }
                }
                $v->tags[''] = 0; //general tag

                $result = DB::table('test_result')
                    ->select(DB::raw('
                        IF(fp_question.question_type_id IN (3,4), fp_test_result.points, fp_question.points) as points,
                        fp_question.question_tags
                    '))
                    ->leftJoin('question', 'question.id', '=', 'test_result.question_id')
                    ->where('unique_id', '=', $v->user_id)
                    ->where('result', '=', 1)
                    ->get();
                if(count($result) > 0){
                    foreach($result as $r){
                        $question_tags = $r->question_tags ? explode(',', $r->question_tags) : array();
                        if(count($question_tags) > 0){
                            foreach($question_tags as $t){
                                $v->tags[$t] += $r->points;
                                $v->points_tags_total += $r->points;
                            }
                        }
                        else{
                            $v->tags[''] += 1; //general tag if not tag
                            $v->points_tags_total += $r->points;
                        }
                    }
                }
            }
        }

        //sort according to total tag points
        $this->arraySort($user, 'points_tags_total', false);

        $data['user'] = $user;

        $data['progressColor'] = array('success', 'info', 'warning', 'danger');

        return View::make('quiz.sliderUsers', $data);
    }
    private function arraySort(&$array, $key, $isAsc = true){
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii=>$va) {
            $sorter[$ii] = $va->$key;
        }

        if($isAsc){
            uasort($sorter, array($this, 'arraySortCompareAsc'));
        }
        else{
            uasort($sorter, array($this, 'arraySortCompareDesc'));
        }

        foreach ($sorter as $ii=>$va) {
            $ret[] = $array[$ii];
        }

        $array = $ret;
    }
    private function arraySortCompareAsc($a, $b){
        return $a == $b ? 0 : ($a < $b ? -1 : 1);
    }
    private function arraySortCompareDesc($a, $b){
        return $a == $b ? 0 : ($a > $b ? -1 : 1);
    }

    public function quizRanking($id){
        $total_score = DB::table('question')
            ->select(DB::raw('SUM(
                IF(
                    fp_question.question_type_id IN (3,4),
                    fp_question.max_point,
                    fp_question.points
                )
            ) as total_points'))
            ->where('question.test_id', '=', $id)
            ->pluck('total_points');
        $result = DB::table('question')
            ->select(DB::raw('
                fp_user.name,
                SUM(
                    IF(
                        fp_question.question_type_id IN (3,4),
                        fp_question.max_point,
                        fp_question.points
                    )
                ) as score
            '))
            ->leftJoin('test_result', 'test_result.question_id', '=', 'question.id')
            ->leftJoin('user', 'user.user_id', '=', 'test_result.unique_id')
            ->where('question.test_id', '=', $id)
            ->whereNotNull('user.user_id')
            ->groupBy('test_result.unique_id')
            ->orderBy('score', 'desc')
            ->get();

        $data['total_score'] = $total_score;
        $data['result'] = $result;

        return View::make('quiz.ranking', $data);
    }

    public function quizAddPersonalCommunity(Request $request){
        $validation = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required'
        ]);
        if ($validation->fails()) {
            echo 0;
        }

        $table = Input::get('type') == 1 ? 'test_personal' : 'test_community';
        $thisTest = DB::table($table)
            ->where('user_id', '=', Auth::user()->user_id)
            ->where('parent_test_id', '=', Input::get('parent_test_id'))
            ->orderBy('version', 'DESC')
            ->first();

        //update order of other test before insert
        DB::table($table)
            ->where('order', '>=', Input::get('order'))
            ->increment('order');

        $test_id = Input::get('id');

        //copy as new test
        $question_new = array();
        if(Input::get('type') == 1){
            $personal = Test::find(Input::get('id'));
            $newPersonal = $personal->replicate();
            $newPersonal->user_id = Auth::user()->user_id;
            if(Input::get('company_id')){
                $newPersonal->company_id = Input::get('company_id');
            }
            $newPersonal->save();
            $test_id = $newPersonal->id;

            $question = Question::where('test_id', '=', Input::get('id'))
                ->get();
            if(count($question) > 0){
                foreach($question as $q){
                    $newQuestion = $q->replicate();
                    $newQuestion->test_id = $test_id;
                    $newQuestion->save();

                    $question_new[$q->id] = $newQuestion->id;
                }
            }
        }

        $test = Input::get('type') == 1 ? new TestPersonal() : new TestCommunity();
        $test->user_id = Auth::user()->user_id;
        $test->test_id = $test_id;
        $test->version = $thisTest ? $thisTest->version + 1 : 1;
        $test->order = Input::get('order') ? Input::get('order') : 1;
        $test->parent_test_id = Input::get('parent_test_id');
        $test->save();

        if(Input::get('type') == 2){
            //index to elastic search
            $community = $test->getOriginal();
            $community += $test->test->getOriginal();
            $community = (Object)$community;
            $this->quizElasticSearch($test->id, 1, $community);
        }

        $info = (object)array(
            'version_id' => $test->id,
            'version' => $test->version,
            'order' => $test->order,
            'question' => $question_new
        );
        header("Content-type: application/json");
        return response()->json($info);
    }

    public function quizSearch(Request $request){
        $validation = Validator::make($request->all(), [
            'search' => 'required'
        ]);

        $r = array();
        if ($validation->fails()) {
            $r = $this->getTestCommunity();
        }
        else {
            $ids = [];
            $search = Input::get('search');
            $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();

            $body = [
                "sort" => [
                    ["order" => ["order" => "asc"]],
                    ["id" => ["order" => "asc"]]
                ]
            ];

            $matches = [
                ['match' => ['title' => $search]]
            ];
            preg_match('!\d+!', $search, $m);
            $version = array_key_exists(0, $m) ? $m[0] : '';
            if ($version) {
                $matches[] = ['match' => ['version' => $version]];
            }

            $body['query'] = [
                'bool' => [
                    'must' => $matches
                ]
            ];

            //get data
            $params = [
                'index' => 'default',
                'type' => 'test',
                'client' => [
                    'ignore' => 404
                ],
                "fields" => "",
                'body' => $body
            ];
            $s = $client->search($params);
            $m = $s['hits']['hits'];

            if (count($m) > 0) {
                foreach ($m as $t) {
                    $ids[] = $t['_id'];
                }
                $r = $this->getTestCommunity($ids);
            }
        }

        $data = [
            'test_community' => $r,
            'test_limit' => 6
        ];
        $company_id = Input::get('company_id') ? Input::get('company_id') : '';
        $this->getTestPermission($data, $company_id);

        return View::make('quiz.community', $data);
    }
    public function quizElasticSearchView(){
        $client = ES::create()
            ->setHosts(\Config::get('elasticsearch.host'))
            ->build();

        $body = [
            "sort" => [
                ["order" => ["order" => "asc"]],
                ["id" => ["order" => "asc"]]
            ]
        ];

        $search = '';
        $body= [];
        if($search) {
            $matches = [
                ['match' => ['title' => $search]]
            ];
            preg_match('!\d+!', $search, $m);
            $version = array_key_exists(0, $m) ? $m[0] : '';
            if ($version) {
                $matches[] = ['match' => ['version' => $version]];
            }

            $body['query'] = [
                'bool' => [
                    'must' => $matches
                ]
            ];
        }

        //get data
        $params = [
            'index' => 'default',
            'type' => 'test',
            'client' => [
                'ignore' => 404
            ],
            'body' => $body
        ];
        $s = $client->search($params);

        //delete
        if(isset($_GET['d'])) {
            $hits = $s['hits']['hits'];
            if (count($hits) > 0) {
                foreach($hits as $v){
                    $this->quizElasticSearch($v['_id'], 3);
                }
            }
        }
        else if(isset($_GET['i'])){
            $test = TestCommunity::find($_GET['i']);
            //index to elastic search
            $community = $test->getOriginal();
            $community += $test->test->getOriginal();
            $community = (Object)$community;
            $this->quizElasticSearch($test->id, 1, $community);
        }
        else {
            echo '<pre>';
            print_r($s);
        }
    }
    private function quizElasticSearch($id, $type = 1, $body = []){
        //1 = insert
        //2 = update
        //3 = delete
        if($id) {
            $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();
            $params = [
                'index' => 'default',
                'type' => 'test',
                'id' => $id
            ];
            if($type == 1){
                $params['body'] = $body;
                $client->index($params);
            }
            else if($type == 2){
                $params['body']['doc'] = $body;
                $client->update($params);
            }
            else if($type == 3){
                $client->delete($params);
            }
        }
    }

    public function quizAssessment($id){
        $data = [];

        //get all test Per Job and  Per Applicants
        $test_id = $this->quizGetTestIds($data,$id);

        $data['job_id'] = $id;

        return View::make('quiz.assessment', $data);
    }
    public function quizSliderSave(Request $request){
        $validation = Validator::make($request->all(), [
            'job_id' => 'required',
            'slider_setting' => 'required'
        ]);

        if (!$validation->fails()) {
            try {
                $slide_id = DB::table('test_slider')
                    ->where('job_id', '=', Input::get('job_id'))
                    ->pluck('id');
                $slider = new TestSlider();
                if ($slide_id) {
                    $slider = TestSlider::find($slide_id);
                }

                $slider->job_id = Input::get('job_id');
                $slider->author_id = Auth::user()->user_id;
                $slider->slider_setting = json_encode(Input::get('slider_setting'));
                $slider->save();
            }
            catch (\Exception $e) {
                print_r($e);
            }
        }
        else{
            echo 'error';
        }
    }
    public function quizUserAssessment($id){
        $data = [];

        //get all test Per Job and  Per Applicants
        $test_id = $this->quizGetTestIds($data, $id);

        $user = DB::table('applicants')
            ->select(DB::raw('
                fp_applicants.id as user_id,
                fp_applicants.name
            '))
            ->where('applicants.job_id', $id)
            ->get();
        if(count($user) > 0) {
            foreach ($user as $v) {
                $test = DB::table('test')
                    ->leftJoin('question', 'question.test_id', '=', 'test.id')
                    ->leftJoin('test_result', function($join){
                        $join->on('test_result.test_id', '=', 'test.id')
                            ->on('test_result.question_id', '=', 'question.id');
                    })
                    ->select(DB::raw('
                        IF(fp_test.default_tags != "", LOWER(fp_test.default_tags), "general") as default_tags,
                        SUM(
                            IF(
                                fp_test_result.result = 1,
                                IF(fp_question.question_type_id IN (3,4), fp_test_result.points, fp_question.points),
                                0
                            )
                        ) as score,
                        SUM(
                            IF(fp_question.question_type_id IN (3,4), fp_question.max_point, fp_question.points)
                        ) as total
                    '))
                    ->where('test_result.unique_id', '=', $v->user_id)
                    ->whereIn('test.id', $test_id)
                    ->whereNotNull('test.id')
                    ->groupBy('default_tags')
                    ->get();
                $v->points_tags_total = 0;
                $v->test_total = 0;
                $v->average_total = 0;
                $v->test = array();
                $count = count($test);
                if($count > 0) {
                    foreach($test as $t){
                        $thisTag = $t->default_tags;
                        $thisPercentage = array_key_exists($thisTag, $data['slide_setting']) ?
                            $data['slide_setting']->$thisTag : 0;
                        $thisScore = $t->score + ($t->score * $thisPercentage/100);
                        $thisTotal = $thisScore > $t->total ? $thisScore : $t->total;
                        $v->test[$thisTag] = $t;
                        $v->points_tags_total += $thisScore;
                        $v->test_total += $t->total;
                    }

                    $v->average_total = number_format($v->points_tags_total/$v->test_total, 4) * 100;
                }
            }

            //sort according to total tag points
            $this->arraySort($user, 'average_total', false);
        }
        $data['user'] = $user;

        $data['progressColor'] = array('success', 'info', 'warning', 'danger');

        return View::make('quiz.assessmentSlider', $data);
    }
    private function quizGetTestIds(&$data, $id){
        $test_jobs_id = DB::table('test_per_job')
            ->where('job_id', $id)
            ->lists('test_id');
        $test_applicants_id = DB::table('test_per_applicant')
            ->leftJoin('applicants', 'applicants.id', '=', 'test_per_applicant.applicant_id')
            ->where('job_id', $id)
            ->lists('test_id');
        $test_id = array_unique(array_merge($test_jobs_id, $test_applicants_id));

        //get tags
        $tags = DB::table('test')
            ->select(DB::raw('LOWER(fp_test.default_tags) default_tags'))
            ->whereIn('test.id', $test_id)
            ->where('test.default_tags', '!=' , '')
            ->groupBy('default_tags')
            ->orderBy('default_tags')
            ->lists('default_tags');
        $test_tags = array_merge(['general'], $tags);
        $data['test_tags'] = array_unique($test_tags);

        //get slider default setting
        $slide_setting = DB::table('test_slider')
            ->where('job_id', '=', $id)
            ->pluck('slider_setting');
        $slide_setting = $slide_setting ? json_decode($slide_setting) : (Object)array();
        $data['slide_setting'] = $slide_setting;

        //get max points per test
        $max_points_per_test = DB::table('test')
            ->leftJoin('question', 'question.test_id', '=', 'test.id')
            ->select(DB::raw('
                IF(fp_test.default_tags != "", LOWER(fp_test.default_tags), "general") as default_tags,
                SUM(
                    IF(fp_question.question_type_id IN (3,4), fp_question.max_point, fp_question.points)
                ) as max_points
            '))
            ->whereIn('test.id', $test_id)
            ->whereNotNull('test.id')
            ->groupBy('default_tags')
            ->lists('max_points', 'default_tags');
        $data['max_points_per_test'] = $max_points_per_test;

        return $test_id;
    }

    public function quizVideo(){
        $data = [
            'assets' => ['janus']
        ];

        return View::make('quiz.video', $data);
    }
    public function quizSaveVideo(Request $request) {
        $stream_id = $request->input('stream_id');
        $media_server = "laravel.software";

        //Connect to the media server
        $remote_connection = new Remote([
            'host' => $media_server,
            'port' => 22,
            'username' => 'root',
            'password' => '(radio5)',
        ]);

        $convert_to_webm_command = 'ffmpeg -y -i /var/www/recordings/' . $stream_id . '.mkv -c:v copy -crf 10 -b:v 0 -c:a libvorbis /var/www/recordings/' . $stream_id . '.webm';
        //Run the mkv file in ffmpeg to repair it(Since erizo makes an invalid mkv file for the html5 video tag)
        $remote_connection->exec($convert_to_webm_command);
    }
    public function quizDeleteVideo($id) {
        $media_server = "laravel.software";

        //Connect to the media server
        $remote_connection = new Remote([
            'host' => $media_server,
            'port' => 22,
            'username' => 'root',
            'password' => '(radio5)',
        ]);

        //delete mkv
        $delete_steam = 'rm -rf /var/www/recordings/' . $id . '.mkv';
        $remote_connection->exec($delete_steam);

        //delete webm
        $delete_steam = 'rm -rf /var/www/recordings/' . $id . '.webm';
        $remote_connection->exec($delete_steam);
    }

    public function quizDeleteResult(Request $request){
        try{
            if($request->input('result_id')) {
                $r = TestResultModel::find($request->input('result_id'));
                if ($r->record_id) {
                    $this->quizDeleteVideo($r->record_id);
                }
                if ($r->local_record_id) {
                    $this->quizDeleteVideo($r->local_record_id);
                }
                $r->delete();
            }
        }
        catch (\Exception $e) {
            print_r($e);
        }
    }
}
