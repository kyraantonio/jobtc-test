<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;

use App\Models\Events;
use App\Helpers\Helper;

use Auth;
use DB;
use Validator;
use Input;
use Redirect;
use View;
use Hash;

class EventsController extends BaseController
{

    public function index()
    {
        $events = Events::where('user_id', '=', Auth::user()->id)
            ->orWhere('public', '=', '1')
            ->get();

        $assets = ['table', 'select2'];


        return View::make('event.index', [
            'events' => $events,
            'assets' => $assets
        ]);
    }

    public function show()
    {
    }

    public function create()
    {
    }

    public function edit($event_id)
    {

        $event = Events::where('event_id', '=', $event_id)
            ->where('user_id', '=', Auth::user()->id)
            ->first();

        if (count($event))
            return View::make('event.edit', [
                'event' => $event
            ]);
        else
            return Redirect::to('event');
    }

    public function store()
    {

        $validation = Validator::make(Input::all(), [
            'event_title' => 'required|unique:events',
            'event_description' => 'required',
            'start_date' => 'required|date_format:"d-m-Y"',
            'end_date' => 'required|date_format:"d-m-Y"'
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->messages());
        } elseif (strtotime(Input::get('start_date')) > strtotime(Input::get('end_date'))) {
            return Redirect::back()->withInput()->withErrors('End date should be greater than start date!!');
        }
        $public = Input::get('public');
        if ($public != '1')
            $public = '0';
        $event = new Events;
        $event->event_title = Input::get('event_title');
        $event->event_description = Helper::mynl2br(Input::get('event_description'));
        $event->start_date = date("Y-m-d H:i:s", strtotime(Input::get('start_date')));
        $event->end_date = date("Y-m-d H:i:s", strtotime(Input::get('end_date')));
        $event->user_id = Auth::user()->id;
        $event->public = $public;
        $event->save();

        return Redirect::to('event')->withSuccess("Event added successfully!!");
    }

    public function update($event_id)
    {

        $event = Events::find($event_id);
        $validation = Validator::make(Input::all(), [
            'event_title' => 'required|unique:events,event_title,' . $event_id . ',event_id',
            'event_description' => 'required',
            'start_date' => 'required|date_format:"d-m-Y"',
            'end_date' => 'required|date_format:"d-m-Y"'
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->messages());
        } elseif (strtotime(Input::get('start_date')) > strtotime(Input::get('end_date'))) {
            return Redirect::back()->withInput()->withErrors('End date should be greater than start date!!');
        } elseif (!$event) {
            return Redirect::back()->withInput()->withErrors('This is not a valid URL!!');
        }

        $public = Input::get('public');
        if ($public != '1')
            $public = '0';
        $event->event_title = Input::get('event_title');
        $event->event_description = Helper::mynl2br(Input::get('event_description'));
        $event->start_date = date("Y-m-d H:i:s", strtotime(Input::get('start_date')));
        $event->end_date = date("Y-m-d H:i:s", strtotime(Input::get('end_date')));
        $event->public = $public;
        $event->save();

        return Redirect::to('event')->withSuccess("Event updated successfully!!");
    }

    public function delete($event_id)
    {
        $event = Events::find($event_id);

        if (!$event && ($event->user_id != Auth::user()->id|| !parent::hasRole('Admin')))
            return Redirect::back()->withErrors('This is not a valid link!!');

        $event->delete();

        return Redirect::to('event')->withSuccess('Delete Successfully!!!');
    }
}

?>