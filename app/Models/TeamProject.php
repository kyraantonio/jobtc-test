<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamProject extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'team_id',
        'project_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'team_project';
    
    public function team() {
        return $this->belongsTo('App\Models\Project');
    }
    
    public function team_member() {
        return $this->hasOne('App\Models\TeamMember');
    }
    
    public function project() {
        return $this->belongsTo('App\Models\Project');
    }
}
