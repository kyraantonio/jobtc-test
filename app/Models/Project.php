<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Project extends Model
{
    Use SoftDeletes;
    protected $fillable = ['company_id',
                           'user_id',
                           'ref_no', 
                           'project_title', 
                           'start_date', 
                           'deadline', 
                           'project_description', 
                           'rate_type', 
                           'rate_value', 
                           'project_progress'];

    protected $primaryKey = 'project_id';
    protected $table = 'project';
    protected $dates = ['deleted_at'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    public function company() {
        return $this->belongsTo('App\Models\Company');
    }
    
    public function task() {
        return $this->hasMany('App\Models\Task');
    }
    
    public function task_permission() {
        return $this->hasMany('App\Models\TaskCheckListPermission');
    }
    
    public function team_member() {
        return $this->HasMany('App\Models\TeamMember','user_id');
    }
    
    public function team_project() {
        return $this->HasMany('App\Models\TeamProject','project_id');
    }
}
