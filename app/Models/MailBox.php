<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailBox extends Model
{
    
    protected $connection = 'mysql_postfix';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mailbox';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = ['username','password', 'name', 'maildir', 'quota' ,'local_part' ,'domain' ,'created' ,'modified' ,'active'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];
}


