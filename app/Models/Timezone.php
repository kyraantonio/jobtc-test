<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{

    protected $fillable = ['timezone_id', 'timezone_name'];

    protected $primaryKey = 'timezone_id';
    protected $table = 'timezone';

}
