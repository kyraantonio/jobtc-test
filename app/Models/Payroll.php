<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['user_pay_period_id','next_due','status'];
    protected $primaryKey = 'id';
    protected $table = 'payroll';
}
