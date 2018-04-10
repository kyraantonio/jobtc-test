<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;

use App\Models\User;
use App\Models\Message;
use App\Models\Setting;


use View;
use Auth;
use Redirect;
use Validator;
use Input;
class MessageController extends BaseController
{

    public function index()
    {

        $user_options = User::where('username', '!=', Auth::user()->username)
            ->orderBy('name', 'asc')
            ->lists('name', 'username')
            ->toArray();

        $inbox = Message::where('to_username', '=', Auth::user()->username)
            ->orderBy('created_at', 'asc')
            ->get();

        $sent = Message::where('from_username', '=', Auth::user()->username)
            ->orderBy('created_at', 'asc')
            ->get();

        $assets = ['editor'];

        return View::make('message.index', [
            'users' => $user_options,
            'inbox' => $inbox,
            'sent' => $sent,
            'assets' => $assets
        ]);
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

        $filevalidation = 'required|mimes:' . $setting->allowed_upload_file . '|max:' . $setting->allowed_upload_max_size;
        $filename = uniqid();

        $validation = Validator::make(Input::all(), [
            'to_username' => 'required',
            'message_subject' => 'required',
            'message_content' => 'required'
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->messages());
        }

        $message = new Message;
        $data = Input::all();

        if (Input::hasFile('file')) {
            $extension = Input::file('file')->getClientOriginalExtension();
            $file = Input::file('file')->move('assets/message_attachment/', $filename . "." . $extension);
            $data['file'] = $filename . "." . $extension;
        } else
            $data['file'] = '';

        $data['from_username'] = Auth::user()->username;
        $message->fill($data);
        $message->save();
        return Redirect::back()->withSuccess('Successfully sent!!');
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}

?>