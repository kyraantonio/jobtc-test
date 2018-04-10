<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPayPeriod extends Model
{
    protected $fillable = ['profile_id','pay_period_id','payday'];

    protected $primaryKey = 'id';
    protected $table = 'user_pay_periods';
    
    
    public function payroll() {
        return $this->hasOne('App\Models\Payroll');
    }
}
