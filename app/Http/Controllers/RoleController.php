<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Profile;
use App\Models\Module;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\PermissionUser;
use Auth;
use Elasticsearch\ClientBuilder as ES;

class RoleController extends Controller {

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

        $positions = Role::where('company_id', $id)->get();
        $modules = Module::all();
        $permissions = Permission::all();
        $permission_role = PermissionRole::all();

        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $id)
                ->first();

        $permissions_list = [];

        $permissions_role = PermissionRole::with('permission')
                ->where('company_id', $id)
                ->where('role_id', $user_profile_role->role_id)
                ->get();

        foreach ($permissions_role as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        $assets = ['companies', 'real-time'];

        return view('roles.show', [
            'positions' => $positions,
            'permissions' => $permissions,
            'permission_role' => $permission_role,
            'modules' => $modules,
            'module_permissions' => $module_permissions,
            'assets' => $assets,
            'company_id' => $id
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

    public function addPositionForm() {
        return view('forms.addPositionForm');
    }

    public function editPositionForm(Request $request, $id) {

        $position = Role::find($id);

        return view('forms.editPositionForm', [
            'position' => $position
        ]);
    }

    public function addPosition(Request $request) {
        $company_id = $request->input('company_id');
        $position_title = $request->input('position_title');
        $position_description = $request->input('position_description');

        $position = new Role();
        $position->company_id = $company_id;
        $position->company_division_id = 0;
        $position->name = $position_title;
        $position->slug = strtolower($position_title) . '-' . $company_id;
        $position->description = $position_description;
        $position->level = 1;
        $position->save();

        //Create an index for searching

        /*
        $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();*/
        $params = array();
        $params['body'] = array(
            'name' => $position->name
        );
        $params['index'] = 'default';
        $params['type'] = 'position';
        $params['id'] = $position->id;
        // $results = $client->index($params);       //using Index() function to inject the data

        $modules = Module::all();
        $permissions = Permission::all();
        $permission_role = PermissionRole::all();
        $permissions_list = [];
        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        return view('roles.partials._newposition', [
            'position' => $position,
            'permissions' => $permissions,
            'permission_role' => $permission_role,
            'modules' => $modules,
            'module_permissions' => $module_permissions,
            'company_id' => $company_id
        ]);
    }

    public function editPosition(Request $request) {

        $position_id = $request->input('position_id');
        $company_id = $request->input('company_id');
        $name = $request->input('title');
        $description = $request->input('description');

        $position = Role::where('id', $position_id);

        $position->update([
            'name' => $name,
            'slug' => strtolower($name) . '-' . $company_id,
            'description' => $description
        ]);

        //Update the index for searching
        /*
        $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();*/
        $params = array();
        $params['body'] = array(
            'doc' => [
                'name' => $name
            ]
        );
        $params['index'] = 'default';
        $params['type'] = 'position';
        $params['id'] = $position_id;
        // $results = $client->update($params);       //using Index() function to inject the data

        return "true";
    }

    public function deletePosition(Request $request) {

        $position_id = $request->input('position_id');

        $position = Role::where('id', $position_id);

        //Delete the index for searching
        /*
        $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();*/
        $params = array();

        $params['index'] = 'default';
        $params['type'] = 'position';
        $params['id'] = $position->pluck('id');
        // $results = $client->delete($params);       //using Index() function to inject the data

        $position->delete();

        return $position_id;
    }

    public function assignPositionPermission(Request $request) {

        $role_id = $request->input('role_id');
        $permission_id = $request->input('permission_id');
        $company_id = $request->input('company_id');

        $permission_role = new PermissionRole();
        $permission_role->role_id = $role_id;
        $permission_role->permission_id = $permission_id;
        $permission_role->company_id = $company_id;
        $permission_role->save();

        $profiles = Profile::where('company_id', $company_id)->where('role_id', $role_id)->get();

        foreach ($profiles as $profile) {

            $permission_user = new PermissionUser();
            $permission_user->user_id = $profile->user_id;
            $permission_user->permission_id = $permission_id;
            $permission_user->company_id = $company_id;
            $permission_user->save();
        }

        return "true";
    }

    public function unassignPositionPermission(Request $request) {

        $role_id = $request->input('role_id');
        $permission_id = $request->input('permission_id');
        $company_id = $request->input('company_id');

        $permission_role = PermissionRole::where('permission_id', $permission_id)->where('role_id', $role_id)->where('company_id', $company_id);
        $permission_role->delete();

        $profiles = Profile::where('company_id', $company_id)->where('role_id', $role_id)->get();

        foreach ($profiles as $profile) {
            $permission_user = PermissionUser::where('permission_id', $permission_id)->where('user_id', $profile->user_id)->where('company_id', $company_id);
            $permission_user->delete();
        }

        return "true";
    }

    public function assignEmployeePermission(Request $request) {

        $user_id = $request->input('user_id');
        $permission_id = $request->input('permission_id');
        $company_id = $request->input('company_id');

        $permission_user = new PermissionUser();
        $permission_user->user_id = $user_id;
        $permission_user->permission_id = $permission_id;
        $permission_user->company_id = $company_id;
        $permission_user->save();

        return "true";
    }

    public function unassignEmployeePermission(Request $request) {

        $user_id = $request->input('user_id');
        $permission_id = $request->input('permission_id');
        $company_id = $request->input('company_id');

        $permission_user = PermissionUser::where('permission_id', $permission_id)->where('user_id', $user_id)->where('company_id', $company_id);
        $permission_user->delete();

        return "true";
    }

}
