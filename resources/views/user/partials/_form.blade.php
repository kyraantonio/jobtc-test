<div class="form-body">
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::select('company_id', $companies, isset($user->company_id) ?
            $user->client_id : '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Select Company', 'tabindex' => '1'] )  !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::select('role_id', $roles, isset($user->role_id) ? $user->role_id :
            '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Select User Role', 'tabindex' => '2'] ) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('text','name',isset($user->name) ? $user->name : '',['class' => 'form-control',
            'placeholder' => 'Name', 'tabindex' => '3']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('password','password','',['class' => 'form-control', 'placeholder' => 'Password', 'tabindex' => '4']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('email','email',isset($user->email) ? $user->email : '',['class' => 'form-control',
            'placeholder' => 'Email', 'tabindex' => '5']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('text','phone',isset($user->phone) ? $user->phone : '',['class' => 'form-control',
            'placeholder' => 'Contact Number', 'tabindex' => '6']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('file','photo',isset($user->photo) ? $user->photo: '',['class' => 'form-control',
            'placeholder' => 'Photo', 'tabindex' => '7', 'accept' => 'image/*']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('text','address_1',isset($user->address_1) ? $user->address_1: '',['class' => 'form-control',
            'placeholder' => 'Address 1', 'tabindex' => '8']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('text','address_2',isset($user->address_2) ? $user->address_2: '',['class' => 'form-control',
            'placeholder' => 'Address 2', 'tabindex' => '9']) !!}
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-12">
            {!! Form::input('text','zipcode',isset($user->zipcode) ? $user->zipcode: '',['class' => 'form-control',
            'placeholder' => 'Zipcode', 'tabindex' => '10']) !!}
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::select('country_id', $countries,( isset($user->country_id) ?
            $user->country_id : ''), ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Select Country', 'tabindex' => '11'] )  !!}
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('text','skype',isset($user->skype) ? $user->skype: '',['class' => 'form-control',
            'placeholder' => 'Skype', 'tabindex' => '12']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('text','facebook',isset($user->facebook) ? $user->facebook: '',['class' => 'form-control',
            'placeholder' => 'Facebook', 'tabindex' => '13']) !!}
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-12">
            {!!  Form::input('text','linkedin',isset($user->linkedin) ? $user->linkedin: '',['class' => 'form-control',
            'placeholder' => 'LinkedIn', 'tabindex' => '14']) !!}
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-12">
            <input class="checkbox" id="ticketit_admin" name="ticketit_admin" type="checkbox" value='1' tabindex="15"/>
            <label for="ticketit_admin">Ticketit Admin</label>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-12">
            <input class="checkbox" id="ticketit_agent" name="ticketit_agent" type="checkbox" value='1' tabindex="16"/>
            <label for="ticketit_agent">Ticketit Agent</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!!  Form::submit(isset($buttonText) ? $buttonText : 'Add User',['class' => 'btn btn-edit btn-shadow pull-right', 'tabindex' =>
            '17'])  !!}
        </div>
    </div>
</div>
