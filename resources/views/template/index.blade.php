@extends('layouts.default')

@section('content')


    <div class="col-md-12">
        <div class="box box-solid box-default">
            <div class="box-header">
                <h3 class="box-title">Email Templates</h3>
            </div>
            <div class="box-body">
                {!!  Form::open(['class' => 'form-horizontal'])  !!}
                <div class="form-body">
                    <div class="form-group">
                        {!!  Form::label('template_id','Select Template',['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <select onchange="if (this.value) window.location.href=this.value" name="template_id"
                                    id="template_id" class="form-control input-xlarge select2me"
                                    placeholder="Select One" tabindex="1">
                                <option value="">Select One</option>
                                @foreach($templates as $template)
                                    <option value="{{ url('template/'.$template->template_id.'/edit') }}">{{ $template->template_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                {!!  Form::close()  !!}
            </div>
        </div>
    </div>
@stop
