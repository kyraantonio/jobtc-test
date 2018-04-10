<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $fillable = ['id', 'company_name', 'contact_person', 'address', 'city', 'state', 'zipcode', 'country_id', 'email', 'phone', 'company_logo', 'allowed_upload_file', 'allowed_upload_max_size', 'default_tax', 'default_discount', 'default_currency', 'timezone_id', 'default_language'];

    protected $primaryKey = 'id';
    protected $table = 'setting';

}
