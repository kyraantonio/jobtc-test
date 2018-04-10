

//Click Toggle Function
$.fn.clickToggle = function (func1, func2) {
    var funcs = [func1, func2];
    this.data('toggleclicked', 0);
    this.click(function () {
        var data = $(this).data();
        var tc = data.toggleclicked;
        $.proxy(funcs[tc], this)();
        data.toggleclicked = (tc + 1) % 2;
    });
    return this;
};

function dateAdd(date, interval, units) {
    var ret = new Date(date); //don't change original date
    switch (interval.toLowerCase()) {
        case 'year'   :
            ret.setFullYear(ret.getFullYear() + units);
            break;
        case 'quarter':
            ret.setMonth(ret.getMonth() + 3 * units);
            break;
        case 'month'  :
            ret.setMonth(ret.getMonth() + units);
            break;
        case 'week'   :
            ret.setDate(ret.getDate() + 7 * units);
            break;
        case 'day'    :
            ret.setDate(ret.getDate() + units);
            break;
        case 'hour'   :
            ret.setTime(ret.getTime() + units * 3600000);
            break;
        case 'minute' :
            ret.setTime(ret.getTime() + units * 60000);
            break;
        case 'second' :
            ret.setTime(ret.getTime() + units * 1000);
            break;
        default       :
            ret = undefined;
            break;
    }
    return ret;
}

//region For Draggability
$('.link-group').sortable({
    handle: '.move-link',
    connectWith: ".link-group",
    placeholder: "ui-state-highlight",
    receive: function (event, ui) {
        var _link_items = ui.item.parents('.link-group').find('.list-group-item');
        var _task_id = ui.item.find('.task_list_id').val();
        var _company_id = ui.item.find('.company_id').val();
        var _data = [];
        $.each(_link_items, function (e) {
            var _str_id = this.id;
            var _id = _str_id.split('-');
            _data.push(_id);
        });
        var url = public_path + '/setLinkOrder/' + _task_id + '/' + _company_id;
        $.post(url, {links_order: _data}, function (res) {
            console.log(res);
        });
    },
    update: function (event, ui) {
        var _link_items = ui.item.parents('.link-group').find('.list-group-item');
        var _task_id = ui.item.find('.task_list_id').val();
        var _company_id = ui.item.find('.company_id').val();
        var _data = [];
        $.each(_link_items, function (e) {
            var _str_id = this.id;
            var _id = _str_id.split('-');
            _data.push(_id[1]);
        });

        var url = public_path + 'setLinkOrder/' + _task_id + '/' + _company_id;
        $.post(url, {links_order: _data}, function (res) {
            console.log(res);
        });
    }
});
$('.tasklist-group').sortable({
    dropOnEmpty: true,
    connectWith: ".tasklist-group",
    handle: '.drag-handle',
    placeholder: "ui-state-highlight",
    receive: function (event, ui) {
        //For receiving
        var itemText = ui.item.attr('id');

        var list_group_id = $(this).attr('id').split('_').pop();

        var task_list_id = $(this).find('.task_list_id').val();

        var task_list_item_id = ui.item.attr('id').split('_').pop();

        var data = $(this).sortable('serialize');
        //data.push({'name': '_token', 'value': _body.find('input[name="_token"]').val()})

        url = public_path + '/changeCheckList/' + list_group_id + '/' + task_list_item_id;

        //Remove warning that no data is found if dragged to an empty list
        $(this).find('li:contains("No data was found.")').remove();

        $.post(url, data);

    },
    update: function (event, ui) {

        //For Sorting within lists
        var list_group_id = $(this).attr('id').split('_').pop();

        var task_list_id = $(this).find('.task_list_id').val();

        var task_list_item_id = $(this).find('.task_list_item_id').val();

        var data = $(this).sortable('serialize');

        var url;

        url = public_path + '/sortCheckList/' + list_group_id;

        $.post(url, data);

    }
});
//endregion
var task_id = $('.briefcase_id').val();
var _body = $('body');
//var _body = $('#collapse-' + '{{ $task->task_id }}');
//var task_id = '{{ $task->task_id }}';
var alert_msg = function (msg, _class) {
    var alert = '<div class="alert ' + _class + ' alert-dismissable">';
    alert += '<i class="fa fa-check"></i>';
    alert += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>';
    alert += '<strong>' + msg + '</strong>';
    alert += '</div>';
    $('section.content').prepend(alert);
};

//region For Delete Hover
_body.find('.list-group .alert_delete').hover(function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var index = $(this).parent().parent().parent().index();
    var checklist_item_id = $(this).parent().parent().parent().parent().attr('id');
    //console.log(index);
    $('#' + checklist_item_id + ' .list-group-item:eq(' + index + ')').addClass('has-border');

}, function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var index = $(this).parent().parent().parent().index();
    var checklist_item_id = $(this).parent().parent().parent().parent().attr('id');
    //console.log(checklist_item_id);
    $('#' + checklist_item_id + ' .list-group-item:eq(' + index + ')').removeClass('has-border');
});

//endregion

var finish_checklist = function () {
    var count = 0;
    var over_all = 0;
    _body.find('.checklist-status').each(function () {
        over_all++;
        if ($(this).hasClass('bg-green')) {
            count++;
        }
    });
    var _percentage = (count / over_all) * 100;
    _body.find(".progress-in")
            .animate({
                width: _percentage.toFixed(0) + '%'
            }, 100);
    _body.find('.progress-val').html(_percentage.toFixed(0) + '%');
};

var update_checklist_status = function (id, status) {

    var data = [];
    data.push(
            {'name': '_token', 'value': _body.find('input[name="_token"]').val()},
    {'name': 'task_id', 'value': _body.find('input[name="task_id"]').val()},
    {'name': 'user_id', 'value': _body.find('input[name="user_id"]').val()},
    {'name': 'status', 'value': status}
    );

    $.post(public_path + 'updateCheckListStatus/' + id, data, function (e) {
    });

};

var update_checklist_data = function (id, header, details, checklist_header, checklist_item) {

    var data = [];
    data.push(
            {'name': '_token', 'value': _body.find('input[name="_token"]').val()},
    {'name': 'task_id', 'value': _body.find('.task_id').val()},
    {'name': 'user_id', 'value': _body.find('.user_id').val()},
    {'name': 'checklist_header', 'value': header},
    {'name': 'checklist', 'value': details}
    );

    $.post(public_path + 'updateCheckList/' + id, data, function (_data) {
        var _return_data = jQuery.parseJSON(_data);
        $('.text-area-content').remove();

        var header = '<i class="glyphicon glyphicon-list"></i>'+_return_data.checklist_header;
        var content = _return_data.checklist;


        checklist_header.removeAttr('style').html(header);
        checklist_item.removeAttr('style').html(content);

    });

};

function startTask(id) {

    var data = [];
    data.push({'name': 'task_checklist_id', 'value': id});
    $.post(public_path + 'startTask', data, function (timer_id) {
        $('#timer-' + id).parent().find('.timer_id').val(timer_id);
    });
}

function pauseTask(timer_id, task_checklist_id, time_paused) {
    var data = [];
    data.push({'name': 'timer_id', 'value': timer_id}, {'name': 'task_checklist_id', 'value': task_checklist_id}, {'name': 'time', 'value': time_paused});
    $.post(public_path + 'pauseTask', data, function (e) {
    });
}


function resumeTask(timer_id, task_checklist_id) {
    var data = [];
    data.push({'name': 'timer_id', 'value': timer_id});
    $.post(public_path + 'resumeTask', data, function (new_timer_id) {
        console.log('new_timer_id: ' + new_timer_id);
        $('#timer-' + task_checklist_id).siblings('.timer_id').val(new_timer_id);
    });
}

function endTask(timer_id, time_ended) {

    var data = [];
    data.push({'name': 'timer_id', 'value': timer_id}, {'name': 'time', 'value': time_ended});
    $.post(public_path + 'endTask', data, function (e) {
    });

}

function saveCurrentTime(timer_id, task_checklist_id, current_time) {
    var data = [];
    data.push({'name': 'timer_id', 'value': timer_id}, {'name': 'task_checklist_id', 'value': task_checklist_id}, {'name': 'time', 'value': current_time});
    $.post(public_path + 'saveCurrentTime', data, function (e) {
    });
}


function saveStillCounting() {
    $('.still-counting').each(function (index) {
        var timer_id = $(this).siblings('.timer_id').val();
        var task_checklist_id = $(this).siblings('.task_checklist_id').val();

        $('#timer-pause-' + task_checklist_id).text('Pause');
        var time_resume = $('#timer-options-' + task_checklist_id).find('.total_time').val();
        console.log('time_resume: ' + time_resume);

        var time_array = time_resume.split(":");

        var hours = '-' + time_array[0] + 'H';
        var minutes = '-' + time_array[1] + 'M';
        var seconds = '-' + time_array[2] + 'S';

        var since = hours + ' ' + minutes + ' ' + seconds;

        $('#timer-' + task_checklist_id).countdown({since: since, format: 'HMS', compact: true});
        $('#timer-' + task_checklist_id).countdown('resume');
    });
}

//on Page load, save and resume the timer that wasn't paused
saveStillCounting();

_body.on('click', '.start-timer', function () {
            var id = $(this).siblings('.task_checklist_id').val();
            startTask(id);
            console.log('Starting Task' + $('#timer-' + id).text());
            $(this).remove();
            if ($('#timer-' + id).text() === '') {
                $('.task-item-timer').countdown('pause');
                $('.task-item-timer').siblings('.pause-timer').text('Resume');
                $('.task-item-timer').siblings('.pause-timer').addClass('resume-timer');
                $('.task-item-timer').siblings('.pause-timer').removeClass('pause-timer');

                $('.still-counting').each(function (index) {
                    var timer_id = $(this).siblings('.timer_id').val();
                    var task_checklist_id = $(this).siblings('.task_checklist_id').val();

                    //var time_paused = $('#timer-' + task_checklist_id).find('.countdown-row').text();
                    var time_paused = $('.still-counting').text();
                    console.log('time_paused: ' + time_paused);

                    pauseTask(timer_id, task_checklist_id, time_paused);
                });

                $('.task-item-timer').removeClass('still-counting');

                var d = new Date();
                $('#timer-' + id).countdown({since: d, format: 'HMS', compact: true});
                $('#timer-' + id).parent().append('<button id="timer-pause-' + id + '" class="btn btn-primary pause-timer">Pause</button>');
                $('#timer-' + id).parent().append('<input class="task_checklist_id" type="hidden" value="' + id + '" />');
                $('#timer-' + id).parent().append('<input class="total_time" type="hidden" value="" />');
                $('#timer-' + id).parent().append('<input class="timer_status" type="hidden" value="Started" />');
                $('#timer-' + id).countdown('resume');
                $('#timer-' + id).addClass('still-counting');
            } else {

                $('.task-item-timer').countdown('pause');
                $('.task-item-timer').siblings('.pause-timer').text('Resume');
                $('.task-item-timer').siblings('.pause-timer').addClass('resume-timer');
                $('.task-item-timer').siblings('.pause-timer').removeClass('pause-timer');

                $('.still-counting').each(function (index) {
                    var timer_id = $(this).siblings('.timer_id').val();
                    var task_checklist_id = $(this).siblings('.task_checklist_id').val();

                    //var time_paused = $('#timer-' + task_checklist_id).find('.countdown-row').text();
                    var time_paused = $('.still-counting').text();
                    console.log('time_paused: ' + time_paused);

                    pauseTask(timer_id, task_checklist_id, time_paused);
                });

                $('.task-item-timer').removeClass('still-counting');

                $('#timer-pause-' + id).text('Pause');
                var time_resume = $('#timer-' + id).text();
                console.log('time_resume: ' + time_resume);
                var time_array = time_resume.split(":");

                var hours = '-' + time_array[0] + 'H';
                var minutes = '-' + time_array[1] + 'M';
                var seconds = '-' + time_array[2] + 'S';

                var since = hours + ' ' + minutes + ' ' + seconds;

                $('#timer-' + id).countdown({since: since, format: 'HMS', compact: true});
                $('#timer-' + id).parent().append('<button id="timer-pause-' + id + '" class="btn btn-primary pause-timer">Pause</button>');
                $('#timer-' + id).countdown('resume');
            }
        });

_body.on('click', '.pause-timer', function () {
    var timer_id = $(this).siblings('.timer_id').val();
    var task_checklist_id = $(this).siblings('.task_checklist_id').val();
    var time_paused = $('#timer-' + task_checklist_id).text();
    console.log('task_checklist_id: ' + task_checklist_id);
    console.log('time_paused: ' + time_paused);

    $('#timer-' + task_checklist_id).countdown('pause');
    $('#timer-pause-' + task_checklist_id).text('Resume');
    $('#timer-options-' + task_checklist_id).children('.timer_status').val('Paused');
    $('#timer-options-' + task_checklist_id).children('.total_time').val(time_paused);
    $('#timer-' + task_checklist_id).removeClass('still-counting');
    $('#timer-pause-' + task_checklist_id).switchClass('.pause-timer', 'resume-timer');
    pauseTask(timer_id, task_checklist_id, time_paused);
});

_body.on('click', '.resume-timer', function () {
    //$('.resume-timer').clickToggle(function () {

    var timer_id = $(this).siblings('.timer_id').val();
    var task_checklist_id = $(this).siblings('.task_checklist_id').val();

    $('#timer-pause-' + task_checklist_id).text('Pause');
    var time_resume = $('#timer-options-' + task_checklist_id).find('.total_time').val();

    var time_array = time_resume.split(":");

    var hours = '-' + time_array[0] + 'H';
    var minutes = '-' + time_array[1] + 'M';
    var seconds = '-' + time_array[2] + 'S';

    var since = hours + ' ' + minutes + ' ' + seconds;

    $('#timer-' + task_checklist_id).countdown({since: since, format: 'HMS', compact: true});

    $('.task-item-timer').countdown('pause');
    $('.task-item-timer').siblings('.pause-timer').text('Resume');
    $('.task-item-timer').siblings('.pause-timer').addClass('resume-timer');
    $('.task-item-timer').siblings('.pause-timer').removeClass('pause-timer');

    $('.still-counting').each(function (index) {
        var timer_id = $(this).siblings('.timer_id').val();
        var task_checklist_id = $(this).siblings('.task_checklist_id').val();

        var time_paused = $('#timer-options-' + task_checklist_id).find('.countdown-row').text();
        console.log('time_paused: ' + time_paused);

        pauseTask(timer_id, task_checklist_id, time_paused);
    });


    $('.task-item-timer').removeClass('still-counting');

    $('#timer-' + task_checklist_id).countdown('resume');
    $('#timer-' + task_checklist_id).addClass('still-counting');
    $('#timer-' + task_checklist_id).addClass('task-item-timer');
    $('#timer-options-' + task_checklist_id).children('timer_status').val('Resumed');
    $('#timer-pause-' + task_checklist_id).switchClass('resume-timer', 'pause-timer');
    $('#timer-pause-' + task_checklist_id).text('Pause');
    console.log("timer_id: " + timer_id);
    console.log("task_checklist_id: " + task_checklist_id);
    resumeTask(timer_id, task_checklist_id);
});


//region Check List
//For Checklist Status
_body.on('click', '.checklist-status', function (e) {
    //$('.checklist-status').click(function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    var index = $(this).parent().parent().parent().index();
    var id = $(this).siblings('.task_list_item_id').val();

    console.log(id);

    /*From Default, Change to ongoing*/
    if ($(this).hasClass('bg-gray')) {
        $(this).html('&nbsp;<i class="glyphicon glyphicon-time"></i>&nbsp;');
        $(this).switchClass('bg-gray', 'bg-orange', function () {
            update_checklist_status(id, 'Ongoing');
        });

    }
    /*From Ongoing, Change to Completed, Update the progress bar, increase the value*/
    if ($(this).hasClass('bg-orange')) {
        $(this).html('&nbsp;<i class="glyphicon glyphicon-ok"></i>&nbsp;');
        $(this).switchClass('bg-orange', 'bg-green', function () {
            finish_checklist();
            update_checklist_status(id, 'Completed');
        });
        //var timer_id = $('#timer-' + id).parent().find('.timer_id').val();
        //var time_ended = $('#timer-' + id).text();
        //console.log('time_ended: ' + time_ended);
        //if ($('#timer-pause-' + id).length > 0) {
            //$('#timer-pause-' + id).remove();
        //}
        //$('#timer-' + id).removeClass('still-counting');
        //$('#timer-' + id).countdown('pause');
        //endTask(timer_id, time_ended);
    }
    /*From Completed, Change to Urgent, Update the progress bar, decrease the value*/
    if ($(this).hasClass('bg-green')) {
        $(this).html('&nbsp;&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;&nbsp;');
        $(this).switchClass('bg-green', 'bg-red', function () {
            finish_checklist();
            update_checklist_status(id, 'Urgent');
        });
    }
    /*From Urgent, Change to back to Default*/
    if ($(this).hasClass('bg-red')) {
        $(this).html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
        $(this).switchClass('bg-red', 'bg-gray', function () {
            update_checklist_status(id, 'Default');
        });
    }
});

_body.on('click', '.check-list-btn', function () {
    var text_area_ele = '<li id="add-new-task" class="list-group-item text-area-content area-content">';
    text_area_ele += '<input class="form-control" name="checklist_header" placeholder="Title" value="" />';
    text_area_ele += '<textarea id="add-new-task-textarea" class=" form-control" name="checklist" placeholder="New Task" rows="3"></textarea><br/>';
    text_area_ele += '<button class="btn btn-submit btn-shadow btn-sm submit-checklist" type="button">Save</button>&nbsp;&nbsp;&nbsp;';
    text_area_ele += '<button class="btn btn-delete btn-shadow btn-sm cancel-checklist" type="button">Cancel</button>';
    text_area_ele += '</li>';

    var briefcase_id = $('.briefcase_id').val();

    var _this = $(this);
    var check_list_container = $('#list_group_' + briefcase_id);
    console.log('briefcase_id: ' + briefcase_id);
    _this.addClass('disabled');
    check_list_container.append(text_area_ele);

    //Immediately add an entry into the database
    var task_check_list_id;
    var new_task_url = public_path + 'addNewTask';
    var blank_task = new FormData();
    blank_task.append('_token', _body.find('input[name="_token"]').val());
    blank_task.append('task_id', _body.find('.briefcase_id').val());
    blank_task.append('user_id', _body.find('.user_id').val());

    $.ajax({
        url: new_task_url,
        type: "POST",
        data: blank_task,
        // THIS MUST BE DONE FOR FILE UPLOADING
        contentType: false,
        processData: false,
        beforeSend: function () {

        },
        success: function (data) {
            task_check_list_id = data;
        },
        error: function (xhr, status, error) {

        }
    }); //ajax


    var add_new_task_textarea = CKEDITOR.replace('add-new-task-textarea');


    _body.find('input[name="checklist_header"]').on('change', function () {
        var ajaxurl = public_path + 'saveTaskCheckListHeader';

        var formData = new FormData();
        formData.append('task_check_list_id', task_check_list_id);
        formData.append('checklist_header', $(this).val());

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: formData,
            // THIS MUST BE DONE FOR FILE UPLOADING
            contentType: false,
            processData: false,
            beforeSend: function () {
            },
            success: function (data) {
            },
            error: function (xhr, status, error) {

            }
        }); //ajax
    });

    add_new_task_textarea.on('change', function (evt) {
        var ajaxurl = public_path + 'saveTaskCheckList';

        var formData = new FormData();
        formData.append('task_check_list_id', task_check_list_id);
        formData.append('checklist_content', evt.editor.getData());

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: formData,
            // THIS MUST BE DONE FOR FILE UPLOADING
            contentType: false,
            processData: false,
            beforeSend: function () {
            },
            success: function (data) {
            },
            error: function (xhr, status, error) {

            }
        }); //ajax

    });

    add_new_task_textarea.on('fileUploadRequest', function (evt) {
        var fileLoader = evt.data.fileLoader,
                xhr = fileLoader.xhr;

        //xhr.open('PUT', fileLoader.uploadUrl, true);

        //fileLoader.xhr.send(formData);

        // Prevented default behavior.
        //evt.stop();

        //saveChecklistContent(task_check_list_id,CKEDITOR.instances['add-new-task-textarea'].getData());
        var ajaxurl = fileLoader.uploadUrl;
        formData = new FormData();
        formData.append('upload', fileLoader.file, fileLoader.fileName);
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: formData,
            // THIS MUST BE DONE FOR FILE UPLOADING
            contentType: false,
            processData: false,
            beforeSend: function () {
            },
            success: function (data) {

                console.log('file upload finished');
            },
            error: function (xhr, status, error) {

            }
        }); //ajax

    }); // Listener with priority 4 will be executed before priority 5.

    add_new_task_textarea.on('fileUploadResponse', function (evt) {
        console.log('task_check_list_id', task_check_list_id);
        console.log('editor data', CKEDITOR.instances['add-new-task-textarea'].getData());
        //saveChecklistContent(task_check_list_id, evt.editor.getData());
    });

    check_list_container.on('click', '.submit-checklist', function (e) {
        _this.removeClass('disabled');
        e.preventDefault();
        e.stopImmediatePropagation();
        //var data = _body.find('.task-form').serializeArray();
        var data = [];
        data.push(
                {'name': '_token', 'value': _body.find('input[name="_token"]').val()},
        {'name': 'task_check_list_id', 'value': task_check_list_id},
        {'name': 'task_id', 'value': _body.find('.briefcase_id').val()},
        {'name': 'user_id', 'value': _body.find('.user_id').val()},
        {'name': 'checklist_header', 'value': _body.find('input[name="checklist_header"]').val()},
        {'name': 'checklist', 'value': CKEDITOR.instances['add-new-task-textarea'].getData()}
        );

        $.post(public_path + 'checkList', data, function (d) {
            var _return_data = jQuery.parseJSON(d);

            var ele = '';
            $.each(_return_data, function (index, val) {
                var status = val.status;
                var statusClass;

                switch (status) {
                    case 'Default':
                        statusClass = 'bg-gray'
                        break;
                    case 'Ongoing':
                        statusClass = 'bg-orange'
                        break;
                    case 'Completed':
                        statusClass = 'bg-green'
                        break;
                    case 'Urgent':
                        statusClass = 'bg-red'
                        break;
                }

                ele += '<li id="task_item_' + val.id + '" class="list-group-item task-list-item">';
                ele += '<div class="row task-list-details">';
                ele += '<div class="col-sm-6">';
                ele += '<a data-toggle="collapse" href="#task-item-collapse-' + val.id + '" class="checklist-header"><i class="glyphicon glyphicon-list"></i>' + val.checklist_header + '</a>';
                ele += '<input type="hidden" class="task_list_item_id" value="' + val.id + '" />';
                ele += '<input type="hidden" class="task_list_id" value="' + val.task_id + '" />';
                ele += '</div>';
                ele += '<div class="col-sm-3">';

                if (val.timer[0] !== undefined) {
                    ele += '<div id="timer-options-' + val.id + '" class="pull-right">';
                    if (val.timer[0].timer_status === 'Resumed' || val.timer[0].timer_status === 'Started') {
                        ele += '<text id="timer-' + val.id + '" class="still-counting">' + val.timer[0].total_time + '</text>';
                        ele += '<button id="timer-pause-' + val.id + '" class="btn btn-primary pause-timer">Pause</button>';
                    } else {
                        ele += '<text id="timer-' + val.id + '">' + val.timer[0].total_time + '</text>';
                        ele += '<button id="timer-pause-' + val.id + '" class="btn btn-primary resume-timer">Resume</button>';
                        ele += '<input class="timer_id" type="hidden" value="' + val.timer[0].timer_id + '">';
                        ele += '<input class="task_checklist_id" type="hidden" value="' + val.id + '">';
                        ele += '<input class="total_time" type="hidden" value="' + val.timer[0].total_time + '">';
                        ele += '<input class="timer_status" type="hidden" value="' + val.timer[0].timer_status + '">';

                    }
                    ele += '</div>';
                } else {

                    ele += '<div id="timer-options-' + val.id + '" class="pull-right">';
                    ele += '<button id="timer-start-' + val.id + '" class="btn btn-primary start-timer">Start</button>';
                    ele += '<text id="timer-' + val.id + '"></text>';
                    ele += '<input class="task_checklist_id" type="hidden" value="'+ val.id +'">';
                    ele += '<input class="timer_id" type="hidden" value="">';
                    ele += '</div>'

                }
                ele += '</div>';
                
                ele += '<div class="pull-right">';

                if (status === 'Default') {
                    ele += '<div class="btn btn-default btn-shadow bg-gray checklist-status">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>';
                }
                if (status === 'Ongoing') {
                    ele += '<div class="btn btn-default btn-shadow bg-orange checklist-status">&nbsp;<i class="glyphicon glyphicon-time"></i>&nbsp;</div>';
                }
                if (status === 'Completed') {
                    ele += '<div class="btn btn-default btn-shadow bg-green checklist-status">&nbsp;<i class="glyphicon glyphicon glyphicon-ok"></i>&nbsp;</div><div class="btn btn-default btn-shadow bg-green checklist-status">&nbsp;<i class="glyphicon glyphicon glyphicon-ok"></i>&nbsp;</div>';
                }
                if (status === 'Urgent') {
                    ele += '<div class="btn btn-default btn-shadow bg-red checklist-status">&nbsp;&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;&nbsp;</div>';
                }
                ele += '&nbsp;&nbsp;&nbsp;';
                //ele += '<div class="btn btn-default btn-shadow ' + statusClass + ' checklist-status">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;';
                //ele += '<a href="#" class="icon icon-btn edit-task-list-item"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;';
                ele += '<input type="hidden" class="task_list_item_id" value="' + val.id + '" />';
                ele += '<input type="hidden" class="task_list_id" value="' + val.id + '" />';
                ele += '<a href="#" class="drag-handle icon icon-btn move-tasklist"><i class="fa fa-arrows"></i></a>&nbsp;&nbsp;&nbsp;';
                ele += '</div>';
                ele += '</div>';
                ele += '<div class="row">';
                ele += '<div id="task-item-collapse-' + val.id + '" class="task-item-collapse collapse">';
                ele += '<div class="checklist-item">' + val.checklist + '</div>';
                ele += '<input type="hidden" class="task_list_item_id" value="' + val.id + '" />';
                ele += '<input type="hidden" class="task_list_id" value="' + val.task_id + '" />';
                ele += '<br/>';
                ele += '<div class="row">';
                ele += '<div class="col-md-12">';
                ele += '<div class="pull-right" style="margin-right: 5px">';
                ele += '<a href="#" class="btn-delete btn-shadow btn alert_delete" style="font-size: 18px!important;"><i class="fa fa-times" aria-hidden="true"></i> Delete</a>&nbsp;&nbsp;&nbsp;';
                ele += '<a href="#" class="btn-edit btn-shadow btn edit-task-list-item" style="font-size: 18px!important;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                ele += '<input type="hidden" class="task_list_item_id" value="' + val.id + '" />';
                ele += '<input type="hidden" class="task_list_id" value="' + val.task_id + '" />';
                ele += '</div>';
                ele += '</div>';
                ele += '</div>';
                ele += '</div>';
                ele += '</div>';
                ele += '</div>';
                ele += '</li>';

            });

            console.log(_body.find('input[class="project_id"]').val());
            //socket.emit('add-task-list-item', {'room_name': '/project/' + _body.find('input[class="project_id"]').val(), 'list_group_id': _body.find('input[name="task_id"]').val(), 'task_check_list_id': task_check_list_id});

            //Remove Text area
            $('#add-new-task').remove();
            check_list_container.children('li:contains("No data was found.")').remove();
            check_list_container.append(ele);
            _this.removeAttr('disabled');
        });
    }).on('click', '.cancel-checklist', function () {
        _this.removeClass('disabled');
        $('#add-new-task').remove();

        var delete_new_task = public_path + 'cancelAddNewTask';
        var delete_task = new FormData();
        delete_task.append('task_check_list_id', task_check_list_id);

        $.ajax({
            url: delete_new_task,
            type: "POST",
            data: delete_task,
            // THIS MUST BE DONE FOR FILE UPLOADING
            contentType: false,
            processData: false,
            beforeSend: function () {
            },
            success: function (data) {
            },
            error: function (xhr, status, error) {

            }
        }); //ajax

        //$('.text-area-content').remove();
    });
});

_body.on('click', '.edit-task-list-item', function (e) {
    //Prevents default behavior
    e.preventDefault();

    //Get list item index
    var index = $(this).parent().parent().parent().parent().parent().parent().index();

    //Get the list group id
    var list_group_id = $(this).parent().parent().parent().parent().parent().parent().parent().attr('id');

    var task_list_id = $(this).siblings('.task_list_id').val();

    var task_list_item_id = $(this).siblings('.task_list_item_id').val();

    //Header Element
    var task_item_header = $(this).parent().parent().parent().parent().parent().parent().find('.checklist-header');
    //Content Element
    var task_item_content = $(this).parent().parent().parent().parent().parent().parent().find('.checklist-item');

    //Get Header Text
    var header_text = $(this).parent().parent().parent().parent().parent().parent().find('.checklist-header').text();

    //Get Text
    var content_text = $(this).parent().parent().parent().parent().parent().parent().find('.checklist-item').html();

    //Header Editor
    var header_text_area_ele = '<div class="text-area-content">';
    header_text_area_ele += '<div class="form-group">';
    header_text_area_ele += '<input type="text" name="checklist_header" class="form-control edit-checklist-header" placeholder="Task Header" value="' + header_text + '"/>';
    header_text_area_ele += '</div>'; //form-group
    header_text_area_ele += '</div>';

    //Content Editor
    var content_text_area_ele = '<div class="text-area-content area-content">';
    content_text_area_ele += '<div class="form-group">';
    content_text_area_ele += '<textarea id="editChecklistItem' + task_list_item_id + '" class="form-control edit-checklist-item" name="checklist" placeholder="Checklist" rows="3">' + content_text + '</textarea><br/>';
    content_text_area_ele += '</div>'; //form-group
    content_text_area_ele += '<button class="btn btn-submit btn-shadow btn-sm update-checklist" type="button">Save & Close</button>&nbsp;&nbsp;&nbsp;';
    content_text_area_ele += '<a href="#" class="btn-delete btn-shadow btn alert_delete pull-right" style="margin-right:0;font-size: 18px!important;"><i class="fa fa-times" aria-hidden="true"></i> Delete</a>';
    content_text_area_ele += '<input type="hidden" class="task_list_item_id" value="' + task_list_item_id + '" />';
    content_text_area_ele += '<input type="hidden" class="task_list_id" value="' + task_list_id + '" />';
    content_text_area_ele += '</div>';


    task_item_header.css({'display': 'none'}).before(header_text_area_ele);

    task_item_content.css({'display': 'none'}).before(content_text_area_ele);

    //var textarea_id = $('#' + list_group_id + ' .list-group-item').eq(index).find('textarea').attr('id');
    var textarea_id = $(this).parent().parent().parent().parent().parent().parent().find('.edit-checklist-item').attr('id');

    var edit_task_list_editor = CKEDITOR.replace(textarea_id);
    edit_task_list_editor.on('change', function (evt) {

        var ajaxurl = public_path + 'autoSaveEditChecklist';

        var formData = new FormData();
        formData.append('task_check_list_id', task_list_item_id);
        formData.append('checklist', evt.editor.getData());

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: formData,
            // THIS MUST BE DONE FOR FILE UPLOADING
            contentType: false,
            processData: false,
            beforeSend: function () {
            },
            success: function (data) {
            },
            error: function (xhr, status, error) {

            }
        }); //ajax
    });

    //Toggle the content area to show
    $('#task-item-collapse-' + task_list_item_id).collapse('show');
    $(this).css({'display': 'none'});
    $(this).siblings('.alert_delete').css({'display': 'none'});
});

_body.on('click', '.update-checklist', function (e) {
    //Stops multiple calls to the this event
    e.stopImmediatePropagation();
    //Get Task item header
    var task_item_id = $(this).parent().parent().find('.task_list_item_id').val();
    
    var _task_item = $('#task_item_' + task_item_id);
    
    _task_item.removeClass('is-task-item-selected');
    //Get list item index
    var index = $(this).parent().parent().parent().parent().parent().index();

    //Get the list group id
    var list_group_id = $(this).parent().parent().parent().parent().parent().parent().attr('id');

    //Get checklist item with the list group id
    var checklist_item = $(this).parent().parent().find('.checklist-item');

    //Get checklist header with the list group id
    var checklist_header = $(this).parent().parent().parent().parent().find('.checklist-header');

    //Get task item id
    var task_list_item_id = $(this).parent().parent().parent().find('.task_list_item_id').val();

    //Get Data from CKEditor
    var textarea_id = $(this).parent().find('textarea').attr('id');

    var task_list_header = $(this).parent().parent().parent().parent().find('.edit-checklist-header').val();

    var task_list_data = CKEDITOR.instances[textarea_id].getData();

    //update_checklist_header(task_list_item_id, task_list_header, checklist_header);

    update_checklist_data(task_list_item_id, task_list_header, task_list_data, checklist_header, checklist_item);

    //Hide the content area
    $('#task-item-collapse-' + task_list_item_id).collapse('hide');

    $('.edit-task-list-item')
            .removeAttr('style');
    $('.alert_delete').css({'display': 'inline'});
});


_body.on('click', '.alert_delete', function (e) {
    e.preventDefault();

    //var index = $(this).parent().parent().parent().index();

    var task_list_item_id = $(this).siblings('.task_list_item_id').val();
    //Get the list group id
    //var list_group_id = $(this).parent().parent().parent().parent().attr('id');

    var list_item = $('#task_item_' + task_list_item_id);

    list_item.remove();

    var url = public_path + 'deleteCheckList/' + task_list_item_id;

    $.post(url);

});
$('.task-list').on('show.bs.collapse', function () {
    var id = this.id.match(/\d+/);
    var task_list = $('#collapse-container-' + id);
    task_list.addClass('is-selected');
});
$('.task-list .panel-heading .col-xs-6')
        .click(function () {
            var data_target = $(this).parent().parent().parent().find('.task-header').data('target');
            var id = data_target.match(/\d+/);
            var task_list = $('#collapse-container-' + id);
            task_list.removeClass('is-selected');
        });
$('.task-list-item .checklist-header, .task-list-details .edit-task-list-item').click(function (event) {
    var href = !$(this).hasClass('icon') ? $(this).attr('href') : $(this).parent().parent().find('.checklist-header').attr('href');
    var id = href.match(/\d+/);
    var task_list_item = $('#task_item_' + parseInt(id));
    task_list_item.addClass('is-task-item-selected');
});
$('.list-group-item.task-list-item').on('hidden.bs.collapse', function () {
    var id = this.id.match(/\d+/);
    var task_list = $('#task_item_' + id);
    task_list.removeClass('is-task-item-selected');
});
/*$('.task-list-item').bind('dblclick', function () {
 var edit_btn = $(this).find('.icon-btn.edit-task-list-item');
 edit_btn.bind().trigger('click');
 console.log('trigger');
 });*/
//endregion
//region For Tasklist Delete
$('.task-list').on('click', '.delete-tasklist', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var task_id = url.split('/').pop();

    //region Delete Modal
    var _delete_modal = $('#delete-modal');
    _delete_modal.find('.delete-msg').html('Deleting this Briefcase will delete all content.');
    _delete_modal.modal('show');
    $('.confirm-delete').on('click', function (e) {
        e.preventDefault();
        //Remove the collapse panel immediately
        _delete_modal.modal('hide');
        $('#collapse-container-' + task_id).remove();
        $.post(url);
    });
    //endregion
});
//endregion

//region Add Spreadsheet
_body.on('click', '.add-spreadsheet', function () {

    var spreadsheet_name = 'task-spreadsheet-' + makeid();

    //Create a new spreadsheet page in ethercalc
    var request = new XMLHttpRequest();
    request.open('POST', 'https://job.tc:9000/');
    request.setRequestHeader('Content-Type', 'application/json');
    request.onreadystatechange = function () {
        if (this.readyState === 4) {
            console.log('Status:', this.status);
            console.log('Headers:', this.getAllResponseHeaders());
            console.log('Body:', this.responseText);
        }
    };
    var body = {
        'room': spreadsheet_name
    };
    request.send(JSON.stringify(body));

    var text_area_ele = '<li id="add-new-spreadsheet" class="list-group-item text-area-content area-content">';
    text_area_ele += '<input class="form-control" name="spreadsheet_header" placeholder="Title" value="" />';
    text_area_ele += '<iframe style="height: 800px;" id="spreadsheet_iframe" class="spreadsheet_iframe" src="https://job.tc:9000/' + spreadsheet_name + '"></iframe>';
    text_area_ele += '<button class="btn btn-submit btn-shadow btn-sm submit-checklist" type="button">Save</button>&nbsp;&nbsp;&nbsp;';
    text_area_ele += '<button class="btn btn-delete btn-shadow btn-sm cancel-checklist" type="button">Cancel</button>';
    text_area_ele += '</li>';

    var _this = $(this);
    var check_list_container = $('#list_group_' + this.id);
    _this.addClass('disabled');
    check_list_container.append(text_area_ele);

    //Immediately add an entry into the database
    var task_check_list_id;
    var new_task_url = public_path + 'addNewTask';
    var blank_task = new FormData();
    blank_task.append('_token', _body.find('input[name="_token"]').val());
    blank_task.append('task_id', _body.find('.briefcase_id').val());
    blank_task.append('user_id', _body.find('.user_id').val());

    $.ajax({
        url: new_task_url,
        type: "POST",
        data: blank_task,
        // THIS MUST BE DONE FOR FILE UPLOADING
        contentType: false,
        processData: false,
        beforeSend: function () {

        },
        success: function (data) {
            task_check_list_id = data;
        },
        error: function (xhr, status, error) {

        }
    }); //ajax


    check_list_container.on('click', '.submit-checklist', function (e) {
        _this.removeClass('disabled');
        e.preventDefault();
        e.stopImmediatePropagation();
        //var data = _body.find('.task-form').serializeArray();

        var spreadsheet_html = '<iframe style="height: 800px;" id="spreadsheet_iframe" class="spreadsheet_iframe" src="https://job.tc:9000/' + spreadsheet_name + '"></iframe>';

        var data = [];
        data.push(
                {'name': '_token', 'value': _body.find('input[name="_token"]').val()},
        {'name': 'task_check_list_id', 'value': task_check_list_id},
        {'name': 'task_id', 'value': _body.find('.briefcase_id').val()},
        {'name': 'user_id', 'value': _body.find('.user_id').val()},
        {'name': 'checklist_header', 'value': _body.find('input[name="spreadsheet_header"]').val()},
        {'name': 'checklist', 'value': spreadsheet_html}
        );

        $.post(public_path + 'saveSpreadsheet', data, function (d) {
            var _return_data = jQuery.parseJSON(d);

            var ele = '';
            $.each(_return_data, function (index, val) {
                var status = val.status;
                var statusClass;

                switch (status) {
                    case 'Default':
                        statusClass = 'bg-gray';
                        break;
                    case 'Ongoing':
                        statusClass = 'bg-orange';
                        break;
                    case 'Completed':
                        statusClass = 'bg-green';
                        break;
                    case 'Urgent':
                        statusClass = 'bg-red';
                        break;
                }

                ele += '<li id="task_item_' + val.id + '" class="list-group-item task-list-item">';
                ele += '<div class="row task-list-details">';
                ele += '<div class="col-md-7">';
                ele += '<a data-toggle="collapse" href="#task-item-collapse-' + val.id + '" class="checklist-header">' + val.checklist_header + '</a>';
                ele += '<input type="hidden" class="task_list_item_id" value="' + val.id + '" />';
                ele += '<input type="hidden" class="task_list_id" value="' + val.task_id + '" />';
                ele += '</div>';
                ele += '<div class="pull-right">';
                ele += '<div class="btn btn-default btn-shadow ' + statusClass + ' checklist-status">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;';
                ele += '<a href="#" class="icon icon-btn edit-task-list-item"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;';
                ele += '<input type="hidden" class="task_list_item_id" value="' + val.id + '" />';
                ele += '<input type="hidden" class="task_list_id" value="' + val.id + '" />';
                ele += '<a href="#" class="drag-handle icon icon-btn move-tasklist"><i class="fa fa-arrows"></i></a>&nbsp;&nbsp;&nbsp;';
                ele += '<a href="#" class="icon icon-btn alert_delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
                ele += '<input type="hidden" class="task_list_item_id" value="' + val.id + '" />';
                ele += '<input type="hidden" class="task_list_id" value="' + val.task_id + '" />';
                ele += '</div>';
                ele += '</div>';
                ele += '<div class="row">';
                ele += '<div id="task-item-collapse-' + val.id + '" class="task-item-collapse collapse">';
                ele += '<div class="checklist-item"><i class="glyphicon glyphicon-list"></i>' + val.checklist + '</div>';
                ele += '<input type="hidden" class="task_list_item_id" value="' + val.id + '" />';
                ele += '<input type="hidden" class="task_list_id" value="' + val.task_id + '" />';
                ele += '<hr/>';
                ele += '<div class="row">';
                ele += '<div class="col-md-12">';
                ele += '<div class="pull-right" style="margin-right: 5px">';
                ele += '<a href="#" class="btn-delete btn-shadow btn alert_delete" style="font-size: 18px!important;"><i class="fa fa-times" aria-hidden="true"></i> Delete</a>&nbsp;&nbsp;&nbsp;';
                ele += '<a href="#" class="btn-edit btn-shadow btn edit-task-list-item" style="font-size: 18px!important;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                ele += '<input type="hidden" class="task_list_item_id" value="' + val.id + '" />';
                ele += '<input type="hidden" class="task_list_id" value="' + val.task_id + '" />';
                ele += '</div>';
                ele += '</div>';
                ele += '</div>';
                ele += '</div>';
                ele += '</div>';
                ele += '</li>';

            });

            $('#add-new-task').remove();
            check_list_container.children('li:contains("No data was found.")').remove();
            check_list_container.html(ele);
            _this.removeAttr('disabled');
        });
    }).on('click', '.cancel-checklist', function () {
        _this.removeClass('disabled');
        $('#add-new-spreadsheet').remove();

        var delete_new_task = public_path + 'cancelAddNewTask';
        var delete_task = new FormData();
        delete_task.append('task_check_list_id', task_check_list_id);

        $.ajax({
            url: delete_new_task,
            type: "POST",
            data: delete_task,
            // THIS MUST BE DONE FOR FILE UPLOADING
            contentType: false,
            processData: false,
            beforeSend: function () {
            },
            success: function (data) {
            },
            error: function (xhr, status, error) {

            }
        }); //ajax

        //$('.text-area-content').remove();
    });
});
//endregion
$('.check-list-container')
        .on('click', '.toggle-tasklistitem', function () {

            var task_list_item_id = $(this).siblings('.task_list_item_id').val();
            var company_id = $(this).siblings('.company_id').val();
            var task_list_id = $(this).siblings('.task_list_id').val();

            var task_checklist_url = public_path + 'getTaskChecklistItem/' + task_list_item_id + '/' + company_id + '/' + task_list_id;

            $('#task-item-collapse-' + task_list_item_id).load(task_checklist_url, function (e) {
                $('#task_item_' + task_list_item_id).find('a').removeClass('toggle-tasklistitem');
            });
        });

function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 5; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}

window.onbeforeunload = function (event) {
    $('.still-counting').each(function (index) {
        $('#timer-' + task_checklist_id).countdown('pause');
        var timer_id = $(this).siblings('.timer_id').val();
        var task_checklist_id = $(this).siblings('.task_checklist_id').val();

        var current_time = $('#timer-' + task_checklist_id).find('.countdown-row').text();
        console.log('current_time: ' + current_time);

        saveCurrentTime(timer_id, task_checklist_id, current_time);
    });
};


$('.add-link-modal').on('click', function (e) {

    var add_link_form = public_path + '/addLinkFormBriefcase';

    var company_id = $('.company_id').val();
    var user_id = $('.user_id').val();
    var task_id = $('.task_list_id').val();

    BootstrapDialog.show({
        title: 'Add Link <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Add Link',
                cssClass: 'btn btn-submit btn-shadow btn-sm pull-right',
                action: function (dialog) {

                    var ajaxurl = public_path + '/links';

                    var form = $("#add-link-form")[0];

                    var formData = new FormData(form);
                    formData.append('task_id', task_id);
                    formData.append('company_id', company_id);
                    formData.append('user_id', user_id);
                    formData.append('is_dashboard', 0);

                    console.log('task_id: ' + task_id);
                    console.log('company_id: ' + company_id);
                    console.log('user_id: ' + user_id);

                    var $button = this; // 'this' here is a jQuery object that wrapping the <button> DOM element.
                    $button.disable();
                    $button.spin();

                    $.ajax({
                        url: ajaxurl,
                        type: "POST",
                        data: formData,
                        // THIS MUST BE DONE FOR FILE UPLOADING
                        contentType: false,
                        processData: false,
                        beforeSend: function () {

                        },
                        success: function (data) {
                            $('.link-group').append(data);

                            dialog.close();
                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax*/
                }
            }],
        data: {
            'pageToLoad': add_link_form
        },
        onshown: function (ref) {

        },
        closable: false
    });
});

$('body').on('click', '.edit-link', function () {

    var link_id = $(this).attr('id');
    
    var company_id = $('.company_id').val();
    var user_id = $('.user_id').val();
    var task_id = $('.task_list_id').val();
    
    var edit_link_form = public_path + '/links/' + link_id + '/edit';

    BootstrapDialog.show({
        title: 'Edit Link <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Edit Link',
                cssClass: 'btn btn-submit btn-shadow btn-sm pull-right',
                action: function (dialog) {
                    
                    var ajaxurl = public_path + '/links/'+link_id;
                    
                    var form = $("#add-link-form")[0];
                    
                    
                    var formData = new FormData(form);
                    formData.append('task_id', task_id);
                    formData.append('company_id', company_id);
                    formData.append('user_id', user_id);
                    formData.append('is_dashboard', 0);
                    formData.append('_method', 'PATCH');

                    console.log('task_id: ' + task_id);
                    console.log('company_id: ' + company_id);
                    console.log('user_id: ' + user_id);

                    var $button = this; // 'this' here is a jQuery object that wrapping the <button> DOM element.
                    $button.disable();
                    $button.spin();

                    $.ajax({
                        url: ajaxurl,
                        type: "POST",
                        data: formData,
                        // THIS MUST BE DONE FOR FILE UPLOADING
                        contentType: false,
                        processData: false,
                        beforeSend: function () {

                        },
                        success: function (data) {
                            $('#link-'+link_id).replaceWith(data);

                            dialog.close();
                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax*/
                }
            }],
        data: {
            'pageToLoad': edit_link_form
        },
        onshown: function (ref) {

        },
        closable: false
    });
});

$('body').on('click', '.remove-link', function (e) {
    e.preventDefault();
    var link_id = $(this).attr('id');

    var ajaxurl = public_path +'/links/' + link_id;
    var formData = new FormData();
    formData.append('_method', 'DELETE');

    $.ajax({
        url: ajaxurl,
        type: "POST",
        data: formData,
        // THIS MUST BE DONE FOR FILE UPLOADING
        contentType: false,
        processData: false,
        beforeSend: function () {

        },
        success: function (data) {
            $('#link-'+link_id).remove();
        },
        error: function (xhr, status, error) {

        }
    }); //ajax*/
});

//Briefcase Options
//Edit Briefcase
$('.edit-briefcase').click(function () {

    var briefcase_id = $('.briefcase_id').val();

    var edit_briefcase_form = public_path + '/briefcase/' + briefcase_id + '/edit';

    BootstrapDialog.show({
        title: 'Edit Briefcase <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Save',
                cssClass: 'btn btn-submit btn-shadow btn-sm pull-right',
                action: function (dialog) {

                    var ajaxurl = public_path + '/briefcase/' + briefcase_id;

                    var form = $("#edit-briefcase-form")[0];

                    var formData = new FormData(form);
                    formData.append('_method', 'PATCH');

                    console.log(formData.get('task_title'));

                    var $button = this; // 'this' here is a jQuery object that wrapping the <button> DOM element.
                    $button.disable();
                    $button.spin();

                    $.ajax({
                        url: ajaxurl,
                        type: "POST",
                        data: formData,
                        // THIS MUST BE DONE FOR FILE UPLOADING
                        contentType: false,
                        processData: false,
                        beforeSend: function () {

                        },
                        success: function (data) {

                            dialog.close();
                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax*/
                }
            }],
        data: {
            'pageToLoad': edit_briefcase_form
        },
        onshown: function (ref) {

        },
        closable: false
    });

});

$('.delete-briefcase').click(function () {
    BootstrapDialog.confirm({
        title: 'Delete Briefcase',
        message: 'Warning! Deleting this Briefcase will delete all content. Continue?',
        type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
        closable: true, // <-- Default value is false
        draggable: true, // <-- Default value is false
        btnCancelLabel: 'No', // <-- Default value is 'Cancel',
        btnOKLabel: 'Yes', // <-- Default value is 'OK',
        btnOKClass: 'btn-submit', // <-- If you didn't specify it, dialog type will be used,
        btnCancelClass: 'btn-cancel', // <-- If you didn't specify it, dialog type will be used,
        callback: function (result) {
            // result will be true if button was click, while it will be false if users close the dialog directly.
            if (result) {
                var briefcase_id = $('.briefcase_id').val();
                var ajaxurl = public_path + '/briefcase/' + briefcase_id;

                var formData = new FormData();
                formData.append('_method', 'DELETE');

                var project_id = _body.find('input[class="project_id"]').val();
                var project_url = public_path + '/project/' + project_id;

                $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data: formData,
                    // THIS MUST BE DONE FOR FILE UPLOADING
                    contentType: false,
                    processData: false,
                    beforeSend: function () {

                    },
                    success: function (data) {

                        window.location = project_url
                    },
                    error: function (xhr, status, error) {

                    }
                }); //ajax*/
            } else {

            }
        }
    });
});
