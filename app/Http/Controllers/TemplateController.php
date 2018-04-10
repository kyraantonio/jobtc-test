<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;

use App\Models\Template;

use View;
use Auth;
use Redirect;
use Validator;
use Input;
class TemplateController extends BaseController
{

    public function index()
    {
        $templates = Template::orderBy('template_subject', 'asc')->get();


        return View::make('template.index', [
            'templates' => $templates,
            'assets' => []
        ]);
    }

    public function show()
    {
    }

    public function create()
    {
    }

    public function edit($template_id)
    {
        $template = Template::find($template_id);
        $templates = Template::all();
        $assets = ['editor'];

        if (!$template)
            return Redirect::to('template')->withErrors('This is not a valid template!!');

        return View::make('template.edit', [
            'template' => $template,
            'templates' => $templates,
            'assets' => $assets
        ]);

    }

    public function store()
    {
    }

    public function update($template_id)
    {
        $template = Template::find($template_id);
        $validation = Validator::make(Input::all(), [
            'template_content' => 'required',
            'template_subject' => 'required'
        ]);
        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->messages());
        }
        $template->template_content = Input::get('template_content');
        $template->template_subject = Input::get('template_subject');
        $template->save();
        return Redirect::back()->withSuccess('Successfully saved!!');
    }

    public function destroy()
    {
    }
}

?>