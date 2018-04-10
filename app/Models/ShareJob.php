<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareJob extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'job_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'share_jobs';
    
    
    public function jobs() {
       return $this->belongsTo('App\Models\Job','id');
    }
}
