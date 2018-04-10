<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Billing extends Model
{

    protected $fillable = ['billing_id', 'ref_no', 'client_id', 'issue_date', 'due_date', 'valid_date', 'tax', 'discount', 'currency', 'notes', 'invoiced_on', 'billing_type'];
    protected $primaryKey = 'billing_id';
    protected $table = 'billing';

}
