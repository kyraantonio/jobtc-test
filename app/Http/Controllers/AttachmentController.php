<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;

use App\Models\Setting;
use App\Models\Attachment;

use Validator;
use Redirect;
use Input;
use Auth;
use File;

class AttachmentController extends BaseController
{

    public function index()
    {
    }

    public function show()
    {
    }

    public function create()
    {
    }

    public function edit()
    {
    }

    public function store()
    {
        $setting = Setting::find(1);
        $filevalidation = 'required|mimes:' . $setting->allowed_upload_file . '
									|max:' . $setting->allowed_upload_max_size;
        $filename = uniqid();
        $validation = Validator::make(Input::all(), [
            'attachment_title' => 'required',
            'file' => $filevalidation
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->messages());
        }

        $attachment = new Attachment;
        $data = Input::all();

        if (Input::hasFile('file')) {
            $extension = Input::file('file')->getClientOriginalExtension();
            $file = Input::file('file')->move('assets/attachment_files/', $filename . "." . $extension);
            $data['file'] = $filename . "." . $extension;
        }

        $data['username'] = Auth::user()->username;
        $attachment->fill($data);
        $attachment->save();
        return Redirect::back()->withSuccess('Successfully saved!!');
    }

    public function update()
    {
    }

    public function destroy($attachment_id)
    {
        $attachment = Attachment::find($attachment_id);

        if (!$attachment || ($attachment->username != Auth::user()->username && !parent::hasRole('Admin')))
            return Redirect::back()->withErrors('This is not a valid link!!');

        File::delete('assets/attachment_files/' . $attachment->file);
        $attachment->delete($attachment_id);
        return Redirect::back()->withSuccess('Deleted successfully!!');
    }
}

?>