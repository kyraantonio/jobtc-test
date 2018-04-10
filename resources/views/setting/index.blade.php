@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">General Setting </h3>
                </div>
                @if(isset($setting->id))
                    {!!  Form::open(['files' => 'true', 'method' => 'PUT','route' => ['setting.update', isset
                    ($setting->id) ? $setting->id : ''],'class' => 'general-setting-form'])  !!}
                @else
                    {!!  Form::open(['files' => 'true', 'method' => 'POST','route' => ['setting.store'],'class' =>
                    'form-horizontal setting-form'])  !!}
                @endif
                <div class="box-body">
                    <div class="form-group">
                        {!!  Form::input('text','company_name',isset($setting->company_name) ? $setting->company_name :
                        '',['class' => 'form-control', 'placeholder' => 'Company Name', 'tabindex' => '1']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('contact_person','Contact Person') !!}
                        {!!  Form::input('text','contact_person',isset($setting->contact_person) ?
                        $setting->contact_person : '',['class' => 'form-control', 'placeholder' => 'Enter Contact Person', 'tabindex' => '2']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('address','Address') !!}
                        {!!  Form::textarea('address',isset($setting->address) ? $setting->address : '',['size' =>
                        '30x3', 'class' => 'form-control', 'placeholder' => 'Enter Contact Address', 'tabindex' => '3']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('city','City') !!}
                        {!!  Form::input('text','city',isset($setting->city) ? $setting->city : '',['class' =>
                        'form-control', 'placeholder' => 'Enter City Name', 'tabindex' => '4']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('state','State') !!}
                        {!!  Form::input('text','state',isset($setting->state) ? $setting->state : '',['class' =>
                        'form-control', 'placeholder' => 'Enter State Name', 'tabindex' => '5']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('country_id','Country') !!}
                        {!!  Form::select('country_id', [null=>'Please Select'] + $countries, isset
                        ($setting->country_id) ? $setting->country_id : '', ['class' => 'form-control input-large select2me', 'placeholder' => 'Select One', 'tabindex' => '6'] )  !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('zipcode','Zip Code') !!}
                        {!!  Form::input('number','zipcode',isset($setting->zipcode) ? $setting->zipcode : '',['class'
                        => 'form-control', 'placeholder' => 'Enter Zip Code', 'tabindex' => '7']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('email','Email') !!}
                        {!!  Form::input('email','email',isset($setting->email) ? $setting->email : '',['class' =>
                        'form-control', 'placeholder' => 'Enter Email', 'tabindex' => '8']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('phone','Phone') !!}
                        {!!  Form::input('text','phone',isset($setting->phone) ? $setting->phone : '',['class' =>
                        'form-control', 'placeholder' => 'Enter Phone', 'tabindex' => '9']) !!}
                    </div>
                    <div class="form-group">
                        <label>
                            {!!  Form::checkbox('remove_image', 'Yes', false, ['class' => 'form-control', 'id' =>
                            'remove_image', 'tabindex' => '10']) !!}
                            Remove Logo
                        </label>
                    </div>
                    <div class="form-group" id="div_avatar">
                        {!!  Form::label('file','Avatar') !!}
                        {!!  Form::input('file','file','') !!}
                    </div>
                </div>
                <div class="box-footer">
                    {!!   Form::submit('Save',['class' => 'btn btn-edit', 'tabindex' => '13']) !!}
                </div>
                {!!  Form::close()  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">System Setting </h3>
                </div>
                {!!  Form::open(['method' => 'PUT','route' => ['setting.update', isset($setting->id) ? $setting->id :
                ''],'class' => 'system-setting-form'])  !!}
                <div class="box-body">
                    <div class="form-group">
                        {!!  Form::input('text','allowed_upload_file',isset($setting->allowed_upload_file) ?
                        $setting->allowed_upload_file : '',['class' => 'form-control', 'placeholder' => 'File Extensions']) !!}
                        <span class="help-block">Separated by comma operator (,) </span>
                    </div>
                    <div class="form-group">
                        {!! Form::select('default_language',[
                                'en'=>'English',
                                'fr'=>'French',
                                'du'=>'Dutch',
                                'ge'=>'German',
                                'it'=>'Italian',
                                'rs'=>'Russian',
                                'sp'=>'Spanish'
                                ],$setting->default_language,['class' => 'form-control', 'placeholder' => 'Select Language', 'tabindex' => '14']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::select('timezone_id', [null=>'Please Select'] + $timezone, isset
                        ($setting->timezone_id) ? $setting->timezone_id : '', ['class' => 'form-control input-large select2me', 'placeholder' => 'Select Timezone', 'tabindex' => '15'] )  !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::input('text','allowed_upload_max_size',isset($setting->allowed_upload_max_size) ?
                        $setting->allowed_upload_max_size : '',['class' => 'form-control', 'placeholder' => 'File Max Size', 'tabindex' => '16']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::input('text','default_currency',isset($setting->default_currency) ?
                        $setting->default_currency : '',['class' => 'form-control', 'placeholder' => 'Default Currency', 'tabindex' => '17']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::input('number','default_tax',isset($setting->default_tax) ? round
                        ($setting->default_tax,2) : '',['class' => 'form-control', 'placeholder' => 'Default Tax', 'tabindex' => '18']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::input('number','default_discount',isset($setting->default_discount) ? round
                        ($setting->default_discount,2) : '',['class' => 'form-control', 'placeholder' => 'Default Discount', 'tabindex' => '19']) !!}
                    </div>
                </div>
                <div class="box-footer">
                    {!!  Form::submit('Save',['class' => 'btn btn-edit btn-shadow', 'tabindex' => '20'])  !!}
                </div>
                {!!  Form::close()  !!}
            </div>
        </div>
    </div>
@stop