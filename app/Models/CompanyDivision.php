<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDivision extends Model
{
    protected $fillable = [ 'company_id','division_name'];

    protected $primaryKey = 'id';
    protected $table = 'company_divisions';
}
