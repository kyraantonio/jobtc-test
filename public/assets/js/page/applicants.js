/* 
 *Applicant Page Scripts
 */

//For Click toggle

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
var unique_id = $('.page_applicant_id').val();
var tag_type = 'applicant';
$('.status-container').tagEditor({
    maxTags: 9999,
    placeholder: 'Enter tags ...',
    autocomplete: {
        delay: 0, // show suggestions immediately
        position: {collision: 'flip'}, // automatic menu position up/down
        source: public_path + 'getTags/' + unique_id + '/' + tag_type
    },
    onChange: function (field, editor, tags) {
        var ajaxurl = public_path + 'addNewTag';
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

$(".submit-comment").click(function (e) {
    e.preventDefault();
    var applicant_id = $('input[name=applicant_id]').val();
    var job_id = $('input[name=job_id]').val();
    var ajaxurl = public_path + '/addComment';
    var form = $(".add-comment-form")[0];
    var formData = new FormData(form);

    formData.append('module', 'applicant');
    formData.append('send_email', $('.email-comment').is(':checked'));
    formData.append('job_id', job_id);

    if ($.trim($(".comment-textarea").val())) {
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: formData,
            // THIS MUST BE DONE FOR FILE UPLOADING
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.comment-textarea').attr('disabled', 'disabled');
                $('.submit-comment').attr('disabled', 'disabled');
            },
            success: function (data) {
                //$('.no-comment-notifier').remove();
                $('.comment-textarea').val("");
                $('.comment-textarea').attr('disabled', false);
                $('.submit-comment').attr('disabled', false);
                socket.emit('applicant-comment', data);
                $('#comment-list-' + applicant_id).prepend(data);
            },
            error: function (xhr, status, error) {

            }
        }); //ajax
    }
});

//For Applicant Criteria
var assessment_instruction = CKEDITOR.replace('assessment-instruction', {
    height: '200px'
});
assessment_instruction.on('change', function (evt) {
    //var ajaxUrl = public_path + 'saveApplicantCriteria';
    //var applicant_id = window.location.href.split("/").pop();
    var ajaxUrl = public_path + 'saveJobCriteria';
    var job_id = $('#assessment-instruction').data('job-id');

    var formData = new FormData();
    //formData.append('applicant_id', applicant_id);
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

//For Applicant Notes
var applicant_notes = CKEDITOR.replace('applicant-notes', {
    height: '200px'
});
applicant_notes.on('change', function (evt) {

    var ajaxurl = public_path + 'saveApplicantNotes';
    var applicant_id = window.location.href.split("/").pop();

    var formData = new FormData();
    formData.append('applicant_id', applicant_id);
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

//For Written Question
$('.written_editor').each(function(e){
    CKEDITOR.replace(this.id, {
        height: '200px'
    });
});

$('.edit-applicant').on('click', function (e) {
    console.log("testing edit applicant");
    e.preventDefault();
    e.stopImmediatePropagation();
    var is_upload = $(this).hasClass('is-upload-document') ? 1 : 0;
    var applicant_id = $(this).siblings('.applicant_id').val();
    var company_id = $(this).siblings('.company_id').val();
    var edit_applicant_form = public_path + 'a/' + applicant_id + '/edit';
    var ajaxurl = public_path + 'a/' + applicant_id;
    var _this_modal = $('.this-modal');
    _this_modal.find('.modal-body').load(edit_applicant_form);
    _this_modal.find('.modal-title').html((is_upload ? 'Upload File' : 'Edit Profile'));
    _this_modal.modal('show');
    _this_modal.on('click','input[type=submit]',function(e){
        _this_modal.modal('hide');
    });
    /*BootstrapDialog.show({
        title:  (is_upload ? 'Upload File' : 'Edit Profile') + ' <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: (is_upload ? 'Upload' : 'Save'),
                cssClass: 'btn-edit btn-shadow',
                action: function (dialog) {

                    var form = $(".edit-applicant-form");

                    var formData = form.serializeArray();
                    *//*formData.append('_method', "PATCH");
                    formData.append('applicant_id', applicant_id);
                    formData.append('company_id', company_id);*//*

                    var resume = form.find('input[name="resume"]')[0].files[0];
                    var photo = form.find('input[name="photo"]')[0].files[0];
                    var name = form.find('input[name="name"]').val();
                    var email = form.find('input[name="email"]').val();
                    var phone = form.find('input[name="phone"]').val();

                    formData.push(
                        {name:'applicant_id',value:applicant_id},
                        {name:'company_id',value:company_id}
                    );
                    if(!is_upload){
                        formData.push(
                            {name:'name',value:name},
                            {name:'email',value:email},
                            {name:'phone',value:phone}
                        );
                    }

                    formData.push(
                        {name:'photo',value:photo},
                        {name:'resume',value:resume}
                    );

                    var $button = this; // 'this' here is a jQuery object that wrapping the <button> DOM element.
                    $button.disable();
                    $button.spin();
                    $.ajax({
                        url: ajaxurl,
                        type: "post",
                        data: formData,
                        // THIS MUST BE DONE FOR FILE UPLOADING
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function (data) {

                        },
                        success: function (data) {
                            console.log(data);
                            *//*var json_data = JSON.parse(data);

                            //Update Employee information
                            $('.applicant-posting-resume').attr('src','https://docs.google.com/viewer?url='+public_path + json_data.resume+'&embedded=true');
                            $('.add-comment-form').find('.employee-photo').attr('src', public_path + json_data.photo);
                            $('.add-comment-form').find('.media-heading').text(name);
                            $('#applicant-' + applicant_id).find('.applicant-photo').attr('src', public_path + json_data.photo);
                            $('#applicant-' + applicant_id).find('.applicant-name').text(name);
                            $('#applicant-' + applicant_id).find('.applicant-email').text(email);
                            $('#applicant-' + applicant_id).find('.applicant-phone').text(phone);

                            dialog.close();*//*

                        },
                        error: function (xhr, status, error) {
                        }
                    }); //ajax
                }
            }],
        data: {
            'pageToLoad': edit_applicant_form
        },
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });*/

});

$('.edit-applicant-password').on('click', function (e) {
    //e.preventDefault();
    //e.stopImmediatePropagation();
    var applicant_id = $(this).siblings('.applicant_id').val();
    var company_id = $(this).siblings('.company_id').val();
    var edit_applicant_form = public_path + 'editApplicantPasswordForm';
    var ajaxurl = public_path + 'editApplicantPassword';

    BootstrapDialog.show({
        title: 'Edit Password <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Save',
                cssClass: 'save-password btn-edit btn-shadow',
                action: function (dialog) {

                    var form = $(".edit-applicant-password-form");

                    var formData = new FormData();
                    
                    var new_password = $(form).find('input[name="new_password"]').val();
                    formData.append('applicant_id', applicant_id);
                    formData.append('company_id', company_id);
                    formData.append('new_password', new_password);

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
            'pageToLoad': edit_applicant_form
        },
        onshown: function (ref) {
            $('.save-password').attr('disabled',true);
        },
        closable: false
    });
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
        $(this).parent().parent().find('.move-btn').css({'display':'inline'});
    } else if ($(this).hasClass('bg-green')) {
        $(this).switchClass('bg-green', 'bg-light-blue-gradient', function () {
            $(this).html('Hire');
            fire_applicant(applicant_id, company_id);
        });
        $(this).parent().parent().find('.move-btn').css({'display':'none'});
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

var slider_div = $('.slider-div');
var btn_next = $('.btn-next');
var btn_prev = $('.btn-prev');

btn_next.click(function (e) {
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
btn_prev.click(function (e) {
    $(this)
            .closest('.slider-div')
            .removeClass('active')
            .prev('.slider-div')
            .addClass('active');
});
    


