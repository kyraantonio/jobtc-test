@extends('layouts.default')
@section('content')
@foreach($type['_source']['hits'] as $result)
{{$result->project_title}}
@endforeach
@stop