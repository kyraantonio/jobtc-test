<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewQuestionAnswer extends Model
{
    protected $fillable = ['question_id','module_type','module_id','video_id','score'];
     protected $table = 'interview_question_answers';
}
