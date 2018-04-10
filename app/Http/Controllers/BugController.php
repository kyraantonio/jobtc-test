<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;

use App\Models\Bug;
use App\Models\Project;
use App\Models\AssignedUser;
use App\Models\Task;
use App\Models\User;
use App\Models\Note;

use DB;
use Validator;
use Auth;
use Input;
use View;
use Redirect;
use File;

class BugController extends BaseController
{

    public function index()
    {

        if ($this->userHasRole('admin')) {
            $bug = Bug::all();
        } else
            if ($this->userHasRole('client')) {
                $bug = DB::table('bug')
                    ->join('project', 'project.project_id', '=', 'bug.project_id')
                    ->join('user', 'user.client_id', '=', 'project.client_id')
                    ->where('user.user_id', '=', Auth::user()->user_id)
                    ->get();
            } else
                if ($this->userHasRole('staff')) {

                    $bug = DB::table('bug')
                        ->join('assigned_user', 'assigned_user.unique_id', '=', 'bug.bug_id')
                        ->where('belongs_to', '=', 'bug')
                        ->where('username', '=', Auth::user()->username)
                        ->get();
                }

        $project_options = Project::orderBy('project_title', 'asc')
            ->lists('project_title', 'project_id');

        $assets = ['table', 'datepicker'];

        return View::make('bug.index', [
            'bugs' => $bug,
            'projects' => $project_options,
            'assets' => $assets
        ]);
    }

    public function show($bug_id)
    {
        if ($this->userHasRole('admin')) {
            $bug = Bug::find($bug_id);
        } elseif ($this->userHasRole('staff')) {
            $bug = DB::table('bug')
                ->join('project', 'project.project_id', '=', 'bug.project_id')
                ->join('user', 'user.client_id', '=', 'project.client_id')
                ->where('user.user_id', '=', Auth::user()->user_id)
                ->where('bug_id', '=', $bug_id)
                ->first();
        } elseif ($this->userHasRole('client')) {


            $bug = DB::table('bug')
                ->join('assigned_user', 'assigned_user.unique_id', '=', 'bug.bug_id')
                ->where('belongs_to', '=', 'bug')
                ->where('username', '=', Auth::user()->username)
                ->where('bug_id', '=', $bug_id)
                ->first();
        }
        if (!$bug)
            return Redirect::to('bug')->withErrors('This is not a valid link!!');

        $assignedUser = AssignedUser::where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)
            ->get();

        $assign_username = AssignedUser::where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)
            ->lists('username', 'username')
            ->toArray();

        $user = User::where('client_id', '=', '')
            ->orderBy('name', 'asc')
            ->lists('name', 'username')
            ->toArray();

        $project_options = Project::orderBy('project_title', 'asc')
            ->lists('project_title', 'project_id');

        $note = Note::where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)
            ->where('username', '=', Auth::user()->username)
            ->first();

        $comment = DB::table('comment')
            ->where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)
            ->join('user', 'comment.username', '=', 'user.username')
            ->orderBy('comment.created_at', 'desc')
            ->get();

        $attachment = DB::table('attachment')
            ->where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)
            ->join('user', 'attachment.username', '=', 'user.username')
            ->orderBy('attachment.created_at', 'desc')
            ->get();

        if (!$this->userHasRole('Staff')) {
            $task = Task::where('belongs_to', '=', 'bug')
                ->where('unique_id', '=', $bug_id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $task = Task::where('belongs_to', '=', 'bug')
                ->where('unique_id', '=', $bug_id)
                ->where('assign_username', '=', Auth::user()->username)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $assets = ['datepicker'];

        return View::make('bug.show', [
            'bug' => $bug,
            'projects' => $project_options,
            'note' => $note,
            'comments' => $comment,
            'attachments' => $attachment,
            'assignedUsers' => $assignedUser,
            'assign_username' => $assign_username,
            'users' => $user,
            'tasks' => $task,
            'assets' => $assets
        ]);
    }

    public function create()
    {
        return View::make('bug.create');
    }

    public function edit($id)
    {
        $bug = Bug::find($id);

        $project_options = Project::orderBy('project_title', 'asc')
            ->lists('project_title', 'project_id')
            ->toArray();

        return View::make('bug.edit', [
            'bugs' => $bug,
            'projects' => $project_options
        ]);
    }

    public
    function store()
    {

        $validation = Validator::make(Input::all(), [
            'project_id' => 'required',
            'ref_no' => 'required|unique:bug',
            'reported_on' => 'required',
            'bug_priority' => 'required',
            'bug_status' => 'required'
        ]);

        if ($validation->fails()) {
            return Redirect::to('bug')->withInput()->withErrors($validation->messages());
        }

        $bug = new Bug;
        $bug->project_id = Input::get('project_id');
        $bug->ref_no = Input::get('ref_no');
        $bug->reported_on = date("Y-m-d H:i:s", strtotime(Input::get('reported_on')));
        $bug->bug_description = Input::get('bug_description');
        $bug->bug_priority = Input::get('bug_priority');
        $bug->bug_status = Input::get('bug_status');
        $bug->save();

        return Redirect::to('bug')->withSuccess("Bug added successfully !!");
    }

    public
    function update($bug_id)
    {
        $bug = Bug::find($bug_id);

        $bug->project_id = Input::get('project_id');
        $bug->ref_no = Input::get('ref_no');
        $bug->reported_on = date("Y-m-d H:i:s", strtotime(Input::get('reported_on')));
        $bug->bug_description = Input::get('bug_description');
        $bug->bug_priority = Input::get('bug_priority');
        $bug->bug_status = Input::get('bug_status');
        $bug->save();

        return Redirect::to('bug')->withSuccess("Bug updated successfully!!");
    }

    public
    function updateBugStatus()
    {
        $bug = Bug::find(Input::get('bug_id'));
        $validation = Validator::make(Input::all(), [
            'bug_id' => 'required',
            'bug_status' => 'required|in:unconfirmed,confirmed,progress,resolved'
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation->messages());
        } elseif (!$bug) {
            return Redirect::back()->withErrors('Wrong URL!!');
        }

        $bug->bug_status = Input::get('bug_status');
        $bug->save();
        return Redirect::back()->withSuccess('Saved!!');
    }

    public
    function destroy()
    {
    }

    public
    function delete($bug_id)
    {
        $bug = Bug::find($bug_id);

        if (!$bug || !$this->userHasRole('Admin'))
            return Redirect::to('bug')->withErrors('This is not a valid link!!');

        DB::table('assigned_user')
            ->where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)->delete();

        $attachments = DB::table('attachment')
            ->where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)->get();

        foreach ($attachments as $attachment)
            File::delete('assets/attachment_files/' . $attachment->file);

        DB::table('attachment')
            ->where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)->delete();

        DB::table('comment')
            ->where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)->delete();

        DB::table('notes')
            ->where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)->delete();

        DB::table('task')
            ->where('belongs_to', '=', 'bug')
            ->where('unique_id', '=', $bug_id)->delete();

        $bug->delete();

        return Redirect::to('bug')->withSuccess('Delete Successfully!!!');
    }
}

?>