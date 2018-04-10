@extends('layouts.default')
@section('content')
<div id="my_projects">
    <div class="col-md-12">
        <div class="project_container">
            @foreach($projects->chunk(2) as $chunk)
            <div class="project-row row">
                @foreach($chunk as $index => $project)
                <div class="col-md-6 project-column">
                    <div class="project-details">
                        <div class="project-options pull-right">
                            <a target="_blank" href="{{url('project/'.$project->project_id)}}" class="btn-edit btn-shadow btn view-project">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                View
                            </a>
                        </div>
                        <div class="project_title"><a target="_blank" href='{{url('project/'.$project->project_id)}}'>{{$project->project_title}}</a></div>
                        <div class="project_type">{{$project->project_type}}</div>
                        <div class="project_progress">{{$project->project_progress}}%</div>
                        <div class="project_description">{{$project->project_description}}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    
        <div class="modal fade edit-modal" id="edit_project_form" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                </div>
            </div>
        </div>
    </div>
</div>
@stop