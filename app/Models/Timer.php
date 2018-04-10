<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{

    protected $fillable = ['timer_id', 'user_id','project_id','task_id', 'task_checklist_id', 'start_time', 'end_time','total_time','timer_status'];

    protected $primaryKey = 'timer_id';
    protected $table = 'timer';
    
     public function task_checklist() {
        return $this->belongsTo('App\Models\TaskChecklist');
    }
    
    public function setTotalTimeAttribute($value) {
        $this->attributes['total_time'] = strtotime($value);
    }
    
}
