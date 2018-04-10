<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $fillable = ['ticket_id', 'ticket_subject', 'ticket_description', 'ticket_priority', 'file', 'ticket_status', 'username'];
    protected $primaryKey = 'ticket_id';
    protected $table = 'ticket';

}
