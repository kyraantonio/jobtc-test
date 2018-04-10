<table id="payroll-table" class="table table-condensed table-bordered table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Project</th>
            <th>Total Time</th>
            <th>Total Cost</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $employee)
        <tr>
            @if($employee->rate->count() > 0)
            <td><span>{{$employee->user->name}}</span><h6>({{$employee->rate[0]->currency." ".$employee->rate[0]->rate_value}})</h6></td>
            @else
            <td><span>{{$employee->user->name}}</span><h6>(No Rate Set)</h6></td>
            @endif
            <td>
                @foreach($projects as $project)
                @if($task_checklists->where('user_id',$employee->user->user_id)->where('project_id',$project->project_id)->count() > 0)
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{$project->project_title}}</h4>
                        @foreach($task_checklists->where('user_id',$employee->user->user_id) as $task_checklist)
                        @if($task_checklist->task_checklist->task->project->project_id === $project->project_id)
                        <div class="row">
                            <div class="col-md-3">{{$task_checklist->task_checklist->checklist_header}}</div>
                            <div class="col-md-3">{{$task_checklist->total_time}}</div>
                        </div>
                        @endif
                        @endforeach
                        <div class="row">
                            <div class="col-md-3">&nbsp;</div>                            
                            @foreach($total_time_per_project->where('user_id',$employee->user->user_id)->where('project_id',$project->project_id) as $total)
                            <div class="col-md-3">{{$total->timeSum}}</div>
                            @foreach($employee->rate as $rate)
                            @if($employee->rate->count() > 0)
                            <div class="col-md-3">{{$rate->currency}}&nbsp;{{round($total->hours * $rate->rate_value,2)}}</div>
                            @else
                            <div class="col-md-3"></div>
                            @endif
                            @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </td>
            <td>
                <div class="row">
                    @if($projects->count() > 0)
                    @foreach($total_time->where('user_id',$employee->user_id) as $total)
                    <div class="col-md-3">{{$total->timeSum}}</div>
                    @endforeach
                    @endif
                </div>
            </td>
            <td>
                <div class="row">
                    @foreach($total_time->where('user_id',$employee->user_id) as $total)
                    @if($employee->rate->count() > 0)
                    <div class="col-md-3">{{$employee->rate[0]->currency}}&nbsp;{{round($total->hours * $employee->rate[0]->rate_value,2)}}</div>
                    @else
                    <div class="col-md-3"></div>
                    @endif
                    @endforeach
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<input class="company_id" type="hidden" value="{{$company_id}}">