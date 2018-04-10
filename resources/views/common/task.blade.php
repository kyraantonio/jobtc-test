<div class="modal fade" id="add_task" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Add Task</h4>
            </div>
            {!!  Form::open(['method' => 'POST','route' => ['task.store'],'class' => 'task-form'])  !!}
            <div class="modal-body">
                {!!  Form::hidden('belongs_to',$belongs_to)  !!}
                {!!  Form::hidden('unique_id', $unique_id)  !!}
                {!!  Form::hidden('project_id', $project_id)  !!}
                <div class="form-group">
                    {!!  Form::input('text','task_title','',['class' => 'form-control', 'placeholder' => 'Title', 'tabindex' => '1']) !!}
                </div>
                <div class="form-group">
                    {!!  Form::textarea('task_description','',['size' => '30x3', 'class' => 'form-control',
                    'placeholder' => 'Description', 'tabindex' => '2']) !!}
                </div>
                <div class="form-group">
                    <div class='input-group date datetimepicker' id='start_date'>
                        {!!  Form::input('text','due_date',
                            isset($task->due_date) ? date("d-m-Y",strtotime($task->due_date)) : '', ['class' => 'form-control form-control-inline input-medium', 'placeholder' => 'Due Date', 'tabindex' => '4'])  !!}
                        <span class="input-group-addon open-date-calendar">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                @if(Auth::user('user')->user_type === 1 || Auth::user('user')->user_type === 2 || Auth::user('user')->user_type === 3)
                    <div class="form-group">
                            {!!  Form::select('username', $assign_username, isset
                            ($task->user_id) ? $task->user_id : '',
                             ['class' => 'form-control input-xlarge select2me',
                            'placeholder' => 'Assign User',] )  !!}
                    </div>
                @endif
                @if(Auth::user('user')->user_type === 4)
                    {!!  Form::hidden('assign_username',Auth::user('user')->email,['readonly' => true])  !!}
                @endif
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    {!!  Form::submit('Add',['class' => 'btn btn-edit', 'tabindex' => '5'])  !!}
                </div>
            </div>
            {!!  Form::close() !!}
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-container">
        <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-target="#task-details" data-parent="#accordion_" aria-expanded="true">
            <h4 class="panel-title">Task List
                <a data-toggle="modal" class="pull-right" href="#add_task"><i class="fa fa-plus"></i></a>
            </h4>
        </div>
        <div id="task-details" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                <div class="panel-content">
                    <table class="table table-hover table-striped">
                        @if(count($tasks) > 0)
                            @foreach($tasks as $task)
                                @if((Auth::user()->is('client') && $task->is_visible == 'yes') ||
                                     !Auth::user()->is('client'))

                                    <tr>
                                        <td>{{ $task->task_title }}</td>
                                        <td>{{ $task->name }}</td>
                                    </tr>

                                @endif
                            @endforeach
                        @else
                             <tr>
                                <td colspan="2">No data was found.</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
