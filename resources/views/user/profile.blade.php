@extends('layouts.default')
@section('content')
    <div class="container-fluid content">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Update Profile</h4>
                        <p class="card-category">Complete your profile</p>
                    </div>
                    <div class="card-body">
                        {!!  Form::open(array('url' => 'updateProfile','files' => 'true', 'role' => 'form', 'class' =>
                    'profile-form container'))  !!}
                                <div class="row">
                                    <div class="form-group">
                                        <div class="media">
                                            <div class="media-body">
                                                {!!  Form::input('file','photo','',['accept' => 'image/*','class' => 'file-input', 'placeholder'=>'Upload Picture']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Name</label>
                                                {!!  Form::input('text','name',Auth::user()->name,['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Email</label>
                                                {!!  Form::input('email','email',Auth::user()->email,['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Address 1</label>
                                                {!!  Form::input('text','address_1',Auth::user()->address_1,['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Address 2</label>
                                                {!!  Form::input('text','address_2',Auth::user()->address_2,['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Country</label>
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
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Phone</label>
                                                {!!  Form::input('text','phone',Auth::user()->phone,['class' => 'form-control number-only']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Zip Code</label>
                                                {!!  Form::input('text','zipcode',Auth::user()->zipcode,['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Skype</label>
                                                {!!  Form::input('text','skype',Auth::user()->skype,['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Facebook</label>
                                                {!!  Form::input('text','facebook',Auth::user()->facebook,['class' => 'form-control url-only']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Linkedin</label>
                                                {!!  Form::input('text','linkedin',Auth::user()->linkedin,['class' => 'form-control url-only']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {!!  Form::submit('Update',['class' => 'btn btn-edit btn-primary float-right update-profile'])  !!}
                                        </div>
                                        <div class="pull-right btn bg-green update-progress"></div>
                                    </div>
                                </div>
                                {!!  Form::close()  !!}
                        </div>
                    
                </div>
            </div>
            <div class="col-md-4 row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="#pablo">
                                @if(empty(Auth::user()->photo))
                                <img class="img" src="assets/user/avatar.png" />
                                @else
                                <img class="img" src="{{url(Auth::user()->photo)}}" />
                                @endif
                            </a>
                        </div>
                        <div class="card-body">
                            <h6 class="card-category text-gray">{{Auth::user()->email}}</h6>
                            <h4 class="card-title">{{Auth::user()->name}}</h4>
                            <p class="card-description">{{Auth::user()->phone}}</p>
                            <p class="card-description"></p>
                            <p class="card-description"></p>
                            <p class="card-description"></p>
                            <a href="#pablo" class="btn btn-primary btn-round">Follow</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Change Password</h4>
                    </div>
                    <div class="card-body">
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
                                    {!!  Form::submit('Change Password',['disabled' => 'disabled','class' => 'btn btn-edit btn-primary change-password'])  !!}
                                </div>
                                <div class="pull-right btn bg-green update-password"></div>
                            </div>
                            {!!  Form::close()  !!}
                        </div>
                    </div>
                </div>
            </div>
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