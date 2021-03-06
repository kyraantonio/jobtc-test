{!! Form::open(array('files' => true, 'url' => 'quiz/' . $questions_info->id . '?p=question' . ($company_id ? '&company_id=' . $company_id : ''), 'method' => 'PATCH')) !!}
<div class="row">
    <div class="col-md-6 form-group">
        <label class="col-sm-4 text-right">Question Type:</label>
        <div class="col-md-8">
            <?php
            echo Form::select(
                'question_type_id',
                $question_type, $questions_info->question_type_id,
                array('class' => 'q-form question-type-dp form-control')
            );
            ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-inline">
            <label>Time Limit:</label>
            <input type='text' name="length" style="width: 80px;" class="q-form time-form form-control" value="{{ $questions_info->length ? date('i:s', strtotime($questions_info->length)) : '' }}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-inline question-points-area<?php echo in_array($questions_info->question_type_id, array(1, 2)) ? '' : ' hidden'; ?>" data-type="">
            <label>Points:</label>
            <input type="text" name="points" style="width: 80px;" class="q-form points-form form-control" value="{{ $questions_info->points }}" />
        </div>
        <div class="form-inline question-points-area<?php echo $questions_info->question_type_id == 3 ? '' : ' hidden'; ?>" data-type="3" style="white-space: nowrap">
            <label>Maximum Score:</label>
            <input type="text" name="max_point" style="width: 70px;" class="q-form points-form form-control" value="{{ $questions_info->max_point }}" />
        </div>
        <div class="form-inline question-points-area<?php echo $questions_info->question_type_id == 4 ? '' : ' hidden'; ?>" data-type="4" style="white-space: nowrap">
            <label>Score:</label>
            <input type="text" name="max_point" style="width: 70px;" class="q-form points-form form-control" value="{{ $questions_info->max_point }}" />
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-2 text-right">Question:</label>
        <div class="col-md-10">
            <textarea name="question" class="q-form form-control summernote-editor">{{ $questions_info->question }}</textarea>
        </div>
    </div>
</div>
<div class="form-group question-answer-area<?php echo $questions_info->question_type_id == 4 ? '' : ' hidden'; ?>" data-type="4">
    <div class="row">
        <label class="col-sm-2 text-right">Note:</label>
        <div class="col-md-10">
            <textarea name="note" class="q-form form-control summernote-editor">{{ $questions_info->note }}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-2 text-right">Explanation:</label>
        <div class="col-md-10">
            <textarea name="explanation" class="q-form form-control summernote-editor">{{ $questions_info->explanation }}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-2 text-right">Question Image:</label>
        <div class="col-md-10">
            <div class="media">
                <div class="media-left">
                    {!! $questions_info->question_photo ?
                        HTML::image('/assets/img/question/' . $questions_info->question_photo, '', array('style' => 'width: 64px;max-width: 64px!important;')) :
                        ''
                    !!}
                </div>
                <div class="media-body">
                    <div class="col-md-9">
                        <div class="fileUpload btn btn-edit btn-shadow btn-sm">
                            <span>Choose Image</span>
                            <input class="upload form-control" name="question_photo" type="file" value="" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="pull-right">
                            <input name="clear_photo" type="checkbox" value="1" id="checkbox" class="checkbox" />
                            <label for="checkbox">Clear Photo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group question-answer-area<?php echo $questions_info->question_type_id == 1 ? '' : ' hidden'; ?>" data-type="1">
    <div class="row">
        <label class="col-sm-2 text-right">Question Answers:</label>
        <div class="col-md-10">
            <?php
            $choices = $questions_info->question_type_id == 1 ? json_decode($questions_info->question_choices) : array();
            ?>
            @if(count($choices) > 0)
                @foreach($choices as $k=>$c)
                <div class="row question-answer">
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" name="question_choices[]" class="question_choices q-form form-control" placeholder="Choices" value="{{ $c }}" />
                        </div>
                    </div>
                    <div class="col-md-1 text-center">
                        <input type="radio" class="q-form radio" id="radio-{{ $questions_info->id . $k }}" name="question_answer" value="{{ $k }}" {{ $k == $questions_info->question_answer ? 'checked' : '' }} />
                        <label for="radio-{{ $questions_info->id . $k }}"></label>
                    </div>
                    <div class="col-md-1 text-center">
                        <div class="form-group">
                            <a href="#" class="alert_delete remove-choice-btn" style="font-size: 25px">
                                <i class="fa fa fa-times" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                @for($i = 0; $i < 4; $i ++)
                <div class="row question-answer">
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" name="question_choices[]" class="question_choices q-form form-control" placeholder="Choices" />
                        </div>
                    </div>
                    <div class="col-md-1 text-center">
                        <input type="radio" class="q-form radio" id="radio-{{ $i }}" name="question_answer" value="{{ $i }}" {{ $i == 0 ? 'checked' : '' }} />
                        <label for="radio-{{ $i }}"></label>
                    </div>
                    <div class="col-md-1 text-center">
                        <div class="form-group">
                            <a href="#" class="alert_delete remove-choice-btn" style="font-size: 25px">
                                <i class="fa fa fa-times" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endfor
            @endif
            <div class="text-right" style="margin-top: 10px;">
                <input type="button" value="Add Choice" class="add-choice-btn btn btn-submit btn-shadow" />
            </div>
        </div>
    </div>
</div>
<div class="form-group question-answer-area<?php echo $questions_info->question_type_id == 2 ? '' : ' hidden'; ?>" data-type="2">
    <div class="row">
        <label class="col-sm-2 text-right">Question Answers:</label>
        <div class="col-md-10">
            <input type="text" name="question_answer" class="q-form form-control" <?php
                echo $questions_info->question_type_id == 1 ? 'disabled' : 'value="' . $questions_info->question_answer . '"';
                ?> />
        </div>
    </div>
</div>
<div class="form-group question-answer-area<?php echo $questions_info->question_type_id == 3 ? '' : ' hidden'; ?>" data-type="3">
    <div class="row">
        <label class="col-sm-2 text-right">Marking Criteria:</label>
        <div class="col-md-10">
            <textarea name="marking_criteria" class="q-form form-control summernote-editor" rows="3" <?php echo $questions_info->question_type_id == 3 ? '' : 'disabled'; ?>>{{ $questions_info->marking_criteria }}</textarea>
        </div>
    </div>
</div>

<div class="form-group question-answer-area<?php echo $questions_info->question_type_id == 4 ? '' : ' hidden'; ?>" data-type="4">
    <div class="row">
        <label class="col-sm-2 text-right">Score Tag</label>
        <div class="col-md-10">
            <input type="text" name="question_tags" value="{{ $questions_info->question_tags }}" class="q-form tag-input form-control" data-role="tagsinput" style="width: 100%;" <?php echo $questions_info->question_type_id == 4 ? '' : 'disabled'; ?>/>
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

        //region summer note
        var options = $.extend(true,
            {
                lang: '' ,
                codemirror: {
                    theme: 'monokai',
                    mode: 'text/html',
                    htmlMode: true,
                    lineWrapping: true
                }
            } ,
            {
                "toolbar": [
                    ["style", ["style"]],
                    ["font", ["bold", "underline", "italic", "clear"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["table", ["table"]],
                    ["insert", ["link", "picture", "video"]],
                    ["view", ["fullscreen", "codeview", "help"]]
                ]
            }
        );
        $("textarea.summernote-editor").summernote(options);
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