<?php
/**
 * Created by PhpStorm.
 * User: ralph
 * Date: 3/24/16
 * Time: 12:51 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkTag extends  Model
{

    protected $fillable = ['name'];
    protected $primaryKey = 'id';
    protected $table = 'link_tags';
}