<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    
    use SoftDeletes;
    //protected $fillable = ['company_name', 'contact_person', 'email', 'phone', 'address', 'zipcode', 'city', 'state', 'country_id'];
    protected $fillable = [ 'name',  'email', 'phone','number_of_employees','address_1','address_2','province','zipcode','website','country_id'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    
    protected $primaryKey = 'id';
    protected $table = 'companies';
    protected $dates = ['deleted_at'];
    
    public function profile() {
        return $this->hasOne('App\Models\Profile');
    }
}
