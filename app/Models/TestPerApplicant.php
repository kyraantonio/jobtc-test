<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPerApplicant extends Model
{
    public $timestamps = true;
    protected $fillable = [
       'test_id',
       'applicant_id' 
    ];
    protected $primaryKey = 'id';
    protected $table = 'test_per_applicant';
    
    public function tests() {
        return $this->hasMany('App\Models\Test');
    }
}
