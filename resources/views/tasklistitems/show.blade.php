@extends('layouts.default')
@section('content')
<div id="collapse-{{ $task_id }}">
    <ul class="tasklist-group list-group" id="list_group_{{ $task_id }}">
        <li id="task_item_{{ $list_item->id }}" class="list-group-item task-list-item">
            {{--region Briefcase Item Add Link--}}
            <div class="modal fade add_link_modal" id="add_link_{{ $list_item->task_id . '-' . $list_item->id }}" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title">Add Link</h4>
                        </div>
                        <div class="modal-body">
                            {!!  Form::open(['route' => 'links.store','class' => 'form-horizontal link-form'])  !!}
                            {!! Form::hidden('task_id',$list_item->task_id) !!}
                            {!! Form::hidden('task_item_id',$list_item->id) !!}
                            {!! Form::hidden('user_id',$user_id) !!}
                            {!! Form::hidden('company_id',$company_id) !!}
                            @include('links/partials/_form')
                            {!! Form::close()  !!}
                        </div>
                    </div>
                </div>
            </div>
            {{--endregion--}}
            <div class="row task-list-details">
                <div class="col-sm-6">
                    <a href="#task-item-collapse-{{$list_item->id}}" class="checklist-header toggle-tasklistitem">{!! $list_item->checklist_header !!}</a>
                    <input type="hidden" class="company_id" value="{{$company_id}}" />
                    <input type="hidden" class="task_list_item_id" value="{{$list_item->id}}" />
                    <input type="hidden" class="task_list_id" value="{{$list_item->task_id}}" />
                </div>
                <div class="col-sm-3">
                    @forelse($list_item->timer as $timer)
                    <div id='timer-options-{{$list_item->id}}' class="pull-right"> 
                        @if($timer->timer_status === 'Resumed' || $timer->timer_status === 'Started')
                        <text id='timer-{{$list_item->id}}' class='still-counting task-item-timer'>{{$timer->timeSum}}</text>
                        <button id="timer-pause-{{$list_item->id}}" class="btn btn-primary pause-timer">Pause</button>
                        @elseif($timer->timer_status === 'Completed')
                        <text id='timer-{{$list_item->id}}' class="task-item-timer">{{$timer->timeSum}}</text>
                        @else
                        <text id='timer-{{$list_item->id}}' class="task-item-timer">{{$timer->timeSum}}</text>
                        <button id="timer-pause-{{$list_item->id}}" class="btn btn-primary resume-timer">Resume</button>
                        @endif
                        <input class="timer_id" type="hidden" value="{{$timer->timer_id}}">
                        <input class="task_checklist_id" type="hidden" value="{{$list_item->id}}">
                        <input class="total_time" type="hidden" value="{{$timer->timeSum}}">
                        <input class="timer_status" type="hidden" value="{{$timer->timer_status}}">
                    </div>
                    @empty
                    <div id='timer-options-{{$list_item->id}}' class="pull-right">
                        <text id='timer-{{$list_item->id}}' class="task-item-timer"></text>
                        <button id="timer-start-{{$list_item->id}}" class="btn btn-primary start-timer">Start</button>
                        <input class="task_checklist_id" type="hidden" value="{{$list_item->id}}">
                        <input class="timer_id" type="hidden" value="">
                    </div>
                    @endforelse
                </div>
                <div class="col-sm-3" style="white-space: nowrap">
                    <div class="pull-right">
                        @if ($list_item->status === 'Default')
                        <div class="btn btn-default btn-shadow bg-gray checklist-status">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                        @elseif($list_item->status === 'Ongoing')
                        <div class="btn btn-default btn-shadow bg-orange checklist-status">&nbsp;<i class="glyphicon glyphicon-time"></i>&nbsp;</div>
                        @elseif($list_item->status === 'Completed')
                        <div class="btn btn-default btn-shadow bg-green checklist-status">&nbsp;<i class="glyphicon glyphicon glyphicon-ok"></i>&nbsp;</div>
                        @elseif($list_item->status === 'Urgent')
                        <div class="btn btn-default btn-shadow bg-red checklist-status">&nbsp;&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;&nbsp;</div>
                        @endif
                        &nbsp;&nbsp;&nbsp;
                        {{--<a href="#" class="icon icon-btn edit-task-list-item"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                                                <input type="hidden" class="task_list_item_id" value="{{$list_item->id}}" />
                        <input type="hidden" class="task_list_id" value="{{$list_item->task_id}}" />--}}

                        <!--a href="#" class="icon icon-btn alert_delete"><i class="fa fa-times" aria-hidden="true"></i></a-->
                        <input type="hidden" class="task_list_item_id" value="{{$list_item->id}}" />
                        <input type="hidden" class="task_list_id" value="{{$list_item->task_id}}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="task-item-collapse-{{$list_item->id}}" class="task-item-collapse">
                    <div class="checklist-item">{!! $list_item->checklist !!}</div>
                    <input type="hidden" class="task_list_item_id" value="{{$list_item->id}}" />
                    <input type="hidden" class="task_list_id" value="{{$list_item->task_id}}" />
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right" style="margin-right: 5px;">
                                <a target="_blank" href="{{url('taskitem/'.$list_item->id)}}" class="btn-edit btn-shadow btn"><i class="fa fa-external-link"></i> View</a>&nbsp;&nbsp;&nbsp;
                                @if($module_permissions->where('slug','edit.tasks')->count() === 1)
                                <a href="#" class="btn-edit btn-shadow btn edit-task-list-item" style="font-size: 18px!important;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>&nbsp;&nbsp;&nbsp;
                                @endif
                                @if($module_permissions->where('slug','delete.tasks')->count() === 1)
                                <a href="#" class="btn-delete btn-shadow btn alert_delete view-btn-delete" style="font-size: 18px!important;"><i class="fa fa-times" aria-hidden="true"></i> Delete</a>
                                @endif
                                <input type="hidden" class="task_list_item_id" value="{{$list_item->id}}" />
                                <input type="hidden" class="task_list_id" value="{{$list_item->task_id}}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <input class="task_id" type="hidden" value="{{$task_id}}"/>
</div>
@stop