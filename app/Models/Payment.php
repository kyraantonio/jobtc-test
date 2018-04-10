<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
	//
    protected $fillable = ['payment_id', 'billing_id', 'payment_amount', 'payment_type', 'payment_notes', 'payment_date'];
    protected $primaryKey = 'payment_id';
    protected $table = 'payment';
}