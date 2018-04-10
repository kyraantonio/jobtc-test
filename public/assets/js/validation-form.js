var Validate = function () {
	var handleUser = function() {
   		$('.user-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                user_role: {
	                    required: true
	                },
	                username: {
	                    required: true
	                },
	                password: {
	                    required: true
	                },
	                email: {
	                    required: true
	                },
	                name: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleProject = function() {

   		$('.project-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                project_title: {
	                    required: true
	                },
	                client_id: {
	                    required: true
	                },
	                ref_no: {
	                    required: true
	                },
	                start_date: {
	                    required: true
	                },
	                deadline: {
	                    required: true
	                },
	                rate_type: {
	                    required: true
	                },
	                rate_value: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}	
	var handleBilling = function() {

   		$('.billing-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                ref_no: {
	                    required: true
	                },
	                client_id: {
	                    required: true
	                },
	                issue_date: {
	                    required: true
	                },
	                due_date: {
	                    required: true
	                },
	                valid_date: {
	                    required: true
	                },
	                tax: {
	                    required: true,
	                    number: true
	                },
	                discount: {
	                    number: true
	                },
	                currency: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleItem = function() {

   		$('.item-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                item_name: {
	                    required: true
	                },
	                item_quantity: {
	                    required: true,
	                    number: true
	                },
	                unit_price: {
	                    required: true,
	                    number: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleBug = function() {

   		$('.bug-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                project_id: {
	                    required: true
	                },
	                ref_no: {
	                    required: true
	                },
	                reported_on: {
	                    required: true
	                },
	                bug_priority: {
	                    required: true
	                },
	                bug_status: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleClient = function() {

   		$('.client-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                company_name: {
	                    required: true
	                },
	                contact_person: {
	                    required: true
	                },
	                email: {
	                    required: true
	                },
	                country_id: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleChangePassword = function() {

   		$('.change-password-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                password: {
	                    required: true
	                },
	                new_password: {
	                    required: true
	                },
	                new_password_confirmation: {
	                    required: true,
	                    equalTo: "#new_password"
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleProfile = function() {

   		$('.profile-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                name: {
	                    required: true
	                },
	                email: {
	                    required: true,
	                    email: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleComment = function() {

   		$('.comment-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                comment: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleAttachment = function() {
   		$('.attachment-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                attachment_title: {
	                    required: true
	                },
	                attachment_description: {
	                    required: true
	                },
	                file: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleMessage = function() {
   		$('.message-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                message_subject: {
	                    required: true
	                },
	                message_content: {
	                    required: true
	                },
	                to_username: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleTaks = function() {
   		$('.task-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                task_title: {
	                    required: true
	                },
	                due_date: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleTicket = function() {

   		$('.ticket-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                ticket_subject: {
	                    required: true
	                },
	                ticket_description: {
	                    required: true
	                },
	                ticket_priority: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleAssignUser = function() {

   		$('.assign-user-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                username: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleInstall = function() {

   		$('.install-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                hostname: {
	                    required: true
	                },
	                mysql_username: {
	                    required: true
	                },
	                mysql_password: {
	                    required: true
	                },
	                mysql_database: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handlePayment = function() {

   		$('.payment-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                payment_amount: {
	                    required: true
	                },
	                payment_date: {
	                    required: true
	                },
	                payment_notes: {
	                    required: true
	                },
	                payment_type: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleGeneralSetting = function() {

   		$('.general-setting-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                company_name: {
	                    required: true
	                },
	                contact_person: {
	                    required: true
	                },
	                address: {
	                    required: true
	                },
	                city: {
	                    required: true
	                },
	                country: {
	                    required: true
	                },
	                zipcode: {
	                    required: true
	                },
	                email: {
	                    required: true
	                },
	                phone: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
	var handleSystemSetting = function() {

   		$('.system-setting-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                allowed_upload_file: {
	                    required: true
	                },
	                allowed_upload_max_size: {
	                    required: true
	                },
	                default_currency: {
	                    required: true
	                },
	                default_tax: {
	                    required: true
	                },
	                default_discount: {
	                    required: true
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	};
    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
            	format: 'dd-mm-yyyy',
                /*rtl: Metronic.isRTL(),*/
                orientation: "left",
                autoclose: true
            });
            $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }
    };

    // var handleSlider = function () {
    //     jQuery("#slider-snap-inc").slider({
    //         isRTL: Metronic.isRTL(),
    //         value: Slider_Value,
    //         min: 0,
    //         max: 100,
    //         step: 1,
    //         slide: function (event, ui) {
    //             jQuery("#slider-snap-inc-amount").text(ui.value + "% complete");
    //             jQuery("#project_progress").val(ui.value);
    //         }
    //     });
    //     jQuery("#slider-snap-inc-amount").text(jQuery("#slider-snap-inc").slider("value") + "% complete");
    //     jQuery("#project_progress").val(jQuery("#slider-snap-inc").slider("value"));
    // }

    // var handleSlider = function() {
    // 	jQuery('#slider_0').noUiSlider({
    //         direction: (Metronic.isRTL() ? "rtl" : "ltr"),
    //         start: 40,
    //         connect: "lower",
    //         range: {
    //             'min': 0,
    //             'max': 100
    //         }
    //     });
    // }

    return {
        init: function () {
            handleClient();
            handleUser();
            handleChangePassword();
            handleProfile();
            //handleProject();
            handleDatePickers();
            handleBug();
            handleItem();
            handleGeneralSetting();
            handleSystemSetting();
            handleComment();
            handleAttachment();
            handleTicket();
            handleMessage();
            //handleTaks();
            handleBilling();
            handleInstall();
            handlePayment();
            handleAssignUser();

            $(".knob").knob(); 
		    $('#chat-box').slimScroll({
		        height: '250px'
		    });
            
	            jQuery(document).on("click", ".alert_delete", function(e) {
	            var link = jQuery(this).attr("href"); 
	            e.preventDefault();    
	            bootbox.confirm("Are you sure want to proceed?", function(result) {    
	                if (result) {
	                    document.location.href = link;     
	                }    
	            });
	        });
        }
    };
}();