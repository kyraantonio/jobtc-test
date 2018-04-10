<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSession extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'video_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['session_id','unique_id','owner_type','total_time','is_recording'];
    
}
