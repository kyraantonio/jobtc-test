<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'team_id',
        'user_id',
        'company_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'team_member';
    
    public function team() {
        return $this->belongsToMany('App\Models\Team');
    }
    
    public function team_project() {
        return $this->belongsToMany('App\Models\TeamProject');
    }
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
}
