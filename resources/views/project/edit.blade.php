<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Edit Project</h4>
</div>
<div class="modal-body">
        {!! Form::model([$project,$clients,$users],['method' => 'PATCH','route' => ['project.update',$project->project_id],'id' => 'project-form','class' =>'form-horizontal project-form'])  !!}

        @include('project/partials/_form', ['buttonText' => 'Update Project'] )
        {!!  Form::close()  !!}
</div>
<script>
    $(function () {
        Validate.init();
    });
</script>