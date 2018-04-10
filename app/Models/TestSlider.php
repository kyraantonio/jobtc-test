<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestSlider extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'job_id',
        'author_id',
        'slider_setting'
    ];
    protected $primaryKey = 'id';
    protected $table = 'test_slider';
}
