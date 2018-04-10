<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Edit Briefcase</h4>
</div>
<div class="modal-body">
        {!! Form::model($task,['method' => 'PATCH','route' => ['task.update',$task->task_id] ,'class' =>
        'form-horizontal link-form'])  !!}
        @include('task/partials/_form', ['belongs_to'=> $task->belongs_to,
                'unique_id'=> $task->unique_id,'buttonText' => 'Save'] )
        {!!  Form::close()  !!}
</div>
