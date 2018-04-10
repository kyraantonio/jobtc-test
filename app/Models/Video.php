<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['unique_id','user_type','owner_id','owner_type','stream_id','video_type', 'video_url'];
    
    public function video_tags() {
        return $this->hasOne('App\Models\VideoTag');
    }
    
    public function tags() {
        return $this->hasOne('App\Models\Tag','unique_id');
    }
}
