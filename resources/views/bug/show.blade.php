@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="modal fade" id="ajax" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    </div>
                </div>
            </div>

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Details</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Attachments</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Task</a></li>
                    <li class="dropdown pull-right">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Options <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ url('bug') }}">Back</a>
                            </li>
                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                                       href="{{ url('bug/'.$bug->bug_id.'/edit') }}" data-toggle='modal'
                                                       data-target='#ajax'>Edit</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                                       href="{{ url('bug/'.$bug->bug_id.'/delete') }}">Delete</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-solid box-default">
                                    <div class="box-header">
                                        <h3 class="box-title">Bug Ref # {{ $bug->ref_no }}</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Project Ref No:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{ $projects[$bug->project_id] }}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Description:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{ $bug->bug_description }}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Reported On:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{ date("d M Y, h:ia", strtotime($bug->reported_on)) }}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Priority:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{ $bug->bug_priority }}
                                            </div>
                                        </div>

                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Status
                                            </div>
                                            <div class="col-md-7 value">
                                                {!! Form::open(['method' => 'POST','url' => 'updateBugStatus','class'
                                                => 'form-horizontal'])  !!}
                                                {!!  Form::select('bug_status', [
                                                   null => 'Please select',
                                                   'unconfirmed' => 'Unconfirmed',
                                                   'confirmed' => 'Confirmed',
                                                   'progress' => 'Progress',
                                                   'resolved' => 'Resolved'
                                                ], isset($bug->bug_status) ? $bug->bug_status : '', ['class' => 'form-control select2me', 'placeholder' => 'Select One', "onchange" => "this.form.submit()"] )  !!}
                                                {!!  Form::hidden('bug_id',$bug->bug_id) !!}
                                                {!!  Form::close()  !!}
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                @include('common.note',['note' => $note, 'belongs_to' => 'bug', 'unique_id' => $bug->bug_id])

                            </div>

                            @role('admin')
                                @include('common.assign',['assignedUsers' => $assignedUsers, 'belongs_to' => 'bug', 'unique_id' => $bug->bug_id])
                            @endrole

                            @include('common.comment',['comments' => $comments, 'belongs_to' => 'bug', 'unique_id' => $bug->bug_id])

                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        @include('common.attachment',['attachments' => $attachments, 'belongs_to' => 'bug', 'unique_id' => $bug->bug_id])
                    </div>
                    <div class="tab-pane" id="tab_3">
                        @include('common.task',['tasks' => $tasks, 'belongs_to' => 'bug', 'unique_id' => $bug->bug_id])
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop