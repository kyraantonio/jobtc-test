/* 
 *User Page Scripts
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
var unique_id = $('.employee_id').val();
var tag_type = 'employee';
$('.status-container').tagEditor({
    maxTags: 9999,
    placeholder: 'Enter tags ...',
    autocomplete: {
        delay: 0, // show suggestions immediately
        position: {collision: 'flip'}, // automatic menu position up/down
        source: public_path + 'getTags/'+ unique_id + '/' +tag_type
    },
    onChange: function (field, editor, tags) {
        var ajaxurl = public_path + 'addNewTag';
        var token = $('input[name=_token]').val();
        
        
        var formData = new FormData();
        formData.append('unique_id',unique_id);
        formData.append('tag_type',tag_type);
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
    }
});

$(".submit-comment").click(function (e) {
    e.preventDefault();
    var user_id = $('input[name=unique_id]').val();
    console.log('user_id: '+user_id);
    
    var ajaxurl = public_path + '/addComment';
    var form = $(".add-comment-form")[0];
    var formData = new FormData(form);
    formData.append('module', 'employee');
    formData.append('send_email', $('.email-comment').is(':checked'));
    formData.append('unique_id',user_id);

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
                $('#comment-list-' + user_id).prepend(data);
            },
            error: function (xhr, status, error) {

            }
        }); //ajax
    }
});


//For Applicant Notes
var employee_notes = CKEDITOR.replace('employee-notes',{
height: '200px'
});

employee_notes.on('change', function (evt) {

    var ajaxurl = public_path + 'saveEmployeeNotes';
    var employee_id = $('.employee_id').val();

    var formData = new FormData();
    formData.append('employee_id', employee_id);
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


$('.hire').click(function () {

    var applicant_id = $(this).parent().find('.applicant_id').val();
    var company_id = $(this).parent().find('.company_id').val();

    /*From Default, Change to ongoing*/
    if ($(this).hasClass('bg-light-blue-gradient')) {
        $(this).switchClass('bg-light-blue-gradient', 'bg-green', function () {
            $(this).html('<i class="fa fa-star" aria-hidden="true"></i>&nbsp;Hired');
            hire_applicant(applicant_id,company_id);
        });
    } else if ($(this).hasClass('bg-green')) {
        $(this).switchClass('bg-green', 'bg-light-blue-gradient', function () {
            $(this).html('Hire');
            fire_applicant(applicant_id,company_id);
        });
    }

});


var hire_applicant = function (applicant_id,company_id) {

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

var fire_applicant = function (applicant_id,company_id) {

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