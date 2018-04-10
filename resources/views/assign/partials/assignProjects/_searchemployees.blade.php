<ul class="taskgroup-list list-group">
    @foreach($profiles as $profile)
    <li id="profile-{{$profile->user->user_id}}" class="list-group-item">
        <div class="row">
            <div class="col-md-9">
                <a class="employee-toggle" data-toggle="collapse">
                    <i class="pull-left fa fa-chevron-down" aria-hidden="true"></i>
                    <div class="name">{{$profile->user->name}}</div>
                </a>
            </div>
            <div class="pull-right">
                <a href="#" class="drag-handle">
                    <i class="fa fa-arrows"></i>
                </a>
                <a href="#" class="hidden unassign-member">
                    <i class="fa fa-times"></i>
                    <input class="user_id" type="hidden" value="{{$profile->user->user_id}}"/>
                    <input class="team_id" type="hidden" value=""/>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="briefcase-container collapse">
            </div>
        </div>
    </li>
    @endforeach
</ul>
{!!$profiles->render()!!}
