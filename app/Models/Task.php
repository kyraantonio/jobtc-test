<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\SoftDeletes;
class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'task_id',
        'project_id',
        'user_id',
        'is_visible',
        'task_title',
        'task_description',
        'due_date',
        'task_status',
        'belongs_to',
        'unique_id'
    ];

    protected $primaryKey = 'task_id';
    protected $table = 'task';
    protected $dates = ['deleted_at'];
    
    public function project() {
        return $this->belongsTo('App\Models\Project');
    }
    
    public function task_list_items(){
        return $this->hasMany('App\Models\TaskChecklist');
    }
    
    public function task_permission(){
        return $this->hasMany('App\Models\TaskCheckListPermission');
    }
    
    

}
