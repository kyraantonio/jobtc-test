<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinksOrder extends Model
{
    //
    protected $fillable = ['task_id','company_id','links_order'];
    protected $primaryKey = 'id';
    protected $table= 'links_order';


}
