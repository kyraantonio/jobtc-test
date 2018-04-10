<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoTag extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'video_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','applicant_id','job_id','video_id','tags'];
    
    public function video() {
        return $this->belongsTo('App\Models\Video','id','video_id');
    }
}
