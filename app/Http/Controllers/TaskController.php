<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\LinksOrder;
use Bican\Roles\Exceptions\RoleDeniedException;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Timer;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskTimer;
use App\Models\TaskChecklist;
use App\Models\TaskChecklistOrder;
use App\Models\TaskCheckListPermission;
use App\Models\TaskChecklistStatus;
use App\Models\Link;
use App\Models\LinkCategory;
use App\Models\Profile;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\PermissionUser;
use View;
use Auth;
use Redirect;
use Validator;
use Input;
use \DB;

class TaskController extends BaseController {

    function __construct() {
        //Only staff and admin can access
        if (parent::hasRole('client')) {
            throw new RoleDeniedException('Company or Admin');
        }
    }

    /**
     * @return mixed
     */
    public function index() {

        if (parent::hasRole('staff')) {

            $tasks = Task::orderBy('created_at', 'desc')
                    ->get();
        } else {
            /* $tasks = Task::orderBy('created_at', 'desc')
              ->join('user', 'task.user_id', '=', 'users.id')
              ->select(
              'task.*', 'users.first_name', 'user.email'
              )->get(); */
            $tasks = Task::where('user_id', '=', Auth::user()->user_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        }

        $belongsTo = 'task';

        $assign_username = User::orderBy('name')
                ->lists('name', 'user_id');

        $assets = ['calendar', 'table'];

        return View::make('task.index', [
                    'assets' => $assets,
                    'tasks' => $tasks,
                    'belongs_to' => $belongsTo,
                    'isCompany' => parent::hasRole('client'),
                    'assign_username' => $assign_username
        ]);
    }

    public function show($id) {

        $user_id = Auth::user('user')->user_id;
        $user = User::find($user_id);

        $task = Task::find($id);
        if ($user->level() === 1) {
            $task = Task::find($id);
        } elseif ($user->level() > 1) {
            $task = Task::find($id);
        }

        $task_timer = DB::table('task_timer')
                ->leftJoin('user', 'task_timer.user_id', '=', 'user.user_id')
                ->leftJoin('task', 'task_timer.task_id', '=', 'task.task_id')
                ->select(
                        'task_timer.*', 'user.name', 'task.task_title', DB::raw(
                                'FORMAT(TIMESTAMPDIFF(SECOND, fp_task_timer.start_time, fp_task_timer.end_time) / 3600, 2) as time'
                        ), DB::raw(
                                'TIMESTAMPDIFF(SECOND, fp_task_timer.start_time, now()) as _time'
                        )
                )
                ->where('task_timer.task_id', '=', $id)
                ->orderBy('start_time', 'desc')
                ->get();

        $current_time = DB::table('task_timer')
                ->select(
                        DB::raw(
                                'TIMESTAMPDIFF(SECOND, fp_task_timer.start_time, now()) as _time, id'
                        )
                )
                ->where('task_timer.task_id', '=', $id)
                ->where('task_timer.end_time', '=', '0000-00-00 00:00:00')
                ->first();

        //Check if there is an entry in the taskchecklist order table
        $task_order_count = TaskChecklistOrder::where('task_id', $id)->count();

        if ($task_order_count > 0) {
            $task_order = TaskChecklistOrder::where('task_id', $id)->first();
            $checkList = TaskChecklist::with(['timer' => function($query) use($user_id) {
                            $query->select(DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, MAX(timer_id) as timer_id, MAX(timer_status) as timer_status, user_id,project_id,task_checklist_id'))->where('user_id', $user_id)->groupBy('task_checklist_id')->get();
                        }, 'task_checklist_statuses'])->where('task_id', '=', $id)->orderBy(DB::raw('FIELD(id,' . $task_order->task_id_order . ')'))->get();
        } else {
            $task_order = TaskChecklistOrder::where('task_id', $id)->first();
            $checkList = TaskChecklist::with(['timer' => function($query) use($user_id) {
                            $query->select(DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, MAX(timer_id) as timer_id, MAX(timer_status) as timer_status, user_id,project_id,task_checklist_id'))->where('user_id', $user_id)->groupBy('task_checklist_id')->get();
                        }, 'task_checklist_statuses'])->where('task_id', '=', $id)->get();
        }

        $total_checklist = TaskChecklist::where('task_id', '=', $id)->count();
        $finish_checklist = TaskChecklist::where('status', '=', 'Completed')->where('task_id', '=', $id)->count();
        $percentage = $total_checklist > 0 ? ($finish_checklist / $total_checklist) * 100 : 0;

        $links_order_count = LinksOrder::where('task_id', $id)->count();

        if ($links_order_count > 0) {
            $links_order = LinksOrder::where('task_id', $id)->first();
            $links = Link::select(
                            'links.id', 'title', 'url', 'descriptions', 'tags', 'comments', 'task_item_id', 'user_id', 'task_id', 'link_categories.name as category_name'
                    )
                    ->leftJoin('link_categories', 'link_categories.id', '=', 'links.category_id')
                    ->where('task_id', '=', $id)
                    ->orderBy(DB::raw('FIELD(fp_links.id,' . $links_order->links_order . ')'))
                    ->get();
        } else {
            $links = Link::select(
                            'links.id', 'title', 'url', 'descriptions', 'tags', 'comments', 'task_item_id', 'user_id', 'task_id', 'link_categories.name as category_name'
                    )
                    ->leftJoin('link_categories', 'link_categories.id', '=', 'links.category_id')
                    ->where('task_id', '=', $id)
                    ->orderBy('id', 'DESC')
                    ->get();
        }

        $categories = LinkCategory::all()
                ->lists('name', 'id')
                ->toArray();


        $company_id = Project::where('project_id', $task->project_id)->pluck('company_id');

        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $company_id)
                ->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        $project_owner = Project::where('project_id', $task->project_id)->pluck('user_id');

        $assets = ['tasks', 'calendar'];

        return view('task.show', [
            'task' => $task,
            'assets' => $assets,
            'task_timer' => $task_timer,
            'checkList' => $checkList,
            'current_time' => $current_time,
            'percentage' => number_format($percentage, 0),
            'links' => $links,
            'user_id' => $user_id,
            'categories' => $categories,
            'module_permissions' => $module_permissions,
            'company_id' => $company_id,
            'project_owner' => $project_owner
        ]);
    }

    public function create() {
        
    }

    public function edit($id) {
        $task = Task::find($id);

        $assign_username = User::orderBy('name')
                ->lists('name', 'user_id');

        if (count($task) > 0) {
            return view('task.edit', [
                'task' => $task,
                'isCompany' => parent::hasRole('client'),
                'assign_username' => $assign_username
            ]);
        }
    }

    public function store(Request $request) {

        $validation = Validator::make($request->all(), [
                    'task_title' => 'required',
                    'belongs_to' => 'required',
                    'unique_id' => 'required'
        ]);

        if ($validation->fails()) {
            return Redirect::back();
        }

        $task = new Task;
        $data = Input::all();
        $data['task_status'] = 'pending';
        $data['project_id'] = $data['unique_id'];
        $data['due_date'] = date("Y-m-d H:i:s", strtotime($data['due_date']));

        $data['user_id'] = Auth::user()->user_id;

        $task->fill($data);
        $task->save();

        return Redirect::back();
    }

    public function updateTaskStatus() {

        $task = Task::find(Input::get('task_id'));
        $validation = Validator::make(Input::all(), [
                    'task_id' => 'required',
                    'task_status' => 'required|in:pending,progress,completed'
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation->messages());
        } elseif (!$task) {
            return Redirect::back()->withErrors('Wrong URL!!');
        }

        $task->task_status = Input::get('task_status');
        $task->save();

        return Redirect::back();
    }

    public function update(Request $request, $id) {

        $task = Task::find($id);

        $data = $request->all();
        $data['due_date'] = date("Y-m-d H:i:s", strtotime($data['due_date']));

        $task->update($data);

        return Redirect::back();
    }

    public function destroy($task_id) {
        $task = Task::where('task_id', $task_id);
        if (!$task) {
            return Redirect::back()->withErrors('This is not a valid link!!');
        }
        $task->delete($task_id);

        return Redirect::back();
    }

    public function delete(Request $request, $id) {
        $task = Task::where('task_id', $id)->delete();

        //Check if the task exists in the task checklist permission table and delete it
        $task_check_list_permission_count = TaskCheckListPermission::where('task_id', $id)->count();

        if ($task_check_list_permission_count > 0) {
            $task_check_list_permission = TaskCheckListPermission::where('task_id', $id);
            $task_check_list_permission->delete();
        }

        return json_encode($task);
    }

    public function taskTimer(Request $request, $id) {
        $input = $request->except(['is_finished']);
        $taskTimer = new TaskTimer($input);
        $taskTimer->save();

        $data['table'] = DB::table('task_timer')
                ->leftJoin('user', 'task_timer.user_id', '=', 'user.user_id')
                ->leftJoin('task', 'task_timer.task_id', '=', 'task.task_id')
                ->select(
                        'task_timer.*', 'user.name', 'task.task_title', DB::raw(
                                'FORMAT(TIMESTAMPDIFF(SECOND, fp_task_timer.start_time, fp_task_timer.end_time) / 3600, 2) as time'
                        )
                )
                ->where('task_timer.task_id', '=', $id)
                ->orderBy('start_time', 'desc')
                ->get();

        $data['return_task_timer'] = $taskTimer->id;
        return json_encode($data);
    }

    public function updateTaskTimer(Request $request, $id) {
        $taskTimer = TaskTimer::find($id);
        $taskTimer->update($request->all());

        $data['table'] = DB::table('task_timer')
                ->leftJoin('user', 'task_timer.user_id', '=', 'user.user_id')
                ->leftJoin('task', 'task_timer.task_id', '=', 'task.task_id')
                ->select(
                        'task_timer.*', 'user.name', 'task.task_title', DB::raw(
                                'FORMAT(TIMESTAMPDIFF(SECOND, fp_task_timer.start_time, fp_task_timer.end_time) / 3600, 2) as time'
                        )
                )
                ->where('task_timer.task_id', '=', $taskTimer->task_id)
                ->orderBy('start_time', 'desc')
                ->get();

        return json_encode($data);
    }

    public function deleteTaskTimer($id) {
        $task = TaskTimer::find($id);
        $task->delete($id);

        return Redirect::back();
    }

    public function getChecklist(Request $request) {
        $tasklist = TaskChecklist::where('task_id', $request->task_id)->get();

        return json_encode($tasklist);
    }

    public function checkList(Request $request) {
        //Save the task list item immediately
        //$taskCheckList = new TaskChecklist($request->all());
        //$taskCheckList->save();
        $task_check_list_id = $request->input('task_check_list_id');
        $task_id = $request->input('task_id');
        $taskCheckList = TaskChecklist::where('id', $task_check_list_id)->first();

        $has_order_list = TaskChecklistOrder::where('task_id', '=', $task_id)->count();

        if ($has_order_list > 0) {
            //then get the new task list item id and append it as the last item on the order
            $taskCheckListOrderString = TaskChecklistOrder::where('task_id', '=', $task_id)->pluck('task_id_order');
            $task_list_id_array = $taskCheckListOrderString . ',' . $taskCheckList->id;
            $taskCheckListOrderUpdate = TaskChecklistOrder::where('task_id', $task_id)->update([
                'task_id_order' => $task_list_id_array
            ]);

            //$data = TaskChecklist::where('task_id', '=', $taskCheckList->task_id)->get();
            $data = TaskChecklist::with('timer')->where('task_id', '=', $task_id)->where('id', $task_check_list_id)->orderBy(DB::raw('FIELD(id,' . $task_list_id_array . ')'))->get();
        } else {
            $data = TaskChecklist::with('timer')->where('task_id', '=', $task_id)->where('id', $task_check_list_id)->get();
        }

        return json_encode($data);
    }

    public function sortCheckList(Request $request, $id) {

        $taskCheckListOrder = new TaskChecklistOrder();

        //Check if the task id has an ordering list
        $task_list_id_count = TaskChecklistOrder::where('task_id', $id)->count();

        //Turn list of task item ids into a string
        $task_list_id_array = implode(",", str_replace("\"", '', $request->get('task_item')));

        if ($task_list_id_count > 0) {

            $taskCheckListOrder->where('task_id', $id)->delete();

            $taskCheckListOrder->task_id = $id;
            $taskCheckListOrder->task_id_order = $task_list_id_array;
            $taskCheckListOrder->save();
        } else {

            $taskCheckListOrder->task_id = $id;
            $taskCheckListOrder->task_id_order = $task_list_id_array;
            $taskCheckListOrder->save();
        }

        return json_encode($task_list_id_array);
    }

    public function updateCheckListStatus(Request $request, $id) {

        $user_id = Auth::user()->user_id;
        $status = $request->input('status');

        /*$taskCheckListStatusCount = TaskChecklistStatus::where('task_checklist_id', $id)->where('user_id', $user_id)->count();

        if ($taskCheckListStatusCount > 0) {
            $taskCheckListStatus = TaskChecklistStatus::where('task_checklist_id', $id)->where('user_id', $user_id)->update([
                'status' => $status
            ]);
        } else {
            $taskCheckListStatus = new TaskChecklistStatus([
                'task_checklist_id' => $id,
                'user_id' => $user_id,
                'status' => $status
            ]);
            $taskCheckListStatus->save();
        }*/
        $task_checklist = TaskChecklist::where('id',$id)->update([
            'status' => $status
        ]);
        
        return "true";
    }

    public function updateCheckList(Request $request, $id) {
        $taskCheckList = TaskChecklist::find($id);
        $data = $request->all();

        $taskCheckList->update($data);

        return json_encode($data);
    }

    public function deleteCheckList($id) {
        //Find the task item to delete 
        $checkList = TaskChecklist::find($id);

        //Delete the task item from the task order
        $task_order = explode(",", TaskChecklistOrder::where('task_id', '=', $checkList->task_id)->pluck('task_id_order'));

        $new_task_order = [];
        foreach ($task_order as $order) {
            if (str_replace('"', '', $order) !== $id) {
                array_push($new_task_order, $order);
            }
        }
        $task_order_update = TaskChecklistOrder::where('task_id', '=', $checkList->task_id)->update([
            'task_id_order' => implode(',', $new_task_order)
        ]);

        //Delete the task item
        $checkList->delete($id);

        //If Checklist item was the last item in the list, delete the task order
        $task_list_count = TaskChecklist::where('task_id', $checkList->task_id)->count();

        if (!$task_list_count > 0) {

            $delete_task_order = TaskChecklistOrder::where('task_id', $checkList->task_id)->delete();
        }

        return $checkList;
    }

    public function changeCheckList(Request $request, $task_id, $task_list_item_id) {

        $taskCheckList = TaskCheckList::where('id', $task_list_item_id)
                ->update([
            'task_id' => $task_id
        ]);


        $taskCheckListOrder = new TaskChecklistOrder();

        //Check if the task id has an ordering list
        $task_list_id_count = TaskChecklistOrder::where('task_id', $task_id)->count();

        //Turn list of task item ids into a string
        $task_list_id_array = implode(",", str_replace("\"", '', $request->get('task_item')));

        if ($task_list_id_count > 0) {

            $taskCheckListOrder->where('task_id', $task_id)->delete();

            $taskCheckListOrder->task_id = $task_id;
            $taskCheckListOrder->task_id_order = $task_list_id_array;
            $taskCheckListOrder->save();
        } else {

            $taskCheckListOrder->task_id = $task_id;
            $taskCheckListOrder->task_id_order = $task_list_id_array;
            $taskCheckListOrder->save();
        }

        return json_encode($task_list_id_array);
    }

    //For CKEditor Image uploads
    public function saveImage(Request $request) {

        $file_name = $request->file('upload');

        if (file_exists(public_path('assets/ckeditor_uploaded_images/' . $file_name->getClientOriginalName()))) {
            $uploaded_file_name = $file_name->getClientOriginalName();
        } else {
            $file_name->move(
                    'assets/ckeditor_uploaded_images/', $file_name->getClientOriginalName()
            );
            $uploaded_file_name = $file_name->getClientOriginalName();
        }

        $data = array(
            "uploaded" => 1,
            "fileName" => $uploaded_file_name,
            "url" => 'https://job.tc/assets/ckeditor_uploaded_images/' . $uploaded_file_name
                //"url" => 'http://localhost:8000/assets/ckeditor_uploaded_images/' . $uploaded_file_name
        );

        return json_encode($data);
    }

    //For initial save of task item in Task Checklist table
    public function addNewTask(Request $request) {

        $user_id = $request->input('user_id');
        $task_id = $request->input('task_id');

        $task_check_list = new TaskChecklist();
        $task_check_list->user_id = $user_id;
        $task_check_list->task_id = $task_id;
        $task_check_list->checklist_header = '<div style=\"color:red\">No Title</div>';
        $task_check_list->checklist = '';
        $task_check_list->save();


        $has_order_list = TaskChecklistOrder::where('task_id', '=', $task_check_list->task_id)->count();

        if ($has_order_list > 0) {
            //then get the new task list item id and append it as the last item on the order
            $taskCheckListOrderString = TaskChecklistOrder::where('task_id', '=', $task_check_list->task_id)->pluck('task_id_order');
            $task_list_id_array = $taskCheckListOrderString . ',' . $task_check_list->id;
            $taskCheckListOrderUpdate = TaskChecklistOrder::where('task_id', $task_check_list->task_id)->update([
                'task_id_order' => $task_list_id_array
            ]);

            //$data = TaskChecklist::where('task_id', '=', $taskCheckList->task_id)->get();
            $data = TaskChecklist::where('task_id', '=', $task_check_list->task_id)->orderBy(DB::raw('FIELD(id,' . $task_list_id_array . ')'))->get();
        } else {
            $data = TaskChecklist::where('task_id', '=', $task_check_list->task_id)->get();
        }

        return $task_check_list->id;
    }

    public function saveTaskCheckListHeader(Request $request) {
        $task_checklist_id = $request->input('task_check_list_id');
        $checklist_header = $request->input('checklist_header');

        if ($checklist_header === '') {
            $checklist_header = 'No Title';
        }

        $task_check_list = TaskChecklist::where('id', $task_checklist_id);
        $task_check_list->update([
            'checklist_header' => $checklist_header
        ]);

        return "true";
    }

    public function saveTaskCheckList(Request $request) {
        $task_checklist_id = $request->input('task_check_list_id');
        $checklist_content = $request->input('checklist_content');

        $task_check_list = TaskChecklist::where('id', $task_checklist_id);
        $task_check_list->update([
            'checklist' => $checklist_content
        ]);

        return "true";
    }

    public function cancelAddNewTask(Request $request) {
        $task_checklist_id = $request->input('task_check_list_id');
        $task_check_list = TaskChecklist::where('id', $task_checklist_id);
        $task_check_list->delete();

        return "true";
    }

    public function getTaskChecklistItem(Request $request, $task_check_list_id, $company_id, $task_list_id) {
        //$task_check_list_id = $request->input('task_check_list_id');
        //$data = TaskChecklist::where('id', '=', $task_check_list_id)->get();
        //return json_encode($data);

        $user_id = Auth::user('user')->user_id;

        $list_item = TaskChecklist::where('id', $task_check_list_id)->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        $links = Link::select(
                        'links.id', 'title', 'url', 'descriptions', 'tags', 'comments', 'task_id', 'task_item_id', 'user_id', 'link_categories.name as category_name'
                )
                ->leftJoin('link_categories', 'link_categories.id', '=', 'links.category_id')
                ->where('task_id', '=', $task_list_id)
                ->get();

        $categories = LinkCategory::all()
                ->lists('name', 'id')
                ->toArray();

        return view('task.partials._taskchecklistitem', [
            'list_item' => $list_item,
            'module_permissions' => $module_permissions,
            'links' => $links,
            'user_id' => $user_id,
            'company_id' => $company_id,
            'categories' => $categories
        ]);
    }

    public function saveSpreadsheet(Request $request) {
        //$taskCheckList = new TaskChecklist($request->all());
        //$taskCheckList->save();
        $task_id = $request->input('task_id');
        $task_check_list_id = $request->input('task_check_list_id');
        $checklist_header = $request->input('checklist_header');
        $checklist = $request->input('checklist');

        $taskCheckList = TaskChecklist::where('id', $task_check_list_id);

        $taskCheckList->update([
            'checklist_header' => $checklist_header,
            'checklist' => $checklist,
        ]);

        $has_order_list = TaskChecklistOrder::where('task_id', '=', $task_id)->count();

        if ($has_order_list > 0) {
            //then get the new task list item id and append it as the last item on the order
            $taskCheckListOrderString = TaskChecklistOrder::where('task_id', '=', $task_id)->pluck('task_id_order');
            $task_list_id_array = $taskCheckListOrderString . ',' . $task_id;
            $taskCheckListOrderUpdate = TaskChecklistOrder::where('task_id', $task_id)->update([
                'task_id_order' => $task_list_id_array
            ]);

            //$data = TaskChecklist::where('task_id', '=', $taskCheckList->task_id)->get();
            $data = TaskChecklist::where('task_id', '=', $task_id)->orderBy(DB::raw('FIELD(id,' . $task_list_id_array . ')'))->get();
        } else {
            $data = TaskChecklist::where('task_id', '=', $task_id)->get();
        }

        return json_encode($data);
    }

    public function addBriefcaseForm() {
        return view('forms.addBriefcaseForm');
    }

    public function addBriefcase(Request $request) {

        $user_id = Auth::user('user')->user_id;
        $project_id = $request->input('project_id');
        $title = $request->input('title');

        $project = Project::where('project_id', $project_id)->first();

        $task = new Task;
        $task->belongs_to = 'project';
        $task->unique_id = $project_id;
        $task->task_title = $title;
        $task->task_description = '';
        $task->is_visible = 'yes';
        $task->task_status = 'pending';
        $task->user_id = $user_id;
        $task->project_id = $project_id;
        $task->save();

        //If the one who added the briefcase isn't the project owner,
        // Give permissions to them automatically
        if ($project->user_id !== $user_id) {
            $task_check_list_permission = new TaskCheckListPermission();
            $task_check_list_permission->task_id = $task->task_id;
            $task_check_list_permission->user_id = $user_id;
            $task_check_list_permission->project_id = $project_id;
            $task_check_list_permission->company_id = $project->company_id;
            $task_check_list_permission->save();
        }

        return view('task.partials._briefcase', [
            'task' => $task
        ]);
    }

    public function autoSaveEditChecklist(Request $request) {
        $task_check_list_id = $request->input('task_check_list_id');
        $checklist = $request->input('checklist');

        $taskCheckList = TaskChecklist::where('id', $task_check_list_id);

        $taskCheckList->update([
            'checklist' => $checklist
        ]);

        return "true";
    }

    public function getTaskListItem(Request $request, $id) {

        $user_id = Auth::user('user')->user_id;
        $company_id = $request->input('company_id');

        $list_item = TaskChecklist::where('id', $id)->first();

        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $company_id)
                ->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        return view('task._partials._taskchecklistitem', [
            'list_item' => $list_item,
            'module_permissions' => $module_permissions
        ]);
    }

    public function startTask(Request $request) {

        $user_id = Auth::user()->user_id;
        $task_checklist_id = $request->input('task_checklist_id');
        $task_id = TaskChecklist::where('id', $task_checklist_id)->pluck('task_id');
        $project_id = Task::where('task_id', $task_id)->pluck('project_id');

        $current_timestamp = time();

        $start_timestamp = date('Y-m-d H:i:s', $current_timestamp);

        $timer_exists = Timer::where('user_id', $user_id)->where('task_checklist_id', $task_checklist_id)->count();

        $timers_running = Timer::where('user_id', $user_id)->where('timer_status', 'Started')->orWhere('timer_status', 'Resumed')->where('user_id', $user_id)->count();

        if ($timer_exists > 0) {
            $timer = Timer::where('user_id', $user_id)->where('task_checklist_id', $task_checklist_id)->update([
                'timer_status' => 'Started'
            ]);

            $timer_id = Timer::where('user_id', $user_id)->where('task_checklist_id', $task_checklist_id)->pluck('timer_id');

            if ($timers_running > 0) {
                $stop_timers = Timer::where('user_id', $user_id)->where('timer_status', 'Started')->orWhere('timer_status', 'Resumed')->where('user_id', $user_id)->update([
                    'timer_status' => 'Paused'
                ]);
            }
        } else {

            /* if ($timers_running > 0) {
              $stop_timers = Timer::whereNotIn('user_id', $user_id)->where('timer_status', 'Started')->orWhere('timer_status', 'Resumed')->update([
              'timer_status' => 'Paused'
              ]);
              } */

            if ($timers_running > 0) {
                $stop_timers = Timer::where('user_id', $user_id)->where('timer_status', 'Started')->orWhere('timer_status', 'Resumed')->where('user_id', $user_id)->update([
                    'timer_status' => 'Paused'
                ]);
            }

            $timer = new Timer([
                'user_id' => $user_id,
                'task_checklist_id' => $task_checklist_id,
                'start_time' => $start_timestamp,
                'task_id' => $task_id,
                'project_id' => $project_id,
                'timer_status' => 'Started'
            ]);
            $timer->save();
            $timer_id = $timer->timer_id;
        }
        return $timer_id;
    }

    public function pauseTask(Request $request) {

        $user_id = Auth::user()->user_id;

        $timer_id = $request->input('timer_id');
        $task_checklist_id = $request->input('task_checklist_id');
        $time = $request->input('time');

        $current_timestamp = time();

        $end_timestamp = date('Y-m-d H:i:s', $current_timestamp);

        $previous_timers_count = Timer::where('user_id', $user_id)->where('task_checklist_id', $task_checklist_id)->whereRaw("DATE(created_at) <> DATE(NOW())")->count();

        if ($previous_timers_count === 0) {
            $timer = Timer::where('timer_id', $timer_id)->update([
                'end_time' => $end_timestamp,
                'total_time' => $time,
                'timer_status' => 'Paused'
            ]);
        } else {

            $previous_timers = Timer::select(DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum'))->where('user_id', $user_id)->where('task_checklist_id', $task_checklist_id)->whereRaw("DATE(created_at) <> DATE(NOW())")->first();

            $total_time_today = date('H:i:s', strtotime($time) - strtotime($previous_timers->timeSum));
            $timer = Timer::where('timer_id', $timer_id)->update([
                'end_time' => $end_timestamp,
                'total_time' => $total_time_today,
                'timer_status' => 'Paused'
            ]);
        }

        return "true";
    }

    public function resumeTask(Request $request) {

        $timer_id = $request->input('timer_id');

        $user_id = Auth::user()->user_id;

        $timers_running = Timer::where('user_id', $user_id)->where('timer_status', 'Started')->orWhere('timer_status', 'Resumed')->where('user_id', $user_id)->count();

        if ($timers_running > 0) {
            $stop_timers = Timer::where('user_id', $user_id)->where('timer_status', 'Started')->orWhere('timer_status', 'Resumed')->where('user_id', $user_id)->update([
                'timer_status' => 'Paused'
            ]);
        }

        $current_timestamp = time();

        $current_timestamp_format = date('Y-m-d', $current_timestamp);

        $day_start = strtotime(Timer::where('timer_id', $timer_id)->pluck('created_at'));
        $day_start_format = date('Y-m-d', $day_start);


        if ($current_timestamp_format === $day_start_format) {

            $timer = Timer::where('timer_id', $timer_id)->update([
                'end_time' => '',
                'timer_status' => 'Resumed'
            ]);
        } else {

            $previous_timer = Timer::where('timer_id', $timer_id)->first();
            $start_time = date('Y-m-d H:i:s', $current_timestamp);

            $timer = new Timer([
                'user_id' => $user_id,
                'task_checklist_id' => $previous_timer->task_checklist_id,
                'start_time' => $start_time,
                'task_id' => $previous_timer->task_id,
                'project_id' => $previous_timer->project_id,
                'timer_status' => 'Resumed'
            ]);
            $timer->save();
            $timer_id = $timer->timer_id;
        }
        return $timer_id;
    }

    public function endTask(Request $request) {

        $user_id = Auth::user()->user_id;

        $timer_id = $request->input('timer_id');
        $time = $request->input('time');

        $current_timestamp = time();

        $start_timestamp = Timer::where('timer_id', $timer_id)->pluck('start_time');
        $end_timestamp = date('Y-m-d H:i:s', $current_timestamp);

        $start_date = date_create($start_timestamp);
        $end_date = date_create($end_timestamp);
        $diff = date_diff($start_date, $end_date);

        $total_time = $diff->format('%H:%I:%S');

        $timer = Timer::where('timer_id', $timer_id)->update([
            'end_time' => $end_timestamp,
            'total_time' => $time,
            'timer_status' => 'Completed'
        ]);

        return "true";
    }

    public function saveCurrentTime(Request $request) {
        $user_id = Auth::user()->user_id;

        $timer_id = $request->input('timer_id');
        $task_checklist_id = $request->input('task_checklist_id');
        $time = $request->input('time');

        $current_timestamp = time();

        $end_timestamp = date('Y-m-d H:i:s', $current_timestamp);

        $previous_timers_count = Timer::where('user_id', $user_id)->where('task_checklist_id', $task_checklist_id)->whereRaw("DATE(created_at) <> DATE(NOW())")->count();

        if ($previous_timers_count === 0) {
            $timer = Timer::where('timer_id', $timer_id)->update([
                'end_time' => $end_timestamp,
                'total_time' => $time,
                'timer_status' => 'Resumed'
            ]);
        } else {

            $previous_timers = Timer::select(DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum'))->where('user_id', $user_id)->where('task_checklist_id', $task_checklist_id)->whereRaw("DATE(created_at) <> DATE(NOW())")->first();

            $total_time_today = date('H:i:s', strtotime($time) - strtotime($previous_timers->timeSum));
            $timer = Timer::where('timer_id', $timer_id)->update([
                'end_time' => $end_timestamp,
                'total_time' => $total_time_today,
                'timer_status' => 'Resumed'
            ]);
        }

        return "true";
    }

}

?>
