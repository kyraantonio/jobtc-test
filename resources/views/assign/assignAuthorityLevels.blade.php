@extends('layouts.default')
@section('content')
@foreach($authority_levels->chunk(3) as $chunk)
<div class="row">
    @foreach($chunk as $level)
    <div class="col-md-4">
        <div  class="box box-default">
            <div class="box-container">
                <div class="box-header">
                    <h3 class="box-title">{{$level->name}}&nbsp;(Level&nbsp;{{$level->level}})</h3>
                </div>
                <div class="box-body">
                    <div class="box-content">
                        <ul id="role-{{$level->id}}" class="list-group role-list">
                            @foreach($company_users as $profile)
                            @if($profile->role_id === $level->id)
                            <li class="list-group-item">
                                {{$profile->user->name}}
                                <div class="pull-right">
                                    <a href="#" class="drag-handle">
                                        <i class="fa fa-arrows"></i>
                                    </a>
                                    <input type="hidden" class="role_id" value="{{$level->id}}"/>
                                    <input type="hidden" class="user_id" value="{{$profile->user_id}}"/>
                                    <input type="hidden" class="company_id" value="{{$profile->company_id}}"/>
                                </div>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end column-->
    @endforeach
</div>
@endforeach
@stop