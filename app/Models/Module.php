<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
     protected $fillable = ['name'];

    protected $primaryKey = 'id';
    protected $table = 'modules';
    
}
