@extends('layouts.default')
@section('content')
<?php
/*
 * Job Dashboard
 * Updated 4/23/2015
 * */
?>
@if($jobs->total() > 1)
<div class="text-center hidden-sm hidden-xs">
    <ul class="pagination applicant-list-pager">
        @if($jobs->currentPage() > 1)
        <li><a class="pager-previous" href="{{$jobs->previousPageUrl()}}" rel="previous">Previous</a></li> 
        @endif
        @for($i = 1; $i <= $jobs->lastPage(); $i++)
        @if($i === $jobs->currentPage())
        <li class="active"><a id="pager-item-{{$i}}" class="pager-item" href="{{$jobs->url($i)}}">{{$i}}</a></li>
        @else
        <li><a id="pager-item-{{$i}}" class="pager-item" href="{{$jobs->url($i)}}">{{$i}}</a></li>
        @endif
        @endfor
        @if($jobs->currentPage() < $jobs->lastPage())
        <li><a class="pager-next" href="{{$jobs->nextPageUrl()}}" rel="next">Next</a></li>
        @endif
    </ul>
</div>
<div class="text-center hidden-lg hidden-md">
    <ul class="pagination applicant-list-pager">
        @if($jobs->currentPage() > 1)
        <li><a class="pager-previous-mobile" href="{{$jobs->previousPageUrl()}}" rel="previous">Previous</a></li> 
        @endif
        @for($i = 1; $i <= $jobs->lastPage(); $i++)
        @if($i === $jobs->currentPage())
        <li class="active"><a id="pager-item-mobile-{{$i}}" class="pager-item-mobile" href="{{$jobs->url($i)}}">{{$i}}</a></li>
        @else
        <li><a id="pager-item-mobile-{{$i}}" class="pager-item-mobile" href="{{$jobs->url($i)}}">{{$i}}</a></li>
        @endif
        @endfor
        @if($jobs->currentPage() < $jobs->lastPage())
        <li><a class="pager-next-mobile" href="{{$jobs->nextPageUrl()}}" rel="next">Next</a></li>
        @endif
    </ul>
</div>
@endif
<div class="job-list-container container-fluid">
    <div class="row job-list-row">
        @unless($jobs->count())
        <div class="col-md-12">No available jobs. Please add a job.</div>
        @else
        @foreach($jobs as $list_item)
        <div class="col-md-4 col-xs-12">
            <div class="job">    
                <div class="job-info row">
                    <div class="col-md-12">
                        <div class="media">
                            <div class="media-middle">
                                <a target="_blank" href="/j/{{$list_item->id}}">
                                    @if(isset($list_item->photo))
                                    <img class="job-photo" src="{{url($list_item->photo)}}" alt="Job Photo">
                                    @else
                                    <img class="job-photo" src="{{url('uploads/default-avatar.jpg')}}" alt="Job Photo">
                                    @endif
                                </a>
                                <div class="pull-right hidden-xs">
                                    @if($list_item->applicants->count() > 1)
                                    <a href="/applicant/list/{{$list_item->id}}" target="_blank" class="btn btn-info btn-lg view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$list_item->applicants->count()}} Applicants</a>
                                    <a href="/applicant/list/{{$list_item->id}}" target="_blank" class="btn btn-info btn-md view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$list_item->applicants->count()}} Applicants</a>
                                    @elseif ($list_item->applicants->count() === 1) 
                                    <a href="/applicant/list/{{$list_item->id}}" target="_blank" class="btn btn-info btn-lg view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$list_item->applicants->count()}} Applicant</a>
                                    <a href="/applicant/list/{{$list_item->id}}" target="_blank" class="btn btn-info btn-md view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$list_item->applicants->count()}} Applicant</a>
                                    @elseif ($list_item->applicants->count() === 0)
                                    <a href="/applicant/list/{{$list_item->id}}" target="_blank" class="btn btn-info btn-lg view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;No Applicants</a>
                                    <a href="/applicant/list/{{$list_item->id}}" target="_blank" class="btn btn-info btn-md view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;No Applicants</a>
                                    @endif
                                    <input name="job_id" class="job_id" type="hidden" value="{{$list_item->id}}"/>
                                </div>
                                <div class="pull-right hidden-md hidden-lg hidden-sm">
                                    @if($list_item->applicants->count() > 1)
                                    <a href="#" target="_blank" class="btn btn-info btn-lg view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$list_item->applicants->count()}} Applicants</a>
                                    <a href="#" target="_blank" class="btn btn-info btn-md view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$list_item->applicants->count()}} Applicants</a>
                                    @elseif ($list_item->applicants->count() === 1) 
                                    <a href="#" target="_blank" class="btn btn-info btn-lg view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$list_item->applicants->count()}} Applicant</a>
                                    <a href="#" target="_blank" class="btn btn-info btn-md view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$list_item->applicants->count()}} Applicant</a>
                                    @elseif ($list_item->applicants->count() === 0)
                                    <a href="#" target="_blank" class="btn btn-info btn-lg view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;No Applicants</a>
                                    <a href="#" target="_blank" class="btn btn-info btn-md view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;No Applicants</a>
                                    @endif
                                    <input name="job_id" class="job_id" type="hidden" value="{{$list_item->id}}"/>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="mini-space"></div>
                                <text class="media-heading"><a target="_blank" href="/j/{{$list_item->id}}">{{$list_item->title}}</a></text>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mini-space"></div>
                <div class="row tasklist-row">
                    <div id="applicant-list-{{$count}}" class="applicant-list col-md-12">
                        <p class="job-description">{!! nl2br(e($list_item->description)) !!}</p>
                        <input class="token" name="_token" type="hidden" value="{{csrf_token()}}">
                    </div>
                </div>
                <div class="mini-space"></div>
            </div>
            <div class="mini-space"></div>
            <div class="job-header pull-right">
                <a class="btn btn-edit btn-shadow btn-lg edit-job"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
                <a class="btn btn-delete btn-shadow btn-lg delete-job"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
                <input name="job_id" class="job_id" type="hidden" value="{{$list_item->id}}"/>
            </div>
            {{--*/ $count++ /*--}}
        </div><!-- end card-->
        @endforeach
        @endunless
    </div>
</div><!-- end section -->
@stop