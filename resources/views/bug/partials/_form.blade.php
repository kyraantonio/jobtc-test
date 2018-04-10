<div class="form-body">
    <div class="form-group">
        {!!  Form::label('ref_no','Reference No',['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-9">
            {!!  Form::input('text','ref_no',isset($bugs->ref_no) ? $bugs->ref_no : '',['class' => 'form-control',
            'placeholder' => 'Reference No', 'tabindex' => '1']) !!}
        </div>
    </div>
    <div class="form-group">
        {!!  Form::label('project_id','Project',['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-9">
            {!!  Form::select('project_id',  $projects, isset($bugs->project_id) ?
            $bugs->project_id : '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Select One', 'tabindex' => '2'] )  !!}
        </div>
    </div>
    <div class="form-group">
        {!!  Form::label('reported_on','Report Date',['class' => 'col-md-3 control-label form-control-inline
        date-picker']) !!}
        <div class="col-md-9">
            {!!  Form::input('text','reported_on',isset($bugs->reported_on) ? date("d M Y H:i",strtotime
            ($bugs->reported_on)) : '',['class' => 'form-control form-control-inline input-medium date-picker', 'placeholder' => 'Report Date', 'tabindex' => '3', 'data-inputmask' => "'alias': 'dd-mm-yyyy'", 'data-mask' => 'true'])  !!}
        </div>
    </div>
    <div class="form-group">
        {!!  Form::label('bug_description','Description',['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-9">
            {!!  Form::textarea('bug_description',isset($bugs->bug_description) ? $bugs->bug_description : '',['size'
            => '30x3', 'class' => 'form-control', 'placeholder' => 'Project Description', 'tabindex' => '4']) !!}
        </div>
    </div>
    <div class="form-group">
        {!!  Form::label('bug_priority','Priority',['class' => 'col-md-3 control-label', 'tabindex' => '5']) !!}
        <div class="col-md-9">
            {!!  Form::select('bug_priority', [
                null => 'Please select',
                'low' => 'Low',
                'medium' => 'Medium',
                'high' => 'High',
                'critical' => 'Critical'
             ], isset($bugs->bug_priority) ? $bugs->bug_priority : '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Select One', 'tabindex' => '6'] )  !!}
        </div>
    </div>
    <div class="form-group">
        {!!  Form::label('bug_status','Status',['class' => 'col-md-3 control-label', 'tabindex' => '7']) !!}
        <div class="col-md-9">
            {!! Form::select('bug_status', [
                null => 'Please select',
                'unconfirmed' => 'Unconfirmed',
                'confirmed' => 'Confirmed',
                'progress' => 'Progress',
                'resolved' => 'Resolved'
             ], isset($bugs->bug_status) ? $bugs->bug_status : '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Select One', 'tabindex' => '8'] )   !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!!  Form::submit(isset($buttonText) ? $buttonText : 'Add Bug',['class' => 'btn green', 'tabindex' => '9'])  !!}
        </div>
    </div>
</div>
