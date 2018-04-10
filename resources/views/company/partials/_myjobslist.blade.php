<div class="mini-space"></div>
<div class="row">
    <div class="col-md-12">
        <ul id="my_jobs_tabs" class="nav nav-tabs">
            <li class="my_jobs_tab active"><a data-toggle="pill" href="#my_jobs_list">My Jobs</a></li>
            <li class="shared_jobs_tab"><a data-toggle="pill" href="#shared_jobs_list">Shared Jobs</a></li>
        </ul>
        <div class="tab-content">
            <div id="my_jobs_list" class="tab-pane fade in active">
                <div class="job_container">
                    @foreach($my_jobs->chunk(2) as $chunk)
                    <div class="job-row row">
                        @foreach($chunk as $job)
                        <div class="col-md-6">
                            <div  class="box box-default">
                                <div class="box-container">
                                    <div class="box-header">
                                        <h3 class="box-title">
                                            <a target="_blank" href="{{url('job/'.$job->id)}}">{{$job->title}}</a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                <div class="mini-space"></div>
                <div class="job_tab_options">
                    @if(Auth::user('user')->can('create.jobs') && $module_permissions->where('slug','create.jobs')->count() === 1)
                    <a href="#" id="add-job" class="btn btn-shadow btn-default add-job">
                        <i class="fa fa-plus"></i> 
                        <strong>New Job</strong>
                    </a>
                    @endif
                    <input class="company_id" type="hidden" value="{{$company_id}}"/>
                </div>
                <div class="mini-space"></div>
            </div>
            <div id="shared_jobs_list" class="tab-pane fade in">
                @foreach($shared_jobs->chunk(2) as $chunk)
                <div class="job-row row">
                    @foreach($chunk as $job)
                    <div class="col-md-6">
                        <div  class="box box-default">
                            <div class="box-container">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <a target="_blank" href="{{url('job/'.$job->id)}}">{{$job->title}}</a>
                                    </h3>
                                    <div class="pull-right">
                                        <div class="row">
                                            <label>Shared by {{$job->user->name}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    /*Add Job*/
    $('#my_jobs_list').on('click', '#add-job', function (e) {
        e.stopImmediatePropagation();

        $(this).addClass('disabled');

        var url = public_path + 'addJobFormCompany';
        var job_container = $('.job_container');

        $.get(url, function (data) {
            job_container.append(data);
        });

    });

    $('#my_jobs_list').on('click', '.save-job', function (e) {
        e.stopImmediatePropagation();
        var url = public_path + 'addJobCompany';
        var job_container = $('.job_container');
        var company_id = $('.job_tab_options').find('.company_id').val();

        var data = {
            'job_title': $('input[name="job-title"]').val(),
            'company_id': company_id
        };

        $.post(url, data, function (data) {
            $('#add-job-form').remove();
            $('#add-job').removeClass('disabled');
            var job_count = job_container.find('.job-row').last().children().length;

            if (job_count === 1) {
                job_container.find('.job-row').last().append(data);
            } else {
                job_container.append('<div class="job-row row">' + data + '</div>');
            }


        });
    });

    $('#my_jobs_list').on('click', '.cancel-job', function (e) {
        e.stopImmediatePropagation();
        $('#add-job').removeClass('disabled');
        $('#add-job-form').remove();
    });
    
</script>