<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayPeriod extends Model
{
    protected $fillable = ['type', 'period'];

    protected $primaryKey = 'id';
    protected $table = 'payroll_pay_periods';
}
