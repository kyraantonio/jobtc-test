<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewQuestion extends Model
{
     protected $fillable = ['question','description','note','score','points','additional_points','time_limit'];
     protected $table = 'interview_questions';
}
