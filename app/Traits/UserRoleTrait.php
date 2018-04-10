<?php
/**
 * Created by PhpStorm.
 * User: ralph
 * Date: 3/23/16
 * Time: 11:19 PM
 */

namespace App\Traits;


trait UserRoleTrait
{
    protected function getActiveUser(){
        return request()->user();
    }

    protected function userHasRole($role){
        $user = $this->getActiveUser();
        return $user->is(strtolower($role));
    }

    protected function hasRole($role){
        return $this->userHasRole($role);
    }
}