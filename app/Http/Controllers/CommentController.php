<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Job;
use App\Models\Applicant;
use App\Models\User;
use Auth;
use Redirect;
use Input;
use Validator;
use Mail;

Class CommentController extends BaseController {

    public function index() {
        
    }

    public function show() {
        
    }

    public function create() {
        
    }

    public function edit() {
        
    }

    public function store() {

        $validation = Validator::make(Input::all(), ['comment' => 'required']);

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->messages());
        }

        $comment = new Comment;
        $data = Input::all();
        $data['user_id'] = Auth::user()->id;
        $comment->fill($data);
        $comment->save();

        return Redirect::back()->withSuccess('Successfully saved!!');
    }

    public function update() {
        
    }

    public function destroy($comment_id) {
        $comment = Comment::find($comment_id);

        if (!$comment || ($comment->username != Auth::user()->username && !Entrust::hasRole('Admin')))
            return Redirect::back()->withErrors('This is not a valid link!!');

        $comment->delete($comment_id);
        return Redirect::back()->withSuccess('Deleted successfully!!');
    }

    public function addComment(Request $request) {

        //$user_id = $request->user('user')->user_id;
        if (Auth::check('user')) {
            $commenter_id = $request->user('user')->user_id;
            $commenter_type = 'employee';
        } elseif (Auth::check('applicant')) {
            $commenter_id = Auth::user('applicant')->id;
            $commenter_type = 'applicant';
        }


        $unique_id = $request->input('unique_id');
        $comment = $request->input('comment');
        $send_email = $request->input('send_email');
        $belongs_to = $request->input('module');

        $new_comment = new Comment([
            'commenter_id' => $commenter_id,
            'commenter_type' => $commenter_type,
            'unique_id' => $unique_id,
            'belongs_to' => $belongs_to,
            'comment' => $comment
        ]);

        $new_comment->save();

        if ($belongs_to === 'applicant') {

            $job_id = $request->input('job_id');
            $job_owner = Job::where('id', $job_id)->first();

            if (Auth::check('user')) {
                $new_comment_item = Comment::with('user')
                        ->where('comment_id', $new_comment->comment_id)
                        ->first();

                //Get from and to address            
                $from_email = User::where('user_id', $commenter_id)->first();
                $to_email = Applicant::where('id', $unique_id)->first();
            } elseif (Auth::check('applicant')) {
                $new_comment_item = Comment::with('applicant')->where('comment_id', $new_comment->comment_id)->first();

                //Get from and to address            
                $from_email = Applicant::where('id', $unique_id)->first();
                $to_email = User::where('user_id', $job_owner->user_id)->first();
            }

            if ($send_email === 'true') {
                Mail::queue('emails.commentEmail', ['from_email' => $from_email, 'to_email' => $to_email, 'job_owner' => $job_owner, 'comment' => $comment], function ($message) use ($from_email, $to_email, $job_owner) {
                    $message->from($from_email->email, $from_email->name);
                    $message->to($to_email->email, $to_email->name);
                    //$message->to(['jobtcmailer@gmail.com'],$to_email->name);
                    $message->subject($job_owner->title);
                });
            }

            return view('common.commentListItem', ['comment' => $new_comment_item]);
        }


        if ($belongs_to === 'employee') {

            $new_comment_item = Comment::with('user')
                    ->where('comment_id', $new_comment->comment_id)
                    ->first();

            //Get from and to address            
            $from_email = User::where('user_id', $commenter_id)->first();
            $to_email = User::where('user_id', $unique_id)->first();

            if ($send_email === 'true') {
                Mail::queue('emails.commentEmail', ['from_email' => $from_email, 'to_email' => $to_email, 'comment' => $comment], function ($message) use ($from_email, $to_email) {
                    $message->from($from_email->email, $from_email->name);
                    $message->to($to_email->email, $to_email->name);
                    //$message->to(['jobtcmailer@gmail.com'],$to_email->name);
                    $message->subject($from_email->name);
                });
            }

            return view('common.commentListItem', ['comment' => $new_comment_item,'employee' => $unique_id]);
        }
    }

}

?>