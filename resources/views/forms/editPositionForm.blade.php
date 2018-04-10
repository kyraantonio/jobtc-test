<form actions="" method="POST" class="edit-position-form form-horizontal" role="form" novalidate="novalidate">
    {!! csrf_field() !!}
    <div class="form-group">
        <div class="col-md-12">
            <input class="form-control title" name="title" type="text" placeholder="Title" value="{{$position->name}}" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <textarea id="edit-description" class="form-control description" name="description">{{$position->description}}</textarea>
        </div>
    </div>
</form>
<!--Might be needed later-->
<!--script>
    var editor = CKEDITOR.replace('edit-description', {
        startupFocus: true
    });
    
    editor.on('change', function (evt) {
        $('#edit-description').text(evt.editor.getData());
    });
</script-->