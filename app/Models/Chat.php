<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    	//
    protected $fillable = ['module_type','module_id','display_name','message'];
    protected $table = 'chat';
}
