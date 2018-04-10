<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPersonal extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'test_id',
        'order',
        'version',
        'parent_test_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'test_personal';
}
