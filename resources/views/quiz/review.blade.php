<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                <div class="panel-group test-group">
                    <div class="box box-default">
                        <div class="box-container">
                            <div class="box-header">
                                <h3 class="box-title">{{ $tests_info->title }}</h3>
                                <div class="pull-right" style="margin-right: 10px;">
                                    <a href="{{ url($company_id ? 'quizPerCompany/' . $company_id : 'quiz') }}" class="tc-icons">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="box-content">
                                    <div class="slider-container">
                                        <div class="slider-div text-center active">
                                            <div class="slider-body">
                                                <span style="font-size: 23px;">{!! $tests_info->start_message !!}</span>
                                                <br />
                                                <button type="button" class="btn btn-submit btn-shadow btn-next">Start Review</button>
                                            </div>
                                        </div>
                                        @foreach($questions_info as $ref=>$v)
                                        <div class="slider-div">
                                            <div class="slider-body">
                                                <div class="form-group text-center">
                                                    <span style="font-size: 23px;">{!! $v->question !!}</span>
                                                </div>
                                                {!! $v->question_photo ?
                                                    '<div class="form-group text-center">' .
                                                    HTML::image('/assets/img/question/' . $v->question_photo, '') .
                                                    '</div>' :
                                                    ''
                                                !!}
    
                                                @if($v->question_type_id == 4)
                                                <div class="form-group">
                                                    <label>Note:</label>
                                                    <div>
                                                        {!! $v->note ? $v->note : '<em style="color: #f00;">No note!</em>' !!}
                                                    </div>
                                                </div>
                                                @endif
    
                                                <div class="form-group">
                                                    <label>Explanation:</label>
                                                    <div>
                                                        {!! $v->explanation ? $v->explanation : '<em style="color: #f00;">No explanation!</em>' !!}
                                                    </div>
                                                </div>
                                                @if($v->question_type_id == 3)
                                                <div class="form-group">
                                                    <label>Marking Criteria:</label>
                                                    <div>
                                                        {!! $v->marking_criteria ? $v->marking_criteria : '<em style="color: #f00;">No criteria!</em>' !!}
                                                    </div>
                                                </div>
                                                @elseif($v->question_type_id == 4 && $v->record_id)
                                                <video id="quiz-video-play" controls="controls" preload="metadata" src="https://laravel.software/recordings/{{ $v->record_id }}.webm">
                                                    Your browser does not support the video tag.
                                                </video>
                                                @endif
    
                                                @if($v->question_type_id != 4)
                                                <div class="form-group">
                                                    <label>Your Answer</label>
                                                    <div>
                                                        {!!
                                                            $v->result_answer != '' ?
                                                                (
                                                                    $v->question_type_id == 1 ?
                                                                    (
                                                                        array_key_exists($v->result_answer, $v->question_choices) ?
                                                                        $v->question_choices[$v->result_answer] :
                                                                        '<span style="color: #f00;">Answer not found on choices!</span>'
                                                                    ) :
                                                                    $v->result_answer
                                                                ) :
                                                                '<span style="color: #f00;">No Answer!</span>'
                                                        !!}
                                                        @if($v->question_type_id != 3)
                                                            {!! '<span style="color: #' .
                                                                ($v->result ? '59ae59' : 'f00') .
                                                                ';"> <em>(' .
                                                                ($v->result ? 'Correct' : 'Wrong') .
                                                                ')</em></span>' !!}
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
    
                                                @if(!in_array($v->question_type_id, array(3, 4)))
                                                <div class="form-group">
                                                    <label>Correct Answer</label>
                                                    <div>
                                                        @if($v->question_type_id == 1)
                                                            {!! array_key_exists($v->question_answer, $v->question_choices) ?
                                                                $v->question_choices[$v->question_answer] :
                                                                '<span style="color: #f00;">Answer not found on choices!</span>'
                                                            !!}
                                                        @elseif($v->question_type_id == 2)
                                                            {{ $v->question_answer }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-inline">
                                                    <label>Points</label>&nbsp;{{ $v->result ?
                                                    ($v->question_type_id == 3 ? $v->result_points : $v->points) : 0
                                                     }}
                                                </div>
                                                @elseif(!Auth::check('user'))
                                                <div class="form-inline">
                                                    <label>Points</label>&nbsp;{{ $v->result ?
                                                        (in_array($v->question_type_id, array(3,4)) ? $v->result_points : $v->points) : 0
                                                     }}
                                                </div>
                                                @endif
    
                                                <div class="text-center">
                                                    <div>
                                                        <button type="button" class="btn btn-shadow btn-delete btn-prev" id="{{ $v->result_id }}">Previous</button>
                                                        <button type="button" class="btn btn-shadow btn-submit btn-next" id="{{ $v->result_id }}">Next</button>
                                                        @if(Auth::check('user') && in_array($v->question_type_id, array(3, 4)))
                                                        <div class="pull-right" style="padding-left: 5px;">
                                                            <div class="input-group">
                                                                <input type="number" name="points[{{ $v->result_id }}]" value="{{ $v->result_points }}" step="1" max="{{ $v->max_point }}" class="form-control" style="width: 70px;">
                                                                <div class="input-group-addon">/{{ $v->max_point }}</div>
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
                                                <span style="font-size: 23px;">{!! $tests_info->completion_message !!}</span>
                                                @if($tests_info->completion_image)
                                                    {!! HTML::image('/assets/shared-files/image/' . $tests_info->completion_image, '', array('style' => 'width: 100%;')) !!}
                                                @endif
                                                @if($tests_info->completion_sound)
                                                    @if(\App\Helpers\Helper::checkFileIsAudio($tests_info->completion_sound))
                                                        <audio class="player" src="{{ url() . '/assets/shared-files/sound/' . $tests_info->completion_sound }}"></audio>
                                                    @endif
                                                @endif
                                                <br />
                                                <button type="button" class="btn btn-shadow btn-delete btn-prev">Back</button>
                                                <button type="button" class="btn btn-shadow btn-finish hidden">Complete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('quiz.result')
            </div>
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

@section('js_footer')
@parent
<script>
    $(function(e){
        var slider_div = $('.slider-div');
        var btn_next = $('.btn-next');
        var btn_prev = $('.btn-prev');

        btn_next.click(function(e){
            $(this)
                .closest('.slider-div')
                .removeClass('active')
                .next('.slider-div')
                .addClass('active');

            var player = $(this)
                .closest('.slider-div')
                .next('.slider-div')
                .find('.player');
            if(player.length != 0){
                var audio = player.get(0);
                audio.play();
            }
        });
        btn_prev.click(function(e){
            $(this)
                .closest('.slider-div')
                .removeClass('active')
                .prev('.slider-div')
                .addClass('active');
        });
        $('.btn-next, .btn-prev').click(function(e){
            var thisId = this.id;
            if(thisId){
                var thisElement = $('input[name="points[' + thisId + ']"]');
                if(thisElement.length != 0){
                    var data = {
                        points: thisElement.val()
                    };

                    $.ajax({
                        url: '{{ URL::to('quiz') }}/' + thisId + '?p=exam',
                        data: data,
                        method: "PATCH",
                        success: function(doc) {
                            console.log(doc);
                        },
                        error: function(a, b, c){

                        }
                    });
                }
            }
        });
    });
</script>
@stop