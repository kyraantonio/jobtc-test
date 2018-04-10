<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
      /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'discussions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['owner_id','company_id', 'room_name','room_type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];
}
