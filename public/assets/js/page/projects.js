/*Briefcases Load on Demand*/
$('#accordion').on('click', '.toggle-briefcase', function () {
    //var project_id = $(this).attr('id').split('-').pop();
    var task_id = $(this).find('.task_id').val();
    //var company_id = $(this).find('.company_id').val();
    var company_id = $(this).find('.company_id').val();

    var task_url = public_path + 'task/' + task_id;

    $('#load-task-assign-' + task_id).load(task_url, function () {
        $('#task-' + task_id).removeClass('toggle-briefcase');
    });
});


/*Project Options*/
$('.project-options').on('click', '.delete-project', function (e) {
    e.stopImmediatePropagation();
    var url = public_path + 'deleteProject';
    var project_id = $(this).siblings('.project_id').val();
    var company_id = $(this).siblings('.company_id').val();

    BootstrapDialog.confirm('Are you sure you want to delete this project?', function (result) {
        if (result) {
            var data = {
                'project_id': project_id
            };

            $.post(url, data, function () {
                window.location = public_path + 'company/' +company_id + '/projects';
            });
        }
    });

});

$('.project-options').on('click', '.add-briefcase', function (e) {
    e.stopImmediatePropagation();
    $(this).addClass('disabled');

    var url = public_path + 'addBriefcaseForm';
    var project_id = $(this).siblings('.project_id').val();
    var project_container = $('#project-collapse-' + project_id + ' .task-list').last();

    $.get(url, function (data) {
        project_container.append(data);
    });

    $('#project-collapse-' + project_id).on('click', '.save-briefcase', function (e) {
        e.stopImmediatePropagation();
        var save_url = public_path + 'addBriefcase';
        var briefcase_data = {
            'title': $('input[name="briefcase-title"]').val(),
            'project_id': project_id
        };
        $.post(save_url, briefcase_data, function (data) {
            $('#project-collapse-' + project_id + ' #add-briefcase-form').remove();
            $('#project-collapse-' + project_id + ' #add-briefcase').removeClass('disabled');
            $(data).insertAfter($('#project-collapse-' + project_id + ' .task-list').last());

            var task_id = $(data).attr('id').split('_').pop();
            var task_url = public_path + 'task/' + task_id;

            $('#load-task-assign-' + task_id).load(task_url);
            $('#project-collapse-' + project_id + ' .empty-notifier').hide();
        });
    });

    $('#project-collapse-' + project_id).on('click', '.cancel-briefcase', function () {
        $('#project-collapse-' + project_id + ' #add-briefcase').removeClass('disabled');
        $('#project-collapse-' + project_id + ' #add-briefcase-form').remove();
    });
});

