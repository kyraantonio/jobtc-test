<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantJob extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'applicant_jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['applicant_id', 'job_id','user_id', 'notes', 'criteria', 'hired', 'has_account'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];
}
