<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Bug extends Model
{

    protected $fillable = ['bug_id', 'ref_no', 'project_id', 'bug_priority', 'bug_description', 'bug_status', 'reported_on'];

    protected $primaryKey = 'bug_id';
    protected $table = 'bug';

}
