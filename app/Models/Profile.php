<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id','company_id','role_id'];

    protected $primaryKey = 'id';
    protected $table = 'profiles';
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    public function company() {
        return $this->belongsTo('App\Models\Company')->withTrashed();
    }
    
    public function role() {
        return $this->belongsTo('Bican\Roles\Models\Role');
    }
    
    public function rate() {
        return $this->hasMany('App\Models\Rate');
    }
}
