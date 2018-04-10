/* 
 * Discussion Page scripts
 */

$('.create-room').click(function (e) {
    //e.preventDefault();
    //e.stopImmediatePropagation();
    var create_discussions_room_form = public_path + '/discussions/create';

    BootstrapDialog.show({
        title: 'Create Discussion Room',
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
                    var ajaxurl = public_path + 'discussions';

                    var formData = new FormData();
                    var room_name = $('.room_name').val();
                    var room_type = $('.room_type').val();
                    formData.append('room_name', room_name);
                    formData.append('room_type', room_type);

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
                            var row = "<tr>" +
                                    "<td>" + json_data.room_name + "</td>" +
                                    "<td>" + json_data.room_type + "</td>" +
                                    "<td>" +
                                    "<div class='btn-group'>" +
                                    "<a target='_blank' href='" + public_path + 'discussions/' + json_data.id + "' class='btn btn-success create-room'>Join</a>" +
                                    "<a target='_blank' href='" + public_path + 'discussions/' + json_data.id + "/edit' class='btn btn-success edit-room'>Edit</a>" +
                                    "<a target='_blank' href='" + public_path + 'discussions/' + json_data.id + "' class='btn btn-success delete-room'>Delete</a>" +
                                    "<input class='room_id' type='hidden' value='{{$discussion->id}}' />" +
                                    "</div>" +
                                    "</td>" +
                                    "</tr>";





                            $('.table').append(row);
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
            'pageToLoad': create_discussions_room_form
        },
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });
});

$('body').on('click', '.edit-room', function (e) {
    e.preventDefault();
    var room_id = $(this).siblings('.room_id').val();

    var edit_discussions_room_form = public_path + '/discussions/' + room_id + '/edit';

    BootstrapDialog.show({
        title: 'Edit Discussion Room',
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
                    var ajaxurl = public_path + 'discussions/' + room_id;

                    var formData = new FormData();
                    var room_name = $('.room_name').val();
                    var room_type = $('.room_type').val();

                    formData.append('room_name', room_name);
                    formData.append('room_type', room_type);
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

                            var json_data = JSON.parse(data);
                            $('#room_name-' + json_data.id).text(json_data.room_name);
                            $('#room_type-' + json_data.id).text(json_data.room_type);
                            if (json_data.room_type === 'public') {
                                $('#room_link-' + json_data.id).attr('href', public_path + 'discussions/' + json_data.id + '/public');
                            } else {
                                $('#room_link-' + json_data.id).attr('href', public_path + 'discussions/' + json_data.id);
                            }
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
            'pageToLoad': edit_discussions_room_form
        },
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });
});

$('body').on('click', '.delete-room', function (e) {
    e.preventDefault();

    var room_id = $(this).siblings('.room_id').val();

    BootstrapDialog.show({
        title: 'Delete Discussion Room',
        size: 'size-normal',
        message: 'Delete Room?',
        buttons: [{
                label: 'Ok',
                cssClass: 'btn-edit btn-shadow',
                action: function (dialog) {
                    var ajaxurl = public_path + 'discussions/' + room_id;

                    var formData = new FormData();
                    formData.append('_method', 'DELETE');

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
                            $('#room_name-' + data).parent().remove();
                            dialog.close();

                        },
                        error: function (xhr, status, error) {

                        }
                    }); //ajax
                }
            }, {
                label: 'Cancel',
                cssClass: 'btn-delete btn-shadow',
                action: function (dialog) {
                    dialog.close();
                }
            }],
        onshown: function (ref) {
            //initCkeditor(ref);
        },
        closable: false
    });
});
