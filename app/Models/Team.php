<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'project_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'team';
    
    public function team_member() {
        return $this->hasMany('App\Models\TeamMember');
    }
    
    public function team_project() {
        return $this->hasMany('App\Models\TeamProject');
    }
}
