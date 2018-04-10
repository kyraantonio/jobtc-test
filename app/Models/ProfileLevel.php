<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileLevel extends Model
{
    protected $fillable = ['profile_id','profile_level','unique_id'];

    protected $primaryKey = 'id';
    protected $table = 'profile_levels';
    
}
