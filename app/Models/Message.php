<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Message extends Model
{

    protected $fillable = ['message_id', 'to_username', 'from_username', 'message_subject', 'message_content', 'file'];
    protected $primaryKey = 'message_id';
    protected $table = 'message';

}
