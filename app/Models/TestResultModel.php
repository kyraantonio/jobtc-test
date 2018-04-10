<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResultModel extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'test_id',
        'question_id',
        'belongs_to',
        'unique_id',
        'answer',
        'record_id',
        'result',
        'points'
    ];
    protected $primaryKey = 'id';
    protected $table = 'test_result';
    
    public function applicant() {
        return $this->hasOne('App\Models\Applicant','unique_id');
    }
    
    public function user() {
        return $this->hasOne('App\Models\User','unique_id');
    }
}
