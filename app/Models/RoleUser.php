<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
     protected $fillable = ['role_id','user_id'];

    protected $primaryKey = 'id';
    protected $table = 'role_user';
    
    public function role() {
        return $this->belongsTo('App\Models\Role');
    }
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
}
