<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Events extends Model
{

    protected $fillable = [
        'event_id',
        'event_title',
        'event_description',
        'start_date_time',
        'end_date_time',
        'public',
        'event_color'
    ];

    protected $primaryKey = 'event_id';
    protected $table = 'events';

}
