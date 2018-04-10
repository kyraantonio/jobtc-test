<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPerJob extends Model
{
    public $timestamps = true;
    protected $fillable = [
       'test_id',
       'job_id' 
    ];
    protected $primaryKey = 'id';
    protected $table = 'test_per_job';
    
    public function tests() {
        return $this->hasMany('App\Models\Test');
    }
}
