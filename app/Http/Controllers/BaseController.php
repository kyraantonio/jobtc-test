<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UserRoleTrait;

class BaseController extends Controller
{

    use UserRoleTrait;

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }


}
