<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Edit Bug</h4>
</div>
<div class="modal-body">
    @role('admin')
        {!!  Form::model($bugs,['method' => 'PATCH','route' => ['bug.update',$bugs->bug_id] ,'class' =>
        'form-horizontal bug-form'])  !!}
        @include('bug/partials/_form', ['buttonText' => 'Update Bug'] )
        {!!  Form::close()  !!}
    @else
        <div class='alert alert-danger alert-dismissable'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>
            <strong>You dont have to perform this action!!</strong>
        </div>
    @endrole
</div>
<script>
    $(function () {
        Validate.init();
    });
</script>