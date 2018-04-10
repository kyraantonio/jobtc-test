<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Applicant;
use App\Models\User;
use App\Models\Profile;
use \Auth;
use \View;
use \Form;
use \Input;
use \Redirect;

/* class SessionController extends BaseController {

  public function create(Request $request) {

  if (Auth::check('user') || Auth::viaRemember('user')) {
  return Redirect::to('dashboard');
  } elseif (Auth::check('applicant') || Auth::viaRemember('applicant')) {
  return Redirect::to('a/' . Auth::user('applicant')->id);
  }

  return View::make('session.create');
  }

  public function store(Request $request) {
  if (Auth::attempt('user',Input::only('email', 'password'), Input::get('remember'))) {
  if (Auth::user('user')->user_status != 'Active') {
  $name = Auth::user('user')->name;
  Auth::logout('user');
  return Redirect::to('login')->withErrors("$name you are not allowed to login!!");

  } else {
  return Redirect::intended('dashboard');
  }

  } if (Auth::attempt('applicant',Input::only('email', 'password'), Input::get('remember'))) {

  $applicant = Applicant::where('email',$request->input('email'))->first();

  return Redirect::intended('a/'.$applicant->id);

  } else {
  return Redirect::back()->withErrors("Wrong username or password!!");
  }
  }

  public function destroy() {
  $name = Auth::user('user')->name;
  Auth::logout('user');
  return Redirect::to('login')->withSuccess("$name you are logged out!!");
  }

  } */

class SessionController extends Controller {

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('guest', ['except' => 'getLogout']);
    }

    public function create(Request $request) {

        //Get the authority level for the user
        if (Auth::check('user') || Auth::viaRemember('user')) {

            $user = User::where('user_id', Auth::user('user')->user_id)->first();
            $user_has_profile = Profile::where('user_id', Auth::user('user')->user_id)->count();

            if ($user_has_profile > 0) {
                $profile = Profile::where('user_id', Auth::user('user')->user_id)->first();

                return redirect()->route('company', [$profile->company_id]);
            } else {
                return redirect()->route('dashboard');
            }
        } elseif (Auth::check('applicant') || Auth::viaRemember('applicant')) {
            return redirect()->route('a', [Auth::user('applicant')->id]);
        }

        return redirect('login')->withInput(Request::flashExcept('password'));
    }

    /**
     * landing page for user
     *
     * @param  request  $request
     * @return Response
     */
    public function login(Request $request) {

        $email = $request->input('email');
        $pass = $request->input('password');
        $remember = $request->input('remember');


        if ($remember === 0) {
            $remember = false;
        } else {
            $remember = true;
        }

        $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required'
        ]);

        if ($validator->fails()) {

            return redirect('login')->withInput();
            
        } else {
            if (Auth::attempt("user", ['email' => $email, 'password' => $pass], $remember)) {

                //return redirect()->route('dashboard');

                $user = User::where('user_id', Auth::user('user')->user_id)->first();
                $user_has_profile = Profile::where('user_id', Auth::user('user')->user_id)->count();

                if ($user_has_profile > 0) {
                    $profile = Profile::where('user_id', Auth::user('user')->user_id)->first();

                    return redirect()->route('company', [$profile->company_id]);
                } else {
                    return redirect()->route('dashboard');
                }
            } else if (Auth::attempt("applicant", ['email' => $email, 'password' => $pass], $remember)) {

                $applicant = Applicant::where('email', $email)->first();

                return redirect()->route('a', [$applicant->id]);
            } else {

                //$applicant = Applicant::where('email',$email)->where('password',bcrypt($pass))->first();

                return redirect('login')->withInput();
                //return redirect()->route('a', [$applicant->id]);
            }
        }
    }

    /**
     * Register user 
     * 
     * @param request $request
     * */
    public function register(Request $request) {

        $email = $request->input('email');
        $pass = $request->input('password');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $user_type = $request->input('user_type');

        $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required|confirmed',
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'user_type' => 'required'
        ]);


        if ($validator->fails()) {

            return redirect()->route('home')->withErrors($validator, 'register')->withInput();
        } else {
            //Create a new User
            $user = new User([
                'email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'user_type' => $user_type,
                'password' => bcrypt($pass)
            ]);

            $user->save();
            //Log the user in after registration
            if (Auth::attempt("user", ['email' => $email, 'password' => $pass])) {

                return redirect()->route('dashboard');
            } else {
                return redirect()->route('home');
            }
        } //Validator
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'username' => 'required|max:255|unique:users',
                    'password' => 'required|confirmed|min:3',
        ]);
    }

    public function authorizeUsersAndApplicants(Request $request) {
        if (Auth::check("user") || Auth::viaRemember("user")) {
            // Authentication passed...
            $user = User::where('user_id', Auth::user('user')->user_id)->first();
            $user_has_profile = Profile::where('user_id', Auth::user('user')->user_id)->count();

            if ($user_has_profile > 0) {
                $profile = Profile::where('user_id', Auth::user('user')->user_id)->first();

                return redirect()->route('company', [$profile->company_id]);
            } else {
                return redirect()->route('dashboard');
            }
        } else if (Auth::check("applicant") || Auth::viaRemember("applicant")) {

            return redirect()->route('a', [Auth::user("applicant")->id]);
            //return redirect()->intended('dashboard');
        } else {
            return redirect()->intended('dashboard');
        }
    }

    public function destroy() {
        if (Auth::check('user')) {
            $name = Auth::user('user')->name;
            Auth::logout('user');
            return Redirect::to('login')->withSuccess("$name you are logged out!!");
        } elseif (Auth::check('applicant')) {
            $name = Auth::user('applicant')->name;
            Auth::logout('applicant');
            return Redirect::to('login')->withSuccess("$name you are logged out!!");
        }
    }

}
