<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamCompany extends Model {

    public $timestamps = true;
    protected $fillable = [
        'team_id',
        'company_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'team_companies';

    public function team() {
        return $this->belongsToMany('App\Models\Team');
    }

    public function team_project() {
        return $this->belongsToMany('App\Models\TeamProject');
    }

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

}
