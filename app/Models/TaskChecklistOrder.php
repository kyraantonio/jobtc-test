<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskChecklistOrder extends Model
{
    //

    protected $fillable = [
        'task_id',
        'task_id_order'
    ];

    protected $primaryKey = 'id';
    protected $table = 'task_check_list_order';
}
