<?php
/**
 * Created by PhpStorm.
 * User: ralph
 * Date: 3/15/16
 * Time: 8:52 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Cache;

class CacheDataController extends BaseController
{

    public function getCache(Request $request, $cacheKey){

        $data = [];
        if(Cache::has($cacheKey)){
            $data = Cache::get($cacheKey);
        }

        return json_encode([ 'aaData'=>$data]);
    }
}