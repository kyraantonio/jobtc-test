<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{

    protected $fillable = ['template_id', 'template_subject', 'template_content'];

    protected $primaryKey = 'template_id';
    protected $table = 'template';

}
