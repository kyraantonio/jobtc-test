<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Note;
use Input;
use DB;
use Redirect;
use Auth;

class NewNoteController extends BaseController
{

    public function index()
    {
        
    }

    public function show(){
    }
    public function showNotes()
    {
        
    }

    public function create()
    {
    }

    public function edit()
    {
    }

    public function update($note_id = 0)
    {

        $note = Note::findOrNew($note_id);
        $data = Input::all();
        $data['username'] = Auth::user()->username;
        $note->fill($data);
        $note->save();

        return Redirect::back()->withSuccess('Successfully saved!!');
    }

    public function store()
    {

        $note = new Note;
        $data = Input::all();
        $data['username'] = Auth::user()->username;
        $note->fill($data);
        $note->save();

        return Redirect::back()->withSuccess('Successfully saved!!');
    }

    public function destroy()
    {
    }
}

?>