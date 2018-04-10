<div class="form-body">
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::select('project_type', [
                'Standard' => 'Standard',
                'Hiring Assessment' => 'Hiring Assessment',
                'Software Development' => 'Software Development',
                'Coding' => 'Coding'
            ], isset($project->project_type) ? $project->project_type : '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Type', 'tabindex' => '7'] )  !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('text','project_title',isset($project->project_title) ? $project->project_title : '',
            ['class' => 'form-control', 'placeholder' => 'Title', 'tabindex' => '1']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::textarea('project_description',isset($project->project_description) ?
            $project->project_description : '',['rows' => '3','class' => 'form-control', 'placeholder' => 'Description', 'tabindex' => '6']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {{--*/ $companies = \App\Helpers\Helper::getCompanyLinks() /*--}}
            {{--*/ $clients = [] /*--}}
            {{--*/ $_company_id = Request::segment(2) /*--}}
            @if(count($companies) > 0)
                @foreach($companies as $company)
                    {{--*/ $clients[$company->company->id] = $company->company->name /*--}}
                @endforeach
            @endif
            {!! Form::select('company_id', $clients, isset($project->company_id) ?
            $project->company_id : $_company_id, ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Company', 'tabindex' =>'2'] )  !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <div class='input-group date datetimepicker' id='start_date'>
                {!!  Form::input('text','start_date',
                    isset($project->start_date) ? date("d-m-Y",strtotime($project->start_date)) : '', ['class' => 'form-control form-control-inline input-medium', 'placeholder' => 'Start', 'tabindex' => '4'])  !!}
                <span class="input-group-addon open-date-calendar">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class='input-group date datetimepicker' id='end_date'>
                {!!  Form::input('text','deadline',
                    isset($project->deadline) ? date("d-m-Y",strtotime($project->deadline)) : '', ['class' => 'form-control form-control-inline input-medium', 'placeholder' => 'Deadline', 'tabindex' => '5'])  !!}
                <span class="input-group-addon open-date-calendar">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2">
            {!! Form::input('text','rate_value',isset($project->rate_value) ? $project->rate_value : '',['class' =>
            'form-control', 'placeholder' => 'Rate', 'tabindex' => '8']) !!}
        </div>
        <div class="col-md-3">
            {!!  Form::select('currency', [
                'USD' => 'USD',
                'EUR' => 'EUR',
                'GBP' => 'GBP',
                'PHP' => 'PHP'
            ], isset($project->currency) ? $project->currency : '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Currency', 'tabindex' => '7'] )  !!}
        </div>
        <div class="col-md-3">
            {!!  Form::select('rate_type', [
                'fixed' => 'Fixed',
                'hourly' => 'Hourly'
            ], isset($project->rate_type) ? $project->rate_type : '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Type', 'tabindex' => '7'] )  !!}
        </div>
        <div class="col-md-4">
            {!!  Form::input('text','account',isset($project->account) ? $project->account : '', ['class' => 'form-control form-control-inline input-medium', 'placeholder' => 'Account', 'tabindex' => '4'])  !!}
            {!!  Form::input('hidden','project_id',isset($project->project_id) ? $project->project_id: '', ['class' => 'form-control form-control-inline input-medium project_id'])  !!}
        </div>
    </div>
    <div class="row">
        <div class="pull-right">
            {!!  Form::submit((isset($buttonText) ? $buttonText : 'Add Project'),['class' => 'btn btn-edit btn-shadow update-project', 'tabindex' =>
            '9'])  !!}
        </div>
    </div>
</div>
<script>
    $('.update-project').click(function(e){
        e.preventDefault();
        
        var project_id = $('.project-form').find('.project_id').val();
        
        console.log(project_id)
        
        var url = public_path + 'project/' + project_id;
        
        $.ajax( 
        { 
            url: url,
            type: 'POST', 
            data: $('#project-form').serialize(),
            success: function(data){
                $('#edit_project_form').modal('toggle');
                $('#project-'+project_id).find('.box-title').text(data);
            }
        });
    });
</script>