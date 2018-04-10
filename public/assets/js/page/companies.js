/* 
 * Companies Page scripts
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

//General Functions
function removeDuplicates(listName, newItem) {
    var dupl = false;
    $("#" + listName + " > li").each(function () {
        if ($(this)[0] !== newItem[0]) {
            if ($(this).html() === newItem.html()) {
                dupl = true;
            }
        }
    });

    return !dupl;
}

function activateRate(){
    $('.employee-options').on('click', '.add-rate', function (e) {
        e.preventDefault();

        var user_id = $(this).siblings('.user_id').val();
        var company_id = $(this).siblings('.company_id').val();

        console.log('user_id: ' + user_id);
        console.log('company_id: ' + company_id);

        var edit_rate_form = public_path + 'rate/create';

        BootstrapDialog.show({
            title: 'Edit Rate <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
            size: 'size-normal',
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

                        var ajaxurl = public_path + 'rate';
                        var form = $("#add-rate-form")[0];
                        var currency = $(form).find('select[name="currency"]').val();
                        var rate_type = $(form).find('select[name="rate_type"]').val();
                        var rate_value = $(form).find('input[name="rate_value"]').val();
                        var pay_period = $(form).find('select[name="pay_period"]').val();
                        var payday;

                        switch (pay_period) {
                            case 'biweekly':

                                payday = $(form).find('select[name="biweekly-1"]').val() + ',' + $(form).find('select[name="biweekly-2"]').val();

                                break;
                            case 'weekly':

                                payday = $(form).find('select[name="weekly"]').val();

                                break;
                            case 'monthly':

                                payday = $(form).find('select[name="monthly"]').val();
                                break;
                            case 'semi-monthly':

                                payday = $(form).find('select[name="semi-monthly-1"]').val() + ',' + $(form).find('select[name="semi-monthly-2"]').val();
                                break;

                        }

                        console.log('user_id: ' + user_id);
                        console.log('rate type: ' + rate_type);
                        console.log('rate value: ' + rate_value);
                        console.log('company_id: ' + company_id);
                        console.log('currency: ' + currency);
                        console.log('pay_period: ' + pay_period);
                        console.log('payday: ' + payday);

                        var formData = new FormData();
                        formData.append('user_id', user_id);
                        formData.append('company_id', company_id);
                        formData.append('currency', currency);
                        formData.append('rate_type', rate_type);
                        formData.append('rate_value', rate_value);
                        formData.append('pay_period', pay_period);
                        formData.append('payday', payday);

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
                                $('#rate-' + user_id).switchClass('add-rate', 'edit-rate');
                                $('#rate-' + user_id).children('span').text('Edit Rate');
                                $('#employee-' + user_id + ' .rate_id').val(data);
                                console.log();
                                dialog.close();
                            },
                            error: function (xhr, status, error) {

                            }
                        }); //ajax*/
                    }
                }],
            data: {
                'pageToLoad': edit_rate_form
            },
            onshown: function (ref) {

            },
            closable: false
        });

    });
}

activateRate();

function assignTask(user_id, task_id, project_id, company_id) {

    var url = public_path + 'assignTaskList';

    var data = {
        'user_id': user_id,
        'task_id': task_id,
        'project_id': project_id,
        'company_id': company_id
    };

    $.post(url, data);
}

function unassignTask(user_id, task_id, project_id, company_id) {

    var url = public_path + 'unassignTaskList';

    var data = {
        'user_id': user_id,
        'task_id': task_id,
        'project_id': project_id,
        'company_id': company_id
    };

    $.post(url, data);
}

function shareToCompanyEmployee(user_id, company_id, job_id) {

    var url = public_path + 'shareToCompanyEmployee';

    var data = {
        'user_id': user_id,
        'company_id': company_id,
        'job_id': job_id
    };

    $.post(url, data);

}

function unshareFromCompanyEmployee(user_id, company_id, job_id) {

    var url = public_path + 'unshareFromCompanyEmployee';

    var data = {
        'user_id': user_id,
        'company_id': company_id,
        'job_id': job_id
    };

    $.post(url, data);

}

function assignPositionPermission(role_id, permission_id, company_id) {
    var url = public_path + 'assignPositionPermission';

    var data = {
        'role_id': role_id,
        'permission_id': permission_id,
        'company_id': company_id
    };

    $.post(url, data);
}

function unassignPositionPermission(role_id, permission_id, company_id) {
    var url = public_path + 'unassignPositionPermission';

    var data = {
        'role_id': role_id,
        'permission_id': permission_id,
        'company_id': company_id
    };

    $.post(url, data);
}

function myJobsScripts() {

}

function assignProjectsScripts() {
    //For Dragging employees to projects
    $('.taskgroup-list').sortable({
        dropOnEmpty: true,
        connectWith: ".taskgroup-list",
        handle: '.drag-handle',
        remove: function (event, ui) {
            //Don't remove item when dropped to the project list group
            $(this).append($(ui.item).clone());
        },
        receive: function (event, ui) {

            project_id = $(this).siblings().find('.project_id').val();
            //company_id = $(this).siblings().find('.company_id').val();
            company_id = window.location.pathname.split('/').pop();
            console.log('company_id' + company_id);
            list_group_user_id = $(ui.item).attr('id');
            user_id = list_group_user_id.split('-').pop();

            //var identicalItemCount = $("#project-" + project_id + ' .list-group').children('.list-group-item:contains(' + ui.item.text() + ')').length;

            var identicalItemCount = $("#project-" + project_id + ' .list-group').children('li:contains(' + ui.item.find('.user_id').val() + ')').length;

            console.log(project_id);
            //If a duplicate, remove it
            if (identicalItemCount > 1) {
                $("#project-" + project_id + ' .list-group').children('li:contains(' + ui.item.find('.user_id').val() + ')').remove();
            }

            //Show unassign button
            $(ui.item).find('.unassign-member').removeClass('hidden');
            //Remove Edit profile button
            $(ui.item).find('.edit-profile').remove();

            //Create Team
            team_url = public_path + 'createTeam';
            team_data = {
                'project_id': project_id,
                'user_id': user_id,
                'company_id': company_id
            };

            $.post(team_url, team_data, function (data) {
                //Assign the team id to the this list group item's input
                //$(ui.item).find('.team_id').val(team_id);
                $(ui.item).find('.profile-container').html(data);
            });

            //Remove warning that no employee is assigned.
            $(this).find('li:contains("No Employees assigned to this project.")').remove();


        },
        update: function (event, ui) {

        }
    });

    //For Dragging Companies to Projects
    $('.company-list-group').sortable({
        dropOnEmpty: true,
        connectWith: ".company-list-group",
        handle: '.drag-handle',
        remove: function (event, ui) {
            //Don't remove item when dropped to the project list group
            $(this).append($(ui.item).clone());
        },
        receive: function (event, ui) {

            project_id = $(this).siblings().find('.project_id').val();
            list_group_company_id = $(ui.item).attr('id');
            company_id = list_group_company_id.split('-').pop();

            //var identicalItemCount = $("#project-" + project_id + ' .list-group').children('.list-group-item:contains(' + ui.item.text() + ')').length;

            var identicalItemCount = $("#project-" + project_id + ' .list-group').children('li:contains(' + ui.item.find('.company_id').val() + ')').length;

            //If a duplicate, remove it
            if (identicalItemCount > 1) {
                $("#project-" + project_id + ' .list-group').children('li:contains(' + ui.item.find('.company_id').val() + ')').remove();
            }

            //Show unassign button
            $(ui.item).find('.unassign-company').removeClass('hidden');
            //Remove Edit profile button
            //$(ui.item).find('.edit-profile').remove();

            //Create Team
            team_url = public_path + 'assignCompanyToTeam';
            team_data = {
                'project_id': project_id,
                'company_id': company_id
            };
            console.log('project_id: ' + project_id);
            console.log('company_id: ' + company_id);

            $.post(team_url, team_data, function (data) {
                //Assign the team id to the this list group item's input
                //$(ui.item).find('.team_id').val(team_id);
                $(ui.item).find('.employee-list').html(data);
            });


        },
        update: function (event, ui) {

        }
    });

    /*Edit Profile of an employee*/
    $('.taskgroup-list').on('click', '.edit-profile', function () {

        //Get the user profile id
        var user_id = $(this).parent().parent().parent().attr('id').split('-').pop();

        $('#profile-collapse-' + user_id).collapse('show');

        $(this).parent().siblings().find('.employee-photo').attr('style', 'height:150px;width:150px');

        //Photo element
        var photo_url = $(this).parent().siblings().find('.employee-photo').attr('src');

        //Name element
        var name_element = $(this).parent().siblings().find('.name');
        var name_text = $(this).parent().siblings().find('.name').text();

        //Email element
        var email_element = $(this).parent().parent().parent().find('.email');
        var email_text = $(this).parent().parent().parent().find('.email').text();

        //Phone element
        var phone_element = $(this).parent().parent().parent().find('.phone');
        var phone_text = $(this).parent().parent().parent().find('.phone').text();

        //Skype element
        var skype_element = $(this).parent().parent().parent().find('.skype');
        var skype_text = $(this).parent().parent().parent().find('.skype').text();

        //Address 1 element
        var address_1_element = $(this).parent().parent().parent().find('.address_1');
        var address_1_text = $(this).parent().parent().parent().find('.address_1').text();

        //Address 2 element
        var address_2_element = $(this).parent().parent().parent().find('.address_2');
        var address_2_text = $(this).parent().parent().parent().find('.address_2').text();

        //Zipcode element
        var zipcode_element = $(this).parent().parent().parent().find('.zipcode');
        var zipcode_text = $(this).parent().parent().parent().find('.zipcode').text();

        //Country element
        var country_element = $(this).parent().parent().parent().find('.country');
        var country_dropdown = $(this).parent().parent().parent().find('.country-dropdown');
        var country_text = $(this).parent().parent().parent().find('.country').text();

        //Facebook element
        var facebook_element = $(this).parent().parent().parent().find('.facebook');
        var facebook_text = $(this).parent().parent().parent().find('.facebook').text();

        //Linkedin element
        var linkedin_element = $(this).parent().parent().parent().find('.linkedin');
        var linkedin_text = $(this).parent().parent().parent().find('.linkedin').text();

        //Photo Editor
        var photo_ele = '<input type="file" name="photo" class="form-control edit-photo" placeholder="Edit Photo" value="' + photo_url + '"/>';

        //Name Editor
        var name_ele = '<input type="text" name="name" class="form-control edit-name" placeholder="Edit Name" value="' + name_text + '"/>';

        //Password Editor
        var password_ele = '<input type="password" name="password" class="form-control edit-password" placeholder="Edit Password" value=""/>';

        var password_ele = '<div class="text-area-content">';
        password_ele += '<div class="input-group">';
        password_ele += '<span class="input-group-addon" id="password-addon" ><i class="fa fa-lock" aria-hidden="true"></i></span>';
        password_ele += '<input type="password" name="password" class="form-control edit-password" placeholder="Enter New Password" aria-describedby="password-addon" value=""/>';
        password_ele += '</div>'; //input-group
        password_ele += '</div>';

        //Email Editor
        var email_ele = '<div class="text-area-content">';
        email_ele += '<div class="input-group">';
        email_ele += '<span class="input-group-addon" id="email-addon" ><i class="fa fa-envelope-o" aria-hidden="true"></i></span>';
        email_ele += '<input type="text" name="email" class="form-control edit-email" placeholder="Edit Email" aria-describedby="email-addon" value="' + email_text + '"/>';
        email_ele += '</div>'; //input-group
        email_ele += '</div>';

        //Phone Editor
        var phone_ele = '<div class="text-area-content">';
        phone_ele += '<div class="input-group">';
        phone_ele += '<span class="input-group-addon" id="phone-addon" ><i class="fa fa-phone-square" aria-hidden="true"></i></span>';
        phone_ele += '<input type="text" name="email" class="form-control edit-phone" placeholder="Edit Phone Number" aria-describedby="phone-addon" value="' + phone_text + '"/>';
        phone_ele += '</div>'; //input-group
        phone_ele += '</div>';

        //Skype Editor
        var skype_ele = '<div class="text-area-content">';
        skype_ele += '<div class="input-group">';
        skype_ele += '<span class="input-group-addon" id="skype-addon" ><i class="fa fa-skype" aria-hidden="true"></i></span>';
        skype_ele += '<input type="text" name="skype" class="form-control edit-skype" placeholder="Edit Skype" aria-describedby="skype-addon" value="' + skype_text + '"/>';
        skype_ele += '</div>'; //input-group
        skype_ele += '</div>';

        //Address 1 Editor
        var address_1_ele = '<div class="text-area-content">';
        address_1_ele += '<div class="input-group">';
        address_1_ele += '<span class="input-group-addon" id="address-1-addon" ><i class="fa fa-map-marker" aria-hidden="true"></i></span>';
        address_1_ele += '<input type="text" name="skype" class="form-control edit-address-1" placeholder="Edit Address 1" aria-describedby="address-1-addon" value="' + address_1_text + '"/>';
        address_1_ele += '</div>'; //input-group
        address_1_ele += '</div>';

        //Address 2 Editor
        var address_2_ele = '<div class="text-area-content">';
        address_2_ele += '<div class="input-group">';
        address_2_ele += '<span class="input-group-addon" id="address-2-addon" ><i class="fa fa-map-marker" aria-hidden="true"></i></span>';
        address_2_ele += '<input type="text" name="skype" class="form-control edit-address-2" placeholder="Edit Address 2" aria-describedby="address-2-addon" value="' + address_2_text + '"/>';
        address_2_ele += '</div>'; //input-group
        address_2_ele += '</div>';

        //Zipcode Editor
        var zipcode_ele = '<div class="text-area-content">';
        zipcode_ele += '<div class="input-group">';
        zipcode_ele += '<span class="input-group-addon" id="zipcode-addon" ><i class="fa fa-map-marker" aria-hidden="true"></i></span>';
        zipcode_ele += '<input type="text" name="skype" class="form-control edit-zipcode" placeholder="Edit Zipcode" aria-describedby="zipcode-addon" value="' + zipcode_text + '"/>';
        zipcode_ele += '</div>'; //input-group
        zipcode_ele += '</div>';

        //Facebook Editor
        var facebook_ele = '<div class="text-area-content">';
        facebook_ele += '<div class="input-group">';
        facebook_ele += '<span class="input-group-addon" id="facebook-addon" ><i class="fa fa-facebook-square" aria-hidden="true"></i></span>';
        facebook_ele += '<input type="text" name="skype" class="form-control edit-facebook" placeholder="Edit Facebook" aria-describedby="facebook-addon" value="' + facebook_text + '"/>';
        facebook_ele += '</div>'; //input-group
        facebook_ele += '</div>';

        //Linkedin Editor
        var linkedin_ele = '<div class="text-area-content">';
        linkedin_ele += '<div class="input-group">';
        linkedin_ele += '<span class="input-group-addon" id="linkedin-addon" ><i class="fa fa-linkedin-square" aria-hidden="true"></i></span>';
        linkedin_ele += '<input type="text" name="skype" class="form-control edit-linkedin" placeholder="Edit Skype" aria-describedby="linkedin-addon" value="' + linkedin_text + '"/>';
        linkedin_ele += '</div>'; //input-group
        linkedin_ele += '</div>';

        var save_button_ele = '<br /><button class="btn btn-submit btn-shadow btn-sm update-profile" type="button">Save & Close</button>&nbsp;&nbsp;&nbsp;';

        name_element.css({'display': 'none'});
        email_element.before(photo_ele);
        email_element.before(name_ele);
        email_element.css({'display': 'none'}).before(email_ele);
        email_element.after(password_ele);
        phone_element.css({'display': 'none'}).before(phone_ele);
        skype_element.css({'display': 'none'}).before(skype_ele);
        address_1_element.css({'display': 'none'}).before(address_1_ele);
        address_2_element.css({'display': 'none'}).before(address_2_ele);
        zipcode_element.css({'display': 'none'}).before(zipcode_ele);

        country_element.css({'display': 'none'});
        country_dropdown.removeClass('hidden');

        facebook_element.css({'display': 'none'}).before(facebook_ele);
        linkedin_element.css({'display': 'none'}).before(linkedin_ele);

        //Append Save button to the last element
        linkedin_element.after(save_button_ele);

    });

    $('.taskgroup-list').on('click', '.update-profile', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var user_id = $(this).parent().parent().parent().attr('id').split('-').pop();

        $('#profile-collapse-' + user_id).collapse('hide');

        var name_container = $('#profile-' + user_id);
        var profile_container = $(this).parent();

        var name_ele = name_container.find('.name');
        var email_ele = profile_container.find('.email');
        var phone_ele = profile_container.find('.phone');
        var skype_ele = profile_container.find('.skype');
        var address_1_ele = profile_container.find('.address_1');
        var address_2_ele = profile_container.find('.address_2');
        var zipcode_ele = profile_container.find('.zipcode');
        var country_ele = profile_container.find('.country');
        var facebook_ele = profile_container.find('.facebook');
        var linkedin_ele = profile_container.find('.linkedin');

        var name = name_container.find('.edit-name').val().trim();
        var photo = profile_container.find('.edit-photo').get(0).files[0];
        var email = profile_container.find('.edit-email').val().trim();
        var password = profile_container.find('.edit-password').val().trim();
        var phone = profile_container.find('.edit-phone').val().trim();
        var skype = profile_container.find('.edit-skype').val().trim();
        var address_1 = profile_container.find('.edit-address-1').val().trim();
        var address_2 = profile_container.find('.edit-address-2').val().trim();
        var zipcode = profile_container.find('.edit-zipcode').val().trim();
        var country_id = profile_container.find('.country-dropdown').find('.edit-country').val().trim();
        var country = profile_container.find('.country-dropdown').find('.edit-country option:selected').text().trim();
        var facebook = profile_container.find('.edit-facebook').val().trim();
        var linkedin = profile_container.find('.edit-linkedin').val().trim();

        var data = [];

        data.push(
                {'name': 'user_id', 'value': user_id},
        {'name': 'name', 'value': name},
        {'name': 'password', 'value': password},
        {'name': 'email', 'value': email},
        {'name': 'phone', 'value': phone},
        {'name': 'photo', 'value': photo},
        {'name': 'skype', 'value': skype},
        {'name': 'address_1', 'value': address_1},
        {'name': 'address_2', 'value': address_2},
        {'name': 'zipcode', 'value': zipcode},
        {'name': 'country_id', 'value': country_id},
        {'name': 'facebook', 'value': facebook},
        {'name': 'linkedin', 'value': linkedin}
        );

        //$.post(public_path + '/updateProfile', data);

        var ajaxurl = public_path + 'updateProfile';
        var formData = new FormData();
        formData.append('user_id', user_id);
        formData.append('name', name);
        formData.append('password', password);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('photo', photo);
        formData.append('skype', skype);
        formData.append('address_1', address_1);
        formData.append('address_2', address_2);
        formData.append('zipcode', zipcode);
        formData.append('country_id', country_id);
        formData.append('facebook', facebook);
        formData.append('linkedin', linkedin);

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
                name_container.find('.employee-photo').attr('src', public_path + data);
            },
            error: function (xhr, status, error) {
            }
        }); //ajax


        name_container.find('.text-area-content').remove();
        profile_container.find('.edit-name').remove();
        profile_container.find('.edit-photo').remove();
        profile_container.find('.update-profile').remove();
        profile_container.find('.country-dropdown').addClass('hidden');

        name_container.find('.name').attr('style', '');
        name_container.find('.employee-photo').attr('style', '');


        name_ele.removeAttr('style').html(name);
        email_ele.removeAttr('style').html('<i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;' + email);
        phone_ele.removeAttr('style').html('<i class="fa fa-phone-square" aria-hidden="true"></i>&nbsp;' + phone);
        skype_ele.removeAttr('style').html('<i class="fa fa-skype" aria-hidden="true"></i>&nbsp;' + skype);
        address_1_ele.removeAttr('style').html('<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;' + address_1);
        address_2_ele.removeAttr('style').html('<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;' + address_2);
        zipcode_ele.removeAttr('style').html('<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;' + zipcode);
        country_ele.removeAttr('style').html('<i class="fa fa-globe" aria-hidden="true"></i>&nbsp;' + country);
        facebook_ele.removeAttr('style').html('<i class="fa fa-facebook-square" aria-hidden="true"></i>&nbsp;' + facebook);
        linkedin_ele.removeAttr('style').html('<i class="fa fa-linkedin-square" aria-hidden="true"></i>&nbsp;' + linkedin);
    });

    $('.list-group').on('click', '.task-permission', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var user_id = $(this).children('.user_id').val();
        var task_id = $(this).children('.task_id').val();
        var project_id = $(this).children('.project_id').val();
        var company_id = $(this).children('.company_id').val();

        var assign_html = '<i class="fa fa-check" aria-hidden="true"></i>';
        assign_html += '<input class="user_id" type="hidden" value="' + user_id + '"/>';
        assign_html += '<input class="task_id" type="hidden" value="' + task_id + '"/>';
        assign_html += '<input class="project_id" type="hidden" value="' + project_id + '"/>';
        assign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';

        var unassign_html = '<i class="fa fa-plus" aria-hidden="true"></i>';
        unassign_html += '<input class="user_id" type="hidden" value="' + user_id + '"/>';
        unassign_html += '<input class="task_id" type="hidden" value="' + task_id + '"/>';
        unassign_html += '<input class="project_id" type="hidden" value="' + project_id + '"/>';
        unassign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';

        /*Assign the Task List to this user*/
        if ($(this).hasClass('bg-gray')) {
            $(this).switchClass('bg-gray', 'bg-green', function () {
                $(this).html(assign_html);
                assignTask(user_id, task_id, project_id, company_id);
            });
        }
        /*Unassign the Task List from this user*/
        if ($(this).hasClass('bg-green')) {
            $(this).switchClass('bg-green', 'bg-gray', function () {
                $(this).html(unassign_html);
                unassignTask(user_id, task_id, project_id, company_id);
            });
        }

    });

    $('.profile-toggle').clickToggle(function () {
        $(this).find('.name').attr('style', 'font-size:23px;position:relative;top:25px');
        $(this).find('.employee-photo').attr('style', 'height:150px;width:150px');
    },
            function () {
                $(this).find('.name').attr('style', '');
                $(this).find('.employee-photo').attr('style', '');
            });

    $('.team-member').clickToggle(function () {
        $(this).find('.name').attr('style', 'font-size:23px;position:relative;top:25px');
        $(this).find('.employee-photo').attr('style', 'height:150px;width:150px');
    },
            function () {
                $(this).find('.name').attr('style', '');
                $(this).find('.employee-photo').attr('style', '');
            });

    /*Unassign Team Member from project*/
    $('.list-group').on('click', '.unassign-member', function () {

        var list_item = $(this).parent().parent().parent().parent();

        //Remove the element immediately
        list_item.remove();

        var user_id = $(this).parent().find('.user_id').val();
        var team_id = $(this).parent().find('.team_id').val();
        var project_id = $(this).parent().find('.project_id').val();

        data = {
            'team_id': team_id,
            'user_id': user_id,
            'project_id': project_id
        };

        url = public_path + 'unassignTeamMember';

        $.post(url, data);
    });

    //Unassign Company from project

    $('.company-list-group').on('click', '.unassign-company', function () {

        var list_item = $(this).parent().parent().parent().parent();

        //Remove the element immediately
        list_item.remove();

        var company_id = $(this).parent().find('.company_id').val();
        var project_id = $(this).parent().find('.project_id').val();

        data = {
            'company_id': company_id,
            'project_id': project_id
        };

        url = public_path + 'unassignCompanyFromTeam';

        $.post(url, data);
    });

    /*Employees per Company Load on Demand*/
    $('.company-list-group').on('click', '.toggle-employees', function () {

        var project_id = $(this).find('.project_id').val();
        var company_id = $(this).find('.company_id').val();

        var url = public_path + 'getCompanyEmployeesForProject/' + project_id + '/' + company_id;

        if ($.trim($('#employee-toggle-collapse-' + project_id + '-' + company_id).is(':empty'))) {
            $('#employee-toggle-collapse-' + project_id + '-' + company_id).load(url, function () {

            });
        }
    });
    $('.company-list-group').on('click', '.toggle-subprojects', function () {
        var employee_id = $(this).find('.user_id').val();
        var project_id = $(this).find('.project_id').val();
        var company_id = $(this).find('.company_id').val();

        var url = public_path + 'getSubprojectsForCompanyEmployee/' + employee_id + '/' + project_id + '/' + company_id;
        if ($.trim($('#employee-collapse-' + employee_id + '-' + project_id + '-' + company_id).is(':empty'))) {
            $('#employee-collapse-' + employee_id + '-' + project_id + '-' + company_id).load(url, function () {

            });
        }
    });


} //end assign project scripts

function assignTestsScripts() {

//For Dragging tests to applicants
    $('.job-applicant-list').sortable({
        dropOnEmpty: true,
        connectWith: ".job-applicant-list,.job-test-list",
        handle: '.drag-handle',
        remove: function (event, ui) {
            //Don't remove item when dropped to the project list group
            $(this).append($(ui.item).clone());
        },
        receive: function (event, ui) {

            test_id = $(ui.item).find('.test_id').val();
            list_group_applicant_id = $(ui.item).parent().attr('id');
            applicant_id = list_group_applicant_id.split('-').pop();

            //var identicalItemCount = $("#project-" + project_id + ' .list-group').children('.list-group-item:contains(' + ui.item.text() + ')').length;

            var identicalItemCount = $("#applicant-" + applicant_id + ' .list-group').children('li:contains(' + ui.item.find('.test_id').val() + ')').length;

            //If a duplicate, remove it
            if (identicalItemCount > 1) {
                $("#applicant-" + applicant_id + ' .list-group').children('li:contains(' + ui.item.find('.test_id').val() + ')').remove();
            }

            //Show unassign button
            $(ui.item).find('.unassign-test').removeClass('hidden');

            //Assign Test to Job
            test_url = public_path + 'assignTestToApplicant';
            test_data = {
                'test_id': test_id,
                'applicant_id': applicant_id
            };

            $.post(test_url, test_data, function (data) {
                //Assign the applicant id to the this list group item's input
                $(ui.item).find('.applicant_id').val(data);
                //$(ui.item).find('.profile-container').html(data);
            });

            //Remove warning that no employee is assigned.
            $(this).find('li:contains("No Tests assigned to this applicant.")').remove();

        },
        update: function (event, ui) {

        }
    });

//Assign tests to a job
    $('.job-test-list').sortable({
        dropOnEmpty: true,
        connectWith: ".job-test-list",
        handle: '.drag-handle',
        remove: function (event, ui) {
            //Don't remove item when dropped to the project list group
            $(this).append($(ui.item).clone());
        },
        receive: function (event, ui) {

            test_id = $(ui.item).find('.test_id').val();
            list_group_job_id = $(ui.item).parent().attr('id');
            job_id = list_group_job_id.split('-').pop();

            //var identicalItemCount = $("#project-" + project_id + ' .list-group').children('.list-group-item:contains(' + ui.item.text() + ')').length;

            var identicalItemCount = $("#job-" + job_id + ' .list-group').children('li:contains(' + ui.item.find('.test_id').val() + ')').length;

            //If a duplicate, remove it
            if (identicalItemCount > 1) {
                $("#job-" + job_id + ' .list-group').children('li:contains(' + ui.item.find('.test_id').val() + ')').remove();
            }

            //Show unassign button
            $(ui.item).find('.unassign-test').removeClass('hidden');

            //Assign Test to Job
            test_url = public_path + 'assignTestToJob';
            test_data = {
                'test_id': test_id,
                'job_id': job_id
            };

            $.post(test_url, test_data, function (data) {
                //Assign the applicant id to the this list group item's input
                $(ui.item).find('.job_id').val(data);
                //$(ui.item).find('.profile-container').html(data);
            });

            //Remove warning that no employee is assigned.
            $(this).find('li:contains("Drag a test here to make it available for all applicants in this job posting.")').remove();

        },
        update: function (event, ui) {

        }
    });

    /*Unassign Test from Applicant*/
    $('.job-applicant-list').on('click', '.unassign-test', function () {
        var list_item = $(this).parent().parent().parent();

        list_item.remove();

        var test_id = $(this).find('.test_id').val();
        var applicant_id = $(this).find('.applicant_id').val();

        console.log(test_id);
        console.log(applicant_id);

        data = {
            'test_id': test_id,
            'applicant_id': applicant_id
        };

        url = public_path + 'unassignTestFromApplicant';

        $.post(url, data);

    });

    /*Unassign Test from Job*/
    $('.job-test-list').on('click', '.unassign-test', function () {
        var list_item = $(this).parent().parent().parent();

        list_item.remove();

        var test_id = $(this).find('.test_id').val();
        var job_id = $(this).find('.job_id').val();

        console.log(test_id);
        console.log(job_id);

        data = {
            'test_id': test_id,
            'job_id': job_id
        };

        url = public_path + 'unassignTestFromJob';

        $.post(url, data);

    });

}

function assignAuthorityLevels() {
    //Assigning users to levels
    $('.role-list').sortable({
        dropOnEmpty: true,
        connectWith: ".role-list",
        handle: '.drag-handle',
        remove: function (event, ui) {
            //Don't remove item when dropped to the project list group
            //$(this).append($(ui.item).clone());
        },
        receive: function (event, ui) {
            var role_id = $(ui.item).parent().attr('id').split('-').pop();
            var user_id = $(ui.item).find('.user_id').val();
            var company_id = $(ui.item).find('.company_id').val();

            var url = public_path + 'updateRole';
            var data = {
                'role_id': role_id,
                'user_id': user_id,
                'company_id': company_id
            };

            $.post(url, data);

        },
        update: function (event, ui) {

        }
    });
}

function shareJobsScripts() {

    $('.job-list-group').sortable({
        dropOnEmpty: true,
        connectWith: ".job-list-group",
        handle: '.drag-handle',
        remove: function (event, ui) {
            //Don't remove item when dropped to the project list group
            $(this).append($(ui.item).clone());
        },
        receive: function (event, ui) {

            job_id = $(ui.item).find('.job_id').val();
            list_group_id = $(ui.item).parent().attr('id');
            console.log(list_group_id);
            var user_id;
            var company_id;
            var share_url;
            var share_data;

            if (list_group_id.split('-')[0] === 'user') {
                user_id = list_group_id.split('-').pop();

                var identicalItemCount = $("#user-" + user_id + ' .list-group').children('li:contains(' + ui.item.find('.job_id').val() + ')').length;

                //If a duplicate, remove it
                if (identicalItemCount > 1) {
                    $("#user-" + user_id + ' .list-group').children('li:contains(' + ui.item.find('.job_id').val() + ')').remove();
                }

                //Show unassign button
                $(ui.item).find('.unshare-job').removeClass('hidden');

                //Assign Test to Job
                share_url = public_path + 'shareJobToUser';
                share_data = {
                    'user_id': user_id,
                    'job_id': job_id
                };

                $.post(share_url, share_data, function (data) {
                    //Assign the applicant id to the this list group item's input
                    //$(ui.item).find('.job_id').val(data);
                    //$(ui.item).find('.employee-list').html(data);
                });

            } else {
                company_id = list_group_id.split('-').pop();

                var identicalItemCount = $("#company-" + company_id + ' .list-group').children('li:contains(' + ui.item.find('.job_id').val() + ')').length;

                //If a duplicate, remove it
                if (identicalItemCount > 1) {
                    $("#company-" + company_id + ' .list-group').children('li:contains(' + ui.item.find('.job_id').val() + ')').remove();
                }

                //Show unassign button
                $(ui.item).find('.unshare-job').removeClass('hidden');

                $(ui.item).find('.company_id').val(company_id);

                //Share Job to a Company
                share_url = public_path + 'shareJobToCompany';
                share_data = {
                    'company_id': company_id,
                    'job_id': job_id
                };

                $.post(share_url, share_data, function (data) {
                    //Assign the applicant id to the this list group item's input
                    //$(ui.item).find('.job_id').val(data);
                    //$(ui.item).find('.employee-list').html(data);
                    //$(ui.item).find('.employee-list').html(data);
                    $(ui.item).find('.toggle-employees').attr('id', 'shared-company-item-' + data);
                    $(ui.item).find('.toggle-employees').attr('href', '#employee-collapse-' + data);
                    $(ui.item).find('.employee-list').attr('id', 'employee-collapse-' + data);
                });
            }



            //Remove warning that no employee is assigned.
            $(this).find('li:contains("Drag a test here to make it available for all applicants in this job posting.")').remove();

        },
        update: function (event, ui) {

        }
    });

    /*Unshare Job from User*/
    $('.job-list-group').on('click', '.unshare-job', function () {
        var list_item = $(this).parent().parent().parent();
        var list_group = list_item.parent().attr('id').split('-')[0];

        var job_id = $(this).find('.job_id').val();
        var user_id;
        var company_id;

        //Remove the element immediately 
        list_item.remove();

        if (list_group === 'user') {
            user_id = $(this).find('.user_id').val();

            data = {
                'user_id': user_id,
                'job_id': job_id
            };

            url = public_path + 'unshareJobFromUser';
            $.post(url, data);

        } else {
            company_id = $(this).find('.company_id').val();
            console.log(company_id);
            data = {
                'company_id': company_id,
                'job_id': job_id
            };

            url = public_path + 'unshareJobFromCompany';
            $.post(url, data);
        }
    });

    /*Employees per Company Load on Demand*/
    $('.job-list-group').on('click', '.toggle-employees', function () {
        var shared_company_job_id = $(this).attr('id').split('-').pop();
        var job_id = $(this).parent().parent().parent().attr('id').split('-').pop();
        var company_id = $(this).parent().parent().parent().parent().attr('id').split('-').pop();

        console.log('shared_company_job_id: ' + shared_company_job_id);
        console.log('company_id: ' + company_id);

        var url = public_path + 'getEmployees/' + company_id + '/' + job_id;

        if ($.trim($('#employee-collapse-' + shared_company_job_id).is(':empty'))) {
            $('#employee-collapse-' + shared_company_job_id).load(url, function () {

            });
        }
    });

    $('.job-list-group').on('click', '.job-permission', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var user_id = $(this).children('.user_id').val();
        var job_id = $(this).children('.job_id').val();
        var company_id = $(this).children('.company_id').val();


        var assign_html = '<i class="fa fa-check" aria-hidden="true"></i>';
        assign_html += '<input class="user_id" type="hidden" value="' + user_id + '"/>';
        assign_html += '<input class="job_id" type="hidden" value="' + job_id + '"/>';
        assign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';

        var unassign_html = '<i class="fa fa-plus" aria-hidden="true"></i>';
        unassign_html += '<input class="user_id" type="hidden" value="' + user_id + '"/>';
        unassign_html += '<input class="job_id" type="hidden" value="' + job_id + '"/>';
        unassign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';

        /*Assign the Task List to this user*/
        if ($(this).hasClass('bg-gray')) {
            $(this).switchClass('bg-gray', 'bg-green', function () {
                $(this).html(assign_html);
                shareToCompanyEmployee(user_id, company_id, job_id);
            });
        }
        /*Unassign the Task List from this user*/
        if ($(this).hasClass('bg-green')) {
            $(this).switchClass('bg-green', 'bg-gray', function () {
                $(this).html(unassign_html);
                unshareFromCompanyEmployee(user_id, company_id, job_id);
            });
        }
    });

}

function assignScripts() {

    $('#assign_tabs').one('click', '.assign_projects_tab', function () {
        var url = public_path + 'getAssignProjectsTab/' + company_id;
        if ($.trim($('#assign_projects').is(':empty'))) {
            $('#assign_projects').load(url, function () {
                assignProjectsScripts();
            });
        }
    });

    $('#assign_tabs').one('click', '.assign_tests_tab', function () {
        var url = public_path + 'getAssignTestsTab/' + company_id;
        if ($.trim($('#assign_tests').is(':empty'))) {
            $('#assign_tests').load(url, function () {
                assignTestsScripts();
            });
        }
    });

    $('#assign_tabs').one('click', '.assign_authority_levels_tab', function () {
        var url = public_path + 'getAssignAuthorityLevelsTab/' + company_id;
        if ($.trim($('#assign_authority_levels').is(':empty'))) {
            $('#assign_authority_levels').load(url, function () {
                assignAuthorityLevels();
            });
        }
    });

    $('#assign_tabs').one('click', '.share_jobs_tab', function () {
        var url = public_path + 'getShareJobsTab/' + company_id;
        if ($.trim($('#share_jobs').is(':empty'))) {
            $('#share_jobs').load(url, function () {
                shareJobsScripts();
            });
        }
    });
}

function employeesScripts() {

}

function positionsScripts() {

    $('.permission-list-group').on('click', '.position-permission', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var role_id = $(this).children('.role_id').val();
        var permission_id = $(this).children('.permission_id').val();
        var company_id = $(this).children('.company_id').val();

        var assign_html = '<i class="fa fa-check" aria-hidden="true"></i>';
        assign_html += '<input class="role_id" type="hidden" value="' + role_id + '"/>';
        assign_html += '<input class="permission_id" type="hidden" value="' + permission_id + '"/>';
        assign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';

        var unassign_html = '<i class="fa fa-plus" aria-hidden="true"></i>';
        unassign_html += '<input class="role_id" type="hidden" value="' + role_id + '"/>';
        unassign_html += '<input class="permission_id" type="hidden" value="' + permission_id + '"/>';
        unassign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';


        /*Assign the Task List to this user*/
        if ($(this).hasClass('bg-gray')) {
            $(this).switchClass('bg-gray', 'bg-green', function () {
                $(this).html(assign_html);
                //shareToCompanyEmployee(user_id, company_id, job_id);
                assignPositionPermission(role_id, permission_id, company_id);
            });
        }
        /*Unassign the Task List from this user*/
        if ($(this).hasClass('bg-green')) {
            $(this).switchClass('bg-green', 'bg-gray', function () {
                $(this).html(unassign_html);
                //unshareFromCompanyEmployee(user_id, company_id, job_id);
                unassignPositionPermission(role_id, permission_id, company_id);
            });
        }
    });


}

/*For load on demand tabs*/
var company_id = window.location.pathname.split('/').pop();

$('#company_tabs').one('click', '.jobs_tab', function () {
    var url = public_path + 'getJobsTab/' + company_id;
    if ($.trim($('#my_jobs').is(':empty'))) {
        $('#my_jobs').load(url, function () {
            myJobsScripts();
        });
    }
});

$('#company_tabs').one('click', '.employees_tab', function () {
    var url = public_path + 'getEmployeesTab/' + company_id;
    if ($.trim($('#employees').is(':empty'))) {
        $('#employees').load(url, function () {
            employeesScripts();
        });
    }
});

$('#company_tabs').one('click', '.positions_tab', function () {
    var url = public_path + 'getPositionsTab/' + company_id;
    if ($.trim($('#positions').is(':empty'))) {
        $('#positions').load(url, function () {
            positionsScripts();
        });
    }
});

$('#company_tabs').one('click', '.assign_tab', function () {
    var url = public_path + 'getAssignTab/' + company_id;
    if ($.trim($('#assign').is(':empty'))) {
        $('#assign').load(url, function () {
            assignScripts();
            $('.assign_projects_tab').click();
        });
    }
});

/*Subprojects Load on Demand*/
$('#my_projects').on('click', '.toggle-subprojects', function () {
    //var project_id = $(this).attr('id').split('-').pop();
    var project_id = $(this).find('.project_id').val();
    //var company_id = $(this).find('.company_id').val();
    var company_id = window.location.pathname.split('/').pop();

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

$('#shared_projects').on('click', '.toggle-subprojects', function () {
    //var project_id = $(this).attr('id').split('-').pop();
    var project_id = $(this).find('.project_id').val();
    //var company_id = $(this).find('.company_id').val();
    var company_id = window.location.pathname.split('/').pop();

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

/*Add Employee*/
$('#employees').on('click', '#add-employee', function (e) {
    e.stopImmediatePropagation();
    //$(this).addClass('disabled');

    var company_id = $(this).siblings('.company_id').val();

    var add_employee_form = public_path + 'addEmployeeForm/' + company_id;
    var employee_container = $('.employee-container');

    BootstrapDialog.show({
        title: 'Add Employee <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        buttons: [{
                label: 'Add',
                cssClass: 'btn-edit btn-shadow',
                action: function (dialog) {

                    var ajaxurl = public_path + 'addEmployee';
                    var form = $(".add-employee-form")[0];
                    var authority = $(form).find('input[name="authority"]:checked').val();

                    var formData = new FormData();
                    formData.append('company_id', company_id);
                    formData.append('authority', authority);

                    if ($('#new-employee').hasClass('active') === true) {
                        var name = $(form).find('input[name="employee-name"]').val();
                        var email = $(form).find('input[name="employee-email"]').val();
                        var password = $(form).find('input[name="employee-password"]').val();
                        formData.append('name', name);
                        formData.append('email', email);
                        formData.append('password', password);
                    }

                    if ($('#existing-user').hasClass('active') === true) {
                        var user_id = $(form).find('select[name="user_id"] option:selected').val();
                        formData.append('user_id', user_id);
                    }

                    if ($('#existing-position').hasClass('active') === true) {
                        var role_id = $(form).find('select[name="role_id"] option:selected').val();
                        formData.append('role_id', role_id);
                    }

                    if ($('#new-position').hasClass('active') === true) {
                        var position = $(form).find('input[name="position"]').val();
                        formData.append('position', position);
                    }

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

                            var employee_count = employee_container.find('.employee-row').last().children().length;

                            if (employee_count === 1) {
                                employee_container.find('.employee-row').last().append(data);
                            } else {
                                employee_container.append('<div class="row employee-row">' + data + '</div>');
                            }

                            activateRate();
                            dialog.close();
                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax
                }
            }],
        data: {
            'pageToLoad': add_employee_form
        },
        onshown: function (ref) {

        },
        closable: false
    });

    //$.get(url, function (data) {
    //employee_container.append(data);
    //});

});

/*$('#employees').on('click', '.save-employee', function (e) {
 e.stopImmediatePropagation();
 var url = public_path + 'addEmployee';
 var employee_container = $('.employee-container');
 var company_id = $('.employee_tab_options').find('.company_id').val();
 
 var data = {
 'name': $('input[name="employee-name"]').val(),
 'email': $('input[name="employee-email"]').val(),
 'password': $('input[name="employee-password"]').val(),
 'company_id': company_id
 };
 
 $.post(url, data, function (data) {
 $('#add-employee-form').remove();
 $('#add-employee').removeClass('disabled');
 var employee_count = employee_container.find('.employee-row').last().children().length;
 
 if (employee_count === 1) {
 employee_container.find('.employee-row').last().append(data);
 } else {
 employee_container.append('<div class="row employee-row">' + data + '</div>');
 }
 
 
 });
 });*/

/*$('#employees').on('click', '.cancel-employee', function (e) {
 e.stopImmediatePropagation();
 $('#add-employee').removeClass('disabled');
 $('#add-employee-form').remove();
 });*/

/*
 * Employee Options      
 **/

$('#employees').on('click', '.edit-employee-permissions', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var user_id = $(this).siblings('.user_id').val();
    var company_id = $(this).siblings('.company_id').val();
    var edit_employee_permissions_form = public_path + 'editEmployeePermissionsForm/' + company_id + '/' + user_id;
    console.log(user_id);
    var employee_name = $('#employee-' + user_id).find('.name').text().trim();

    BootstrapDialog.show({
        title: 'Edit Permissions for ' + employee_name + '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-wide',
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);
            return $message;
        },
        data: {
            'pageToLoad': edit_employee_permissions_form
        },
        onshown: function (ref) {

        },
        closable: false
    });
});

$('#employees').on('click', '.edit-employee', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var user_id = $(this).siblings('.user_id').val();
    var company_id = $(this).siblings('.company_id').val();
    var edit_employee_form = public_path + 'editEmployeeForm/' + company_id + '/' + user_id;
    var ajaxurl = public_path + 'editEmployee';

    BootstrapDialog.show({
        title: 'Edit Employee <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
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

                    var form = $(".edit-employee-form");

                    var formData = new FormData();
                    formData.append('user_id', user_id);
                    formData.append('company_id', company_id);

                    var photo = $(form).find('input[name="photo"]')[0].files[0];
                    var resume = $(form).find('input[name="resume"]')[0].files[0];
                    var name = $(form).find('input[name="name"]').val();
                    var email = $(form).find('input[name="email"]').val();
                    var phone = $(form).find('input[name="phone"]').val();
                    var skype = $(form).find('input[name="skype"]').val();
                    var facebook = $(form).find('input[name="facebook"]').val();
                    var linkedin = $(form).find('input[name="linkedin"]').val();
                    var address_1 = $(form).find('input[name="address_1"]').val();
                    var address_2 = $(form).find('input[name="address_2"]').val();
                    var zipcode = $(form).find('input[name="zipcode"]').val();
                    var authority = $(form).find('input[name="authority"]:checked').val();


                    var country = $(form).find('select[name="country_id"] option:selected').text();
                    var country_id = $(form).find('select[name="country_id"] option:selected').val();

                    formData.append('name', name);
                    formData.append('email', email);
                    formData.append('phone', phone);
                    formData.append('skype', skype);
                    formData.append('facebook', facebook);
                    formData.append('linkedin', linkedin);
                    formData.append('address_1', address_1);
                    formData.append('address_2', address_2);
                    formData.append('zipcode', zipcode);
                    formData.append('country_id', country_id);
                    formData.append('photo', photo);
                    formData.append('resume', resume);
                    formData.append('authority', authority);
                    console.log(authority);

                    if ($('#new-position').hasClass('active') === true) {
                        var position = $(form).find('input[name="position"]').val();
                        formData.append('position', position);
                    }

                    if ($('#existing-position').hasClass('active') === true) {
                        var role_id = $(form).find('select[name="role_id"] option:selected').val();
                        formData.append('role_id', role_id);
                    }

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
                            var json_data = JSON.parse(data);

                            //Update Employee information
                            $('#employee-' + user_id).find('.employee-photo').attr('src', public_path + json_data.photo);
                            $('#employee-' + user_id).find('.name').children('a').text(name);
                            $('#employee-' + user_id).find('.email').children('a').text(email);
                            $('#employee-' + user_id).find('.phone').children('a').text(phone);
                            $('#employee-' + user_id).find('.skype').children('a').text(skype);
                            $('#employee-' + user_id).find('.address_1').children('span').text(address_1);
                            $('#employee-' + user_id).find('.address_2').children('span').text(address_2);
                            $('#employee-' + user_id).find('.zipcode').children('span').text(zipcode);
                            $('#employee-' + user_id).find('.facebook').children('span').text(facebook);
                            $('#employee-' + user_id).find('.linkedin').children('span').text(linkedin);

                            $('#employee-' + user_id).find('.position').children('span').text(json_data.position);
                            $('#employee-' + user_id).find('.country').children('span').text(country);

                            dialog.close();

                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax
                }
            }],
        data: {
            'pageToLoad': edit_employee_form
        },
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });

});

$('#employees').on('click', '.remove-employee', function (e) {
    e.preventDefault();

    var user_id = $(this).siblings('.user_id').val();
    var company_id = $(this).siblings('.company_id').val();
    var url = public_path + 'removeEmployeeFromCompany';

    BootstrapDialog.confirm('Are you sure you want to fire this employee?', function (result) {
        if (result) {
            var data = {
                'user_id': user_id,
                'company_id': company_id
            };

            $.post(url, data, function (data) {
                $('#employee-' + data).remove();
            });
        }
    });
});

/*Company Positions*/
$('#positions').on('click', '#add-position', function (e) {
    e.stopImmediatePropagation();
    $(this).addClass('disabled');

    var url = public_path + 'addPositionForm';
    var position_container = $('.position_container');

    $.get(url, function (data) {
        position_container.append(data);
    });
});

$('#positions').on('click', '.save-position', function (e) {
    e.stopImmediatePropagation();
    var url = public_path + 'addPosition';
    var position_container = $('.position_container');
    var company_id = $('.position_tab_options').find('.company_id').val();

    var data = {
        'position_title': $('input[name="position-title"]').val(),
        'position_description': $('textarea[name="position-description"]').val(),
        'company_id': company_id
    };

    $.post(url, data, function (data) {
        $('#add-position-form').remove();
        $('#add-position').removeClass('disabled');
        var position_count = position_container.find('.position-row').last().children().length;

        if (position_count === 1) {
            position_container.find('.position-row').last().append(data);
        } else {
            position_container.append('<div class="position-row row">' + data + '</div>');
        }


    });
});

$('#positions').on('click', '.cancel-position', function (e) {
    e.stopImmediatePropagation();
    $('#add-position').removeClass('disabled');
    $('#add-position-form').remove();
});

$('#positions').on('click', '.edit-position', function (e) {
    e.preventDefault();
    var position_id = $(this).siblings('.position_id').val();
    var company_id = $(this).siblings('.company_id').val();
    var edit_position_form = public_path + 'editPositionForm/' + position_id;
    var ajaxurl = public_path + 'editPosition';

    BootstrapDialog.show({
        title: 'Edit Position <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
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

                    var form = $(".edit-position-form")[0];

                    var formData = new FormData(form);
                    formData.append('position_id', position_id);
                    formData.append('company_id', company_id);

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
                            var new_position_title = $(form).find('.title').val();
                            $('#position-' + position_id + ' .box-title').text(new_position_title);
                            dialog.close();
                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax
                }
            }],
        data: {
            'pageToLoad': edit_position_form
        },
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });

});

$('#positions').on('click', '.delete-position', function (e) {
    e.stopImmediatePropagation();

    var position_id = $(this).siblings('.position_id').val();
    var url = public_path + 'deletePosition';

    BootstrapDialog.confirm('Are you sure you want to delete this position?', function (result) {
        if (result) {
            var data = {
                'position_id': position_id
            };

            $.post(url, data, function (data) {
                $('#position-' + data).remove();
            });
        }
    });
});

$('.permission-list-group').on('click', '.position-permission', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    var role_id = $(this).children('.role_id').val();
    var permission_id = $(this).children('.permission_id').val();
    var company_id = $(this).children('.company_id').val();

    var assign_html = '<i class="fa fa-check" aria-hidden="true"></i>';
    assign_html += '<input class="role_id" type="hidden" value="' + role_id + '"/>';
    assign_html += '<input class="permission_id" type="hidden" value="' + permission_id + '"/>';
    assign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';

    var unassign_html = '<i class="fa fa-plus" aria-hidden="true"></i>';
    unassign_html += '<input class="role_id" type="hidden" value="' + role_id + '"/>';
    unassign_html += '<input class="permission_id" type="hidden" value="' + permission_id + '"/>';
    unassign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';


    /*Assign the Task List to this user*/
    if ($(this).hasClass('bg-gray')) {
        $(this).switchClass('bg-gray', 'bg-green', function () {
            $(this).html(assign_html);
            //shareToCompanyEmployee(user_id, company_id, job_id);
            assignPositionPermission(role_id, permission_id, company_id);
        });
    }
    /*Unassign the Task List from this user*/
    if ($(this).hasClass('bg-green')) {
        $(this).switchClass('bg-green', 'bg-gray', function () {
            $(this).html(unassign_html);
            //unshareFromCompanyEmployee(user_id, company_id, job_id);
            unassignPositionPermission(role_id, permission_id, company_id);
        });
    }
});


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

$(".portlet-toggle").click(function () {
    var icon = $(this);
    icon.toggleClass("ui-icon-minusthick ui-icon-plusthick");
    icon.closest(".portlet").find(".portlet-content").toggle();
});


$('[data-toggle="tooltip"]').tooltip({
    template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner" style="max-width: 500px!important;text-align: left!important;"></div></div>',
    html: true
});

$('.employee-options').on('click', '.edit-rate', function (e) {
    e.preventDefault();

    var user_id = $(this).siblings('.user_id').val();
    var company_id = $(this).siblings('.company_id').val();
    var rate_id = $(this).siblings('.rate_id').val();

    console.log('user_id: ' + user_id);
    console.log('company_id: ' + company_id);
    console.log('rate_id: ' + rate_id);

    var edit_rate_form = public_path + 'rate/' + rate_id + '/edit';

    BootstrapDialog.show({
        title: 'Edit Rate <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>',
        size: 'size-normal',
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

                    var ajaxurl = public_path + 'rate/' + rate_id;
                    var form = $("#edit-rate-form")[0];
                    var currency = $(form).find('select[name="currency"]').val();
                    var rate_type = $(form).find('select[name="rate_type"]').val();
                    var rate_value = $(form).find('input[name="rate_value"]').val();
                    var pay_period = $(form).find('select[name="pay_period"]').val();
                    var payday;

                    switch (pay_period) {
                        case 'biweekly':

                            payday = $(form).find('select[name="biweekly-1"]').val() + ',' + $(form).find('select[name="biweekly-2"]').val();

                            break;
                        case 'weekly':

                            payday = $(form).find('select[name="weekly"]').val();

                            break;
                        case 'monthly':

                            payday = $(form).find('select[name="monthly"]').val();
                            break;
                        case 'semi-monthly':

                            payday = $(form).find('select[name="semi-monthly-1"]').val() + ',' + $(form).find('select[name="semi-monthly-2"]').val();
                            break;

                    }


                    console.log('rate type: ' + rate_type);
                    console.log('rate value: ' + rate_value);
                    console.log('pay period: ' + pay_period);
                    console.log('payday : ' + payday);
                    console.log('user_id: ' + user_id);

                    var formData = new FormData();
                    formData.append('currency', currency);
                    formData.append('rate_type', rate_type);
                    formData.append('rate_value', rate_value);
                    formData.append('pay_period', pay_period);
                    formData.append('payday', payday);
                    formData.append('user_id', user_id);
                    formData.append('company_id', company_id);
                    formData.append('_method', 'PUT');

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
                            console.log('profile id: ' + data);
                            dialog.close();
                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax*/
                }
            }],
        data: {
            'pageToLoad': edit_rate_form
        },
        onshown: function (ref) {

        },
        closable: false
    });

});

$('.add-link').on('click', function (e) {

    var add_link_form = public_path + '/addLinkForm';

    var category_id = $(this).siblings('.add_link_category_id').val();
    var company_id = $(this).siblings('.add_link_company_id').val();
    var user_id = $(this).siblings('.add_link_user_id').val();

    console.log('category_id: ' + category_id);
    console.log('company_id: ' + company_id);
    console.log('user_id: ' + user_id);

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
                    formData.append('category_id', category_id);
                    formData.append('company_id', company_id);
                    formData.append('user_id', user_id);
                    formData.append('is_dashboard', 1);

                    console.log('category_id: ' + category_id);

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
                            //var result_category_id = $(data).children('.category_id').val();
                            console.log('result_category_id: ' + category_id);

                            $('.link-group-'+category_id).append(data);

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
    var task_id = $(this).siblings('.task_id').val();
    var company_id = $('.add_link_company_id').val();
    var user_id = $('.add_link_user_id').val();

    var edit_link_form = public_path + '/editDashboardLink/' + link_id + '/' + company_id;

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

                    var ajaxurl = public_path + '/links/' + link_id;

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
                            $('#link-' + link_id).replaceWith(data);

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

    var ajaxurl = public_path + '/links/' + link_id;
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
            $('.link-' + link_id).remove();
        },
        error: function (xhr, status, error) {

        }
    }); //ajax*/
});