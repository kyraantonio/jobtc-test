<li class="list-group-item" id="link-{{$link->id}}">
    <div class="row">
        <div class="col-sm-4">
            {{--*/ $parse_url = parse_url($link->url) /*--}}
            <input type="hidden" class="task_list_id" value="{{$task->task_id}}" />
            <input type="hidden" class="company_id" value="{{$company_id}}" />
            @if(empty($parse_url['scheme']))
            <a target="_blank" href="http://{{ $link->url }}"><strong>{{ $link->title }}</strong></a>
            @else
            <a target="_blank" href="{{ $link->url }}"><strong>{{ $link->title }}</strong></a>
            @endif
        </div>
        <div class="col-sm-5" style="text-align: justify">{{ $link->descriptions }}</div>
        <div class="col-sm-3 text-right">{{ $link->category_name }}&nbsp;&nbsp;&nbsp;
            <a href="#" class="pull-right move-link"><i class="glyphicon glyphicon-move"></i></a>
            @if($module_permissions->where('slug','delete.links')->count() === 1 || $link->user_id === Auth::user('user')->user_id)
            <a id="{{$link->id}}" class="remove-link pull-right" style="padding-right: 10px"><i class="glyphicon glyphicon-remove"></i></a>
            @endif
            @if($module_permissions->where('slug','edit.links')->count() === 1 || $link->user_id === Auth::user('user')->user_id)
            <a id="{{$link->id}}" class="edit-link pull-right" style="padding-right: 10px"><i class="glyphicon glyphicon-pencil"></i></a>
            @endif
        </div>
    </div>
</li>