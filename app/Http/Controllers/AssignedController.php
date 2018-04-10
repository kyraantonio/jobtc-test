<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;

use App\Models\AssignedUser;
use App\Models\Task;

use Validator;
use DB;
use Input;
use Redirect;

class AssignedController extends BaseController
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
        $validation = Validator::make(Input::all(), [
            'username' => 'required|unique:assigned_user,username,null,username,belongs_to,' .
                Input::get('belongs_to') . ',unique_id,' . Input::get('unique_id')
        ]);
        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->messages());
        }

        $assignedUser = new AssignedUser();
        $data = Input::all();
        $assignedUser->fill($data);
        $assignedUser->save();
        return Redirect::back()->withSuccess('Assigned to selected user!!');
    }

    public function update()
    {
    }

    public function destroy($id)
    {

        if (!parent::userHasRole('Admin'))
            return Redirect::back()->withErrors('You dont have permission of this operation!!');

        $assignedUser = AssignedUser::find($id);
        if (!$assignedUser) {
            return Redirect::back() > withErrors('This is not a valid link!!');
        }

        $task = Task::where('unique_id', '=', $assignedUser->unique_id)
            ->where('belongs_to', '=', $assignedUser->belongs_to)
            ->where('username', '=', $assignedUser->username)
            ->get();

        if (count($task)) {
            return Redirect::back()->withErrors('This user has already assigned task!!');
        }

        $assignedUser->delete($id);
        return Redirect::back()->withSuccess('Deleted successfully!!');
    }
}

?>