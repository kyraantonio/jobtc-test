<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                <div class="panel-group" id="accordion_" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-container">
                            <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-target="#task-details" data-parent="#accordion_" aria-expanded="true">
                                <h4 class="panel-title">
                                    <i class="glyphicon glyphicon-education"></i> Personal Test
                                </h4>
                            </div>
                            <div id="task-details" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <div class="panel-group test-group" data-type="1" id="accordion" role="tablist" aria-multiselectable="true">
                                            @if(count($test) > 0)
                                                @foreach($test as $val)
                                                <div id="collapse-container-{{ $val->id }}" data-id="{{ $val->id }}" data-version="{{ $val->version_id }}" data-parent="{{ $val->parent_test_id }}" data-order="{{ $val->order }}" class="panel test-list-1 task-list">
                                                    <div class="panel-heading task-header" data-toggle="tooltip" data-placement="top" title="Author: {{ $val->name }}" data-target="#collapse-1-{{ $val->version_id }}" role="tab" id="headingOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <div class="row">
                                                            <div class="col-xs-5">
                                                                <h4 class="panel-title task-list-header">
                                                                    <i class="glyphicon glyphicon-education"></i>
                                                                    {{ substr($val->title, 0, 25) . (strlen($val->title) > 25 ? '...' : '') }}
                                                                    <span class="test-version-area hidden">&nbsp;v<span class="test-version">{{ $val->version }}</span></span>
                                                                </h4>
                                                            </div>
                                                            <div class="col-xs-7">
                                                                <div class="btn-group pull-right">
                                                                    <strong>Questions:</strong> {{ count($val->question) }}&nbsp;&nbsp;&nbsp;
                                                                    <strong>Time:</strong> {{ date('i:s', $val->total_time) }}&nbsp;&nbsp;&nbsp;
                                                                    <a class="tc-icons" href="{{ url('quiz/' . $val->id . '?p=review' . ($company_id ? '&company_id=' . $company_id : '')) }}">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                    <a class="trigger-links tc-icons" data-title="Result" data-method="" href="{{ url('quizRanking/' . $val->id) }}">
                                                                        <i class="fa fa-signal" aria-hidden="true"></i>
                                                                    </a>
                                                                    @if(in_array('drag.tests', $test_permissions))
                                                                    <a href="#" class="drag-test move-test tc-icons">
                                                                        <i class="fa fa-arrows" aria-hidden="true"></i>
                                                                    </a>
                                                                    @endif
                                                                    <a href="#" id="{{ $val->id }}" class="test-delete-btn tc-icons hidden">
                                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="collapse-1-{{ $val->version_id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                        <div class="panel-body">
                                                            <div class="panel-content">
                                                                <ul class="list-group question-group">
                                                                    @if(count($val->question) > 0)
                                                                    @foreach($val->question as $q)
                                                                    <li id="question-{{ $q->id }}" data-id="{{ $q->id }}" class="list-group-item task-list-item question-list">
                                                                        <div class="row task-list-details">
                                                                            <div class="col-md-8">
                                                                                <a href="#question-collapse-1-{{ $val->version . '-' . $q->id }}" class="question-header checklist-header" style="font-size: 22px;">
                                                                                    <?php
                                                                                    $q->question = preg_replace("/<\/*[A-Za-z0-9\s\",'.=;:-]*>/i", "", html_entity_decode($q->question));
                                                                                    ?>
                                                                                    {{ substr($q->question, 0, 50) . (strlen($q->question) > 50 ? '...' : '') }}
                                                                                </a>
                                                                            </div>
                                                                            <div class="col-md-3" style="white-space: nowrap;font-size: 22px;">
                                                                                <div class="pull-right">
                                                                                    <strong>Time:</strong> {{ date('i:s', strtotime($q->length)) }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="pull-right">
                                                                                @if(in_array('drag.question', $test_permissions))
                                                                                <a href="#" class="drag-question icon icon-btn move-tasklist tc-icons">
                                                                                    <i class="fa fa-arrows"></i>
                                                                                </a>
                                                                                @endif
                                                                                <a href="#" id="{{ $q->id }}" class="icon icon-btn delete-question-btn tc-icons hidden">
                                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div id="question-collapse-1-{{ $val->version . '-' . $q->id }}" class="question-collapse collapse">
                                                                                <div class="checklist-item">
                                                                                    <span style="font-size: 22px;">{!! $q->question !!}</span>
                                                                                    {!! $q->question_photo ?
                                                                                        '<div class="form-group">' .
                                                                                        HTML::image('/assets/img/question/' . $q->question_photo, '') .
                                                                                        '</div>' :
                                                                                        ''
                                                                                    !!}
                                                                                    <div class="form-group">
                                                                                        <ul class="list-group">
                                                                                        @if($q->question_type_id == 1)
                                                                                            @foreach($q->question_choices as $k=>$c)
                                                                                                <li class="list-group-item">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-11" style="font-size: 22px;">
                                                                                                            {{ $c }}
                                                                                                        </div>
                                                                                                        <div class="col-md-1 text-center">
                                                                                                            <input type="radio" class="q-form radio" id="radio-view-{{ $q->id }}" name="q[{{ $q->id }}]" {{ $k == $q->question_answer ? 'checked' : '' }} />
                                                                                                            <label for="radio-view-{{ $k }}">&nbsp;</label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </li>
                                                                                            @endforeach
                                                                                        @elseif($q->question_type_id == 2)
                                                                                        <li class="list-group-item" style="font-size: 22px;">
                                                                                            {{ $q->question_answer }}
                                                                                        </li>
                                                                                        @endif
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="question-btn-area pull-right{{ $val->user_id == Auth::user('user')->user_id ? '' : ' hidden' }}" style="padding-right: 10px;">
                                                                                    @if(in_array('delete.questions', $test_permissions))
                                                                                    <a href="#" id="{{ $q->id }}" class="delete-question-btn btn-delete btn-shadow btn" style="font-size: 18px!important;">
                                                                                        <i class="fa fa-times" aria-hidden="true"></i> Question
                                                                                    </a>&nbsp;&nbsp;&nbsp;
                                                                                    @endif
                                                                                    @if(in_array('edit.questions', $test_permissions))
                                                                                    <a href="{{ url('quiz/' . $q->id .'/edit?p=question' . ($company_id ? '&company_id=' . $company_id : '')) }}" data-method="GET" data-title="Edit Question" class="btn btn-edit btn-shadow trigger-links">
                                                                                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                                                                    </a>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    @endforeach
                                                                    @else
                                                                    <li class="list-group-item">
                                                                        No data was found.
                                                                    </li>
                                                                    @endif
                                                                </ul>
    
                                                                <div class="test-btn-area {{ $val->user_id == Auth::user('user')->user_id ? '' : ' hidden' }}">
                                                                    @if(in_array('create.questions', $test_permissions))
                                                                    <a class="btn btn-submit btn-shadow btn-sm check-list-btn trigger-links" href="{{ url('quiz/create?p=question&id=' . $val->id . ($company_id ? '&company_id=' . $company_id : '')) }}" data-method="GET" data-title="Add Question" style="font-size: 18px!important;">
                                                                        <i class="glyphicon glyphicon-plus"></i> Question
                                                                    </a>&nbsp;&nbsp;&nbsp;
                                                                    <a class="btn btn-submit btn-shadow btn-sm trigger-add-btn trigger-links" href="{{ url('quiz/create?p=question&id=' . $val->id . '&trigger=1' . ($company_id ? '&company_id=' . $company_id : '')) }}" data-method="GET" data-title="Add Question" style="font-size: 18px!important;">
                                                                        <i class="glyphicon glyphicon-plus"></i> Questions
                                                                    </a>&nbsp;&nbsp;&nbsp;
                                                                    @endif
                                                                    <a href="{{ url('quiz/' . $val->id . ($val->review_only ? '?p=review' : '') . ($company_id ? ($val->review_only ? '&' : '?') . 'company_id=' . $company_id : '')) }}" class="btn btn-assign btn-shadow">
                                                                        <i class="fa fa-eye"></i> Preview
                                                                    </a>&nbsp;&nbsp;&nbsp;
                                                                    @if(in_array('delete.tests', $test_permissions))
                                                                    <a href="#" data-type="1" id="{{ $val->version_id }}" class="test-delete-btn btn-delete btn-shadow btn" style="font-size: 18px!important;">
                                                                        <i class="fa fa-times" aria-hidden="true"></i> Test
                                                                    </a>&nbsp;&nbsp;&nbsp;
                                                                    @endif
                                                                    @if(in_array('edit.tests', $test_permissions))
                                                                    <a href="{{ url('quiz/' . $val->id .'/edit?p=test' . ($company_id ? '&company_id=' . $company_id : '')) }}" data-method="GET" data-title="Edit Test" class="trigger-links btn btn-edit btn-shadow">
                                                                        <i class="fa fa-pencil"></i> Edit
                                                                    </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if(in_array('create.tests', $test_permissions))
                    <a class="btn btn-shadow btn-default trigger-links" href="{{ url('quiz/create?p=test' . ($company_id ? '&company_id=' . $company_id : '')) }}" data-method="GET" data-title="Add Test">
                        <i class="fa fa-plus"></i>
                        <strong>New Test</strong>
                    </a>
                    @endif
                    <div class="pull-right">
                        <input type="text" name="community_search" class="community-search form-control" />
                        <span style="color: #f00;font-size: 12px;">NOTE: press ENTER to start search</span>
                    </div>
                </div>
                <div class="panel-group" id="accordion_" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-container">
                            <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-target="#task-details" data-parent="#accordion_" aria-expanded="true">
                                <h4 class="panel-title">
                                    <i class="glyphicon glyphicon-education"></i> Community Test
                                </h4>
                            </div>
                            <div id="task-details" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <div class="panel-content">
                                        <div class="panel-group test-group" data-type="2" role="tablist" aria-multiselectable="true">
                                            @include('quiz.community')
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <ul class="pagination community-pagination hidden"></ul>
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