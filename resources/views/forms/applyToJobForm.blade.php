<form actions="" method="post" class="apply-to-job-form form-horizontal" role="form" novalidate="novalidate">
    {!! csrf_field() !!}
    <input type="hidden" name="remember" value="forever" />
    <div class="form-group">
        <div class="col-md-12">
            <label class="control-label col-md-2" for="name">Name</label>
            <div class="col-md-10">
                @if(isset($applicant->name))
                <input class="form-control last_name" name="name" type="text" value="{{$applicant->name}}" />
                @else
                <input class="form-control last_name" name="name" type="text" value="" />
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label class="control-label col-md-2" for="description">Email</label>
            <div class="col-md-10">
                @if(isset($applicant->email))
                <input class="form-control email" name="email" type="text" value="{{$applicant->email or ''}}" />
                @else
                <input class="form-control email" name="email" type="text" value="" />
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label class="control-label col-md-2" for="description">Password</label>
            <div class="col-md-10">
                <input id="applicant-password" class="form-control password" name="password" type="password" value="" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label class="control-label col-md-2" for="description">Confirm Password</label>
            <div class="col-md-10">
                @if(isset($applicant->password))
                <input class="form-control confirm_password" name="confirm_password" type="password" value="{{$applicant->password or ''}}" />
                @else
                <input class="form-control confirm_password" name="confirm_password" type="password" value="" />
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label class="control-label col-md-2" for="phone">Phone</label>
            <div class="col-md-10">
                @if(isset($applicant->email))
                <input class="form-control phone number-only" name="phone" type="text" value="{{$applicant->phone or ''}}" />
                @else
                <input class="form-control phone number-only" name="phone" type="text" value="" />
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label class="control-label col-md-2" for="resume">Resume</label>
            <div class="col-md-10">
                <input class="form-control file-input" name="resume" type="file" value="" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label class="control-label col-md-2" for="photo">Photo</label>
            <div class="col-md-10">
                @if(isset($applicant->photo))
                <img class="profile-pic" src="{{url($applicant->photo)}}"/>
                @endif
                <input class="form-control photo-input" name="photo" type="file" value="" />
            </div>
        </div>
    </div>
</form>
<script>

    var ajaxurl = public_path + '/checkApplicantDuplicateEmail';
    var has_photo,has_config;
    $('.number-only').numberOnly({
        'isForContact': true
    });

    @if(isset($applicant->photo))
            has_photo = ['{{url($applicant->photo)}}'];
            has_config = [{
                'width': '200px',
                'key' : 1
            }];
    @endif

    //Initially Disable the save button
    $('.save').attr('disabled', 'disabled');

    $(".apply-to-job-form").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        email: function () {
                            console.log($('.email').val());
                            return $('.email').val();
                        }
                    }
                }
            },
            password: "required",
            confirm_password : {
                required: true,
                equalTo: "#applicant-password"
            }
        },
        messages: {
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com",
                remote: "That email is already taken"
            }
        }
    }).form();

    //Enable save button when email is valid
    $('.apply-to-job-form').on('keyup blur', function () { // fires on every keyup & blur
        if ($('.apply-to-job-form').valid()) {                   // checks form for validity
            $('.save').attr('disabled', false);
        } else {
            $('.save').attr('disabled', 'disabled');
        }
    });

    $('.file-input').fileinput({
        overwriteInitial: true,
        uploadAsync: false,
        maxFileSize: 1000000,
        removeClass: "btn btn-sm btn-delete btn-shadow",
        browseClass: "btn btn-sm btn-edit btn-shadow",
        browseLabel: 'Browse Document..',
        uploadClass: "btn btn-sm btn-assign hide btn-shadow",
        cancelClass: "btn btn-sm btn-default btn-shadow",
        maxFilesNum: 5,
        showRemove: false,
        showCaption: false,
        dropZoneEnabled: false,
        showUpload: true,
        initialPreviewAsData: true
    });
    $('.photo-input').fileinput({
        uploadAsync: true,
        maxFileSize: 1000000,
        removeClass: "btn btn-sm btn-delete btn-shadow",
        browseClass: "btn btn-sm btn-edit btn-shadow",
        browseLabel: 'Browse Photo..',
        uploadClass: "btn btn-sm btn-assign hide btn-shadow",
        cancelClass: "btn btn-sm btn-default btn-shadow",
        showRemove: false,
        showCaption: false,
        initialPreviewFileType: ['image'],
        dropZoneEnabled: false,
        showUpload: true,
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: has_photo,
        initialPreviewConfig: has_config
    });
</script>