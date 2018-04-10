<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Note extends Model
{

    protected $fillable = ['note_id', 'belongs_to', 'unique_id', 'note_content', 'username'];

    protected $primaryKey = 'note_id';
    protected $table = 'notes';

}
