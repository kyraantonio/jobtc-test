/*Add Projects*/
$('#my_projects').on('click', '#add-project', function (e) {
    e.stopImmediatePropagation();
    $(this).addClass('disabled');

    var url = public_path + 'addProjectForm';
    var project_container = $('.project_container');

    $.get(url, function (data) {
        project_container.append(data);
    });
});

$('#my_projects').on('click', '.save-project', function (e) {
    e.stopImmediatePropagation();
    var url = public_path + 'addProject';
    var project_container = $('.project_container');
    var company_id = $('.project_tab_options').find('.company_id').val();

    var data = {
        'project_title': $('input[name="project-title"]').val(),
        'company_id': company_id
    };

    $.post(url, data, function (data) {
        $('#add-project-form').remove();
        $('#add-project').removeClass('disabled');
        var project_count = project_container.find('.project-row').last().children().length;

        if (project_count === 1) {
            project_container.find('.project-row').last().append(data);
        } else {
            project_container.append('<div class="project-row row">' + data + '</div>');
        }


    });
});

$('#my_projects').on('click', '.cancel-project', function (e) {
    e.stopImmediatePropagation();
    $('#add-project').removeClass('disabled');
    $('#add-project-form').remove();
});

/*Subprojects Load on Demand*/
$('#my_projects').on('click', '.toggle-subprojects', function () {
    //var project_id = $(this).attr('id').split('-').pop();
    var project_id = $(this).find('.project_id').val();
    var company_id = $(this).find('.company_id').val();

    var url = public_path + 'getSubprojects/' + project_id + '/' + company_id;

    if ($.trim($('#project-collapse-' + project_id).is(':empty'))) {
        $('#project-collapse-' + project_id).load(url, function () {
            $(this).find('.task-header').each(function () {
                var task_id = $(this).parent().attr('id').split('-').pop();
                var task_url = public_path + '/task/' + task_id;
                if ($.trim($('#load-task-assign-' + task_id).is(':empty'))) {
                    $('#load-task-assign-' + task_id).load(task_url, function () {
                        $('#project-' + project_id).removeClass('toggle-subprojects');
                    });
                }
            });
        });
    }
});

$('#job_postings_tab').on('click',function(){
    var url = public_path + 'getJobPostings';
    $.get(url, function (data) {
        $('.jobs_container').html(data);
    });
    
})


$('#add-company').on('click', function () {

    var add_company_form = public_path + '/addCompanyForm';

    BootstrapDialog.show({
        title: 'Add Company <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Add Company',
                cssClass: 'btn-edit btn-shadow',
                action: function (dialog) {
                    var ajaxurl = public_path + '/company';
                    var form = $("#add-company-form")[0];

                    var formData = new FormData(form);

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
                            window.location.reload();
                            dialog.close();

                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax
                }
            }],
        data: {
            'pageToLoad': add_company_form
        },
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });


});
$('.edit-company').on('click',function(){
    
    var company_id = $(this).siblings('.company_id').val();
    var edit_company_form = public_path + '/editCompanyForm/'+company_id;

    BootstrapDialog.show({
        title: 'Edit Company <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Edit Company',
                cssClass: 'btn-edit btn-shadow',
                action: function (dialog) {
                    var ajaxurl = public_path + '/company';
                    var form = $("#add-company-form")[0];

                    var formData = new FormData(form);

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
                            window.location.reload();
                            dialog.close();

                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax
                }
            }],
        data: {
            'pageToLoad': edit_company_form
        },
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });
    
});
$('.delete-company').on('click',function(){
    var company_id = $(this).siblings('.company_id').val();
    BootstrapDialog.confirm({
        title: 'Delete Company',
        message: 'Are you sure you want to delete this company?',
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
                
                console.log('company_id: '+company_id);
                var ajaxurl = public_path + '/company/' + company_id;

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
                        $('#company-'+company_id).remove();
                    },
                    error: function (xhr, status, error) {

                    }
                }); //ajax*/
            } else {

            }
        }
    });
});
//Jquery UI Portlet functions

$(".column").sortable({
    connectWith: ".column",
    handle: ".portlet-header",
    cancel: ".portlet-toggle",
    placeholder: "portlet-placeholder ui-corner-all"
});

$(".portlet")
        .addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
        .find(".portlet-header")
        .addClass("ui-widget-header ui-corner-all")
        .prepend("<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");

$(".portlet-toggle").on("click", function () {
    var icon = $(this);
    icon.toggleClass("ui-icon-minusthick ui-icon-plusthick");
    icon.closest(".portlet").find(".portlet-content").toggle();
});

