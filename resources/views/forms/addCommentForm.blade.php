<form class="add-comment-form form-horizontal">
   {!! csrf_field() !!}
    <div class="media">
        <div class="media-left">
            <a href="#">
                @if($user_info->photo !== '')
                <img class="employee-photo" src="{{url($user_info->photo)}}" alt="Employee Photo">
                @else
                <img class="employee-photo" src="{{url('assets/user/avatar.png')}}" alt="Employee Photo">
                @endif
            </a>
            <text class="media-heading">{{$user_info->name}}</text>
        </div>
        <div class="media-body media-right">
            <div class="row">
                <div class="col-md-12">
                    <textarea placeholder="Add a comment for this applicant" class="form-control comment-textarea" name="comment"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div style="margin-top: 15px;">
                        <input class="email-comment checkbox" type="checkbox" id="email-checkbox" value="email"/>
                        <label for="email-checkbox">Email Comment</label>
                        <div class="pull-right">
                            <button class="btn btn-shadow btn-edit submit-comment">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($applicant))
    <input name="unique_id" type="hidden" value="{{$applicant->id}}"/>
    <input name="job_id" type="hidden" value="{{$applicant->job_id}}"/>
    <input name="profile_id" type="hidden" value="{{$user_info->profile->id or '0'}}"/>
    @endif
    @if(isset($profile))
    <input name="unique_id" type="hidden" value="{{$profile->user_id}}"/>
    @endif
</form>
