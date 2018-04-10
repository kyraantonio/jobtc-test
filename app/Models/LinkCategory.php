<?php
/**
 * Created by PhpStorm.
 * User: ralph
 * Date: 3/24/16
 * Time: 12:53 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkCategory extends  Model
{

    protected $fillable = ['name','slug'];
    protected $primaryKey = 'id';
    protected $table= 'link_categories';
}