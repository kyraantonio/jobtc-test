@extends('layouts.default')
@section('content')
<div id="employees">
<div class="employee-container">
    @foreach($profiles->chunk(2) as $chunk)
    <div class="row employee-row">
        @foreach($chunk as $profile)
        @include('user.partials._newemployee')
        @endforeach
    </div>
    @endforeach
</div>
<div class="mini-space"></div>
<div class="row">
    <div class="employee_tab_options">
        @if($module_permissions->where('slug','create.employees')->count() === 1)
        <a href="#" id="add-employee" class="btn btn-shadow btn-default add-employee">
            <i class="fa fa-plus"></i> 
            <strong>New Employee</strong>
        </a>
        @endif
        <input class="company_id" type="hidden" value="{{$company_id}}"/>
    </div>
</div>
</div>
@stop