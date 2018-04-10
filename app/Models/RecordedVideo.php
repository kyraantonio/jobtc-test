<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordedVideo extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recorded_videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['module_id','module_type','filename','alias','recorded_by','user_id','description','subject_name'];
    
     public function tags() {
        return $this->hasOne('App\Models\Tag','unique_id');
    }
}
