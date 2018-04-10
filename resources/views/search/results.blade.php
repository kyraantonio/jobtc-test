@extends('layouts.default')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="search-module">Searched "{{$term}}" in {{studly_case(str_plural($type))}}, {{count($results)}} results</div>
    </div>
</div>
<div class="row">
    @foreach($results as $result)
    @if($type === 'project')
    <div class="col-md-6 search-column">
        <a class="project-title" target="_blank" href="{{url('project/'.$result->project_id)}}">
            {{$result->project_title}}
        </a>
    </div>
    @endif
    @if($type === 'briefcase')
    <div class="col-md-6 search-column">
        <a class="briefcase-title" target="_blank" href="{{url('briefcase/'.$result->task_id)}}">
            {{$result->task_title}}
        </a>
    </div>
    @endif
    @if($type === 'task item')
    <div class="col-md-6 search-column">
        <a class="taskitem-title" target="_blank" href="{{url('taskitem/'.$result->id)}}">
            {{$result->checklist_header}}
        </a>
    </div>
    @endif
    @if($type === 'job')
    <div class="col-md-6 search-column">
        <a class="job-title" target="_blank" href="{{url('job/'.$result->id)}}">
            {{$result->title}}
        </a>
    </div>
    @endif
    @if($type === 'applicant')
    <div class="col-md-6 search-column">
        <a class="applicant-name" target="_blank" href="{{url('a/'.$result->id)}}">
            {{$result->name}}
        </a>
    </div>
    @endif
    @if($type === 'employee')
    @foreach($result->profile as $profile)
    <div class="col-md-6 search-column">
        <a class="employee-name" target="_blank" href="{{url('user/'.$result->user_id.'/company/'.$profile->company_id)}}">
            {{$result->name}}
        </a>
        <div class="company">
            {{$profile->company->name}}
        </div>
    </div>
    @endforeach
    @endif
    @if($type === 'test')
    <div class="col-md-6 search-column">
        <a class="test-name" target="_blank" href="{{url('quiz/'.$result->id)}}">
            {{$result->title}}
        </a>
    </div>
    @endif
    @if($type === 'position')
    <div class="col-md-6 search-column">
        <a class="position-name" target="_blank" href="#">
            {{$result->name}}
        </a>
    </div>
    @endif
    @if($type === 'ticket')
    <div class="col-md-6 search-column">
        <a class="position-name" target="_blank" href="#">
            {{$result->title}}
        </a>
    </div>
    @endif
    @endforeach
</div>
@stop