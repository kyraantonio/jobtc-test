<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    //
    protected $fillable = ['comment','task_id','user_id'];

    protected $primaryKey = 'id';
    protected $table = 'task_comment';
}
