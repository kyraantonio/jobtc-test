<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'test_id',
        'question_type_id',
        'question',
        'question_choices',
        'question_answer',
        'length',
        'question_photo',
        'score',
        'order',
        'points',
        'explanation',
        'marking_criteria',
        'max_point',
        'question_tags'
    ];
    protected $primaryKey = 'id';
    protected $table = 'question';
}
