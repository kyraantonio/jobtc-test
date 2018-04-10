@extends('layouts.default')
@section('content')
<div id="positions">
    <div class="position_container">
        @foreach($positions->chunk(2) as $chunk)
        <div class="position-row row">
            @foreach($chunk as $position)
            @include('roles.partials._newposition')
            @endforeach
        </div>
        @endforeach
    </div>
    <div class="mini-space"></div>
    <div class="position_tab_options">
        @if($module_permissions->where('slug','create.positions')->count() === 1)
        <a href="#" id="add-position" class="btn btn-shadow btn-default add-position">
            <i class="fa fa-plus"></i> 
            <strong>New Position</strong>
        </a>
        @endif
        <input class="company_id" type="hidden" value="{{$company_id}}"/>
    </div>
</div>
@stop