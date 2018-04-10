@foreach($jobs as $job)
<div class="row">
    <div id="job-{{$job->id}}" class="portlet">
        <div class="portlet-header">
            @if($job->photo !== '')
            <img src="{{url($job->photo)}}" class="img-rounded" alt="Job Photo" width="50" height="50">
            @endif
            &nbsp;
            <span>{{$job->title}}&nbsp;({{$job->company['name']}})</span>
        </div>
        <div class="portlet-content">
            <div class="company-info">

            </div>
            <div class="job-info">
                {!! $job->description !!}
            </div>
            <div class="job-options pull-right">
                @if($job->applicant_jobs->where('job_id',$job->id)->where('user_id',Auth::user()->user_id)->count() === 1)
                <a href="#" disabled="disabled" class="btn btn-edit btn-sm btn-shadow"> Applied</a>
                @else
                <a href="#" class="btn btn-edit btn-sm btn-shadow apply-to-job"> Apply</a>
                @endif
                <input class="job_id" type="hidden" value="{{$job->id}}"/>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
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

    $(".portlet-toggle").on("click", function () {
        var icon = $(this);
        icon.toggleClass("ui-icon-minusthick ui-icon-plusthick");
        icon.closest(".portlet").find(".portlet-content").toggle();
    });


    $('.apply-to-job').click(function () {
        console.log('Applying to Job');
        var ajaxurl = public_path + 'dashboardApplyToJob';
        var job_id = $(this).siblings('.job_id').val();
        
        var formData = new FormData();
        formData.append('job_id',job_id);
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
        }); //ajax*/
    });
</script>
