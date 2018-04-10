/* 
 * Payroll Scripts
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

$(document).ready(function () {
    $('#filter').removeClass('hidden');

//Filter Scripts
    $('#filter').change(function () {
        var filter_val = $('#filter').val();
        var company_id = $('.company_id').val();
        var date = $('.date').val();
        var date_today = $('.date_today').val();

        var ajaxurl;

        if (filter_val === 'day') {
            var day_text = moment(date_today).format('MMM DD, YYYY');
            var day = moment(date_today).format('YYYY-MM-DD');
            $('.date-text').text(day_text);
            $('.date').val(day);

            if ($('.filter-next').length === 1) {
                $('.filter-next').remove();
            }

            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + day;
        }

        if (filter_val === 'week') {
            var day = moment(date_today).format('YYYY-MM-DD');
            $('.date').val(day);

            var week_number = moment(day).format('W');
            var this_weeks_monday = moment().startOf('isoweek').format('ddd MMM DD, YYYY');
            var this_weeks_sunday = moment(this_weeks_monday).add(6, 'days').format('ddd MMM DD, YYYY');


            $('.date-text').text(this_weeks_monday + " - " + this_weeks_sunday);

            if ($('.filter-next').length === 1) {
                $('.filter-next').remove();
            }

            console.log("week_number: " + week_number);
            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + day + '-' + week_number;
        }

        if (filter_val === 'month') {
            var date_month = $('.date_month').val();
            var date_year = $('.date_year').val();
            var day = moment(date_today).format('YYYY-MM-DD');

            var month = moment(date_today).format('MMMM YYYY');
            var month_number = moment(date_today).format('MM-DD-YYYY');
            $('.date-text').text(month);
            $('.date').val(day);

            if ($('.filter-next').length === 1) {
                $('.filter-next').remove();
            }

            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + month_number;
        }

        if (filter_val === 'year') {
            var date_year = $('.date_year').val();
            var year = moment(date_year).format('YYYY');
            $('.date-text').text(year);
            $('.date').val(year);

            if ($('.filter-next').length === 1) {
                $('.filter-next').remove();
            }

            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + year;
        }

        filter(ajaxurl);

    });

//Payment History Filter Scripts
    $('#payment-history-filter').change(function () {
        var filter_val = $('#payment-history-filter').val();
        var company_id = $('.company_id').val();
        var date = $('.date').val();
        var date_today = $('.date_today').val();

        var ajaxurl;

        if (filter_val === 'monthly') {

        }

        if (filter_val === 'semi-monthly') {

        }

        if (filter_val === 'biweekly') {

        }

        if (filter_val === 'weekly') {

        }
    });

    $('.date-label').on('click', '.filter-previous', function () {
        var company_id = $('.company_id').val();
        var filter_val = $('#filter').val();
        var date = $('.date').val();

        var date_previous;
        var date_previous_text;
        var ajaxurl;

        if (filter_val === 'day') {
            date_previous = moment(date).subtract(1, 'days').format('YYYY-MM-DD');
            date_previous_text = moment(date).subtract(1, 'days').format('MMM DD, YYYY');
            console.log('date_previous: ' + date_previous);

            $('.date').val(date_previous);
            $('.date-text').text(date_previous_text);
            if ($('.filter-next').length === 0) {
                $('.date-options').append('<button class="btn btn-primary filter-next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>&nbsp;Next</button>');
            }

            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + date_previous;
        }

        if (filter_val === 'week') {
            var week_number = moment(date).subtract(1, 'weeks').format('W');
            var previous_weeks_monday = moment(date).startOf('isoweek').subtract(1, 'weeks').format('ddd MMM DD, YYYY');
            var previous_weeks_sunday = moment(previous_weeks_monday).add(6, 'days').format('ddd MMM DD, YYYY');

            var date_previous = moment(date).startOf('isoweek').subtract(1, 'weeks').format('YYYY-MM-DD');
            $('.date-text').text(previous_weeks_monday + " - " + previous_weeks_sunday);
            $('.date').val(date_previous);
            if ($('.filter-next').length === 0) {
                $('.date-options').append('<button class="btn btn-primary filter-next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>&nbsp;Next</button>');
            }
            console.log("week_number: " + week_number);
            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + date + '-' + week_number;
        }

        if (filter_val === 'month') {
            var date_month = $('.date_month').val();
            var date_year = $('.date_year').val();

            date_previous = moment(date).subtract(1, 'month').format('MM-DD-YYYY');
            date_previous_text = moment(date).subtract(1, 'month').format('MMMM YYYY');

            console.log(date_previous);

            $('.date').val(date_previous);
            $('.date-text').text(date_previous_text);
            if ($('.filter-next').length === 0) {
                $('.date-options').append('<button class="btn btn-primary filter-next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>&nbsp;Next</button>');
            }
            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + date_previous;
        }

        if (filter_val === 'year') {
            date_previous = moment(date).subtract(1, 'years').format('YYYY');
            date_previous_text = moment(date).subtract(1, 'years').format('YYYY');
            console.log('date_previous: ' + date_previous);

            $('.date').val(date_previous);
            $('.date-text').text(date_previous_text);
            if ($('.filter-next').length === 0) {
                $('.date-options').append('<button class="btn btn-primary filter-next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>&nbsp;Next</button>');
            }
            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + date_previous;
        }

        filter(ajaxurl);

    });

    $('.date-label').on('click', '.filter-next', function () {
        var date = $('.date').val();
        var date_today = $('.date_today').val();
        var filter_val = $('#filter').val();
        var company_id = $('.company_id').val();
        var date_next;
        var date_next_text;
        var ajaxurl;

        if (filter_val === 'day') {
            date_next = moment(date).add(1, 'days').format('YYYY-MM-DD');
            date_next_text = moment(date).add(1, 'days').format('MMM DD, YYYY');
            console.log('date_next: ' + date_next);
            $('.date').val(date_next_text);
            $('.date-text').text(date_next_text);
            if (date_today === date_next) {
                $('.filter-next').remove();
            }
            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + date_next;
        }

        if (filter_val === 'week') {
            var week_number = moment(date).add(1, 'weeks').format('W');
            var next_weeks_monday = moment(date).startOf('isoweek').add(1, 'weeks').format('ddd MMM DD, YYYY');
            var next_weeks_sunday = moment(next_weeks_monday).add(6, 'days').format('ddd MMM DD, YYYY');

            var date_next = moment(date).startOf('isoweek').add(1, 'weeks').format('YYYY-MM-DD');
            $('.date-text').text(next_weeks_monday + " - " + next_weeks_sunday);
            $('.date').val(date_next);
            if ($('.filter-next').length === 0) {
                $('.date-options').append('<button class="btn btn-primary filter-next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>&nbsp;Next</button>');
            }
            console.log("week_number: " + week_number);

            var week_today = moment(date_today).format('W');

            if (week_today === week_number) {
                $('.filter-next').remove();
            }

            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + date + '-' + week_number;
        }

        if (filter_val === 'month') {
            var date_month = $('.date_month').val();
            var date_year = $('.date_year').val();
            date_next = moment(date).add(1, 'month').format('MM-DD-YYYY');
            date_next_text = moment(date).add(1, 'month').format('MMMM YYYY');
            console.log('date_next: ' + date_next);
            $('.date').val(date_next);
            $('.date-text').text(date_next_text);

            var date_month_today = moment(date_today).format('MM');
            var date_next_month = moment(date).add(1, 'month').format('MM');

            if (date_month_today === date_next_month) {
                $('.filter-next').remove();
            }

            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + date_next;
        }

        if (filter_val === 'year') {
            date_next = moment(date).add(1, 'year').format('YYYY-MM-DD');
            date_next_text = moment(date).add(1, 'year').format('YYYY');
            console.log('date_next: ' + date_next);
            $('.date').val(date_next_text);
            $('.date-text').text(date_next_text);

            var date_year_today = moment(date_today).format('YYYY');
            var date_next_year = moment().format('YYYY');

            if (date_year_today === date_next_year) {
                $('.filter-next').remove();
            }

            ajaxurl = public_path + 'payroll/filter/' + company_id + '/' + filter_val + '/' + date_next;
        }

        filter(ajaxurl);
    });

    $('#payment-history-tab').click(function () {
        console.log('Clicked payment history');
        var company_id = $('.company_id').val();
        var ajaxurl = public_path + 'payroll/paymentHistory/' + company_id;
        getPaymentHistory(ajaxurl);
    });

    $('#payroll-settings-tab').click(function () {
        console.log('Clicked payment history');
        var company_id = $('.company_id').val();
        var ajaxurl = public_path + 'payroll/payrollSettings/' + company_id;
        getPayrollSettings(ajaxurl);
    });


    //Add Global Payroll Column
    $('body').on('click', '#add-column', function () {
        var add_column_form = public_path + '/addPayrollColumnForm';

        BootstrapDialog.show({
            title: 'Add Payroll Column',
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
                        var ajaxurl = public_path + '/addPayrollColumn';
                        var form = $("#add-payroll-column-form")[0];

                        var formData = new FormData(form);
                        var column_name = $(form).find('input[name="column_name"]').val();
                        var column_type = $(form).find('select[name="column_type"]').val();
                        var default_value = $(form).find('input[name="default_value"]').val();

                        console.log(column_name);
                        console.log(column_type);
                        console.log(default_value);

                        formData.append('column_name', column_name);
                        formData.append('column_type', column_type);
                        formData.append('default_value', default_value);

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
                                $('#payroll-settings-table').html(data);
                                dialog.close();
                            },
                            error: function (xhr, status, error) {

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
                'pageToLoad': add_column_form
            },
            onshown: function (ref) {
                //initCkeditor(ref);
            },
            closable: false
        });
    });
    $('body').on('click', '.edit-column', function () {

        var column_id = $(this).siblings('.column_id').val();
        console.log(column_id);
        var edit_column_form = public_path + '/editPayrollColumnForm/' + column_id;

        BootstrapDialog.show({
            title: 'Edit Payroll Column',
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
                        var ajaxurl = public_path + '/editPayrollColumn';
                        var form = $("#edit-payroll-column-form")[0];

                        var formData = new FormData(form);
                        var column_name = $(form).find('input[name="column_name"]').val();
                        var column_type = $(form).find('select[name="column_type"]').val();
                        var default_value = $(form).find('input[name="default_value"]').val();

                        console.log(column_name);
                        console.log(column_type);
                        console.log(default_value);

                        formData.append('column_name', column_name);
                        formData.append('column_type', column_type);
                        formData.append('default_value', default_value);
                        formData.append('column_id', column_id);
                        //formData.append('_method', 'PUT');

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
                                $('#payroll-settings-table').html(data);
                                dialog.close();
                            },
                            error: function (xhr, status, error) {

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
                'pageToLoad': edit_column_form
            },
            onshown: function (ref) {
                //initCkeditor(ref);
            },
            closable: false
        });
    });
    $('body').on('click', '.delete-column', function () {

        var column_id = $(this).siblings('.column_id').val();

        var ajaxurl = public_path + '/deletePayrollColumn';

        var formData = new FormData();
        formData.append('column_id', column_id);
        //formData.append('_method', 'PUT');

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
                $('#payroll-settings-table').html(data);

            },
            error: function (xhr, status, error) {

            }
        }); //ajax

    });

    //Add Global Pay Period
    $('body').on('click', '#add-pay-period', function () {
        var add_column_form = public_path + '/addPayPeriodForm';

        BootstrapDialog.show({
            title: 'Add Pay Period',
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
                        var ajaxurl = public_path + '/addPayrollColumn';
                        var form = $("#add-payroll-column-form")[0];

                        var formData = new FormData(form);
                        var column_name = $(form).find('input[name="column_name"]').val();
                        var default_value = $(form).find('input[name="default_value"]').val();

                        console.log(column_name);
                        console.log(default_value);

                        formData.append('column_name', column_name);
                        formData.append('default_value', default_value);

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
                                $('#payroll-settings-table').html(data);
                                dialog.close();
                            },
                            error: function (xhr, status, error) {

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
                'pageToLoad': add_column_form
            },
            onshown: function (ref) {
                //initCkeditor(ref);
            },
            closable: false
        });
    });

    $('.date-label').on('click', '.payment-history-previous', function () {
        var company_id = $('.company_id').val();
        var filter_val = $('#filter').val();
        var date = $('.date').val();

        var date_previous;
        var date_previous_text;
        var ajaxurl;

    });

    $('.date-label').on('click', '.payment-history-next', function () {
        var company_id = $('.company_id').val();
        var filter_val = $('#filter').val();
        var date = $('.date').val();

        var date_previous;
        var date_previous_text;
        var ajaxurl;

    });


    $('body').on('click', '.pay-employee', function () {
        var text = $(this).find('.pay-employee-text').text();
        var ajaxurl = public_path + '/editPaymentStatus';
        var profile_id = $(this).siblings('.profile_id').val();
        var formData = new FormData();
        if (text === 'Pay') {
            $(this).find('.pay-employee-text').text('Paid');
            $('.payroll-status-'+profile_id).text('Paid');
            $(this).find('i').replaceWith('<i class="fa fa-check-circle" aria-hidden="true"></i>');
            formData.append('profile_id', profile_id);
            formData.append('status','Paid');
            editPayrollStatus(ajaxurl, formData);
        } else {
            $(this).find('.pay-employee-text').text('Pay');
            $('.payroll-status-'+profile_id).text('Unpaid');
            $(this).find('i').replaceWith('<i class="fa fa-minus-circle" aria-hidden="true"></i>');
            formData.append('profile_id', profile_id);
            formData.append('status','Unpaid');
            editPayrollStatus(ajaxurl, formData);
        }
    });

});

function addColumn(column_name, default_value) {

}


function filter(ajaxurl) {
    $.ajax({
        url: ajaxurl,
        type: "GET",
        beforeSend: function () {
        },
        success: function (data) {
            $('#payroll-table-container').html(data);
        },
        error: function (xhr, status, error) {

        }
    }); //ajax
}

function getPaymentHistory(ajaxurl) {
    $.ajax({
        url: ajaxurl,
        type: "GET",
        beforeSend: function () {
        },
        success: function (data) {
            $('#payment-history').html(data);
            $('#payment-history-filter').removeClass('hidden');

            var base_url = window.location.origin;
            //Bootstrap select doesn't refresh automatically if the dropdown is loaded via AJAX
            $('#payment-history-filter').selectpicker('refresh');

        },
        error: function (xhr, status, error) {

        }
    }); //ajax
}

function getPayrollSettings(ajaxurl) {
    $.ajax({
        url: ajaxurl,
        type: "GET",
        beforeSend: function () {
        },
        success: function (data) {
            $('#payroll-settings').html(data);
        },
        error: function (xhr, status, error) {

        }
    }); //ajax
}

function editPayrollStatus(ajaxurl, formData) {
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
    });
}