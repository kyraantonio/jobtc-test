<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Edit Client</h4>
</div>
<div class="modal-body">
    {!!  Form::model($client,['method' => 'PATCH','route' => ['client.update',$client->client_id] ,'class' =>
    'form-horizontal client-form'])  !!}
    @include('client/partials/_form', ['buttonText' => 'Update Client'] )
    {!! Form::close()  !!}
</div>
<script>
    $(function () {
        Validate.init();
    });
</script>