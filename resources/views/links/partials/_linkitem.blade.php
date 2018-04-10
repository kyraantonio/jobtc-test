<li class='list-group-item link-{{$link->id}}'>
    <div class="row">
        <div class="col-sm-9">
            @if(empty($parse_url['scheme']))
            <a target="_blank" href="http://{{ $link->url }}">{{ $link->title }}</a>
            @else
            <a target="_blank" href="{{ $link->url }}">{{ $link->title }}</a>
            @endif
        </div>
        <div class="col-sm-3">
            @if($module_permissions->where('slug','delete.links')->count() === 1 || $link->user_id === Auth::user('user')->user_id)
            <a id="{{$link->id}}" class="remove-link pull-right"><i class="glyphicon glyphicon-remove"></i></a>
            @endif
            @if($module_permissions->where('slug','edit.links')->count() === 1 || $link->user_id === Auth::user('user')->user_id)
            <a id="{{$link->id}}" class="edit-link pull-right" style="padding-right: 10px;"><i class="glyphicon glyphicon-pencil"></i></a>
            @endif
        </div>
    </div>
    <input class="category_id" type="hidden" value="{{$link->category_id}}"/>
</li>