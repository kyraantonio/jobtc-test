<label class='center-block taskgroup-title'>Available Briefcases</label>
<ul class="tasklist-group list-group">
    @foreach($tasks as $task)
    <li class="tasklist-group list-group-item">
        <div class="row">
            <div class="col-md-6">
                {{$task->task_title}}
            </div>
            <div class="pull-right">
                @if($task_permissions->count() > 0)
                @foreach($task_permissions as $permission)
                @if($task->task_id === $permission->task_id)
                <div class="btn btn-default btn-shadow bg-green task-permission">
                    <i class="fa fa-check" aria-hidden="true"></i>                                                                
                    <input class="user_id" type="hidden" value="{{$user_id}}"/>
                    <input class="task_id" type="hidden" value="{{$task->task_id}}"/>
                    <input class="project_id" type="hidden" value="{{$project_id}}"/>
                    <input class="company_id" type="hidden" value="{{$company_id}}"/>
                </div>
                @else
                <div class="btn btn-default btn-shadow bg-gray task-permission">
                    <i class="fa fa-plus" aria-hidden="true"></i>                                                                
                    <input class="user_id" type="hidden" value="{{$user_id}}"/>
                    <input class="task_id" type="hidden" value="{{$task->task_id}}"/>
                    <input class="project_id" type="hidden" value="{{$project_id}}"/>
                    <input class="company_id" type="hidden" value="{{$company_id}}"/>
                </div>
                @endif
                @endforeach
                @else
                <div class="btn btn-default btn-shadow bg-gray task-permission">
                    <i class="fa fa-plus" aria-hidden="true"></i>                                                                
                    <input class="user_id" type="hidden" value="{{$user_id}}"/>
                    <input class="task_id" type="hidden" value="{{$task->task_id}}"/>
                    <input class="project_id" type="hidden" value="{{$project_id}}"/>
                    <input class="company_id" type="hidden" value="{{$company_id}}"/>
                </div>
                @endif
            </div>
        </div>
    </li>
    @endforeach
</ul>