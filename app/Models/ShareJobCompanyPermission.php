<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareJobCompanyPermission extends Model {

    public $timestamps = true;
    protected $fillable = [
        'company_id',
        'job_id',
        'user_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'share_jobs_companies_permissions';
    
    public function jobs() {
        return $this->belongsTo('App\Models\Job');
    }

}
