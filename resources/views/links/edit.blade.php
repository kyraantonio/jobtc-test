<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Edit Link</h4>
</div>
<div class="modal-body">
    {!! Form::model($link,['method' => 'PATCH','route' => ['links.update',$link->id] ,'class' =>
    'form-horizontal link-form'])  !!}
    @include('links/partials/_form', ['buttonText' => 'Update Links','buttonClass' => 'update-link-btn'] )
    {!!  Form::close()  !!}
</div>
<script>
    $(function () {
//        Validate.init();
    });
</script>