@foreach($tests as $test)
<div class="slider-container">
    <div class="slider-div text-center active">
        <div class="slider-body">
            <button type="button" class="btn btn-submit btn-shadow btn-next">Start Review</button>
        </div>
    </div>
    @foreach($questions as $question)
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
            @endif

            <div class="form-group">
                <label>Your Answer</label>
                <div>
                    <?php
                    if (array_key_exists($question->id, $review_result)) {
                        $this_result = $review_result[$question->id];
                        echo $this_result->answer ?
                                (
                                $question->question_type_id == 1 ?
                                        (
                                        array_key_exists($this_result->answer, $question->question_choices) ?
                                                $question->question_choices[$this_result->answer] :
                                                '<span style="color: #f00;">Answer not found on choices!</span>'
                                        ) :
                                        $this_result->answer
                                ) :
                                '<span style="color: #f00;">No Answer!</span>';
                        if ($question->question_type_id != 3) {
                            echo
                            '<span style="color: #' .
                            ($this_result->result ? '59ae59' : 'f00') .
                            ';"> <em>(' .
                            ($this_result->result ? 'Correct' : 'Wrong') .
                            ')</em></span>';
                        }
                    } else {
                        echo '<span style="color: #f00;">Answer not found on choices!</span>';
                    }
                    ?>
                </div>
            </div>

            @if($question->question_type_id != 3)
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
            @endif

            <div class="text-center">
                <div>
                    <button type="button" class="btn btn-shadow btn-delete btn-prev">Previous</button>
                    <button type="button" class="btn btn-shadow btn-submit btn-next">Next</button>
                    <button type="button" class="btn btn-shadow btn-timer time-limit hidden" data-length="{{ $question->length ? $question->length : '' }}">
                        <span class="timer-area">{{ $question->length ? date('i:s', strtotime($question->length)) : '' }}</span>
                        <span class="glyphicon glyphicon-time"></span>
                    </button>
                    @if($question->question_type_id == 3)
                    <div class="pull-right" style="padding-left: 5px;">
                        <div class="input-group">
                            <input type="number" max="{{ $question->max_point }}" class="form-control" style="width: 70px;">
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
            <audio class="player" src="{{ url('/assets/shared-files/sound/' . $test->completion_sound) }}"></audio>
            @endif
            @endif
            <br />
            <button type="button" class="btn btn-shadow btn-delete btn-prev">Back</button>
            <button type="button" class="btn btn-shadow btn-finish hidden">Complete</button>
        </div>
    </div>
</div>
@endforeach
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

@section('js_footer')
@parent
<script>
    $(function (e) {
        var slider_div = $('.slider-div');
        var btn_next = $('.btn-next');
        var btn_prev = $('.btn-prev');

        slider_div.on('click','.btn-next',function (e) {
            $(this)
                    .closest('.slider-div')
                    .removeClass('active')
                    .next('.slider-div')
                    .addClass('active');

            var player = $(this)
                    .closest('.slider-div')
                    .next('.slider-div')
                    .find('.player');
            if (player.length != 0) {
                var audio = player.get(0);
                audio.play();
            }
        });
        slider_div.on('click','.btn-prev',function (e) {
            $(this)
                    .closest('.slider-div')
                    .removeClass('active')
                    .prev('.slider-div')
                    .addClass('active');
        });
    });
</script>
@stop
