<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'account_name',
        'currency',
        'payment_method_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'accounts';
}