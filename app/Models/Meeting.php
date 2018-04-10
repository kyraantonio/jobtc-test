<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'project_id',
        'user_id',
        'start_date',
        'end_date',
        'type_id',
        'description',
        'estimated_length',
        'priority_id',
        'attendees',
        'meeting_url'
    ];
    protected $primaryKey = 'id';
    protected $table = 'meeting';
}
