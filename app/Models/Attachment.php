<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{

    protected $fillable = ['attachment_id', 'attachment_title', 'attachment_description', 'belongs_to', 'unique_id', 'username', 'file'];
    protected $primaryKey = 'attachment_id';
    protected $table = 'attachment';

}
