@extends('layouts.default')
@section('content')
<div class="row profile">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">Update Profile</h3>
            </div>
            {!!  Form::open(array('url' => 'updateProfile','files' => 'true', 'role' => 'form', 'class' =>
            'profile-form'))  !!}
            <div class="box-body">
                <div class="box-content">
                    <div class="form-group">
                        <div class="media">
                            <div class="media-body">
                                {!!  Form::input('file','photo','',['accept' => 'image/*','class' => 'file-input', 'placeholder'=>'Upload Picture']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!!  Form::input('text','name',Auth::user()->name,['class' => 'form-control', 'placeholder' =>
                        'Name']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::input('email','email',Auth::user()->email,['class' => 'form-control', 'placeholder'
                        => 'Email']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('phone','Phone') !!}
                        {!!  Form::input('text','phone',Auth::user()->phone,['class' => 'form-control number-only', 'placeholder'
                        => 'Phone']) !!}
                    </div>

                    <div class="form-group">
                        {!!  Form::label('address_1','Address 1') !!}
                        {!!  Form::input('text','address_1',Auth::user()->address_1,['class' => 'form-control', 'placeholder'
                        => 'Address 1']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('address_2','Address 2') !!}
                        {!!  Form::input('text','address_2',Auth::user()->address_2,['class' => 'form-control', 'placeholder'
                        => 'Address 2']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('zipcode','Zip Code') !!}
                        {!!  Form::input('text','zipcode',Auth::user()->zipcode,['class' => 'form-control', 'placeholder'
                        => 'Enter Phone']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('country','Country') !!}
                        <select name="country_id" class='form-control input-xlarge select2me' placeholder="Select Country">
                            @foreach($countries as $country)
                            @if($country->country_id == Auth::user()->country_id)
                            <option selected="selected" value='{{$country->country_id}}'>{{$country->country_name}}</option>
                            @else
                            <option value='{{$country->country_id}}'>{{$country->country_name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        {!!  Form::label('skype','Skype') !!}
                        {!!  Form::input('text','skype',Auth::user()->skype,['class' => 'form-control', 'placeholder'
                        => 'Skype']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('facebook','Facebook') !!}
                        {!!  Form::input('text','facebook',Auth::user()->facebook,['class' => 'form-control url-only', 'placeholder'
                        => 'Facebook']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::label('linkedin','LinkedIn') !!}
                        {!!  Form::input('text','linkedin',Auth::user()->linkedin,['class' => 'form-control url-only', 'placeholder'
                        => 'Linkedin']) !!}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-6">
                        {!!  Form::submit('Update',['class' => 'btn btn-edit btn-shadow update-profile'])  !!}
                    </div>
                    <div class="pull-right btn bg-green update-progress"></div>
                </div>
            </div>
            {!!  Form::close()  !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">Change Password</h3>
            </div>
            {!!  Form::open(array('url' => 'changePassword', 'role' => 'form', 'class' => 'change-password-form'))  !!}
            <div class="box-body">
                <div class="box-content">
                    <div class="form-group">
                        {!!  Form::input('password','password','',['id' =>'current_password', 'class' => 'form-control', 'placeholder' => 'Current Password']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::input('password','new_password','',['id' => 'new_password', 'class' => 'form-control', 'placeholder' =>
                        'New Password']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::input('password','new_password_confirmation','',['id' => 'new_password_confirmation','class' => 'form-control',
                        'placeholder' => 'Confirm Password']) !!}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-6">
                        {!!  Form::submit('Change Password',['disabled' => 'disabled','class' => 'btn btn-edit btn-shadow change-password'])  !!}
                    </div>
                    <div class="pull-right btn bg-green update-password"></div>
                </div>
                {!!  Form::close()  !!}
            </div>
        </div>
    </div>
    <style>
        .kv-file-remove{
            display: none;
        }
    </style>
    <script>
        $(function (e) {
            $('.file-input').fileinput({
                uploadAsync: true,
                maxFileSize: 1000000,
                removeClass: "btn btn-sm btn-delete btn-shadow",
                browseClass: "btn btn-sm btn-edit btn-shadow",
                browseLabel: 'Browse Picture ..',
                uploadClass: "btn btn-sm btn-assign hide btn-shadow",
                cancelClass: "btn btn-sm btn-default btn-shadow",
                showRemove: false,
                showCaption: false,
                initialPreviewFileType: ['image'],
                dropZoneEnabled: false,
                showUpload: true,
                overwriteInitial: false,
                initialPreviewAsData: true,
                initialPreview:['{{url(Auth::user()->photo)}}'],
                initialPreviewConfig: [{
                    'caption' : 'User Profile',
                    'width': '200px',
                    'key' : 1
                }]
            });
        });
    </script>
    @stop