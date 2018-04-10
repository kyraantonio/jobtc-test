@extends('layouts.default')
@section('content')
<div class="column" style="padding-bottom: 0;">
    <div class="portlet">
        <div class="portlet-header">No Category</div>
        <div id="category-0" class="portlet-content">
            <ul class="link-group-0" style="padding-left: 0!important;">
                @foreach($links as $link)
                @if($link->category_id === 0)
                <li class='list-group-item link-{{$link->id}}'>
                    <div class="row">
                        <div class="col-sm-9">
                            {{--*/ $parse_url = parse_url($link->url) /*--}}
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
                            <input class="task_id" type="hidden" value="{{$link->briefcases['task_id']}}"/>
                        </div>
                    </div>
                </li>
                @endif
                @endforeach
            </ul>
            <div style="list-style: none;padding: 10px 0">
                <a class="btn btn-submit btn-shadow btn-sm pull-right add-link"><i class="glyphicon glyphicon-plus"></i> Link</a>
                <input class="add_link_category_id" type="hidden" value="0"/>
                <input class="add_link_user_id" type="hidden" value="{{$user_id}}"/>
                <input class="add_link_company_id" type="hidden" value="{{$company_id}}"/>
            </div>
        </div>
    </div>
</div>
@foreach($categories->chunk(3) as $chunk)
<div class="column" style="padding-bottom: 0;">
    @foreach($chunk as $category)
    <div class="portlet">
        <div class="portlet-header">{{ $category->name }}</div>
        <div id="category-{{$category->id}}" class="portlet-content">
            <ul class="link-group-{{$category->id}}" style="padding-left: 0!important;">
                @foreach($links as $link)
                @if($link->category_id === $category->id)
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
                </li>
                @endif
                @endforeach
            </ul>
            <div style="list-style: none;padding: 10px 0">
                <a class="btn btn-submit btn-shadow btn-sm pull-right add-link"><i class="glyphicon glyphicon-plus"></i> Link</a>
                <input class="add_link_category_id" type="hidden" value="{{$category->id}}"/>
                <input class="add_link_user_id" type="hidden" value="{{$user_id}}"/>
                <input class="add_link_company_id" type="hidden" value="{{$company_id}}"/>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach
@stop
