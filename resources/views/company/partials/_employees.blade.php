<div class="employee-container">
    @foreach($profiles->chunk(2) as $chunk)
    <div class="row employee-row">
        @foreach($chunk as $profile)
        @include('user.partials._newemployee')
        @endforeach
    </div>
    @endforeach
</div>
<div class="mini-space"></div>
<div class="row">
    <div class="employee_tab_options">
        @if(Auth::user('user')->can('create.employees') && $module_permissions->where('slug','create.employees')->count() === 1)
        <a href="#" id="add-employee" class="btn btn-shadow btn-default add-employee">
            <i class="fa fa-plus"></i> 
            <strong>New Employee</strong>
        </a>
        @endif
        <input class="company_id" type="hidden" value="{{$company_id}}"/>
    </div>
</div>

<script>
    /*Add Employee*/
    $('#employees').on('click', '#add-employee', function (e) {
        e.stopImmediatePropagation();
        $(this).addClass('disabled');

        var url = public_path + 'addEmployeeForm';
        var employee_container = $('.employee-container');

        $.get(url, function (data) {
            employee_container.append(data);
        });
    });

    $('#employees').on('click', '.save-employee', function (e) {
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
    });

    $('#employees').on('click', '.cancel-employee', function (e) {
        e.stopImmediatePropagation();
        $('#add-employee').removeClass('disabled');
        $('#add-employee-form').remove();
    });

    /*
     * Employee Options      
     **/

    $('#employees').on('click', '.edit-employee', function (e) {
        e.preventDefault();
        var user_id = $(this).siblings('.user_id').val();
        var edit_employee_form = public_path + 'editEmployeeForm/'+user_id;
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
                        
                        var form = $(".edit-employee-form")[0];

                        var formData = new FormData(form);
                        formData.append('user_id', user_id);

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

</script>
