@extends('layouts.default')
@section('content')
<div class="row">
    <div class="col-xs-6">        
        <select id="company-list" class="btn btn-default">
            @foreach($companies as $company)
            <option value="{{$company->id}}">{{$company->name}}</option>
            @endforeach
        </select>
        <div class="mini-space"></div>
            <div class="form-group">
                <label for="email">Indeed Email</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="password">
            </div>
            <button class="btn btn-default start-crawler">Submit</button>
    </div>
    <div class="col-xs-6">
        
    </div>
</div>
@stop
