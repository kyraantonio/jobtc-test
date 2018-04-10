<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'company_id', 'title', 'description', 'photo', 'notes', 'criteria'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

    public function applicants() {
        return $this->hasMany('App\Models\Applicant');
    }
    
    public function applicant_jobs() {
        return $this->hasMany('App\Models\ApplicantJob');
    }
   
    public function shared_jobs() {
        return $this->hasMany('App\Models\ShareJob');
    }

    public function getApplicantsPaginated() {
        return $this->applicants()->paginate(3,['*'],'Job'.$this->id.'ApplicantPage');
    }

}
