<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'length',
        'average_score',
        'test_photo',
        'start_message',
        'completion_message',
        'order',
        'completion_image',
        'completion_sound',
        'default_tags',
        'default_points',
        'default_time',
        'default_question_type_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'test';
}
