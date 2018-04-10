/*Initialize socket transactions(for real time update)*/
var socket = io('https://job.tc:3000');
var socket_port = '3000';
var base_url = 'https://' + window.location.host;
var site_name = base_url.split(':');
var socket_url = site_name[0] + ':' + site_name[1] + ':' + socket_port;

//Check the page and create it as a room
var page_url = window.location.pathname;
var absolute_path = page_url.split('/')[1];


//var socket = io.connect(socket_url);
//console.log(socket);
//Create room and join room for socket.io
//Create Room for that page only
socket.emit('create', page_url);

if (absolute_path === 'company') {

    var get_projects_url = public_path + 'getCompanyProjects/' + page_url.split('/').pop();

    $.get(get_projects_url, function (data) {
        for (x in data) {
            var project_url = '/project/' + data[x];
            socket.emit('create', project_url);
        }
    });
}

/*
 * Receive applicant comments from the Server
 **/
socket.on('applicant-comment', function (msg) {
    var unique_id = $(msg).find('.unique_id').val();
    console.log(unique_id);
    
    
    var comment_id = $('.comment-list').find('.comment_id').eq(0).val();
    if (comment_id === 'undefined') {
        comment_id = 0;
    }

    if ($('.no-comment-notifier').length === 1) {
        $('.no-comment-notifier').remove();
    }
    //Update the comment list
    var new_comment_id = $(msg).find('.comment_id').val();
    if (new_comment_id !== comment_id) {
        $('#comment-list-' + unique_id).prepend(msg);
        $('.comment-list').animate({scrollTop: 0}, 'slow');
    }
});

/*
 * Receive New Task list items from the Server
 **/
socket.on('add-task-list-item', function (msg) {
    //var subproject = $('#list_group_' + this.id);
    //console.log(msg.list_group_id);
    //console.log(msg.html);

    var subproject = $('#list_group_' + msg.list_group_id);

    var data = [];
    data.push({'name': 'task_check_list_id', 'value': msg.task_check_list_id});
    
    $.post(public_path + 'getTaskChecklistItem', data, function (d) {
        var _return_data = jQuery.parseJSON(d);

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
            var ele = '';

            ele += '<li id="task_item_' + val.id + '" class="list-group-item task-list-item">';
            ele += '<div class="row task-list-details">';
            ele += '<div class="col-md-7">';
            ele += '<a data-toggle="collapse" href="#task-item-collapse-' + val.id + '" class="checklist-header">' + val.checklist_header + '</a>';
            ele += '<input type="hidden" class="task_list_item_id" value="' + val.id + '" />';
            ele += '<input type="hidden" class="task_list_id" value="' + val.task_id + '" />';
            ele += '</div>';
            ele += '<div class="pull-right">';
            ele += '<div class="btn btn-default btn-shadow ' + statusClass + ' checklist-status">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;';
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
            
            subproject.append(ele);
        });
        
    });

    
});