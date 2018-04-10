/* 
 * Job Page Scripts
 * Created by: Jexter Dean Buenaventura
 */

$('.edit-job').click(function (e) {
    //e.preventDefault();
    //e.stopImmediatePropagation();
    var job_id = $(this).siblings('.job_id').val();
    var edit_job_form = public_path + '/job/' + job_id + '/edit';

    BootstrapDialog.show({
        title: 'Edit Job',
        size: 'size-wide',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Save',
                cssClass: 'btn-edit btn-shadow',
                action: function (dialog) {
                    var ajaxurl = public_path + '/updateJob/' + job_id;
                    var form = $(".edit-job-form")[0];

                    var formData = new FormData(form);
                    formData.append('job_id', job_id);

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

                            var errorDialog = new BootstrapDialog({
                                title: 'Fields Required',
                                message: data,
                                buttons: [{
                                        label: 'Ok',
                                        action: function (dialog) {
                                            dialog.close();
                                        }
                                    }]
                            }).setType(BootstrapDialog.TYPE_DANGER);

                            var successDialog = new BootstrapDialog({
                                title: 'Success',
                                message: data,
                                buttons: [{
                                        label: 'Ok',
                                        cssClass: 'btn-edit btn-shadow',
                                        action: function (dialog) {
                                            dialog.close();
                                        }
                                    }]
                            }).setType(BootstrapDialog.TYPE_SUCCESS);

                            if (data.toString() === "Job Added" || data.toString() === "Job Updated") {
                                successDialog.open();
                                dialog.close();
                            } else {
                                errorDialog.open();
                                $button.stopSpin();
                                $button.enable();
                            }

                        },
                        error: function (xhr, status, error) {

                            var errorDialog = new BootstrapDialog({
                                title: 'Fields Required',
                                message: status,
                                buttons: [{
                                        label: 'Ok',
                                        cssClass: 'btn-edit btn-shadow',
                                        action: function (dialog) {
                                            dialog.close();
                                        }
                                    }]
                            }).setType(BootstrapDialog.TYPE_DANGER);

                            errorDialog.open();
                        }
                    }); //ajax
                }
            }, {
                label: 'Close',
                cssClass: 'btn-delete btn-shadow',
                action: function (dialog) {
                    dialog.close();
                }
            }],
        data: {
            'pageToLoad': edit_job_form
        },
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });
});

$('.delete-job').click(function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var job_id = $(this).siblings('.job_id').val();

    BootstrapDialog.confirm('Are you sure you want to delete this job?', function (result) {
        if (result) {
            var ajaxurl = public_path + '/job/' + job_id;
            var formData = new FormData();
            formData.append('job_id', job_id);
            formData.append('_token', $('.applicant-list').find('.token').val());

            $.ajax({
                url: ajaxurl,
                type: "DELETE",
                data: formData,
                // THIS MUST BE DONE FOR FILE UPLOADING
                contentType: false,
                processData: false,
                beforeSend: function () {

                },
                success: function (data) {

                    var errorDialog = new BootstrapDialog({
                        title: 'Fields Required',
                        message: data,
                        buttons: [{
                                label: 'Ok',
                                action: function (dialog) {
                                    dialog.close();
                                }
                            }]
                    }).setType(BootstrapDialog.TYPE_DANGER);

                    var successDialog = new BootstrapDialog({
                        title: 'Success',
                        message: data,
                        buttons: [{
                                label: 'Ok',
                                action: function (dialog) {
                                    dialog.close();
                                }
                            }]
                    }).setType(BootstrapDialog.TYPE_SUCCESS);

                    if (data.toString() === "Job Deleted") {
                        successDialog.open();
                    } else {
                        errorDialog.open();
                        $button.stopSpin();
                        $button.enable();
                    }

                },
                error: function (xhr, status, error) {

                    var errorDialog = new BootstrapDialog({
                        title: 'Fields Required',
                        message: status,
                        buttons: [{
                                label: 'Ok',
                                action: function (dialog) {
                                    dialog.close();
                                }
                            }]
                    }).setType(BootstrapDialog.TYPE_DANGER);

                    errorDialog.open();
                }
            }); //ajax

        } else {

        }
    });

});

$(".apply-to-job").click(function () {

    var apply_to_job_form = public_path + "/applyToJobForm";
    var job_id = $('.job_id').val();
    //var token = $('meta[name=csrf-token]').attr('content');
    //var token = $('.applicant-list').find('.token').val();

    BootstrapDialog.show({
        title: 'Apply to Job',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Save',
                cssClass: 'btn-edit btn-shadow save',
                action: function (dialog) {
                    var ajaxurl = public_path + '/applyToJob';
                    var form = $(".apply-to-job-form")[0];
                    var formData = new FormData(form);
                    formData.append('job_id', job_id);
                    formData.append('_token', $('.apply-to-job-form').find('.token').val());

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

                            var errorDialog = new BootstrapDialog({
                                title: 'Fields Required',
                                message: data,
                                buttons: [{
                                        label: 'Ok',
                                        cssClass: 'btn-edit btn-shadow',
                                        action: function (dialog) {
                                            dialog.close();
                                        }
                                    }]
                            }).setType(BootstrapDialog.TYPE_DANGER);

                            var successDialog = new BootstrapDialog({
                                title: 'Success',
                                message: data,
                                buttons: [{
                                        label: 'Ok',
                                        cssClass: 'btn-edit btn-shadow',
                                        action: function (dialog) {
                                            dialog.close();
                                        }
                                    }]
                            }).setType(BootstrapDialog.TYPE_SUCCESS);

                            $('.save').attr('disabled','disabled');
                            
                            window.location.href = public_path+'a/'+data;
                            
                            /*if (data.toString() === "Application Submitted") {
                                successDialog.open();
                                dialog.close();
                            } else {
                                errorDialog.open();
                            }*/

                        },
                        error: function (xhr, status, error) {

                            var errorDialog = new BootstrapDialog({
                                title: 'Fields Required',
                                message: error,
                                buttons: [{
                                        label: 'Ok',
                                        cssClass: 'btn-edit btn-shadow',
                                        action: function (dialog) {
                                            dialog.close();
                                        }
                                    }]
                            }).setType(BootstrapDialog.TYPE_DANGER);

                            errorDialog.open();
                        }
                    }); //ajax
                }
            }, {
                label: 'Close',
                cssClass: 'btn-delete btn-shadow',
                action: function (dialog) {
                    dialog.close();
                }
            }],
        data: {
            'pageToLoad': apply_to_job_form
        },
        onshown: function () {
            //setInterval(validateApplytoJobForm(),1000);
        },
        closable: false
    });
});

$('.status-container').tagEditor({
    maxTags: 9999,
    placeholder: 'Enter Tags ...',
    autocomplete: {
        delay: 0, // show suggestions immediately
        position: {collision: 'flip'}, // automatic menu position up/down
        source: public_path + '/getTags/' + $(this).siblings('.applicant_id').val() + '/applicant' 
    },
    onChange: function (field, editor, tags) {
        var ajaxurl = public_path + '/addNewTag';
        var unique_id = $(field).siblings('.applicant_id').val();
        var tag_type = 'applicant';
        
        var token = $('input[name=_token]').val();
        var formData = new FormData();
        formData.append('unique_id', unique_id);
        formData.append('tag_type', tag_type);
        formData.append('tags', tags);
        formData.append('_token', token);
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
        //alert(tags);
    }
});

function initCkeditor(ref) {
    //var editor = CKEDITOR.instances['edit-description'];
        
    //editor.on('change', function (evt) {
        //$('#edit-description').text(evt.editor.getData());
    //});
}

var assessment_editor = CKEDITOR.replace('assessment-instruction', {
    startupFocus: true
});

assessment_editor.on('change', function (evt) {
    $('#assessment-instruction').text(evt.editor.getData());
    var ajaxUrl = public_path + 'saveJobCriteria';
    var job_id = window.location.href.split("/").pop();

    var formData = new FormData();
    formData.append('job_id', job_id);
    formData.append('criteria', evt.editor.getData());

    $.ajax({
        url: ajaxUrl,
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

//For Job Notes
var job_notes = CKEDITOR.replace('job-notes');

job_notes.on('change', function (evt) {

    var ajaxurl = public_path + 'saveJobNotes';
    var job_id = window.location.href.split("/").pop();

    var formData = new FormData();
    formData.append('job_id', job_id);
    formData.append('notes', evt.editor.getData());

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

$('.hire').click(function (e) {
    e.preventDefault();
    var applicant_id = $(this).parent().find('.applicant_id').val();
    var company_id = $(this).parent().find('.company_id').val();

    /*From Default, Change to ongoing*/
    if ($(this).hasClass('bg-light-blue-gradient')) {
        $(this).switchClass('bg-light-blue-gradient', 'bg-green', function () {
            $(this).html('<i class="fa fa-star" aria-hidden="true"></i>&nbsp;Hired');
            hire_applicant(applicant_id, company_id);
        });
        $(this).parent().find('.move-btn').css({'display':'inline'});
    } else if ($(this).hasClass('bg-green')) {
        $(this).switchClass('bg-green', 'bg-light-blue-gradient', function () {
            $(this).html('Hire');
            fire_applicant(applicant_id, company_id);
        });
        $(this).parent().find('.move-btn').css({'display':'none'});
    }

});


var hire_applicant = function (applicant_id, company_id) {

    var ajaxurl = public_path + 'hireApplicant';

    var formData = new FormData();
    formData.append('applicant_id', applicant_id);
    formData.append('company_id', company_id);

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

};

var fire_applicant = function (applicant_id, company_id) {

    var ajaxurl = public_path + 'fireApplicant';

    var formData = new FormData();
    formData.append('applicant_id', applicant_id);
    formData.append('company_id', company_id);

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

};


function validateApplytoJobForm() {
    
    var ajaxurl = public_path + '/checkApplicantDuplicateEmail';
    
    //Initially Disable the save button
    $('.save').attr('disabled','disabled');
    
    $(".apply-to-job-form").validate({
        rules: {
            name: {
              required: true,
              minlength: 3
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        email: function() {
                            console.log($('.email').val());
                            return $('.email').val();
                        }
                    }
                }
            }
        },
        messages: {
            email: {
                required: "We need your email address to contact you",
                email: "",
                remote: "That email is already taken"
            }
        }
    }).form();
    
    //Enable save button when email is valid
    $('.apply-to-job-form').on('keyup blur', function () { // fires on every keyup & blur
        if ($('.apply-to-job-form').valid()) { // checks form for validity
            $('.save').attr('disabled',false);
        } else {
            $('.save').attr('disabled','disabled');
        }
    });

}