@extends('layouts.default')
@section('content')
    <div class="modal fade" id="add_link" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title">Add Task</h4>
                </div>
                <div class="modal-body">
                    {!!  Form::open(['route' => 'task.store','class' => 'form-horizontal'])  !!}
                    @include('task/partials/_form',['unique_id'=> 0])
                    {!! Form::close()  !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ajax" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">Task List</h3>
                <div class="box-tools pull-right">
                    <a data-toggle="modal" href="#add_link">
                        <button class="btn btn-sm btn-success btn-shadow"><i class="fa fa-plus-circle"></i> Add New Task</button>
                    </a>
                    <button class="btn btn-sm btn-transparent" data-widget="collapse"><i class="fa fa-chevron-up"></i></button>
                </div>
            </div>
            <div class="box-body">

                <?php $DATA = array();

                $QA = array();
                foreach ($tasks as $task) {

                    $status = "";

                    if ($isClient) {
                        $status = studly_case($task->task_status);
                    } else {
                        $status = Form::open(['method' => 'POST', 'url' => 'updateTaskStatus', 'class' =>
                                        'form-horizontal']) .
                                Form::select('task_status', [
                                        'pending' => 'Pending',
                                        'progress' => 'Progress',
                                        'completed' => 'Completed'
                                ], $task->task_status, ['class' => 'form-control',
                                        'placeholder' => 'Update Task',
                                        "onchange" => "this.form.submit()"]) .
                                Form::hidden('task_id', $task->task_id) .
                                Form::close();
                    }

                    /**
                     * Options
                     */
                    $taskToEdit = "<a href='task/$task->task_id/edit' data-toggle='modal' data-target='#ajax1'
                    class='show_edit_form'> <i
                    class='fa fa-edit fa-2x'></i> </a>";

                    $viewTask = "<a href='" . route('task.show', $task->task_id) . "'> <i class='fa fa-eye fa-2x'></i> </a>";

                    $taskToDelete = "<a href='" . route('task.destroy', $task->task_id) . "' class='alert_delete '> <i
                    class='fa
                    fa-trash-o fa-2x'></i> </a>";
                    $Option = "$viewTask <span class='hspacer'></span> $taskToEdit <span class='hspacer'></span> $taskToDelete";

                    $QA[] = array(
                            ($task->task_title),
                            $task->name,
                            $task->due_date,
                            $status,
                            $Option);
                }

                $cacheKey = md5('tasks.list.' . session()->getId());
                Cache::put($cacheKey, $QA, 100);
                ?>
                <table class="table table-striped table-bordered table-hover datatableclass" id="task_table">
                    <thead>
                    <tr>
                        <th>
                            Title
                        </th>
                        <th>
                            Assigned
                        </th>
                        <th>
                            Due Date
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
@stop