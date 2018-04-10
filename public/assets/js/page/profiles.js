/* 
 Profile Page Scripts
 Created on : Jun 6, 2016, 4:41:19 PM
 Author     : Jexter Dean Buenaventura
 */

$('.update-profile').click(function (e) {
    e.preventDefault();

    var ajaxurl = public_path + 'updateMyProfile';
    var form = $('.profile-form')[0];
    var formData = new FormData(form);
    formData.append('no_password', 'true');

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
            $('.profile-form').find('.profile-img').attr('src', public_path + data);

            $('.update-progress').addClass('bg-green');

            $('.update-progress').html('<i class="fa fa-check" aria-hidden="true"></i>&nbsp;Profile Updated');
            $('.update-progress').css('display', 'inline');
            $('.update-progress').fadeOut(5000);
        },
        error: function (xhr, status, error) {
            $('.update-progress').html('<i class="fa fa-check" aria-hidden="true"></i>&nbsp;Profile Updated');
            $('.update-progress').addClass('bg-red');
            $('.update-progress').css('display', 'inline');
            $('.update-progress').fadeOut(5000);
        }
    }); //ajax

});


$('.change-password').click(function (e) {
    e.preventDefault();

    var ajaxurl = public_path + 'changePassword';
    var password = $('#new_password').val();
    var formData = new FormData();
    formData.append('password', password);

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
            $('.update-password').html('<i class="fa fa-check" aria-hidden="true"></i>&nbsp;Password Updated');
            $('.update-password').css('display', 'inline');
            $('.update-password').fadeOut(5000);
            $('.change-password-form input[type="password"]').val('');
        },
        error: function (xhr, status, error) {
            $('.update-password').html('<i class="fa fa-check" aria-hidden="true"></i>&nbsp;Password Updated');
            $('.update-password').addClass('bg-red');
            $('.update-password').css('display', 'inline');
            $('.update-password').fadeOut(5000);
            $('.change-password-form input[type="password"]').val('');
        }
    }); //ajax
});

validateChangePassword();

function validateChangePassword() {

    var ajaxurl = public_path + '/checkPassword';

    $(".change-password-form").validate({
        rules: {
            password: {
                required: true,
                remote: {
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        password: function () {
                            console.log($('#current_password').val());
                            return $('#current_password').val();
                        }
                    }
                }
            },
            new_password: {
                required: "#current_password:filled"
            },
            new_password_confirmation: {
                required: "#new_password:filled",
                equalTo: "#new_password"
            }
        },
        messages: {
            password: {
                required: "",
                remote: "Wrong password"
            },
            new_password: {
                required: "Fill in your current password first"
            },
            new_password_confirmation: {
                required: "",
                equalTo: "Passwords don't match"
            }

        }
    }).form();

    //Enable save button when email is valid
    $('.change-password-form').on('keyup blur', function () { // fires on every keyup & blur
        if ($('.change-password-form').valid()) { // checks form for validity
            $('.change-password').attr('disabled', false);
        } else {
            $('.change-password').attr('disabled', 'disabled');
        }
    });

}