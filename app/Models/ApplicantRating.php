<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantRating extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'applicant_ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = ['applicant_id','score'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];

     public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
