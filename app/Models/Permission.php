<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $fillable = ['name', 'slug','description','model'];
    protected $primaryKey = 'id';
    protected $table = 'permissions';

}
