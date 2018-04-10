<div class="form-body">
    <div class="form-group">
        {!!   Form::label('ref_no','Ref No',['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-9">
            {!!  Form::input('text','ref_no',isset($billing->ref_no) ? $billing->ref_no : '',['class' =>
            'form-control', 'placeholder' => 'Ref. No', 'tabindex' => '1']) !!}
        </div>
    </div>
    <div class="form-group">
        {!!  Form::label('client_id','Company Name',['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-9">
            {!!  Form::select('client_id', $clients, isset($billing->client_id) ?
                $billing->client_id : '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Select One', 'tabindex' => '2'] )  !!}
        </div>
    </div>
    <div class="form-group">
        {!!  Form::label('issue_date','Issue Date',['class' => 'col-md-3 control-label'])  !!}
        <div class="col-md-3">
            {!!  Form::input('text','issue_date',isset($billing->issue_date) ? date("d-m-Y",strtotime
            ($billing->issue_date)) : '', ['class' => 'form-control form-control-inline input-medium date-picker', 'placeholder' => 'Issue Date', 'tabindex' => '3', 'data-inputmask' => "'alias': 'dd-mm-yyyy'", 'data-mask' => 'true'])  !!}
        </div>
    </div>
    @if($data['billing_type'] == 'invoice')
        <div class="form-group">
            {!!  Form::label('due_date','Due Date',['class' => 'col-md-3 control-label'])  !!}
            <div class="col-md-3">
                {!!  Form::input('text','due_date',isset($billing->due_date) ? date("d-m-Y",strtotime
                ($billing->due_date)) : '', ['class' => 'form-control form-control-inline input-medium date-picker', 'placeholder' => 'Enter Due Date', 'tabindex' => '4', 'data-inputmask' => "'alias': 'dd-mm-yyyy'", 'data-mask' => 'true'])  !!}
            </div>
        </div>
    @else
        <div class="form-group">
            {!!  Form::label('valid_date','Valid Date',['class' => 'col-md-3 control-label'])  !!}
            <div class="col-md-3">
                {!!  Form::input('text','valid_date',isset($billing->valid_date) ? date("d-m-Y",strtotime
                ($billing->valid_date)) : '', ['class' => 'form-control form-control-inline input-medium date-picker', 'placeholder' => 'Enter Valid Date', 'tabindex' => '5', 'data-inputmask' => "'alias': 'dd-mm-yyyy'", 'data-mask' => 'true'])  !!}
            </div>
        </div>
    @endif
    <div class="form-group">
        {!!  Form::label('currency','Currency',['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-9">
            {!!  Form::input('text','currency',isset($billing->currency) ? $billing->currency :
            $site_settings->default_currency,['class' => 'form-control', 'placeholder' => 'Enter Currency', 'tabindex' => '6'])  !!}
        </div>
    </div>
    <div class="form-group">
        {!!  Form::label('tax','Tax',['class' => 'col-md-3 control-label'])  !!}
        <div class="col-md-9">
            {!!  Form::input('text','tax',isset($billing->tax) ? round($billing->tax,2) :  round
            ($site_settings->default_tax,2) ,['class' => 'form-control', 'placeholder' => 'Enter Tax', 'tabindex' => '7'])  !!}
        </div>
    </div>
    <div class="form-group">
        {!!  Form::label('discount','Discount',['class' => 'col-md-3 control-label'])  !!}
        <div class="col-md-9">
            {!!  Form::input('text','discount',isset($billing->discount) ? round($billing->discount,2) : round
            ($site_settings->default_discount,2) ,['class' => 'form-control', 'placeholder' => 'Enter Discount', 'tabindex' => '8'])  !!}
        </div>
    </div>
    <div class="form-group">
        {!!  Form::label('notes','Note',['class' => 'col-md-3 control-label'])  !!}
        <div class="col-md-9">
            {!! Form::textarea('notes',isset($billing->notes) ? \App\Helpers\Helper::br2nl($billing->notes) : '',['size' =>
            '30x3', 'class' => 'form-control', 'placeholder' => 'Enter Notes', 'tabindex' => '9'])  !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!!  Form::hidden('billing_type',$data['billing_type'])  !!}
            {!!  Form::submit(isset($buttonText) ? $buttonText : 'Save',['class' => 'btn btn-edit',
            'tabindex'
            => '10'])  !!}
        </div>
    </div>
</div>