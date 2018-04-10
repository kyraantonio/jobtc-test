<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTimer extends Model
{
    //
    protected $fillable = ['start_time','end_time','task_id','user_id'];

    protected $primaryKey = 'id';
    protected $table = 'task_timer';
}
