<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;

use App\Models\Setting;
use App\Models\Country;
use App\Models\Timezone;

use View;
use DB;
use Redirect;
use Input;
use Validator;
use Session;
use File;

class SettingController extends BaseController
{

    public function index()
    {
        $setting = Setting::find(1);
        $countries_option = Country::orderBy('country_name', 'asc')
            ->lists('country_name', 'country_id')
            ->toArray();

        $timezone = Timezone::orderBy('timezone_name', 'asc')
            ->lists('timezone_name', 'timezone_id')
            ->toArray();

        return View::make('setting.index', [
            'assets' => [],
            'setting' => $setting,
            'countries' => $countries_option,
            'timezone' => $timezone
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
        $setting = new Setting;

        $rules = array(
            'file' => 'image|image_size:<=300,<=100|max:10000'
        );

        $validator = Validator::make(Input::all(), $rules);
        $data = Input::all();

        if ($validator->fails())
            return Redirect::back()->withErrors($validator);

        if (Input::hasFile('file') && Input::get('remove_image') != 'Yes') {
            $filename = Input::file('file')->getClientOriginalName();
            $extension = Input::file('file')->getClientOriginalExtension();
            $file = Input::file('file')->move('assets/company_logo/logo.' . $extension);
            $setting->company_logo = 'logo.' . $extension;
        }

        if (Input::get('remove_image') == 'Yes') {
            File::delete('assets/company_logo/' . $setting->company_logo);
            $setting->company_logo = null;
        }
        Session::put('language', Input::get('default_language'));
        App::setLocale(Input::get('default_language'));


        $setting->fill($data);
        $setting->save();
        return Redirect::back()->withSuccess('Successfully saved!!');
    }

    public function update($id)
    {
        $setting = Setting::findOrNew($id);

        $rules = array(
            'file' => 'image|image_size:<=300,<=100|max:10000'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
            return Redirect::back()->withErrors($validator);

        if (Input::hasFile('file') && Input::get('remove_image') != 'Yes') {
            $filename = Input::file('file')->getClientOriginalName();
            $extension = Input::file('file')->getClientOriginalExtension();
            $file = Input::file('file')->move('assets/company_logo/', $setting->id . "." . $extension);
            $setting->company_logo = $setting->id . "." . $extension;
        }
        $data = Input::all();
        Session::put('language', Input::get('default_language'));
        app()->setLocale(Input::get('default_language'));

        if (Input::get('remove_image') == 'Yes') {
            File::delete('assets/company_logo/' . $setting->company_logo);
            $setting->company_logo = null;
        }

        $setting->fill($data);
        $setting->save();
        return Redirect::back()->withSuccess('Successfully saved!!');
    }

    public function destroy()
    {
    }
}

?>