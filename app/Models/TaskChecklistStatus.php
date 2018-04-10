<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskChecklistStatus extends Model
{
      protected $fillable = [
        'task_checklist_id',
        'user_id',
        'status'
    ];

    protected $primaryKey = 'id';
    protected $table = 'task_check_list_status';
    
    public function task_check_lists() {
        return $this->hasMany('App\Models\TaskChecklist');
    }
}
