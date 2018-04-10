<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use \View;

class CKEditorController extends BaseController
{
    public function index()
    {
        return View::make('temp.ckeditor');
    }
}
