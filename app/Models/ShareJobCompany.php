<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareJobCompany extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'company_id',
        'job_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'share_jobs_companies';
    
}
