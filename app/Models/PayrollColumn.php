<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollColumn extends Model
{
    protected $fillable = ['column_name', 'column_type' ,'default_value'];

    protected $primaryKey = 'id';
    protected $table = 'payroll_columns';
}
