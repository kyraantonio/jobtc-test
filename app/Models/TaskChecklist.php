<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskChecklist extends Model
{
    //

    protected $fillable = [
        'id',
        'task_id',
        'user_id',
        'checklist_header',
        'checklist',
        'status'
    ];

    protected $primaryKey = 'id';
    protected $table = 'task_check_list';
    
    public function task() {
        return $this->belongsTo('App\Models\Task');
    }
    
    public function timer() {
        return $this->hasMany('App\Models\Timer');
    }
    
    public function task_checklist_statuses() {
        return $this->hasMany('App\Models\TaskChecklistStatus');
    }
}
