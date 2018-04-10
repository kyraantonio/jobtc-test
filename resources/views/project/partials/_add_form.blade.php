<div class="form-body">
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::select('project_type', [
            'Standard' => 'Standard',
            'Hiring Assessment' => 'Hiring Assessment',
            'Software Development' => 'Software Development',
            'Coding' => 'Coding'
            ], '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Type', 'tabindex' => '7'] )  !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('text','project_title','',
            ['class' => 'form-control', 'placeholder' => 'Title', 'tabindex' => '1']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::textarea('project_description','',['rows' => '3','class' => 'form-control', 'placeholder' => 'Description', 'tabindex' => '6']) !!}
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

            {!! Form::select('company_id', $clients, $_company_id, ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Company', 'tabindex' =>'2'] )  !!}
        </div>
    </div>
<div class="form-group">
<div class="col-md-6">
<div class='input-group date datetimepicker' id='start_date'>
    {!!  Form::input('text','start_date','', ['class' => 'form-control form-control-inline input-medium date-picker', 'placeholder' => 'Start', 'tabindex' => '4'])  !!}
    <span class="input-group-addon open-date-calendar">
        <span class="glyphicon glyphicon-calendar"></span>
    </span>
</div>
</div>
<div class="col-md-6">
<div class='input-group date datetimepicker' id='start_date'>
    {!!  Form::input('text','deadline','', ['class' => 'form-control form-control-inline input-medium date-picker', 'placeholder' => 'Deadline', 'tabindex' => '5'])  !!}
    <span class="input-group-addon open-date-calendar">
        <span class="glyphicon glyphicon-calendar"></span>
    </span>
</div>
</div>
</div>
<div class="form-group">
<div class="col-md-2">
{!! Form::input('text','rate_value','',['class' =>
'form-control', 'placeholder' => 'Rate', 'tabindex' => '8']) !!}
</div>
<div class="col-md-3">
{!!  Form::select('currency', [
'USD' => 'USD',
'EUR' => 'EUR',
'GBP' => 'GBP',
'PHP' => 'PHP'
], '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Currency', 'tabindex' => '7'] )  !!}
</div>
<div class="col-md-3">
{!!  Form::select('rate_type', [
'fixed' => 'Fixed',
'hourly' => 'Hourly'
], '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Type', 'tabindex' => '7'] )  !!}
</div>
<div class="col-md-4">
{!!  Form::input('text','account','', ['class' => 'form-control form-control-inline input-medium', 'placeholder' => 'Account', 'tabindex' => '4'])  !!}
</div>
</div>
<div class="row">
<div class="pull-right">
{!!  Form::submit((isset($buttonText) ? $buttonText : 'Add Project'),['class' => 'btn btn-edit btn-shadow', 'tabindex' =>
'9'])  !!}
</div>
</div>
</div>
