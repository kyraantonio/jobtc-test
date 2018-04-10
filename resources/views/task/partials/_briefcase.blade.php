<div class="modal fade" id="edit_task_{{ $task->task_id }}" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @include('task/edit', ['task'=> $task] )
        </div>
    </div>
</div>
<div id="collapse-container-{{ $task->task_id }}" class="panel task-list">
    <div class="panel-heading task-header" data-target="#collapse-{{ $task->task_id }}" role="tab" id="headingOne" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
        <div class="row">
            <div class="col-xs-6">
                <h4 class="panel-title task-list-header">{{ $task->task_title }}</h4>
            </div>
            <div class="col-xs-6">
                <div class="btn-group pull-right">
                    <a href="#" class="drag-handle move-tasklist"><i class="fa fa-arrows" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div>
        </div>
    </div>
    <div id="collapse-{{ $task->task_id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <div class="panel-content">
                <div id="load-task-assign-{{ $task->task_id }}" class="load-task-assign" data-url="{{ url('task/' . $task->task_id ) }}" style="margin-top: -10px;"></div>
            </div>
        </div>
    </div>
</div>