<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPayrollColumn extends Model
{
    protected $fillable = ['profile_id','payroll_column_id','value'];

    protected $primaryKey = 'id';
    protected $table = 'user_payroll_columns';
}
