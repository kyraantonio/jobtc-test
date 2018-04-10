<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Applicant;
use App\Models\Country;
use App\Models\PasswordReset;
use Hash;
use \DB;
use \Auth;
use \View;
use \Validator;
use \Input;
use \Redirect;
use Mail;

class ProfileController extends BaseController {

    public function index() {

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        $assets = ['profiles'];

        return view('user.profile', ['assets' => $assets, 'countries' => $countries_option]);
    }

    public function show(Request $request, $id) {

        $countries_option = Country::orderBy('country_name', 'asc')->get();

        $assets = ['profiles'];

        return view('user.profile', ['assets' => $assets, 'countries' => $countries_option]);
    }

    public function changePassword(Request $request) {
        /* $user = Auth::user();
          $rules = array(
          'password' => 'required|alphaNum|between:5,16',
          'new_password' => 'required|alphaNum|between:5,16|confirmed'
          );

          $validator = Validator::make(Input::all(), $rules);

          if ($validator->fails())
          return Redirect::back()->withErrors($validator);
          else {
          if (!Hash::check(Input::get('password'), $user->password))
          return Redirect::back()->withErrors('Your old password does not match!!');
          else {
          $user->password = Hash::make(Input::get('new_password'));
          $user->save();
          return Redirect::back()->withSuccess("Password have been changed!!");
          }
          } */
        $user_id = Auth::user('user')->user_id;

        $user = User::where('user_id', $user_id);

        $user->update([
            'password' => bcrypt($request->input('password'))
        ]);

        return "Profile Updated";
    }

    public function checkPassword(Request $request) {

        $user_id = Auth::user('user')->user_id;
        $current_password = $request->input('password');

        $user_password = User::where('user_id', $user_id)->first();

        if (Hash::check($current_password, $user_password->password)) {
            return "true";
        } else {
            return "false";
        }
    }

    public function updateProfile(Request $request) {

        $user_id = $request->input('user_id');

        $user = User::where('user_id', $user_id);

        $password = $request->input('password');

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

        if ($password !== '') {

            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'photo' => $photo_path,
                'address_1' => $request->input('address_1'),
                'address_2' => $request->input('address_2'),
                'zipcode' => $request->input('zipcode'),
                'country_id' => $request->input('country_id'),
                'skype' => $request->input('skype'),
                'facebook' => $request->input('facebook'),
                'linkedin' => $request->input('linkedin'),
            ]);
        } else {

            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'photo' => $photo_path,
                'address_1' => $request->input('address_1'),
                'address_2' => $request->input('address_2'),
                'zipcode' => $request->input('zipcode'),
                'country_id' => $request->input('country_id'),
                'skype' => $request->input('skype'),
                'facebook' => $request->input('facebook'),
                'linkedin' => $request->input('linkedin'),
            ]);
        }

        return $photo_path;
    }

    public function updateMyProfile(Request $request) {
        $user_id = Auth::user()->user_id;

        $user = User::where('user_id', $user_id);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_save = $photo->move('assets/user/', $photo->getClientOriginalName());
            $photo_path = $photo_save->getPathname();
        } else {
            $photo_path = User::where('user_id', $user_id)->pluck('photo');
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'photo' => $photo_path,
            'address_1' => $request->input('address_1'),
            'address_2' => $request->input('address_2'),
            'zipcode' => $request->input('zipcode'),
            'country_id' => $request->input('country_id'),
            'skype' => $request->input('skype'),
            'facebook' => $request->input('facebook'),
            'linkedin' => $request->input('linkedin'),
        ]);

        return $photo_path;
    }

    public function forgotPassword() {
        //$user = User::where('email', '=', Input::get('email'))->where('username', '=', Input::get('username'))->first();
        //projectmanager@hdenergy.ca
        $email = Input::get('email');
        $usertype = Input::get('usertype');
        if ($usertype == 'employee') {
            $user = User::where('email', '=', $email)->first();
        } else {
            $user = Applicant::where('email', '=', $email)->first();
        }

        $rules = array(
            //'username' => 'required',
            'email' => 'required|email'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } elseif (!$user) {
            return Redirect::back()->withErrors('Email address does not exist!');
        } else {
            $token_str = substr(md5(rand(1000000, 9999999)), 0, 5);
            $token = New PasswordReset();
            $token->email = $email;
            $token->token = $token_str;
            $token->usertype = $usertype;
            $token->save();

            //Mail::send('user.forgetPassword', array('username' => Input::get('username') , 'password' => $new_password), function($message){
            //	$message->to(Input::get('email'), 'Forget Password')->subject('Forget Password!');
            //});
            /* Mail::send('user.forgotPassword', array('email' => Input::get('email') , 'password' => $token_str), function($message) {
              $message->to(Input::get('email'), 'Forgot Password')->subject('Forgot Password Reset Link');
              }); */

            $url = 'job.tc/pm';
            
            Mail::queue('user.forgotPassword', ['email' => Input::get('email'), 'token_str' => $token_str,'usertype' => $usertype,'url' => $url], function ($message) {
                $message->from('support@job.tc','Job.tc');
                $message->to(Input::get('email'), 'Forgot Password');
                $message->subject('Forgot Password Reset Link');
            });

            //echo '<a href="http://localhost:8000/resetPassword/?token=' . $token_str . '&usertype=' . $usertype . '">Reset Password</a>';
            return Redirect::back()->withSuccess('Change Password Link has been sent to your email!');
        }
    }

    public function resetPasswordForm(Request $request,$token,$usertype) {
        return view('session.resetPassword',['token' => $token, 'usertype' => $usertype]);
    }
    
    
    public function resetPassword(Request $request) {
        $email = $request->input('email');
        $token = $request->input('token');
        $usertype = $request->input('usertype');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');


        $reset = PasswordReset::where('email', '=', $email)->where('token', '=', $token)->where('usertype', '=', $usertype)->first();
        if ($reset) {
            $rules = array(
                'password' => 'required|min:8|confirmed',
                    //'password_confirm' => 'required|same:password',
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                $user = User::where('email', '=', $email)->update([
                    'password' => bcrypt($password_confirmation)
                ]);
                return Redirect::back()->withSuccess('Password has been changed successfully!');
            }
        } else {
            return Redirect::back()->withErrors('Invalid reset password token!');
        }
    }

}

?>