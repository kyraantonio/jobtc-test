@extends('layouts.default')
@section('content')
    <div class="modal fade" id="add_event" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title">Add Event</h4>
                </div>
                <div class="modal-body">
                    {!!  Form::open(['route' => 'event.store','class' => 'form-horizontal user-form'])  !!}
                    @include('event/partials/_form')
                    {!!  Form::close()  !!}
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
        <div class="box box-solid box-default">
            <div class="box-header">
                <h3 class="box-title">Event List</h3>
                <div class="box-tools pull-right">
                    <a data-toggle="modal" href="#add_event">
                        <button class="btn btn-sm"><i class="fa fa-plus-circle"></i> Add New Event</button>
                    </a>
                    <button class="btn btn-sm btn-transparent" data-widget="collapse"><i class="fa fa-chevron-up"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php $DATA = array();
                $QA = array();
                $current_date = strtotime(date("d M Y"));
                foreach ($events as $event) {
                    $linkToEdit = "<a href='event/$event->event_id/edit' data-toggle='modal' data-target='#ajax'> <i class='fa fa-edit'></i> </a>";
                    $linkToDelete = "<a href='event/$event->event_id/delete' class='alert_delete'> <i class='fa fa-trash-o'></i> </a>";

                    if ($current_date > strtotime($event->end_date))
                        $status = "<small class='badge bg-green'>completed</small>";
                    elseif ($current_date < strtotime($event->start_date))
                        $status = "<small class='badge bg-red'>pending</small>";
                    elseif ($current_date <= strtotime($event->start_date) && $current_date >= strtotime($event->end_date))
                        $status = "<small class='badge bg-yellow'>progress</small>";

                    if ($event->username == Auth::user()->username)
                        $Options = "$linkToEdit <span class='hspacer'></span> $linkToDelete";
                    else
                        $Options = 'NA';
                    $title = $event->event_title;
                    if ($event->public == 1)
                        $title .= " <small class='badge bg-green'>public</small>";
                    $QA[] = array($title, $event->event_description, date("d M Y", strtotime($event->start_date)), date("d M Y", strtotime($event->end_date)), $status, $Options);
                }
                    $cacheKey = 'events.list.'. session()->getId();
                    Cache::put($cacheKey, $QA, 100);
                ?>
                <table class="table table-striped table-bordered table-hover datatableclass" id="user_table">
                    <thead>
                    <tr>
                        <th>
                            Title
                        </th>
                        <th>
                            Description
                        </th>
                        <th>
                            Start Date Time
                        </th>
                        <th>
                            End Date Time
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Option
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