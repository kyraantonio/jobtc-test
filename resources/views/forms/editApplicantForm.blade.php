{!! Form::model($applicant,['method' => 'PATCH','route' => ['applicant.update',$applicant->id] ,'class' =>
        'edit-applicant-form form-horizontal','enctype' => 'multipart/form-data','novalidate' => 'novalidate','role' => 'form'])  !!}
    <div class="box-body">
        <div class="box-content">
            @if($is_upload)
            <div class="form-group">
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            @if($applicant->photo === '' || $applicant->photo === NULL
                            || !file_exists(public_path() . '/' . $applicant->photo))
                            <img class="edit-applicant-photo" src="{{url('assets/user/default-avatar.jpg')}}" />
                            @else
                            <img class="edit-applicant-photo" src="{{url($applicant->photo)}}"/>
                            @endif
                        </a>
                    </div>
                    <div class="media-body">
                        <br />
                        <br />
                        <br />
                        <br />
                        {!!  Form::input('file','photo','',['accept' => 'image/*']) !!}
                    </div>
                </div>
            </div>
            @endif
            @if(!$is_upload)
            <div class="form-group">
                <label class="control-label col-sm-2">Name:</label>
                <div class="col-sm-9">
                    {!!  Form::input('text','name',$applicant->name,['class' => 'form-control', 'placeholder' =>
                    'Name']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Email:</label>
                <div class="col-sm-9">
                    {!!  Form::input('email','email',$applicant->email,['class' => 'form-control', 'placeholder'
                                    => 'Email']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Phone:</label>
                <div class="col-sm-9">
                    {!!  Form::input('text','phone',$applicant->phone,['class' => 'form-control', 'placeholder'
                                    => 'Phone']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Skype:</label>
                <div class="col-sm-9">
                    {!!  Form::input('text','skype',$applicant->skype,['class' => 'form-control', 'placeholder'
                                    => 'Skype']) !!}
                </div>
            </div>
            @endif
            @if($is_upload)
            <div class="form-group">
                <label class="control-label col-sm-2">Resume:</label>
                <div class="col-sm-9">
                    {!!  Form::input('file','resume','') !!}
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="pull-right">
                @if($is_upload)
                    <button type="submit" name="submit" class="btn btn-sm btn-submit btn-shadow">Upload</button>
                @else
                    <button type="submit" name="update" class="btn btn-sm btn-submit btn-shadow">Update</button>
                @endif
                <button type="button" name="cancel" class="btn btn-sm btn-default btn-shadow" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
{!!  Form::close()  !!}
