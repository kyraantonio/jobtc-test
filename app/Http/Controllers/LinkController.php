<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Task;
use App\Models\LinksOrder;
use App\Models\LinkCategory;
use App\Models\Permission;
use App\Models\PermissionUser;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Redirect;

class LinkController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $links = Link::select('links.id', 'title', 'url', 'descriptions', 'tags', 'comments', 'link_categories.name as category_name')
                ->leftJoin('link_categories', 'link_categories.id', '=', 'links.category_id')
                ->get();

        $categories = LinkCategory::all()
                ->lists('name', 'id')
                ->toArray();


        return view('links.index', [
            'assets' => ['table'],
            'links' => $links,
            'categories' => $categories
        ]);
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
        $from_dashboard = isset($request->is_dashboard) ? $request->is_dashboard : 0;
        unset($request->is_dashboard);

        $user_id = $request->input('user_id');
        $company_id = $request->input('company_id');


        $link = new Link($request->all());
        $link->save();

        $task = Task::find($request->task_id);

        $links = Link::select(
                        'links.id', 'title', 'url', 'descriptions', 'tags', 'comments', 'task_id', 'task_item_id', 'user_id', 'link_categories.name as category_name'
                )
                ->leftJoin('link_categories', 'link_categories.id', '=', 'links.category_id')
                ->where('links.id', '=', $link->id)
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

        $is_dashboard = $request->input('is_dashboard');

        if ($is_dashboard === '1') {

            $category_id = $request->input('category_id');

            return view('links.partials._linkitem', [
                'link' => $links,
                'module_permissions' => $module_permissions,
                'category_id' => $category_id
            ]);
        } else {
            return view('links.partials._linkitembriefcase', [
                'link' => $links,
                'task' => $task,
                'user_id' => $user_id,
                'company_id' => $company_id,
                'module_permissions' => $module_permissions,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $categories = LinkCategory::all()
                ->lists('name', 'id')
                ->toArray();

        $link = Link::find($id);

        return view('links.partials._form', [
            'assets' => [],
            'link' => $link,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        /** @var  $link Link */
        $link = Link::find($id);

        $link->update($request->all());

        $links = Link::select(
                        'links.id', 'title', 'url', 'descriptions', 'tags', 'comments', 'task_id', 'task_item_id', 'user_id', 'link_categories.name as category_name'
                )
                ->leftJoin('link_categories', 'link_categories.id', '=', 'links.category_id')
                ->where('links.id', '=', $id)
                ->first();

        $task = Task::find($request->task_id);

        $is_dashboard = $request->input('is_dashboard');

        $user_id = $request->input('user_id');
        $company_id = $request->input('company_id');

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        if ($is_dashboard === 1) {

            $category_id = $request->input('category_id');

            return view('links.partials._linkitem', [
                'link' => $links,
                'module_permissions' => $module_permissions,
                'category_id' => $category_id
            ]);
        } else {
            return view('links.partials._linkitembriefcase', [
                'link' => $links,
                'task' => $task,
                'user_id' => $user_id,
                'company_id' => $company_id,
                'module_permissions' => $module_permissions,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        /** @var  $link Link */
        $link = Link::find($id);
        $link->delete();

        return "true";
    }

    public function deleteLink($id) {

        /** @var  $link Link */
        $link = Link::find($id);
        if (count($link) > 0) {
            $link->delete();
        }

        return redirect()->route('links.index');
    }

    public function setLinkOrder(Request $request, $task_id, $company_id) {

        $count_links_order = LinksOrder::where('task_id', '=', $task_id)->count();

        $links_id_array = implode(",", str_replace("\"", '', $request->get('links_order')));

        if ($count_links_order > 0) {
            $links_order_list = LinksOrder::where('task_id', '=', $task_id)->first();

            $linksOrder = LinksOrder::find($links_order_list->id);
            $linksOrder->links_order = $links_id_array;
            $linksOrder->save();
        } else {
            $linksOrder = new LinksOrder();

            $linksOrder->task_id = $task_id;
            $linksOrder->company_id = $company_id;
            $linksOrder->links_order = $links_id_array;
            $linksOrder->save();
        }

        $links_new_order = LinksOrder::find($linksOrder->id);
        return json_encode($links_new_order);
    }

    public function editDashboardLink(Request $request, $link_id, $company_id) {

        $categories = LinkCategory::all()
                ->lists('name', 'id')
                ->toArray();

        $link = Link::find($link_id);

        $briefcase = Task::with(['project' => function($query) use ($company_id) {
                        $query->where('company_id', $company_id)->first();
                    }])->lists('task_title', 'task_id')->toArray();


        return view('links.partials._edit_dashboard_link_form', [
            'assets' => [],
            'link' => $link,
            'categories' => $categories,
            'briefcase' => $briefcase
        ]);
    }

    public function addLinkForm(Request $request) {

        $company_id = $request->input('company_id');

        $categories = LinkCategory::all()
                ->lists('name', 'id')
                ->toArray();

        $briefcase = Task::with(['project' => function($query) use ($company_id) {
                        $query->where('company_id', $company_id)->first();
                    }])->lists('task_title', 'task_id')->toArray();

        return view('links.partials._add_form', [
            'categories' => $categories,
            'briefcase' => $briefcase
        ]);
    }

    public function addLinkFormBriefcase(Request $request) {

        $categories = LinkCategory::all()
                ->lists('name', 'id')
                ->toArray();

        return view('links.partials._form', [
            'categories' => $categories
        ]);
    }

}
