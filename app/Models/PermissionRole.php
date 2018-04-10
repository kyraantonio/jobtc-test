<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $fillable = ['permission_id','role_id','company_id'];

    protected $primaryKey = 'id';
    protected $table = 'permission_role';
    
    public function permission() {
        return $this->belongsTo('App\Models\Permission');
    }
}

