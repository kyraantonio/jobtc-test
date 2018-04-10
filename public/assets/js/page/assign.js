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
                $(ui.item).find('.employee-toggle').attr('href', '#employee-toggle-' + user_id + '-' + project_id);
                $(ui.item).find('.briefcase-container').attr('id', 'employee-toggle-' + user_id + '-' + project_id);
                $(ui.item).find('.briefcase-container').html(data);
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

    $('#search-field-projects').on('keypress', function (e) {
        if (e.which == 13) {
            var term = $(this).val();
            var company_id = $(this).siblings('.company_id').val();
            var search_url = public_path + 'searchProjects';
            var search_data = {
                'company_id': company_id,
                'term': term
            };

            if (term !== '') {
                $.post(search_url, search_data, function (data) {
                    $('#assign_my_projects').html(data);
                    searchProjectsPagination(search_data);
                });
            } else {
                var all_projects_url = public_path + 'assignProjects/' + company_id;

                $('#assign_my_projects').load(all_projects_url + ' #assign_my_projects', function () {
                    projectsPagination();
                });
            }
        }
    });

    $('#search-field-employees').on('keypress', function (e) {
        if (e.which == 13) {
            var term = $(this).val();
            var company_id = $(this).siblings('.company_id').val();
            var search_url = public_path + 'searchEmployees';
            var search_data = {
                'company_id': company_id,
                'term': term,
                'url': 'assignProjects'
            };

            if (term !== '') {
                $.post(search_url, search_data, function (data) {
                    $('#assign_my_project_employees').html(data);
                    searchEmployeesPagination(search_data);
                });
            } else {
                var all_employees_url = public_path + 'assignProjects/' + company_id;
                $('#assign_my_project_employees').load(all_employees_url + ' #assign_my_project_employees', function () {
                    employeesPagination();
                });
            }
        }
    });

    $('#search-field-companies').on('keypress', function (e) {
        if (e.which == 13) {
            var term = $(this).val();
            var company_id = $(this).siblings('.company_id').val();
            var search_url = public_path + 'searchCompanies';
            var search_data = {
                'company_id': company_id,
                'term': term,
                'url': 'assignProjects'
            };

            if (term !== '') {
                $.post(search_url, search_data, function (data) {
                    $('#assign_my_project_companies').html(data);
                    searchCompaniesPagination(search_data);
                });
            } else {
                var all_companies_url = public_path + 'assignProjects/' + company_id;
                $('#assign_my_project_companies').load(all_companies_url + ' #assign_my_project_companies', function () {
                    companiesPagination();
                });
            }
        }
    });

    //For Project Pagination 
    projectsPagination();
    employeesPagination();
    companiesPagination();

    //Pagination needed when page is loaded the first time
    function projectsPagination() {
        $('#assign_my_projects .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $('#assign_my_projects').load(url + ' #assign_my_projects', function (e) {
                assignProjectsScripts();
            });
        });
    }

    //Pagination needed when page is loaded the first time
    function employeesPagination() {
        $('#assign_my_project_employees .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $('#assign_my_project_employees').load(url + ' #assign_my_project_employees', function (e) {
                assignProjectsScripts();
            });
        });
    }

    //Pagination needed when page is loaded the first time
    function companiesPagination() {
        $('#assign_my_project_companies .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $('#assign_my_project_companies').load(url + ' #assign_my_project_companies', function (e) {
                assignProjectsScripts();
            });
        });
    }

    /*Pagination when item is searched*/
    function searchProjectsPagination(search_data) {
        $('#assign_my_projects .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $.post(url, search_data, function (data) {
                $('#assign_my_projects').html(data);
                searchProjectsPagination(search_data);
                assignProjectsScripts();
            });
        });
    }

    /*Pagination when item is searched*/
    function searchEmployeesPagination(search_data) {
        $('#assign_my_project_employees .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $.post(url, search_data, function (data) {
                $('#assign_my_project_employees').html(data);
                searchEmployeesPagination(search_data);
                assignProjectsScripts();
            });
        });
    }

    /*Pagination when item is searched*/
    function searchCompaniesPagination(search_data) {
        $('#assign_my_project_companies .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $.post(url, search_data, function (data) {
                $('#assign_my_project_companies').html(data);
                searchCompaniesPagination(search_data);
                assignProjectsScripts();
            });
        });
    }
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

        data = {
            'test_id': test_id,
            'job_id': job_id
        };

        url = public_path + 'unassignTestFromJob';

        $.post(url, data);

    });

    $('#search-field-tests').on('keypress', function (e) {
        if (e.which == 13) {
            var term = $(this).val();
            var company_id = $(this).siblings('.company_id').val();
            var search_url = public_path + 'searchTests';
            var search_data = {
                'company_id': company_id,
                'term': term
            };

            if (term !== '') {
                $.post(search_url, search_data, function (data) {
                    $('#assign_my_tests').html(data);
                    searchTestsPagination(search_data);
                });
            } else {
                var all_employees_url = public_path + 'assignTests/' + company_id;
                $('#assign_my_tests').load(all_employees_url + ' #assign_my_tests', function () {
                    testsPagination();
                });
            }
        }
    });

    $('#search-field-jobs').on('keypress', function (e) {
        if (e.which == 13) {
            var term = $(this).val();
            var company_id = $(this).siblings('.company_id').val();
            var search_url = public_path + 'searchJobs';
            var search_data = {
                'company_id': company_id,
                'term': term,
                'url': 'assignTests'
            };

            if (term !== '') {
                $.post(search_url, search_data, function (data) {
                    $('#assign_my_jobs').html(data);
                    searchJobsPagination(search_data);
                });
            } else {
                var all_employees_url = public_path + 'assignTests/' + company_id;
                console.log(all_employees_url);
                $('#assign_my_jobs').load(all_employees_url + ' #assign_my_jobs', function () {
                    jobsPagination();
                });
            }
        }
    });
    
    $('#search-field-applicants').on('keypress', function (e) {
        if (e.which == 13) {
            var term = $(this).val();
            var company_id = $(this).siblings('.company_id').val();
            var job_id = $(this).siblings('.job_id').val();
            var search_url = public_path + 'searchApplicants';
            var search_data = {
                'job_id': job_id,
                'company_id': company_id,
                'term': term,
                'url': 'assignTests'
            };

            if (term !== '') {
                $.post(search_url, search_data, function (data) {
                    $('#assign_my_applicants-'+job_id).html(data);
                    searchApplicantsPagination(search_data,job_id);
                });
            } else {
                var all_applicants_url = public_path + 'assignTests/' + company_id;
                $('#assign_my_applicants-'+job_id).load(all_applicants_url + ' #assign_my_applicants-'+job_id, function () {
                    applicantsPagination();
                });
            }
        }
    });

    testsPagination();
    jobsPagination();
    applicantsPagination();

    function applicantsPagination() {
        $('.assign_my_applicants .pagination').on('click', 'a', function (e) {
            //e.preventDefault();
            e.stopImmediatePropagation();

            var job_id = $(this).siblings().find('.job_id').val();
            var url = $(this).attr('href');
            $('#assign_my_applicants-' + job_id).load(url + ' #assign_my_applicants-' + job_id, function (e) {
                assignTestsScripts();
            });
        });
    }

    //Pagination needed when page is loaded the first time
    function jobsPagination() {
        $('#assign_my_jobs .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $('#assign_my_jobs').load(url + ' #assign_my_jobs', function (e) {
                assignTestsScripts();
            });
        });
    }

    //Pagination needed when page is loaded the first time
    function testsPagination() {
        $('#assign_my_tests .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $('#assign_my_tests').load(url + ' #assign_my_tests', function (e) {
                assignTestsScripts();
            });
        });
    }

    /*Pagination when item is searched*/
    function searchJobsPagination(search_data) {
        $('#assign_my_jobs .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $.post(url, search_data, function (data) {
                $('#assign_my_jobs').html(data);
                searchJobsPagination(search_data);
                assignTestsScripts();
            });
        });
    }
    
    /*Pagination when item is searched*/
    function searchTestsPagination(search_data) {
        $('#assign_my_tests .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $.post(url, search_data, function (data) {
                $('#assign_my_tests').html(data);
                searchTestsPagination(search_data);
                assignTestsScripts();
            });
        });
    }
    
    /*Pagination when item is searched*/
    function searchApplicantsPagination(search_data,job_id) {
        $('#assign_my_applicants-'+job_id+' .pagination').on('click', 'a', function (e) {
            //e.preventDefault();
            //e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $.post(url, search_data, function (data) {
                $('#assign_my_applicants-'+job_id).html(data);
                searchApplicantsPagination(search_data,job_id);
                assignTestsScripts();
            });
        });
    }

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

    $('#search-field-jobs').on('keypress', function (e) {
        if (e.which == 13) {
            var term = $(this).val();
            var company_id = $(this).siblings('.company_id').val();
            var search_url = public_path + 'searchJobs';
            var search_data = {
                'company_id': company_id,
                'term': term,
                'url': 'assignJobs'
            };

            if (term !== '') {
                $.post(search_url, search_data, function (data) {
                    $('#assign_my_jobs').html(data);
                    searchJobsPagination(search_data);
                });
            } else {
                var all_jobs_url = public_path + 'assignJobs/' + company_id;

                $('#assign_my_jobs').load(all_jobs_url + ' #assign_my_jobs', function () {
                    jobsPagination();
                });
            }
        }
    });

    $('#search-field-employees').on('keypress', function (e) {
        if (e.which == 13) {
            var term = $(this).val();
            var company_id = $(this).siblings('.company_id').val();
            var search_url = public_path + 'searchEmployees';
            var search_data = {
                'company_id': company_id,
                'term': term,
                'url': 'assignJobs'
            };

            if (term !== '') {
                $.post(search_url, search_data, function (data) {
                    $('#assign_my_jobs_employees').html(data);
                    searchEmployeesPagination(search_data)
                });
            } else {
                var all_employees_url = public_path + 'assignJobs/' + company_id;

                $('#assign_my_jobs_employees').load(all_employees_url + ' #assign_my_jobs_employees', function () {
                    employeesPagination();
                });
            }
        }
    });

    $('#search-field-companies').on('keypress', function (e) {
        if (e.which == 13) {
            var term = $(this).val();
            var company_id = $(this).siblings('.company_id').val();
            var search_url = public_path + 'searchCompanies';
            var search_data = {
                'company_id': company_id,
                'term': term,
                'url': 'assignJobs'
            };

            if (term !== '') {
                $.post(search_url, search_data, function (data) {
                    $('#share_jobs_companies').html(data);
                    searchCompaniesPagination(search_data);
                });
            } else {
                var all_companies_url = public_path + 'assignJobs/' + company_id;
                $('#share_jobs_companies').load(all_companies_url + ' #share_jobs_companies', function () {
                    companiesPagination();
                });
            }
        }
    });

    jobsPagination();
    employeesPagination();
    companiesPagination();

    //Pagination needed when page is loaded the first time
    function jobsPagination() {
        $('#assign_my_jobs .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $('#assign_my_jobs').load(url + ' #assign_my_jobs', function (e) {
                shareJobsScripts();
            });
        });
    }

    //Pagination needed when page is loaded the first time
    function employeesPagination() {
        $('#assign_my_jobs_employees .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $('#assign_my_jobs_employees').load(url + ' #assign_my_jobs_employees', function (e) {
                shareJobsScripts();
            });
        });
    }

    //Pagination needed when page is loaded the first time
    function companiesPagination() {
        $('#share_jobs_companies .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $('#share_jobs_companies').load(url + ' #share_jobs_companies', function (e) {
                shareJobsScripts();
            });
        });
    }

    /*Pagination when item is searched*/
    function searchJobsPagination(search_data) {
        $('#assign_my_jobs .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $.post(url, search_data, function (data) {
                $('#assign_my_jobs').html(data);
                searchJobsPagination(search_data);
                shareJobsScripts();
            });
        });
    }
    
    /*Pagination when item is searched*/
    function searchCompaniesPagination(search_data) {
        $('#share_jobs_companies .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $.post(url, search_data, function (data) {
                $('#share_jobs_companies').html(data);
                searchCompaniesPagination(search_data);
                shareJobsScripts();
            });
        });
    }
    
    /*Pagination when item is searched*/
    function searchEmployeesPagination(search_data) {
        $('#assign_my_jobs_employees .pagination').on('click', 'a', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var url = $(this).attr('href');
            $.post(url, search_data, function (data) {
                $('#assign_my_jobs_employees').html(data);
                searchEmployeesPagination(search_data);
                shareJobsScripts();
            });
        });
    }

}

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

//Initialize Scripts

if (window.location.href.indexOf("assignProjects") > -1) {
    assignProjectsScripts();
}
if (window.location.href.indexOf("assignTests") > -1) {
    assignTestsScripts();
}

if (window.location.href.indexOf("assignAuthorityLevels") > -1) {
    assignAuthorityLevels();
}
if (window.location.href.indexOf("assignJobs") > -1) {
    shareJobsScripts();
}
