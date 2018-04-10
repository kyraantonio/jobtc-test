@if (count($projects) > 0)
@foreach($projects as $project)
<div id="project-{{$project->project_id}}" class="panel panel-default">
    <div class="panel-heading">
        {{$project->project_title}}
        <div class="pull-right">
            @if(intval($project->company_id) !== intval($company_id))
            <div class="row">
                <label>Shared by {{$project->company->name}}</label>
            </div>
            @endif
            @if(Auth::user('user')->user_id !== $project->user_id)
            <div class="row">
                <label>Shared by {{$project->user->name}}</label>
            </div>
            @endif
        </div>
    </div>
    <div class="panel-body">
        <ul class="company-list-group list-group">
            @foreach($team_companies as $team_company)
            @if($team_company->project_id === $project->project_id)
            <li id="company-{{$team_company->company_id}}" class="list-group-item">
                <div class="row">
                    <div class="col-md-9">
                        <a id="employee-toggle-{{$project->project_id}}-{{$team_company->company_id}}" class="toggle-employees" data-toggle="collapse" href="#employee-toggle-collapse-{{$project->project_id}}-{{$team_company->company_id}}">    
                            <i class="pull-left fa fa-chevron-down" aria-hidden="true"></i>
                            {{$team_company->company->name}}
                            <input class="project_id" type="hidden" value="{{$project->project_id}}"/>
                            <input class="company_id" type="hidden" value="{{$team_company->company_id}}"/>
                        </a>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="drag-handle">
                            <i class="fa fa-arrows"></i>
                        </a>
                        <a href="#" class="unassign-company">
                            <i class="fa fa-times"></i>
                            <input class="project_id" type="hidden" value="{{$project->project_id}}"/>
                            <input class="company_id" type="hidden" value="{{$team_company->company_id}}"/>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div id="employee-toggle-collapse-{{$project->project_id}}-{{$team_company->company_id}}" class="employee-list collapse">
                    </div>
                </div>
            </li>
            @endif
            @endforeach
        </ul>
        <ul class="taskgroup-list list-group">
            @foreach($teams as $team)                            
            @if($team->project_id === $project->project_id)
            @foreach($team->team_member as $team_members)
            <li class="list-group-item">
                <div class="row ">
                    <div class="col-md-10">
                        <a class="team-member name" data-toggle="collapse" href="#team-member-collapse-{{$team_members->user->user_id}}-{{$project->project_id}}">
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            {{$team_members->user->name}}
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="btn-group pull-right">
                            <a href="#" class="drag-handle">
                                <i class="fa fa-arrows"></i>
                            </a>
                            <a href="#" class="unassign-member">
                                <i class="fa fa-times"></i>
                                <input class="user_id" type="hidden" value="{{$team_members->user->user_id}}"/>
                                <input class="team_id" type="hidden" value="{{$team_members->team_id}}"/>
                                <input class="project_id" type="hidden" value="{{$project->project_id}}"/>
                            </a>
                        </div>
                    </div>
                </div>
                @if($project->user_id === Auth::user()->user_id && intval($project->company_id) === intval($company_id))
                <div class="row">
                    <div id="team-member-collapse-{{$team_members->user->user_id}}-{{$project->project_id}}" class="collapse">
                        <div class="task-list-container">
                            <label class='center-block taskgroup-title'>Available Briefcases</label>
                            <ul class="taskgroup-list list-group">
                                @foreach($project->task as $task)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{$task->task_title}}
                                        </div>
                                        <div class="pull-right">
                                            @if($project->task_permission
                                            ->where('user_id',$team_members->user->user_id)
                                            ->where('task_id',$task->task_id)
                                            ->where('project_id',$project->project_id)
                                            ->where('company_id',$project->company_id)
                                            ->count() > 0)

                                            @foreach($project->task_permission
                                            ->where('user_id',$team_members->user->user_id)
                                            ->where('task_id',$task->task_id)
                                            ->where('project_id',$project->project_id)
                                            ->where('company_id',$project->company_id)    
                                            as $permission)
                                            <div class="btn btn-default btn-shadow bg-green task-permission">
                                                <i class="fa fa-check" aria-hidden="true"></i>                                                                
                                                <input class="user_id" type="hidden" value="{{$team_members->user->user_id}}"/>
                                                <input class="task_id" type="hidden" value="{{$task->task_id}}"/>
                                                <input class="project_id" type="hidden" value="{{$project->project_id}}"/>
                                                <input class="company_id" type="hidden" value="{{$project->company_id}}"/>
                                            </div>
                                            @endforeach
                                            @else
                                            <div class="btn btn-default btn-shadow bg-gray task-permission">
                                                <i class="fa fa-plus" aria-hidden="true"></i>                                                                
                                                <input class="user_id" type="hidden" value="{{$team_members->user->user_id}}"/>
                                                <input class="task_id" type="hidden" value="{{$task->task_id}}"/>
                                                <input class="project_id" type="hidden" value="{{$project->project_id}}"/>
                                                <input class="company_id" type="hidden" value="{{$project->company_id}}"/>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
            </li>
            @endforeach
            @endif
            @endforeach
        </ul>
        <!--li class="list-group-item">No Employees assigned to this project.</li-->
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <input type="hidden" class="project_id" value="{{$project->project_id}}" />
                    <input type="hidden" class="company_id" value="{{$project->company_id}}"/>
                </div>
            </div>
        </div>
        <input type="hidden" class="project_id" value="{{$project->project_id}}"/>
        <input type="hidden" class="company_id" value="{{$project->company_id}}"/>
    </div>
</div>
@endforeach
@else
<div class="box box-default">
    <div class="box-container">
        <div class="box-header">
            <h3 class="box-title">&nbsp;</h3>
        </div>
        <div class="box-body">
            <div class="box-content">
                <ul class="taskgroup-list list-group">
                    <li class="list-group-item">No Projects Available</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif
@if ($paginator->lastPage() > 1)
<ul class="pagination">
    <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
        <a href="{{ $paginator->url(1) }}">First</a>
    </li>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
    <?php
    $half_total_links = floor($link_limit / 2);
    $from = $paginator->currentPage() - $half_total_links;
    $to = $paginator->currentPage() + $half_total_links;
    if ($paginator->currentPage() < $half_total_links) {
        $to += $half_total_links - $paginator->currentPage();
    }
    if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
        $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
    }
    ?>
    @if ($from < $i && $i < $to)
    <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
    </li>
    @endif
    @endfor
    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
        <a href="{{ $paginator->url($paginator->lastPage()) }}">Last</a>
    </li>
</ul>
@endif
