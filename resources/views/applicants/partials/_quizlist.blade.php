@if(Auth::check('applicant'))
@foreach($tests as $test)
@if($tests_completed->contains('test_id',$test->id))
<div class="tests-container">
    <div class="box box-default">
        <div class="box-container">
            <div class="box-header" id="test-{{$test->id}}" data-toggle="collapse" data-target="#test-collapse-{{$test->id}}">
                <h3 class="box-title"><i class="fa fa-chevron-down" aria-hidden="true"></i>&nbsp;{{ $test->title }}</h3>
                <!--div class="btn pull-right">Score: {{$test->total_score}} / {{$test->total_points}}</div-->
            </div>
            <div class="box-body">
                <div id="test-collapse-{{$test->id}}" class="box-content collapse in">
                    <div class="slider-container">
                        <div class="slider-div text-center active">
                            <div class="slider-body">
                                {{-- @include('applicants.partials._quizreview') --}}
                                Completed
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="tests-container">
    <div class="box box-default">
        <div class="box-container">
            <div class="box-header" id="test-{{$test->id}}" data-toggle="collapse" data-target="#test-collapse-{{$test->id}}">
                <h3 class="box-title"><i class="fa fa-chevron-down" aria-hidden="true"></i>&nbsp;{{ $test->title }}</h3>
                <!--div class="btn pull-right">Score: {{$test->total_score}} / {{$test->total_points}}</div-->
            </div>
            <div class="box-body">
                <div id="test-collapse-{{$test->id}}" class="box-content collapse in">
                    <div class="slider-container">
                        <div class="slider-div text-center active">
                            <div class="slider-body">
                                <h3 style="font-size: 23px;">{!! $test->start_message !!}</h3>
                                <button class="btn btn-shadow btn-submit btn-next">Start</button>
                            </div>
                        </div>
                        @foreach($questions->where('test_id',$test->id) as $question)
                            <div class="slider-div">
                                <div class="slider-body">
                                    <div class="form-group">
                                        <h3>{!! $question->question !!}</h3>
                                    </div>
                                    {!! $question->question_photo ?
                                    '<div class="form-group">' .
                                        HTML::image('/assets/img/question/' . $question->question_photo, '') .
                                        '</div>' :
                                    ''
                                    !!}
                                    @if($question->question_type_id == 1)
                                        @foreach($question->question_choices as $key=>$value)
                                        <div class="answer-area form-group">
                                            <input type="radio" class="simple radio" name="answer[{{ $question->id }}]" id="radio-{{ $key }}-{{ $question->id }}" value="{{ $key }}" />
                                            <label for="radio-{{ $key }}-{{ $question->id }}">{{ $value }}</label>
                                        </div>
                                        @endforeach
                                    @elseif($question->question_type_id == 2)
                                    <div class="form-group">
                                        <input type="text" name="answer[{{ $question->id }}]" class="form-control" placeholder="answer here..." />
                                    </div>
                                    @elseif($question->question_type_id == 3)
                                        <div class="form-group">
                                            <textarea name="answer[{{ $question->id }}]" class="form-control written_editor" id="written_editor_{{ $question->id }}" rows="3" placeholder="answer here..."></textarea>
                                        </div>
                                    @elseif($question->question_type_id == 4)
                                        <div class="quiz-video" id="quiz-video-{{ $question->id }}"></div>
                                    @endif
                                    <div class="text-center">
                                        <button type="button" data-type="{{ $question->question_type_id }}" class="btn btn-shadow btn-submit btn-next{{ $question->question_type_id == 4 ? ' hidden' : '' }}" id="{{ $question->id }}">Next</button>
                                        <button class="btn btn-shadow btn-timer time-limit hidden" data-length="{{ $question->length ? $question->length : '' }}">
                                            <span class="timer-area">{{ $question->length ? date('i:s', strtotime($question->length)) : '' }}</span>
                                            <span class="glyphicon glyphicon-time"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="slider-div text-center">
                            <div class="slider-body">
                                <span style="font-size: 23px;">{!! $test->completion_message !!}</span>
                                @if($test->completion_image)
                                    {!! HTML::image('/assets/shared-files/image/' . $test->completion_image, '', array('style' => 'width: 100%;')) !!}
                                @endif
                                @if($test->completion_sound)
                                    @if(\App\Helpers\Helper::checkFileIsAudio($test->completion_sound))
                                        <audio class="player" src="{{ url() . '/assets/shared-files/sound/' . $test->completion_sound }}"></audio>
                                    @endif
                                @endif
                                <br />
                                <a class="btn btn-finish">Complete</a>
                                <input class="quiz_id" type="hidden" value="{{$test->id}}"/>
                                <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif <!--Check if test completed condition-->
@endforeach
@endif <!--Check if user is applicant-->
@if(Auth::check('user'))
@foreach($tests as $test)
@if($tests_completed->contains('test_id',$test->id))
<div class="tests-container">
    <div class="box box-default">
        <div class="box-container">
            <div class="box-header" id="test-{{$test->id}}" data-toggle="collapse" data-target="#test-collapse-{{$test->id}}">
                <h3 class="box-title"><i class="fa fa-chevron-down" aria-hidden="true"></i>&nbsp;{{ $test->title }}</h3>
                <div class="btn pull-right">Score: {{$test->total_score}} / {{$test->total_points}}</div>
            </div>
            <div class="box-body">
                <div id="test-collapse-{{$test->id}}" class="box-content collapse in">
                    <div class="slider-container">
                        <div class="slider-div text-center active">
                            <div class="slider-body">
                                @include('applicants.partials._quizreview')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="tests-container">
    <div class="box box-default">
        <div class="box-container">
            <div class="box-header" id="test-{{$test->id}}" data-toggle="collapse" data-target="#test-collapse-{{$test->id}}">
                <h3 class="box-title"><i class="fa fa-chevron-down" aria-hidden="true"></i>&nbsp;{{ $test->title }}</h3>
                <div class="btn pull-right">Score: {{$test->total_score}} / {{$test->total_points}}</div>
            </div>
            <div class="box-body">
                <div id="test-collapse-{{$test->id}}" class="box-content collapse in">
                    <div class="slider-container">
                        <div class="slider-div text-center active">
                            <div class="slider-body">
                    Applicant has not taken this test yet.
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif <!--Check if test is already completed by this applicant-->
@endforeach
@endif
@if(Auth::check('user'))
<div class="tests-container">
    <div class="box box-default">
        <div class="box-container">
            <div class="box-body">
                <div class="box-content text-right">
                    @foreach($tests_tags as $tag=>$score)
                    <div class="row">
                        <div class="col-md-8">
                            <label>{{ strtoupper($tag) }}</label>
                        </div>
                        <div class="col-md-1">
                            {{ $score }}
                        </div>
                        <div class="col-md-2">
                            <label>Adjusted</label>
                        </div>
                        <div class="col-md-1">
                            {{ array_key_exists($tag, $tests_adjust_tags) ? $tests_adjust_tags[$tag] : $score }}
                        </div>
                    </div>
                    @endforeach
                    <hr />
                    <div class="row">
                        <div class="col-md-8">
                            <label>Total</label>
                        </div>
                        <div class="col-md-1">
                            {{ $test_score_total }}
                        </div>
                        <div class="col-md-2">
                            <label>Adjusted</label>
                        </div>
                        <div class="col-md-1">
                            {{ array_sum($tests_adjust_tags) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif