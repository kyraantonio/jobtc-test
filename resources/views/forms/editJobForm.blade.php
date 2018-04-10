<form actions="" method="POST" class="edit-job-form form-horizontal" role="form" novalidate="novalidate">
    {!! csrf_field() !!}
    <div class="form-group">
        <div class="col-md-12">
            <input class="form-control title" name="title" type="text" placeholder="Title" value="{{$job->title}}" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <textarea id="edit-description" class="form-control description" name="description">{{$job->description}}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            @if(isset($job->photo))
            <img class="profile-pic" src="{{url($job->photo)}}"/>
            @endif
            <div class="fileUpload btn btn-edit btn-shadow btn-sm">
                <span>Upload Logo</span>
                <input class="upload" name="photo" type="file" value="" />
            </div>
        </div>
    </div>
</form>
<script>
    var editor = CKEDITOR.replace('edit-description', {
        startupFocus: true
    });
    
    editor.on('change', function (evt) {
        $('#edit-description').text(evt.editor.getData());
    });
</script>