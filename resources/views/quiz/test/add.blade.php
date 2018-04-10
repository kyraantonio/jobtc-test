{!! Form::open(array('files' => true, 'url' => 'quiz?p=test' . ($company_id ? '&company_id=' . $company_id : ''), 'method' => 'POST')) !!}
<div class="form-group">
    <div class="row">
        <label class="col-sm-3 text-right">Test Title</label>
        <div class="col-md-9">
            <input type="text" name="title" class="form-control" />
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-3 text-right">Description</label>
        <div class="col-md-9">
            <textarea name="description" class="form-control"></textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-3 text-right">Test Introduction</label>
        <div class="col-md-9">
            <textarea name="start_message" class="form-control"></textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-3 text-right">Completion Message</label>
        <div class="col-md-9">
            <textarea name="completion_message" class="form-control"></textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-3 text-right">Completion Image</label>
        <div class="col-md-3">
            <input type="file" name="completion_image_upload" class="form-control" accept="image/*" />
        </div>
        <div class="col-md-6">
            <select name="completion_image" class="select-picker form-control" data-live-search="true" title="Choose from Image Files">
                <option></option>
                @if(count($image_files) > 0)
                @foreach($image_files as $v)
                    <option>{{ basename($v) }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-3 text-right">Completion Sound</label>
        <div class="col-md-3">
            <input type="file" name="completion_sound_upload" class="form-control" accept="audio/*" />
        </div>
        <div class="col-md-6">
            <select name="completion_sound" class="select-picker form-control" data-live-search="true" title="Choose from Sound Files">
                <option></option>
                @if(count($sound_files) > 0)
                @foreach($sound_files as $v)
                    <option>{{ basename($v) }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row hidden">
        <label class="col-sm-3 text-right">Test Photo</label>
        <div class="col-md-9">
            <input type="file" name="test_photo" class="form-control" />
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-3 text-right">Default Question Time</label>
        <div class="col-md-3">
            <input type="text" name="default_time" class="time-form form-control" style="width: 100px;" />
        </div>
        <label class="col-sm-3 text-right">Default Points:</label>
        <div class="col-md-3">
            <input type="number" name="default_points" value="1" class="form-control" style="width: 100px;" />
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-3 text-right">Default Question Type:</label>
        <div class="col-md-9">
            <?php
            echo Form::select(
                'default_question_type_id',
                $question_type, '',
                array('class' => 'q-form question-type-dp form-control')
            );
            ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-3 text-right">Default Score Tag</label>
        <div class="col-md-9">
            <input type="text" name="default_tags" class="tag-input form-control" data-role="tagsinput" style="width: 100%;" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-right">
        <input type="submit" name="submit" class="btn btn-submit btn-shadow" value="Save" />
        <input type="button" name="cancel" class="btn btn-delete btn-shadow" value="Cancel" data-dismiss="modal" />
    </div>
</div>
{!! Form::close() !!}

<script>
    $(function(e){
        $('.time-form').inputmask("59:59", {
            placeholder: '0',
            definitions: {
                '5': {
                    validator: "[0-5]",
                    cardinality: 1
                }
            }
        });

        //region Bootstrap Select
        $('.select-picker').selectpicker();
        //endregion

        //region Tags
        var tag_input = $('.tag-input');
        tag_input.tagsinput({
            maxTags: 1,
            cancelConfirmKeysOnEmpty: false, //prevent enter to submit form
            tagClass: function(item) {
                return 'label label-success'
            }
        });
        //endregion
    });
</script>