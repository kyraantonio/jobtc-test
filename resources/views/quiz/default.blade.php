@extends('layouts.default')

@section('content')
@parent
<div class="modal fade test-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
@include('quiz.' . $page)
<style>
    .pagination{
        margin: 0;
    }
    .test-group{
        min-height: 50px;
    }
    .test-modal textarea:not(.active){
        height: 39px!important;
        transition: height 0.25s ease-in;
    }
    .test-modal textarea.active{
        height: 200px!important;
        transition: height 0.25s ease-in;
    }
    .time-form, .points-form{
        font-size: 22px!important;
        font-weight: bold;
    }
    .note-editable{
        height: 100px;
    }

    .bootstrap-tagsinput{
        width: 100%;
        height: 39px;
        font-size: 18px;
        box-shadow: inset 1px 1px 6px rgba(0, 0, 0, 0.4)!important;
        border-radius: 0!important;
        padding: 6px 12px;
        line-height: 1.42857143;
    }
    .bootstrap-tagsinput input{
        box-shadow: none!important;
    }
</style>
@stop

@section('js_footer')
@parent
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.7.3/summernote.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.7.3/summernote.min.js"></script>

<script>
    $(function(e){
        var company_id = '{{ $company_id }}';

        //region Test Community Pagination
        var testPaginationInit, testPaginationExec;
        testPaginationInit = function(){
            var test_community = $('.test-group[data-type=2] .task-list');
            var test_pagination = $('.community-pagination');
            var test_limit = {{ $test_limit }};
            var test_pages = test_community.length > 0 ? Math.ceil(test_community.length/test_limit) : 1;

            //start on page load
            testPaginationExec({
                element: test_community,
                test_limit: test_limit
            });

            test_pagination.html('');
            if(test_pages > 1){
                test_pagination.removeClass('hidden');
                for(var i = 0;i < test_pages; i ++){
                    var page_txt =
                        '<li' + (i == 0 ? ' class="active"' : '') + '>' +
                            '<a href="#" class="test-page-link" data-page="' + i + '">' + (i+1) + '</a>' +
                        '</li>';
                    test_pagination.append(page_txt);
                }
            }
            else{
                test_pagination.addClass('hidden');
            }
        };
        testPaginationExec = function(option){
            var defaults = {
                element: $('.test-group[data-type=2] .task-list'),
                page: 0,
                test_limit: 6
            };
            var options = $.extend({}, defaults, option);

            var pageStart = (options.page * options.test_limit)  + 1;
            var pageEnd = (options.page + 1) * 6;
            var counter = 1;
            var el = options.element;
            el.each(function(e){
                if(counter >= pageStart && counter <= pageEnd){
                    $(this).removeClass('hidden');
                }
                else{
                    $(this).addClass('hidden');
                }
                counter ++;
            });
        };

        testPaginationInit();
        $(document).on('click', '.test-page-link', function(e){
            e.preventDefault();

            testPaginationExec({
                page: $(this).data('page')
            });

            $('.test-page-link').parent('li').removeClass('active');
            $(this).parent('li').addClass('active');
        });
        $(document).on('propertychange keyup input paste', '.community-search', function(e){
            var search = $(this).val();
            if(e.keyCode == 13){
                $.ajax({
                    url: '{{ URL::to('quizSearch') }}',
                    method: "POST",
                    data: {
                        company_id: company_id,
                        search: search
                    },
                    success: function(content) {
                        $('.test-list-2').remove();

                        $('.test-group[data-type=2]').html(content);

                        testPaginationInit();
                    }
                });
            }
        });
        //endregion

        var testModal = $('.test-modal');

        $(document).on('click', '.trigger-links', function(e){
            e.preventDefault();

            var link = e.currentTarget.href;
            var title = $(this).data('title');
            var method = $(this).data('method');
            $.ajax({
                method: method ? method : 'get',
                url: link,
                success: function(data) {
                    testModal.find('.modal-title').html(title);
                    testModal.find('.modal-body').html(data);
                    testModal.modal('show');
                }
            });
        });

        @if($triggerTest)
        var $thisTest = $('.test-list-1[data-id="{!! $triggerTest !!}"]');
        $thisTest.find('.panel-heading').trigger('click');
        $thisTest.find('.trigger-add-btn').trigger('click');
        @endif

        //region Toggle Collapse
        $(document).on('click', '.task-header', function(e){
            var target = $(this).parent().find('.panel-collapse');
            target.collapse('toggle');
        });

        $(document).on('click', '.question-header', function(e){
            e.preventDefault();
            var target = $(this).closest('.question-list').find('.question-collapse');
            target.collapse('toggle');
        });
        //endregion

        //region Test Sort and Drag and Clone
        var t = $('.test-group');
        t.sortable({
            revert: "invalid",
            connectWith: ".test-group, .community-test-area",
            handle: '.drag-test',
            stop: function (event, ui) {
                var sourceEle = $(event.target);
                var destinationEle = $(ui.item).parent();
                var destinationAppend = $(ui.item).prev().length != 0 ?
                    $(ui.item).prev() :
                    ($(ui.item).next().length != 0 ?
                        $(ui.item).next() :
                        destinationEle
                    );
                if(destinationEle.data('type') != sourceEle.data('type')){
                    var thisItem;
                    var order = 1;

                    if($(ui.item).prev().length != 0){
                        thisItem = $(ui.item)
                            .clone(false, false)
                            .insertAfter(destinationAppend);
                        order = destinationAppend.data('order') + 1;
                    }
                    else{
                        if($(ui.item).next().length != 0){
                            thisItem = $(ui.item)
                                .clone(false, false)
                                .insertBefore(destinationAppend);
                            order = destinationAppend.data('order') + 1;
                        }
                        else{
                            thisItem = $(ui.item)
                                .clone(false, false)
                                .appendTo(destinationAppend);
                        }
                    }
                    t.sortable('cancel');
                    var url = public_path + 'quizAddPersonalCommunity';
                    $.post(
                        url,
                        {
                            id: $(ui.item).data('id'),
                            company_id: company_id,
                            order: order,
                            version: thisItem.find('.test-version').html(),
                            type: destinationEle.data('type'),
                            parent_test_id: thisItem.data('parent')
                        },
                        function(v){
                            var newTarget = 'collapse-' + destinationEle.data('type') + '-' + v.version_id;
                            thisItem
                                .attr('data-version', v.version_id)
                                .attr('data-order', v.order);

                            thisItem
                                .find('.panel-heading')
                                .attr('data-target', '#' + newTarget);
                            thisItem
                                .find('.panel-collapse')
                                .attr('id', newTarget);
                            thisItem
                                .find('.test-version')
                                .html(v.version);
                            thisItem
                                .find('.test-delete-btn')
                                .data('type', destinationEle.data('type'));
                            thisItem
                                .find('.test-delete-btn')
                                .attr('id', v.version_id);

                            if(destinationEle.data('type') == "2"){
                                testPaginationInit();
                                thisItem
                                    .find('.test-version-area')
                                    .removeClass('hidden');
                            }
                            else{
                                thisItem
                                    .find('.test-btn-area')
                                    .removeClass('hidden');
                                thisItem
                                    .find('.question-btn-area')
                                    .removeClass('hidden');
                                thisItem
                                    .find('.test-version-area')
                                    .addClass('hidden');
                            }

                            if(v.question.length != 0){
                                var q = v.question;
                                thisItem.find('.delete-question-btn').each(function(e){
                                    if(q[this.id] != undefined){
                                        $(this).attr('id', q[this.id]);
                                    }
                                });
                            }
                        }
                    );
                }
                else{
                    var sortId = [];
                    t.parent().find('.test-group[data-type='+ sourceEle.data('type') + '] .task-list').each(function(e){
                        sortId.push($(this).data('version'));
                    });

                    var url = public_path + 'testSort';
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: { id: sortId, type: sourceEle.data('type') },
                        success: function(doc) {

                        }
                    });
                }
            }
        });
        //endregion

        //region Test Delete
        $(document).on('click', '.test-delete-btn', function(e){
            var thisId = this.id;
            var testType = $(this).data('type');
            var thisTest = $(this).closest('.task-list');
            $.ajax({
                url: '{{ URL::to('quiz') }}/' + thisId + '?t=1&type=' + testType,
                method: "DELETE",
                success: function(doc) {
                    thisTest.remove();
                }
            });
        });
        //endregion

        //region Quest Sort
        var q = $('.question-group');
        q.sortable({
            revert: "invalid",
            connectWith: ".question-group",
            handle: '.drag-question',
            stop: function (event, ui) {
                var sortId = [];
                $(this).find('.question-list').each(function(e){
                    sortId.push($(this).data('id'));
                });

                var url = public_path + '/questionSort';
                $.post(url, { id: sortId });
            }
        });
        //endregion

        //region Question Highlight
        $('.question-collapse')
            .on('shown.bs.collapse', function (e) {
                $(this).closest('.question-list').addClass('is-task-item-selected');
            })
            .on('hidden.bs.collapse', function (e) {
                $(this).closest('.question-list').removeClass('is-task-item-selected');
            });
        //endregion

        //region Question Type
        $(document).on('change', '.question-type-dp', function(e){
            var showThisQArea = $(this).val();
            var qArea = $(this).closest('.modal-body');
            if($.inArray(showThisQArea, ["1", "2"]) == -1){
                qArea
                    .find('.question-answer-area[data-type!="' + showThisQArea + '"], .question-points-area[data-type!="' + showThisQArea + '"]')
                    .addClass('hidden');
                qArea
                    .find('.question-answer-area[data-type="' + showThisQArea + '"], .question-points-area[data-type="' + showThisQArea + '"]')
                    .removeClass('hidden')
                    .find('.q-form')
                    .removeAttr('disabled');
            }
            else{
                qArea
                    .find('.question-answer-area, .question-points-area')
                    .addClass('hidden')
                    .find('.q-form')
                    .attr('disabled', 'disabled');
                qArea
                    .find('.question-answer-area[data-type="' + showThisQArea + '"], .question-points-area[data-type=""]')
                    .removeClass('hidden')
                    .find('.q-form')
                    .removeAttr('disabled');
            }
        });
        //endregion

        //region Question Delete
        $(document).on('click', '.delete-question-btn', function(e){
            var thisId = this.id;
            var thisQuestion = $(this).closest('.question-list');
            $.ajax({
                url: '{{ URL::to('quiz') }}/' + thisId + '?t=2',
                method: "DELETE",
                success: function(doc) {
                    thisQuestion.remove();
                }
            });
        });
        //endregion

        //region Choices Events
        $(document).on('click', '.add-choice-btn', function(e){
            var qAHtml = testModal.find('.modal-body .question-answer').html();
            qAHtml = qAHtml.replace('checked', '');
            var thisChoice = '<div class="row question-answer">' + qAHtml + '</div>';
            $(this).parent().before(thisChoice);
            var question_answer = $(this).parent().prev('.question-answer');
            question_answer.find('.question_choices').val('');
            question_answer.find('.radio').removeAttr('checked');
        });
        $(document).on('click', '.remove-choice-btn', function(e){
            $(this).closest('.row').remove();
        });
        //endregion

        //region Textarea folder
        $(document).on('click', '.test-modal .form-control', function() {
            var t = $('.test-modal textarea');
            t.removeClass('active');
            if($(this).is('textarea')){
                $(this).addClass('active');
            }
        });
        //endregion

        //region Play Pause Audio
        $('.audio-btn').click(function() {
            var thisBtn = $(this);
            var audio = $(this).prev('.player');
            audio.on('ended', function() {
                thisBtn
                    .removeClass('fa-pause')
                    .addClass('fa-play');
            });

            audio = audio.get(0);
            if (audio.paused == false) {
                audio.pause();
                thisBtn
                    .removeClass('fa-pause')
                    .addClass('fa-play');
            }
            else {
                audio.play();
                thisBtn
                    .removeClass('fa-play')
                    .addClass('fa-pause');
            }
        });
        //endregion

        //region File Delete
        var delete_file_btn = $('.delete-file-btn');
        delete_file_btn.click(function(e){
            e.preventDefault();

            var thisId = this.id;
            var thisFile = $(this).closest('tr');
            var type = $(this).data('type');
            $.ajax({
                url: '{{ URL::to('quiz') }}/1?t=' + type + '&f=' + thisId,
                method: "DELETE",
                success: function(doc) {
                    thisFile.remove();
                }
            });
        });
        //endregion

        $(document).on('propertychange keyup input paste', 'input[type="number"]', function(e) {
            if($(this).has('max')){
                if($(this).val() > $(this).attr('max')){
                    $(this).val($(this).attr('max'));
                }
            }
            if($(this).val() < 0){
                $(this).val(0);
            }
        });
    });
</script>
@stop