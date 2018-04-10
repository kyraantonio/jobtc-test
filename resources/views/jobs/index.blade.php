@extends('layouts.default')
@section('content')
<div id="my_jobs">
    <div class="job_container">
        @foreach($jobs->chunk(2) as $chunk)
        <div class="job-row row">
            @foreach($chunk as $index => $job)
            <div class="col-md-6 job-column">
                <div class="job-details">
                    <div class="job-options pull-right">
                        <a target="_blank" href="{{url('job/'.$job->id)}}" class="btn-edit btn-shadow btn view-project">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            View
                        </a>
                    </div>
                    <div class="job_title"><a target="_blank" href='{{url('job/'.$job->id)}}'>{{$job->title}}</a></div>
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
@stop