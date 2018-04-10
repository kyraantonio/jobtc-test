<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;
use Bican\Roles\Exceptions\RoleDeniedException;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskTimer;
use App\Models\TaskChecklist;
use App\Models\TaskChecklistOrder;
use App\Models\TaskCheckListPermission;
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

class TaskListItemController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $user_id = Auth::user('user')->user_id;
        $user = User::find($user_id);

        $task_id = TaskChecklist::where('id',$id)->pluck('task_id');
        $project_id = Task::where('task_id',$task_id)->pluck('project_id');
        
        
        //Check if there is an entry in the taskchecklist order table
        $task_order_count = TaskChecklistOrder::where('task_id', $task_id)->count();

        if ($task_order_count > 0) {
            $task_order = TaskChecklistOrder::where('task_id', $task_id)->first();
            $checkList = TaskChecklist::with(['timer' => function($query) use($user_id) {
                            $query->select(DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, MAX(timer_id) as timer_id, MAX(timer_status) as timer_status, user_id,project_id,task_checklist_id'))->where('user_id', $user_id)->groupBy('task_checklist_id')->get();
                        },'task_checklist_statuses'])->where('id', '=', $id)->orderBy(DB::raw('FIELD(id,' . $task_order->task_id_order . ')'))->first();
            
        } else {
            $task_order = TaskChecklistOrder::where('task_id', $task_id)->first();
            $checkList = TaskChecklist::with(['timer' => function($query) use($user_id) {
                            $query->select(DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, MAX(timer_id) as timer_id, MAX(timer_status) as timer_status, user_id,project_id,task_checklist_id'))->where('user_id', $user_id)->groupBy('task_checklist_id')->get();
                        },'task_checklist_statuses'])->where('id', '=', $id)->first();
        }

        $links = Link::select(
                        'links.id', 'title', 'url', 'descriptions', 'tags', 'comments', 'task_item_id', 'user_id', 'link_categories.name as category_name'
                )
                ->leftJoin('link_categories', 'link_categories.id', '=', 'links.category_id')
                ->where('task_id', '=', $task_id)
                ->get();

        $categories = LinkCategory::all()
                ->lists('name', 'id')
                ->toArray();


        $company_id = Project::where('project_id', $project_id)->pluck('company_id');

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        $project_owner = Project::where('project_id', $project_id)->pluck('user_id');

        $assets = ['tasks'];

        return view('tasklistitems.show', [
            'assets' => $assets,
            'list_item' => $checkList,
            'links' => $links,
            'user_id' => $user_id,
            'categories' => $categories,
            'module_permissions' => $module_permissions,
            'company_id' => $company_id,
            'project_owner' => $project_owner,
            'task_id' => $task_id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
