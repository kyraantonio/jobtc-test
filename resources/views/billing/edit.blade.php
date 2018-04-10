<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Edit {{ studly_case($data['billing_type']) }}</h4>
</div>
<div class="modal-body">
    {!!  Form::model($billing,['method' => 'PATCH','route' => ['billing.update',$billing->billing_id] ,'class' =>
    'form-horizontal billing-form'])  !!}
    @include('billing/partials/_form', ['buttonText' => 'Update'] )
    {!!  Form::close()  !!}
</div>