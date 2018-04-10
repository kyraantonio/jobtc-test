<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['assigned_by','object_from','object_from_id','object_to','object_to_id'];
    protected $table = 'assignments';
}
