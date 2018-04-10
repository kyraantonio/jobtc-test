<?php
/**
 * Created by PhpStorm.
 * User: ralph
 * Date: 3/23/16
 * Time: 11:18 PM
 */

namespace App\Api;

use App\Http\Controllers\BaseController;
use App\Traits\UserRoleTrait;

class ApiController extends  BaseController
{
    use UserRoleTrait;
}