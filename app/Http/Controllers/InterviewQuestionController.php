<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\InterviewQuestion;
use App\Models\InterviewQuestionAnswer;
use App\Models\Assign;


class InterviewQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //Initially 0 since it's a new entry
        $score = 0;
        $additional_points = 0
        
        $question = $request->input('question');
        $description = $request->input('description');
        $note = $request->input('note');
        $points = $request->input('points');
        $time_limit = $request->input('time_limit');
        
        $interview_question = new InterviewQuestion([
                'question' => $question,
                'description' => $description,
                'note' => $note,
                'score' => $score,
                'points' => $points,
                'additional_points' => $additional_points,
                'time_limit' => $time_limit
            ]);
        $interview_question->save();
        
        return "true";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $question = $request->input('question');
        $description = $request->input('description');
        $note = $request->input('note');
        $score = $request->input('score');
        $points = $request->input('points');
        $additional_points = $request->input('additional_points');
        $time_limit = $request->input('time_limit');
        
        $interview_question = InterviewQuestion::find($id);
        $interview_question->update([
                'question' => $question,
                'description' => $description,
                'note' => $note,
                'score' => $score,
                'points' => $points,
                'additional_points' => $additional_points,
                'time_limit' => $time_limit
            ]);
        
        return "true";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $interview_question = InterviewQuestion::destroy($id);
        
        return "true";
    }
    
    
    public function addInterviewQuestionAnswer(Request $request) {
        
        $question_id = $request->input('question_id');
        $video_id = $request->input('video_id');
        $module_type = $request->input('module_type');
        $module_id = $request->input('module_id');
        $score = $request->input('score');
        
        $interview_question_answer = new InterviewQuestionAnswer([
            'question_id' => $question_id,
            'video_id' => $video_id,
            'module_type' => $module_type,
            'module_id' => $module_id,
            'score' => $score,
            ]);
        $interview_question_answer->save();
        
        return "true";
    }
    
}
