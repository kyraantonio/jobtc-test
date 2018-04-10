<div class="slider-container">
    <div class="slider-div text-center active">
        <div class="slider-body">
            <button type="button" class="btn btn-submit btn-shadow btn-next">Start Review</button>
        </div>
    </div>
    @foreach($questions->where('test_id',$test->id) as $question)
        <div class="slider-div">
            <div class="slider-body">
                <div class="form-group text-center">
                    <span style="font-size: 23px;">{!! $question->question !!}</span>
                </div>
                {!! $question->question_photo ?
                '<div class="form-group text-center">' .
                    HTML::image('/assets/img/question/' . $question->question_photo, '', array('style' => 'width: 100%;')) .
                    '</div>' :
                ''
                !!}

                @if($question->question_type_id == 4)
                <div class="form-group">
                    <label>Note:</label>
                    <div>
                        {!! $question->note ? $question->note : '<em style="color: #f00;">No note!</em>' !!}
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <label>Explanation:</label>
                    <div>
                        {!! $question->explanation ? $question->explanation : '<em style="color: #f00;">No explanation!</em>' !!}
                    </div>
                </div>

                @if($question->question_type_id == 3)
                <div class="form-group">
                    <label>Marking Criteria:</label>
                    <div>
                        {!! $question->marking_criteria ? $question->marking_criteria : '<em style="color: #f00;">No criteria!</em>' !!}
                    </div>
                </div>
                @elseif($question->question_type_id == 4 && $question->record_id)
                <video id="quiz-video-play" controls="controls" preload="metadata" src="https://extremefreedom.org/recordings/{{ $question->record_id }}.webm">
                    Your browser does not support the video tag.
                </video>
                @endif

                @if($question->question_type_id != 4)
                <div class="form-group">
                    <label>Your Answer</label>
                    <div>
                        {!!
                            $question->result_answer != '' ?
                                (
                                    $question->question_type_id == 1 ?
                                    (
                                        array_key_exists($question->result_answer, $question->question_choices) ?
                                        $question->question_choices[$question->result_answer] :
                                        '<span style="color: #f00;">Answer not found on choices!</span>'
                                    ) :
                                    $question->result_answer
                                ) :
                                '<span style="color: #f00;">No Answer!</span>'
                        !!}
                        @if($question->question_type_id != 3)
                            {!! '<span style="color: #' .
                                ($question->result ? '59ae59' : 'f00') .
                                ';"> <em>(' .
                                ($question->result ? 'Correct' : 'Wrong') .
                                ')</em></span>' !!}
                        @endif
                    </div>
                </div>
                @endif

                @if(!in_array($question->question_type_id, array(3, 4)))
                <div class="form-group">
                    <label>Correct Answer</label>
                    <div>
                        @if($question->question_type_id == 1)
                        {!! array_key_exists($question->question_answer, $question->question_choices) ?
                        $question->question_choices[$question->question_answer] :
                        '<span style="color: #f00;">Answer not found on choices!</span>'
                        !!}
                        @elseif($question->question_type_id == 2)
                        {{ $question->question_answer }}
                        @endif
                    </div>
                </div>
                <div class="form-inline">
                    <label>Points</label>&nbsp;{{ $question->result ?
                    ($question->question_type_id == 3 ? $question->result_points : $question->points) : 0
                     }}
                </div>
                @elseif(!Auth::check('user'))
                <div class="form-inline">
                    <label>Points</label>&nbsp;{{ $question->result ?
                        (in_array($question->question_type_id, array(3,4)) ? $question->result_points : $question->points) : 0
                     }}
                </div>
                @endif

                <div class="text-center">
                    <div>
                        <button type="button" class="btn btn-shadow btn-delete btn-review-prev" id="{{ $question->result_id }}">Previous</button>
                        <button type="button" class="btn btn-shadow btn-submit btn-review-next" id="{{ $question->result_id }}">Next</button>
                        @if(Auth::check('user') && in_array($question->question_type_id, array(3, 4)))
                        <div class="pull-right" style="padding-left: 5px;">
                            <div class="input-group">
                                <input type="number" name="points[{{ $question->result_id }}]" value="{{ $question->result_points }}" step="1" max="{{ $question->max_point }}" class="form-control" style="width: 70px;">
                                <div class="input-group-addon">/{{ $question->max_point }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="slider-div text-center">
        <div class="slider-body">
            <span style="font-size: 23px;">{{ $test->completion_message }}</span>
            @if($test->completion_image)
            {!! HTML::image('/assets/shared-files/image/' . $test->completion_image, '', array('style' => 'width: 100%;')) !!}
            @endif
            @if($test->completion_sound)
            @if(\App\Helpers\Helper::checkFileIsAudio($test->completion_sound))
            <audio class="player" src="{{ url() . '/assets/shared-files/sound/' . $test->completion_sound }}"></audio>
            @endif
            @endif
            <br />
            <button type="button" class="btn btn-shadow btn-delete btn-review-prev">Back</button>
            <button type="button" class="btn btn-shadow btn-finish hidden">Complete</button>
        </div>
    </div>
</div>
<style>
    .slider-container{
        display: table;
        margin: 0 auto;
    }
    .slider-div{
        height: 300px;
        display: none;
    }
    .slider-div.active{
        display: table-row;
    }
    .slider-body{
        padding: 15px;
        vertical-align: middle;
        display: table-cell;
    }
    .answer-area{
        margin-left: 20px;
        font-size: 19px;
    }
</style>
