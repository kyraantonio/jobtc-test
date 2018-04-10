<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['profile_id', 'rate_type', 'rate_value','pay_period_id','currency'];

    protected $primaryKey = 'id';
    protected $table = 'rates';
    
    public function pay_period() {
        return $this->hasOne('App\Models\PayPeriod','id','pay_period_id');
    }
    
    public function user_pay_period() {
        return $this->hasOne('App\Models\UserPayPeriod','profile_id','profile_id');
    }
}
