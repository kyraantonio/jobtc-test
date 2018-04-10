<form id="add-company-form">
    <div class="form-body">
        <div class="form-group">
            <div class="col-md-12">
                {!!  Form::input('text','name',isset($companies->name) ? $companies->name : '',['class'
                => 'form-control', 'placeholder' => 'Company Name', 'tabindex' => '1']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {!!  Form::input('email','email',isset($companies->email) ? $companies->email : '',['class' => 'form-control',
                'placeholder' => 'Contact Email', 'tabindex' => '3']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {!! Form::input('text','phone',isset($companies->phone) ? $companies->phone : '',['class' => 'form-control',
                'placeholder' => 'Contact Number', 'tabindex' => '4']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {!! Form::input('text','website',isset($companies->website) ? $companies->website: '',['class' => 'form-control',
                'placeholder' => 'Website', 'tabindex' => '10']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <select class="form-control input-xlarge select2me" name="number_of_employees" tabindex="5">
                    <option>Number of Employees</option>
                    <option>1 employee</option>
                    <option>more than 5</option>
                    <option>more than 10</option>
                    <option>more than 20</option>
                    <option>more than 50</option>
                    <option>more than 100</option>
                    <option>more than 200</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {!!  Form::textarea('address_1',isset($companies->address_1) ? $companies->address_1 : '',['size' => '30x2', 'class' =>
                'form-control', 'placeholder' => 'Address 1', 'tabindex' => '6']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {!!  Form::textarea('address_2',isset($companies->address_2) ? $companies->address_2 : '',['size' => '30x2', 'class' =>
                'form-control', 'placeholder' => 'Address 2', 'tabindex' => '7']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                {!! Form::input('text','province',isset($companies->province) ? $companies->province: '',['class' => 'form-control',
                'placeholder' => 'State/Province', 'tabindex' => '8']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                {!! Form::input('text','zipcode',isset($companies->zipcode) ? $companies->zipcode: '',['class' => 'form-control',
                'placeholder' => 'Zip/Postal', 'tabindex' => '9']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                {!!  Form::select('country_id', $countries,(isset($companies->country_id) ?
                $companies->country_id : ''), ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Select Country', 'tabindex' => '11'] )  !!}
            </div>
        </div>
    </div>
</form>
