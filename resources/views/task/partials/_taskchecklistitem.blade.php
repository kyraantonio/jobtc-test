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