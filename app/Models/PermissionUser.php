<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    protected $fillable = ['permission_id','user_id','company_id'];

    protected $primaryKey = 'id';
    protected $table = 'permission_user';
    
    public function permission() {
        return $this->belongsTo('App\Models\Permission');
    }
}
