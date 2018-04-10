<form actions="" method="post" class="edit-employee-form form-horizontal" role="form" novalidate="novalidate">
    <div class="box-body">
        <div class="box-content">
            <div class="form-group">
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            @if($profile->user->photo === '' || $profile->user->photo === NULL)
                            <img class="edit-employee-photo" src="{{url('assets/user/default-avatar.jpg')}}" />
                            @else
                            <img class="edit-employee-photo" src="{{url($profile->user->photo)}}"/>
                            @endif
                        </a>
                    </div>
                    <div class="media-body">
                        <br />
                        <br />
                        <br />
                        <br />
                        {!!  Form::input('file','photo','') !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="center-block">
                    <label class="radio-inline"><input id="existing-position-tab" checked="checked" name="position-tab" type="radio" value="" data-target="#existing-position">Existing Position</label>
                    <label class="radio-inline"><input id="new-position-tab" name="position-tab" type="radio" value="" data-target="#new-position">New Position</label>
                </div>
                <div class="tab-content">
                    <div id="existing-position" class="tab-pane active">
                        <select name="role_id" class='form-control input-xlarge select2me' placeholder="Select Position">
                            @foreach($positions as $position)
                            @if($position->id == $profile->role_id)
                            <option selected="selected" value='{{$position->id}}'>{{$position->name}}</option>
                            @else
                            <option value='{{$position->id}}'>{{$position->name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div id="new-position" class="tab-pane">
                        <input class="form-control" name="position" placeholder="New Position" value="" />
                    </div>
                </div>
            </div>
            @if(Auth::user('user')->user_id !== $profile->user_id)
            <div class="form-group">
                <label>User's Authority is: </label>
                <br />
                <label class="radio-inline">
                    @if($employee_is_above_count === 1)
                    <input id="" checked="checked" name="authority" type="radio" value="above">
                    @else
                    <input id=""  name="authority" type="radio" value="above">
                    @endif
                    Above You
                    <a class="above-you-tooltip" href="#" data-toggle="tooltip" data-placement="top" title="Users above you can see all your projects and jobs. They can change your permissions.">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </a>
                </label>
                <label class="radio-inline">
                    @if(isset($profile_levels) && $profile_levels->where('profile_level','equal')->count() === 1)
                    <input id="" checked="checked" name="authority" type="radio" value="equal">
                    @else
                    <input id=""  name="authority" type="radio" value="equal">
                    @endif
                    Equal You
                    <a class="equal-you-tooltip" href="#" data-toggle="tooltip" data-placement="top" title="Users equal you can see your projects and jobs. You can access and change all their projects, jobs and permissions.">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </a>
                </label>
                <label class="radio-inline">
                    @if($employee_is_below_count === 1 || $logged_user_above_count === 1)
                    <input id="" checked="checked" name="authority" type="radio" value="below">
                    @else
                    <input id="" name="authority" type="radio" value="below">
                    @endif
                    Below You
                    <a class="below-you-tooltip" href="#" data-toggle="tooltip" data-placement="top" title="Users below you can't see your projects and jobs unless you share them. You can change any of their permissions. ">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </a>
                </label>
            </div>
            @endif
            <div class="form-group">
                {!!  Form::input('text','name',$profile->user->name,['class' => 'form-control', 'placeholder' =>
                'Name']) !!}
            </div>
            <div class="form-group">
                {!!  Form::input('email','email',$profile->user->email,['class' => 'form-control', 'placeholder'
                => 'Email']) !!}
            </div>
            <div class="form-group">
                {!!  Form::input('text','phone',$profile->user->phone,['class' => 'form-control', 'placeholder'
                => 'Phone']) !!}
            </div>

            <div class="form-group">
                {!!  Form::input('text','address_1',$profile->user->address_1,['class' => 'form-control', 'placeholder'
                => 'Address 1']) !!}
            </div>
            <div class="form-group">
                {!!  Form::input('text','address_2',$profile->user->address_2,['class' => 'form-control', 'placeholder'
                => 'Address 2']) !!}
            </div>
            <div class="form-group">
                {!!  Form::input('text','zipcode',$profile->user->zipcode,['class' => 'form-control', 'placeholder'
                => 'Enter Zipcode']) !!}
            </div>
            <div class="form-group">
                <select name="country_id" class='form-control input-xlarge select2me' placeholder="Select Country">
                    @foreach($countries as $country)
                    @if($country->country_id == $profile->user->country_id)
                    <option selected="selected" value='{{$country->country_id}}'>{{$country->country_name}}</option>
                    @else
                    <option value='{{$country->country_id}}'>{{$country->country_name}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {!!  Form::input('text','skype',$profile->user->skype,['class' => 'form-control', 'placeholder'
                => 'Skype']) !!}
            </div>
            <div class="form-group">
                {!!  Form::input('text','facebook',$profile->user->facebook,['class' => 'form-control', 'placeholder'
                => 'Facebook']) !!}
            </div>
            <div class="form-group">
                {!!  Form::input('text','linkedin',$profile->user->linkedin,['class' => 'form-control', 'placeholder'
                => 'Linkedin']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Resume') !!}
                {!!  Form::input('file','resume','') !!}    
            </div>
        </div>
    </div>
</form>
<script>
    $('.above-you-tooltip').tooltip();
    $('.equal-you-tooltip').tooltip();
    $('.below-you-tooltip').tooltip();

    $('input[name="position-tab"]').click(function () {
        $(this).tab('show');
    });

    $('input[name="employee-tab"]').click(function () {
        $(this).tab('show');
    });
</script>