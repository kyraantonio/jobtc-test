<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Country extends Model
{

    protected $fillable = ['country_id', 'country_name'];

    protected $primaryKey = 'country_id';
    protected $table = 'country';

}
