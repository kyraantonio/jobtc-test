<form actions="" method="post" class="edit-applicant-password-form form-horizontal" role="form" novalidate="novalidate">
    <div class="form-group">
        {!!  Form::input('password','current_password','',['id' => 'current_password', 'class' => 'form-control', 'placeholder' =>
        'Current Password']) !!}
    </div>
    <div class="form-group">
        {!!  Form::input('password','new_password','',['id' => 'new_password', 'class' => 'form-control', 'placeholder' =>
        'New Password']) !!}
    </div>
    <div class="form-group">
        {!!  Form::input('password','confirm_password','',['id' => 'confirm_password', 'class' => 'form-control', 'placeholder' =>
        'Confirm Password']) !!}
    </div>
    <input class="applicant_id" type="hidden" value="{{$applicant_id}}" />
</form>
<script>
    var ajaxurl = public_path + 'checkApplicantPassword';
    $(".edit-applicant-password-form").validate({        
        rules: {
            current_password: {
                remote: {
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        applicant_id: $('.applicant_id').val(),
                        current_password: function() {
                            console.log($('#current_password').val());
                           return $('#current_password').val();
                        }
                    }
                }
            },
            confirm_password: {
                equalTo: "#new_password"
            }
        },
        messages: {
            current_password: {
                remote: "incorrect password"
            }
        }
    }).form();
    
    $('#current_password').on('keyup blur', function () { // fires on every keyup & blur
        if ($('#current_password').valid()) {                   // checks form for validity
            $('.save-password').attr('disabled', false);
        } else {
            $('.save-password').attr('disabled', true);
        }
    });
    
    $('#confirm_password').on('keyup blur', function () { // fires on every keyup & blur
        if ($('#confirm_password').valid() && $('#current_password').valid()) {   
            $('.save-password').attr('disabled', false);        // enables button
        } else {
            $('.save-password').attr('disabled', true);
        }
    });
</script>
