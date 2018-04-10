<form id="add-employee-form" class="add-employee-form">
    <div class="row">
        <div class="col-md-12">
            <div class="center-block">
                <label class="radio-inline"><input id="new-employee-tab" checked="checked" name="employee-tab" type="radio" value="" data-target="#new-employee">New User</label>
                <label class="radio-inline"><input id="existing-user-tab" name="employee-tab" type="radio" value="" data-target="#existing-user">Existing User</label>
            </div>
            <div class="tab-content">
                <div id="new-employee" class="tab-pane active">
                    <input class="form-control" name="employee-name" placeholder="Name" value="" />
                    <br />
                    <input class="form-control" name="employee-email" placeholder="Email" value="" />
                    <br />
                    <input type="password" class="form-control" name="employee-password" placeholder="Password" value="" />
                </div>
                <div id="existing-user" class="tab-pane">
                    @if($profiles->count() > 0)
                    <select name="user_id" class='form-control input-xlarge select2me' placeholder="Select Position">
                        @foreach($profiles as $profile)
                        <option value="{{$profile->user_id}}">{{$profile->name}}&nbsp;({{$profile->email}})</option>
                        @endforeach
                    </select>
                    @else
                    <div class="form-control">No Users Available</div>
                    @endif
                </div>
            </div>
            <br />
            <div class="center-block">
                <label class="radio-inline"><input id="existing-position-tab" checked="checked" name="position-tab" type="radio" value="" data-target="#existing-position">Existing Position</label>
                <label class="radio-inline"><input id="new-position-tab" name="position-tab" type="radio" value="" data-target="#new-position">New Position</label>
            </div>
            <br />
            <div class="tab-content">
                <div id="existing-position" class="tab-pane active">
                    <select name="role_id" class='form-control input-xlarge select2me' placeholder="Select Position">
                        @foreach($positions as $position)
                        <option value="{{$position->id}}">{{$position->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div id="new-position" class="tab-pane">
                    <input class="form-control" name="position" placeholder="New Position" value="" />
                </div>
            </div>
            <br />
            <div>
                <label>User's Authority is: </label>
                <br />
                <label class="radio-inline"><input id="" checked="checked" name="authority" type="radio" value="above">
                    Above You
                    <a class="above-you-tooltip" href="#" data-toggle="tooltip" data-placement="top" title="Users above you can see all your projects and jobs. They can change your permissions.">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </a>
                </label>
                <label class="radio-inline">
                    <input name="authority" type="radio" value="equal">
                    Equal You
                    <a class="equal-you-tooltip" href="#" data-toggle="tooltip" data-placement="top" title="Users equal you can see your projects and jobs. You can access and change all their projects, jobs and permissions.">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </a>
                </label>
                <label class="radio-inline">
                    <input name="authority" type="radio" value="below" >
                    Below You
                    <a class="below-you-tooltip" href="#" data-toggle="tooltip" data-placement="top" title="Users below you can't see your projects and jobs unless you share them. You can change any of their permissions. ">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </a>
                </label>
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
