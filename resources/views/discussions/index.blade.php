@extends('layouts.default')
@section('content')
<?php
/*
 * Discussions index page
 */
?>
<button class='btn btn-primary create-room'>Create Discussion Room</button>
<h2>Discussions</h2>
<table class="table rooms-table">
    <thead>
        <tr>
            <th>Room</th>
            <th>Type</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @forelse($discussions as $discussion)
        <tr>
            <td id="room_name-{{$discussion->id}}">{{$discussion->room_name}}</td>
            <td id="room_type-{{$discussion->id}}">{{$discussion->room_type}}</td>
            <td>
                <div class="btn-group">
                    @if($discussion->room_type == 'public')
                    <a target="_blank" id="room_link-{{$discussion->id}}" href="{{url('/discussions/'.$discussion->id.'/public')}}" class='btn btn-success'>Join</a>
                    @else
                    <a target="_blank" href="{{url('/discussions/'.$discussion->id)}}" class='btn btn-success'>Join</a>
                    @endif
                    <a target="_blank" href="{{url('/discussions/'.$discussion->id.'/edit')}}" class='btn btn-success edit-room'>Edit</a>
                    <a target="_blank" href="{{url('/discussions/'.$discussion->id)}}" class='btn btn-success delete-room'>Delete</a>
                    <input class="room_id" type="hidden" value="{{$discussion->id}}" />
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td>No Rooms Available</td>
        </tr>
        @endforelse
    </tbody>
</table>
@stop