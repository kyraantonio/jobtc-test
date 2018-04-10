<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Country;
use App\Models\Company;
use App\Models\Profile;
use App\Models\Comment;
use App\Models\Video;
use App\Models\Tag;
use App\Models\PermissionUser;
use App\Models\PermissionRole;
use App\Models\Permission;
use Bican\Roles\Models\Role;
use App\Models\Module;
use App\Models\ProfileLevel;
use App\Models\Rate;
use Illuminate\Support\Facades\Storage;
use Elasticsearch\ClientBuilder as ES;
use DB;
use Illuminate\Http\Request;
use Validator;
use Input;
use Redirect;
use View;
use Hash;
use Auth;

class UserController extends BaseController {

    public function index() {
        /* $user = DB::table('user')
          ->join('profiles','profiles.user_id','=','user.user_id')
          ->join('roles','profiles.role_id','=','roles.id')
          ->join('companies','profiles.company_id','=','companies.id')
          ->select('user.user_id','user.user_status', 'user.name','user.email','roles.id as role_id','roles.name as role','companies.name as company_name')
          ->get(); */

        //Get countries for dropdown       
        $countries = Country::orderBy('country_name', 'asc')
                ->lists('country_name', 'country_id')
                ->toArray();

        //The profiles already contain all user, role and company information (it's fields belong to all 3 tables)
        $profiles = Profile::all();

        $role = Role::orderBy('name', 'asc')
                ->lists('name', 'id');

        $client_options = Company::orderBy('name', 'asc')
                ->lists('name', 'id');

        $assets = ['table', 'select2'];

        return View::make('user.index', [
                    'profiles' => $profiles,
                    'companies' => $client_options,
                    'countries' => $countries,
                    'roles' => $role,
                    'assets' => $assets
        ]);
    }

    public function show($user_id, $company_id) {

        $logged_in_user = Auth::user('user')->user_id;

        $profile = Profile::with('user')->where('user_id', $user_id)->where('company_id', $company_id)->first();

        $countries = Country::where('country_id', $profile->user->country_id)->first();

        $role = Role::where('id', $profile->role_id)->first();

        $user_info = User::with('profile')->where('user_id', $logged_in_user)->first();

        $videos = Video::with(['tags' => function($query) {
                        $query->where('tag_type', 'video')->first();
                    }])->where('unique_id', $user_id)->where('user_type', 'employee')->orderBy('id', 'desc')->get();

        $user_tags = Tag::where('unique_id', $user_id)
                ->where('tag_type', 'employee')
                ->first();

        $comments = Comment::with('user')
                        ->where('belongs_to', 'employee')
                        ->where('unique_id', $user_id)
                        ->orderBy('comment_id', 'desc')->get();

        $assets = ['users', 'real-time'];

        return view('user.show', [
            'profile' => $profile,
            'country' => $countries,
            'role' => $role,
            'user_info' => $user_info,
            'user_tags' => $user_tags,
            'videos' => $videos,
            'comments' => $comments,
            'assets' => $assets,
            'count' => 0]);
    }

    public function create() {
        return View::make('user.create');
    }

    public function edit($id) {
        $user = DB::table('user')
//            ->join('assigned_roles', 'assigned_roles.user_id', '=', 'user.user_id')
                ->join('role_user', 'role_user.user_id', '=', 'user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('roles.level', '<>', '1')
                ->where('user.user_id', '=', $id)
                ->first();

        $role = Role::orderBy('name', 'asc')->lists('name', 'id');

        $client_options = Company::orderBy('company_name', 'asc')
                        ->lists('company_name', 'client_id')->toArray();

        if ($user) {

            return View::make('user.edit', [
                        'user' => $user,
                        'clients' => $client_options,
                        'roles' => $role
            ]);
        }

        return Redirect::to('user')->withErrors('Wrong user id to edit!!');
    }

    public function store(Request $request) {

        $role = Role::orderBy('name', 'asc')->lists('name', 'id');

        $validation = Validator::make($request->all(), [
                    'password' => 'required',
                    'email' => 'required',
                    'name' => 'required',
                    'role_id' => 'required'
        ]);

        if ($validation->fails()) {
            return Redirect::to('user')->withErrors($validation->messages());
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            if (file_exists(public_path('assets/user/' . $photo->getClientOriginalName()))) {
                $photo_path = 'assets/user/' . $photo->getClientOriginalName();
            } else {
                $photo_save = $photo->move('assets/user/', $photo->getClientOriginalName());
                $photo_path = $photo_save->getPathname();
            }
        } else {
            if ($photo_path === '' || $photo_path === NULL) {
                $photo_path = 'assets/user/default-avatar.jpg';
            }
        }

        $ticketit_admin = $request->input('ticketit_admin');
        $ticketit_agent = $request->input('ticketit_agent');


        if ($ticketit_admin === NULL) {
            $ticketit_admin = 0;
        }

        if ($ticketit_agent === NULL) {
            $ticketit_agent = 0;
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->photo = $photo_path;
        $user->address_1 = $request->input('address_1');
        $user->address_2 = $request->input('address_2');
        $user->zipcode = $request->input('zipcode');
        $user->country_id = $request->input('country_id');
        $user->skype = $request->input('skype');
        $user->facebook = $request->input('facebook');
        $user->linkedin = $request->input('linkedin');
        $user->ticketit_admin = $ticketit_admin;
        $user->ticketit_agent = $ticketit_agent;
        $user->user_status = 'Active';

        $user->save();

        $profile = new Profile;
        $profile->user_id = $user->user_id;
        $profile->company_id = $request->input('company_id');
        $profile->role_id = $request->input('role_id');
        $profile->save();

        $user->attachRole($request->input('role_id'));

        return Redirect::to('user')->withSuccess("User added successfully!!");
    }

    public function update(Request $request, $id) {
        $user = User::find($id);
        $validation = Validator::make(Input::all(), [
                    'email' => 'required',
                    'name' => 'required',
                    'role_id' => 'required'
        ]);

        if ($validation->fails()) {
            return Redirect::to('user')->withErrors($validation->messages());
        }

        $clientRole = Role::where('id', Input::get('role_id'))->first();
        if ($clientRole && $clientRole->slug === 'client') {

            // no company id the return.
            if (!Input::get('client_id')) {

                print_r(Input::get('client_id'));
                die();
                return Redirect::to('user')->withInput($request->except('password'))
                                ->withErrors('A client should have a company!!');
            }
        }

        $user->client_id = Input::get('client_id');
        $user->name = Input::get('name');

        if (Input::get('user_status') != 'Ban') {
            $user->user_status = 'Active';
            $user->user_status_detail = '';
        } else {
            $user->user_status = 'Ban';
            $user->user_status_detail = Input::get('user_status_detail');
        }


        $user->email = Input::get('email');
        $user->phone = Input::get('phone');
        $user->save();
        $user->detachRole($user->role_id);
        $user->attachRole(Input::get('role_id'));

        return Redirect::to('user')->withSuccess("User updated successfully!!");
    }

    public function destroy() {
        
    }

    public function delete($user_id) {
        $user = User::find($user_id);

        $user->delete();

        return Redirect::to('user')->withSuccess("User deleted successfully!!");
    }

    public function getRegisterForm() {

        $companies = Company::all();
        $countries = Country::all();

        return view('user.register', ['companies' => $companies, 'countries' => $countries]);
    }

    public function register(Request $request) {

        $validation = Validator::make($request->all(), [
                    'password' => 'required',
                    'email' => 'required',
                    'name' => 'required'
        ]);

        if ($validation->fails()) {
            return Redirect::to('register')->withErrors($validation->messages());
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->ticketit_admin = 0;
        $user->ticketit_agent = 0;
        $user->user_status = 'Active';
        $user->save();

        //Create an index for searching
        $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();
        $params = array();
        $params['body'] = array(
            'name' => $user->name
        );
        $params['index'] = 'default';
        $params['type'] = 'employee';
        $params['id'] = $user->user_id;
        $results = $client->index($params);       //using Index() function to inject the data

        $new_user_role = Role::where('company_id', 0)
                ->where('level', 2)
                ->first();

//Set the newly registered user to company id 0(No Company)
        //$profile = new Profile;
        //$profile->user_id = $user->user_id;
        //$profile->company_id = 0;
        //$profile->role_id = $new_user_role->id;
        //$profile->save();

        $user->attachRole($new_user_role->id);

        Auth::loginUsingId("user", $user->user_id);

        return redirect()->route('dashboard');
    }

    public function addEmployeeForm(Request $request, $id) {

        $user_id = Auth::user('user')->user_id;

        $positions = Role::where('company_id', $id)->get();

        $user_list = [];

        $company_profiles = Profile::with('user')
                ->where('company_id', $id)
                ->get();

        foreach ($company_profiles as $company_profile) {
            array_push($user_list, $company_profile->user_id);
        }

        $profiles = User::whereNotIn('user_id', $user_list)
                ->get();

        return view('forms.addEmployeeForm', [
            'positions' => $positions,
            'profiles' => $profiles
        ]);
    }

    public function editEmployeeForm(Request $request, $company_id, $user_id) {

        $my_profile = Profile::where('user_id', Auth::user('user')->user_id)
                        ->where('company_id', $company_id)->first();

        $profile = Profile::with('user')
                ->where('user_id', $user_id)
                ->where('company_id', $company_id)
                ->first();

        $positions = Role::where('company_id', $company_id)->get();

        //Check if this employee is below you 
        $logged_user_above_count = ProfileLevel::where('profile_id', $my_profile->id)
                ->where('profile_level', 'above')
                ->where('unique_id', $profile->id)
                ->count();

        $employee_is_below_count = ProfileLevel::where('profile_id', $profile->id)
                ->where('profile_level', 'below')
                ->where('unique_id', $my_profile->id)
                ->count();

        $employee_is_above_count = ProfileLevel::where('profile_id', $my_profile->id)
                ->where('profile_level', 'below')
                ->where('unique_id', $profile->id)
                ->count();

        if ($logged_user_above_count > 0 && $employee_is_below_count === 0) {

            $profile_levels = ProfileLevel::where('profile_id', $my_profile->id)
                    ->where('unique_id', $profile->id)
                    ->first();
        } elseif ($logged_user_above_count === 0 && $employee_is_below_count > 0) {

            $profile_levels = ProfileLevel::where('profile_id', $profile->id)
                    ->where('unique_id', $my_profile->id)
                    ->first();
        } else {
            $profile_levels = ProfileLevel::where('profile_id', $profile->id)
                    ->where('unique_id', $my_profile->id)
                    ->first();
        }

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        return view('forms.editEmployeeForm', [
            'profile' => $profile,
            'profile_levels' => $profile_levels,
            'logged_user_above_count' => $logged_user_above_count,
            'employee_is_above_count' => $employee_is_above_count,
            'employee_is_below_count' => $employee_is_below_count,
            'positions' => $positions,
            'countries' => $countries_option
        ]);
    }

    public function addEmployee(Request $request) {

        $employee_id = Auth::user('user')->user_id;
        $company_id = $request->input('company_id');

        if ($request->has('name')) {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            $user = new User;
            $user->name = $name;
            $user->password = bcrypt($password);
            $user->email = $email;
            $user->ticketit_admin = 0;
            $user->ticketit_agent = 0;
            $user->user_status = 'Active';
            $user->save();

            //Create an index for searching
            $client = ES::create()
                    ->setHosts(\Config::get('elasticsearch.host'))
                    ->build();
            $params = array();
            $params['body'] = array(
                'name' => $request->input('name')
            );
            $params['index'] = 'default';
            $params['type'] = 'employee';
            $params['id'] = $user->user_id;
            $results = $client->index($params);       //using Index() function to inject the data
        }

        if ($request->has('user_id')) {
            $user_id = $request->input('user_id');
            $user = User::find($user_id);
        }

        if ($request->has('role_id')) {
            $role_id = $request->input('role_id');
            $user_role = Role::where('company_id', $company_id)
                    ->where('id', $role_id)
                    ->first();
        }

        if ($request->has('position')) {
            $position = $request->input('position');

            $user_role = new Role();
            $user_role->company_id = $company_id;
            $user_role->name = $position;
            $user_role->slug = strtolower($position) . '-' . $company_id;
            $user_role->description = '';
            $user_role->level = 1;
            $user_role->save();
        }

        //Set the newly registered user to current company
        $no_company_profile_count = Profile::where('user_id', $user->user_id)->where('company_id', 0)->count();
        if ($no_company_profile_count > 0) {

            $delete_profile = Profile::where('user_id', $user->user_id)->where('company_id', 0);
            $delete_profile->delete();
        }

        $profile = new Profile();
        $profile->user_id = $user->user_id;
        $profile->company_id = $company_id;
        $profile->role_id = $user_role->id;
        $profile->save();

        $user->attachRole($user_role->id);

        if ($request->has('authority')) {
            $authority = $request->input('authority');

            $my_profile = Profile::where('user_id', $employee_id)->where('company_id', $company_id)->first();

            $profile_levels = new ProfileLevel();
            $profile_levels->profile_id = $profile->id;
            $profile_levels->profile_level = $authority;
            $profile_levels->unique_id = $my_profile->id;
            $profile_levels->save();
        }

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        //Role Manager Permissions(Bican Roles Permissions)
        $permissions_list = [];

        $permission_user = PermissionUser::with('permission')
                ->where('company_id', $company_id)
                ->where('user_id', $employee_id)
                ->get();

        foreach ($permission_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();

        //Check if this employee is below you 
        $logged_user_above_count = ProfileLevel::where('profile_id', $my_profile->id)
                ->where('profile_level', 'above')
                ->where('unique_id', $profile->id)
                ->count();

        $employee_is_below_count = ProfileLevel::where('profile_id', $profile->id)
                ->where('profile_level', 'below')
                ->where('unique_id', $my_profile->id)
                ->count();

        $employee_is_above_count = ProfileLevel::where('profile_id', $my_profile->id)
                ->where('profile_level', 'below')
                ->where('unique_id', $profile->id)
                ->count();

        return view('user.partials._newemployee', [
            'profile' => $profile,
            'countries' => $countries_option,
            'module_permissions' => $module_permissions,
            'logged_user_above_count' => $logged_user_above_count,
            'employee_is_below_count' => $employee_is_below_count,
            'employee_is_above_count' => $employee_is_above_count,
            'company_id' => $company_id
        ]);
    }

    public function editEmployee(Request $request) {

        $user_id = $request->input('user_id');
        $company_id = $request->input('company_id');

        $user = User::where('user_id', $user_id);
        $profile = Profile::where('user_id', $user_id)
                ->where('company_id', $company_id);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            if (file_exists(public_path('assets/user/' . $photo->getClientOriginalName()))) {
                $photo_path = 'assets/user/' . $photo->getClientOriginalName();
            } else {
                $photo_save = $photo->move('assets/user/', $photo->getClientOriginalName());
                $photo_path = $photo_save->getPathname();
            }
        } else {
            $photo_path = User::where('user_id', $user_id)->pluck('photo');

            if ($photo_path === '' || $photo_path === NULL) {
                $photo_path = 'assets/user/default-avatar.jpg';
            }
        }

        if ($request->hasFile('resume')) {
            $resume = $request->file('resume');
            if (file_exists(public_path('assets/user/resumes/' . $resume->getClientOriginalName()))) {
                $resume_path = 'assets/user/resumes/' . $resume->getClientOriginalName();
            } else {
                $resume_save = $resume->move('assets/user/resumes/', $resume->getClientOriginalName());
                $resume_path = $resume_save->getPathname();
            }
        } else {
            $resume_path = User::where('user_id', $user_id)->pluck('resume');
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'photo' => $photo_path,
            'resume' => $resume_path,
            'address_1' => $request->input('address_1'),
            'address_2' => $request->input('address_2'),
            'zipcode' => $request->input('zipcode'),
            'country_id' => $request->input('country_id'),
            'skype' => $request->input('skype'),
            'facebook' => $request->input('facebook'),
            'linkedin' => $request->input('linkedin'),
        ]);

        //Update the index for searching
        $client = ES::create()
                ->setHosts(\Config::get('elasticsearch.host'))
                ->build();
        $params = array();
        $params['body'] = array(
            'doc' => [
                'name' => $request->input('name')
            ]
        );
        $params['index'] = 'default';
        $params['type'] = 'employee';
        $params['id'] = $user_id;
        $results = $client->update($params);       //using Index() function to inject the data

        $data = array('photo' => $photo_path);

        if ($request->has('position')) {
            $position = $request->input('position');

            $user_role = new Role();
            $user_role->company_id = $company_id;
            $user_role->name = $position;
            $user_role->slug = strtolower($position) . '-' . $company_id;
            $user_role->description = '';
            $user_role->level = 1;
            $user_role->save();

            $profile->update([
                'role_id' => $user_role->id
            ]);

            $data['position'] = $user_role->name;
        }

        if ($request->has('role_id')) {
            $role_id = $request->input('role_id');
            $profile->update([
                'role_id' => $role_id
            ]);

            $user_role = Role::find($role_id);

            $data['position'] = $user_role->name;
        }

        if ($request->has('authority')) {
            $authority = $request->input('authority');

            $employee_id = Auth::user('user')->user_id;

            $my_profile = Profile::where('user_id', $employee_id)->where('company_id', $company_id)->first();

            $profile_levels = ProfileLevel::where('profile_id', $profile->pluck('id'))->where('unique_id', $my_profile->id);

            //If my profile id is equal to the employee id, Logged in user is editing his/her profile
            if ($my_profile->id !== $profile->pluck('id')) {
                if ($profile_levels->count() > 0) {

                    $profile_levels->update([
                        'profile_level' => $authority
                    ]);
                } else {
                    $new_profile_level = new ProfileLevel();
                    $new_profile_level->profile_id = $profile->pluck('id');
                    $new_profile_level->profile_level = $authority;
                    $new_profile_level->unique_id = $my_profile->id;
                    $new_profile_level->save();
                }
            }
        }

        return json_encode($data);
    }

    public function removeEmployeeFromCompany(Request $request) {
        $user_id = $request->input('user_id');
        $company_id = $request->input('company_id');

        $profile = Profile::where('user_id', $user_id)->where('company_id', $company_id);

        //Remove profile levels
        $profile_levels = ProfileLevel::where('profile_id', $profile->pluck('id'))->orWhere('unique_id', $profile->pluck('id'));
        $profile_levels->delete();

        //Delete profile for this company
        $profile->delete();

        //Add a profile with company id 0 for this user 
        //if this user doesn't have any other profile with other companies
        $profile_count = Profile::where('user_id', $user_id)->count();

        if ($profile_count === 0) {
            $personal_user_role = Role::where('company_id', 0)->first();

            $personal_profile = new Profile();
            $personal_profile->user_id = $user_id;
            $personal_profile->company_id = 0;
            $personal_profile->role_id = $personal_user_role->id;
            $personal_profile->save();
        }
        return $user_id;
    }

    public function saveEmployeeNotes(Request $request) {
        $employee_id = $request->input('employee_id');
        $notes = $request->input('notes');

        $employee = User::where('user_id', $employee_id);
        $employee->update([
            'notes' => $notes
        ]);

        return "true";
    }

    public function editEmployeePermissionsForm(Request $request, $company_id, $user_id) {

        //$user_id = Auth::user('user')->user_id;

        $modules = Module::all();
        $permissions = Permission::all();

        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $company_id)
                ->first();

        $permissions_list = [];

        $permission_role = PermissionRole::with('permission')
                ->where('company_id', $company_id)
                ->where('role_id', $user_profile_role->role_id)
                ->get();

        $permission_user = PermissionUser::with('permission')
                ->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permission_role as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $position = Role::where('id', $user_profile_role->role_id)->first();

        $module_role_permissions = Permission::whereIn('id', $permissions_list)->get();

        $assets = ['companies', 'real-time'];

        return view('forms.editEmployeePermissionsForm', [
            'position' => $position,
            'permissions' => $permissions,
            'permission_role' => $permission_role,
            'permission_user' => $permission_user,
            'modules' => $modules,
            'module_role_permissions' => $module_role_permissions,
            'assets' => $assets,
            'user_id' => intval($user_id),
            'company_id' => intval($company_id)
        ]);
    }

    public function getEmployees(Request $request, $id) {

        $user_id = Auth::user('user')->user_id;

        $profiles = Profile::with('role','rate')->where('company_id', $id)->get();

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        $user_profile_role = Profile::where('user_id', $user_id)
                ->where('company_id', $id)
                ->first();

        $permissions_list = [];

        $permissions_user = PermissionUser::with('permission')
                ->where('company_id', $id)
                ->where('user_id', $user_id)
                ->get();

        foreach ($permissions_user as $role) {
            array_push($permissions_list, $role->permission_id);
        }

        $module_permissions = Permission::whereIn('id', $permissions_list)->get();
        
        $assets = ['companies', 'real-time'];

        return view('user.employees', [
            'profiles' => $profiles,
            'countries' => $countries_option,
            'module_permissions' => $module_permissions,
            'assets' => $assets,
            'company_id' => $id,
        ]);
    }

    private function removeFromString($str, $item) {
        $parts = explode(',', $str);

        while (($i = array_search($item, $parts)) !== false) {
            unset($parts[$i]);
        }

        return implode(',', $parts);
    }
    
}

?>
