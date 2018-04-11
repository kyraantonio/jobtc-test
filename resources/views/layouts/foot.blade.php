<div class="modal fade" id="add_project" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Add Project</h4>
            </div>
            <div class="modal-body">
                @if(Auth::check('user'))
                {!!  Form::open(['route' => 'project.store','class' => 'form-horizontal project-form'])  !!}
                @include('project/partials/_add_form')
                {!! Form::close()  !!}
                @else
                <div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>
                    <strong>You don't have to perform this action!!</strong>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add_ticket" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Add Ticket</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade this-modal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Add Ticket</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<?php $countries = \App\Models\Country::orderBy('country_name', 'asc')->lists('country_name', 'country_id')->toArray(); ?>
<div class="modal fade" id="add_company" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 70%;margin: 0 auto;">
            <div class="modal-header">
                <h4 class="modal-title">Add Company</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!!  Form::open(['route' => 'company.store','class' => 'form-horizontal client-form'])  !!}
                @include('company/partials/_form')
                {!!  Form::close()  !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add_job" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Add Job</h4>
            </div>
            <div class="modal-body">
                @if(Auth::check('user'))
                {!!  Form::open(['route' => 'job.store','class' => 'form-horizontal project-form' ,'files' => true])  !!}
                @include('jobs/partials/_form')
                {!! Form::close() !!}
                @else
                <div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>
                    <strong>You don't have to perform this action!!</strong>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<?php
$roles = \App\Models\Role::orderBy('name', 'asc')->lists('name', 'id');
$companies = \App\Models\Company::orderBy('name', 'asc')->lists('name', 'id');
?>
<div class="modal fade" id="add_user" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Add User</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'user.store','class' => 'form-horizontal user-form' ,'files' => true])  !!}
                @include('user/partials/_form')
                {!!  Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-modal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Delete</h4>
            </div>
            <div class="modal-body">
                <h4 class="delete-msg"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-submit btn btn-shadow confirm-delete">Yes</button>&nbsp;&nbsp;
                <button type="button" class="btn-edit btn btn-shadow" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<form id="form-delete" action="" method="post" style="width: 0;height: 0;">
    {!! csrf_field() !!}
    {!! method_field('delete') !!}
</form>


@if(in_array('table',$assets))
{!!   HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') !!}
{!!  HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js')  !!}
{!! HTML::script('assets/js/plugins/datatables/dataTables.tableTools.js')  !!}
{!! HTML::script('assets/js/plugins/datatables/dataTables.colVis.js')  !!}
{!! HTML::script('assets/js/plugins/datatables/dataTables.colReorder.js')  !!}
@endif

@if(in_array('knob',$assets))
{!! HTML::script('assets/js/plugins/jqueryKnob/jquery.knob.js') !!}
@endif

@if(in_array('calendar',$assets))
{!!  HTML::script('assets/js/fullcalendar.min.js')  !!}
{!! HTML::script('assets/js/bootstrap-datetimepicker.js') !!}
@endif

@if(in_array('select',$assets))
{!! HTML::script('assets/js/bootstrap-select.js') !!}
@endif

@if(in_array('magicSuggest',$assets))
{!! HTML::script('assets/js/magicsuggest-min.js') !!}
@endif

@if(in_array('waiting',$assets))
{!! HTML::script('assets/js/bootstrap.waiting.js') !!}
@endif

@if(in_array('input-mask', $assets))
{!!  HTML::script('assets/js/inputmask.js')  !!}
@endif

{!!  HTML::script('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')  !!}

{!! HTML::script('assets/js/validation-form.js')  !!}
{!! HTML::script('assets/js/plugins/input-mask/jquery.inputmask.js')  !!}
{!! HTML::script('assets/js/plugins/input-mask/jquery.inputmask.date.extensions.js') !!}
{!! HTML::script('assets/js/plugins/input-mask/jquery.inputmask.extensions.js')  !!}


{!! HTML::script('assets/js/countdown.timer.js')  !!}
{!! HTML::script('assets/js/jquery-dateFormat.js')  !!}

{{--Bootstrap Datetimepicker--}}
{!! HTML::script('assets/js/bootstrap-datetimepicker.js')  !!}
{!! HTML::style('assets/css/bootstrap-datetimepicker.css')  !!}

<!-- BS4 Material Design -->
<!-- {!! HTML::script('assets/material-dashboard/BS4/assets/js/bootstrap-material-design.min.js')  !!} -->
 <!--   Core JS Files   -->
    {!! HTML::script('assets/material-dashboard/BS4/assets/js/core/jquery.min.js') !!}
    {!! HTML::script('assets/material-dashboard/BS4/assets/js/core/popper.min.js') !!}
    {!! HTML::script('assets/material-dashboard/BS4/assets/js/bootstrap-material-design.js') !!}
    
    <!-- Material Dashboard Core initialisations of plugins and Bootstrap Material Design Library -->
    {!! HTML::script('assets/material-dashboard/BS4/assets/js/material-dashboard.js?v=2.0.0') !!}

<!--Wysiwyg Editor-->
@if(!(Request::is('tickets/*') || Request::is('quiz/*')))
{!! HTML::script('assets/ckeditor/ckeditor.js')  !!}
@endif


<!--Page Specific scripts-->

@if (in_array('companies',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!!  HTML::script('assets/js/OrgChart/dist/js/jquery.orgchart.js')  !!}
{!!  HTML::script('assets/js/page/companies.js')  !!}
@endif

@if (in_array('jobs',$assets))
{!!  HTML::script('assets/js/jquery-tagEditor/jquery.caret.min.js')  !!}
{!!  HTML::script('assets/js/jquery-tagEditor/jquery.tag-editor.min.js')  !!}
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!!  HTML::script('assets/js/page/jobs.js')  !!}
@endif

@if (in_array('tasklist',$assets))
{!!  HTML::script('assets/js/page/tasklist.js')  !!}
@endif

@if(in_array('real-time',$assets))
<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
{!!  HTML::script('assets/js/page/real-time-scripts.js')  !!}
@endif

@if(in_array('quizzes',$assets))
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.11.0/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.7.3/summernote.min.js"></script>
{!!  HTML::script('assets/js/page/quizzes.js')  !!}
@endif

@if(in_array('applicants',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!!  HTML::script('assets/js/jquery-tagEditor/jquery.caret.min.js')  !!}
{!!  HTML::script('assets/js/jquery-tagEditor/jquery.tag-editor.min.js')  !!}
{!!  HTML::script('assets/js/page/applicants.js')  !!}
{!!  HTML::script('assets/js/adapter.js')  !!}
{!!  HTML::script('assets/js/janus.js')  !!}
{!!  HTML::script('assets/js/SimpleWebRTC/simplewebrtc.bundle.js')  !!}
{!!  HTML::script('assets/js/html2canvas.js') !!}
<script src="https://cdn.rawgit.com/scotch-io/scotch-panels/master/dist/scotchPanels.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.1.1/ekko-lightbox.js"></script>
{!! HTML::script('assets/js/moment.min.js') !!}
{!! HTML::script('assets/js/jquery.plugin.min.js') !!}
{!! HTML::script('assets/js/jquery.countdown.js') !!}
{!!  HTML::script('assets/js/page/video-conference-webrtc.js') !!}
{{--  HTML::script('assets/js/page/video-conference-janus.js') --}}
{{--  HTML::script('assets/js/page/video-call-janus.js')  --}}
@endif

@if(in_array('janus', $assets))
{!! HTML::script('assets/js/adapter.js') !!}
{!! HTML::script('assets/js/janus.js') !!}
{!! HTML::script('assets/js/spin.min.js') !!}
<!--script src="https://simplewebrtc.com/latest-v2.js"></script-->
{!!  HTML::script('assets/js/SimpleWebRTC/latest-v2.js')  !!}
{!! HTML::script('assets/js/janus-api.js') !!}
@endif

@if(in_array('users',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!!  HTML::script('assets/js/jquery-tagEditor/jquery.caret.min.js')  !!}
{!!  HTML::script('assets/js/jquery-tagEditor/jquery.tag-editor.min.js')  !!}
{!!  HTML::script('assets/js/page/users.js')  !!}
{!!  HTML::script('assets/js/erizo.js')  !!}
{!!  HTML::script('assets/js/page/video-conference.js')  !!}
@endif


@if(in_array('profiles',$assets))
{!!  HTML::script('assets/js/page/profiles.js')  !!}
@endif



@if(in_array('tags',$assets))
{!!  HTML::script('assets/js/bootstrap-tagsinput.js')  !!}
@endif

@if(in_array('slider',$assets))
{!!  HTML::script('assets/js/jquery.nstSlider.js')  !!}
@endif

@if(in_array('assign',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!!  HTML::script('assets/js/page/assign.js')  !!}
@endif

@if(in_array('projects',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!!  HTML::script('assets/js/page/projects.js')  !!}
@endif

@if(in_array('briefcases',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!! HTML::script('assets/js/jquery.plugin.min.js') !!}
{!! HTML::script('assets/js/jquery.countdown.js') !!}
{!!  HTML::script('assets/js/page/briefcases.js')  !!}
@endif

@if(in_array('tasks',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!! HTML::script('assets/js/jquery.plugin.min.js') !!}
{!! HTML::script('assets/js/jquery.countdown.js') !!}
{!!  HTML::script('assets/js/page/tasks.js')  !!}
@endif

@if(in_array('payroll',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!!  HTML::script('assets/js/page/payroll.js')  !!}
@endif

@if(in_array('discussions',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!!  HTML::script('assets/js/page/discussions.js')  !!}
@endif

@if(in_array('discussions-room',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!!  HTML::script('assets/js/SimpleWebRTC/simplewebrtc.bundle.js')  !!}
{!! HTML::script('assets/js/adapter.js') !!}
{!! HTML::script('assets/js/janus.js') !!}
{!! HTML::script('assets/js/spin.min.js') !!}
{!! HTML::script('assets/js/janus-api.js') !!}
{!!  HTML::script('assets/js/jquery.caret.min.js')  !!}
{!!  HTML::script('assets/js/jquery.tag-editor.min.js')  !!}
<script src="https://cdn.rawgit.com/scotch-io/scotch-panels/master/dist/scotchPanels.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.1.1/ekko-lightbox.js"></script>
{!!  HTML::script('assets/js/jquery.gridly.js')  !!}
{!!  HTML::script('assets/js/page/discussions-room.js')  !!}
@endif

@if(in_array('dashboard',$assets))
{!!  HTML::script('assets/bootstrap-dialog/src/js/bootstrap-dialog.js')  !!}
{!!  HTML::script('assets/js/page/dashboard.js')  !!}
@endif

@if(in_array('importer',$assets))
{!!  HTML::script('assets/js/page/crawler-page.js')  !!}
@endif

{!!  HTML::script('assets/js/number.js')  !!}
<!--Search Scripts-->
{!!  HTML::script('assets/js/page/search.js')  !!}
<script>
        $(function () {
            $('body')
                    .on('focusin','.number-only',function (e) {
                        $(this).numberOnly({
                            'isForContact': true
                        });
                    })
                    .on('focusout focusin','.url-only',function (e) {
                        if($(this).val() && !isUrlValid($(this).val())){
                            $(this).css({
                                'border': '1px solid #ff0000'
                            });
                            $(this).tooltip({
                                'placement' : 'right',
                                'title' : 'Please input a valid URL!',
                                'trigger' : 'click',
                                'template' :
                                '<div class="tooltip" role="tooltip" style="width: 150px!important;">' +
                                    '<div class="tooltip-arrow"></div>' +
                                    '<div class="tooltip-inner"></div>' +
                                '</div>'
                            });
                            $(this).trigger('click');
                        }
                        else{
                            $(this).siblings('.tooltip').remove();
                            $(this).removeAttr('style data-original-title title aria-describedby');
                        }
                    });

            $('input[type=file]').fileinput({
                overwriteInitial: true,
                uploadAsync: false,
                maxFileSize: 1000000,
                removeClass: "btn btn-sm btn-delete btn-shadow",
                browseClass: "btn btn-sm btn-edit btn-shadow",
                browseLabel: $('input[type=file]').attr('placeholder'),
                uploadClass: "btn btn-sm btn-assign hide btn-shadow",
                cancelClass: "btn btn-sm btn-default btn-shadow",
                maxFilesNum: 5,
                showRemove: false,
                showCaption: false,
                dropZoneEnabled: false,
                showUpload: true,
                initialPreviewAsData: true
            });
            function isUrlValid(url) {
                return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
            }

        //to fix the ajax PATCH/POST method type of form not working
        $.ajaxSetup({
        headers: {
        'X-CSRF-Token': $('input[name="_token"]').val()
        }
        });
                $("#datemask").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
                $("[data-mask]").inputmask();
                $('.datetimepicker').datetimepicker({
        format: "DD-MM-YYYY",
                useCurrent: false,
                pickTime: false
        });
                $('body').on('click', '.datetimepicker', function(e){
        $(this).datetimepicker({
        format: "DD-MM-YYYY",
                useCurrent: false,
                pickTime: false
        });
        });
                $('#dl-menu').dlmenu({
        animationClasses : { in : 'dl-animate-in-2', out : 'dl-animate-out-2' }
        });
        });
        $(document).ajaxComplete(function () {
$("#datemask").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
        $("[data-mask]").inputmask();
        });
        $(document).ready(function () {
@if (in_array('table', $assets))
        var table = $('.datatableclass').dataTable({
"sDom": 'RC<"clear">lfrtip',
        colVis: {
        restore: "Restore",
                showAll: "Show all",
                showNone: "Show none"
        },
        "language": {
        "emptyTable": "No data available in table"
        },
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true,
        "sAjaxSource": "{{ url('/data/'. (isset($cacheKey)?$cacheKey:'none')) }}"
        });
        var tt = new $.fn.dataTable.TableTools(table);
        $(tt.fnContainer()).insertBefore('div.dataTables_wrapper');
        @endif

        $(".textarea").wysihtml5({
"link": false,
        "image": false,
        "font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": false, //Italics, bold, etc. Default true
        "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": false, //Button which allows you to edit the generated HTML. Default false
        "color": false //Button to change color of font
        });
        $('#task-list-box').slimScroll({
height: '250px'
        });
        /*region load task page to project page*/
        var load_task_page = function(){
        $('.load-task-assign').each(function(){
        $(this).load($(this).data('url'));
        });
        };
        load_task_page();
        /*endregion*/
        });
        /*region Auto Close Alert Message*/
        setInterval(function(){
        $('section.content').find('.alert').fadeTo(2000, 500).slideUp(500, function(){
        $(this).alert('close');
        });
        }, 2000);
        /*endregion*/
        $(document).on('click', '.show_edit_form', function(e){
        e.preventDefault();
        var link = e.currentTarget.href;
        console.log(link);
        var _modal_target = $(this).data('target');
        $(_modal_target + ' .modal-content').load(link);
        $(_modal_target).modal('show');
        });
        /*region Hover Task List*/
        $('.task-list .task-header').hover(
        function(){
        var id = $(this).data('target');
                var task_list = $('#collapse-container-' + id.match(/\d+/));
                if (!task_list.hasClass('is-selected')){
        task_list.addClass('hovered');
        }
        },
        function(){
        var id = $(this).data('target');
                $('#collapse-container-' + id.match(/\d+/)).removeClass('hovered');
        }
);
        /*endregion*/
        /*$(document).on("click", ".alert_delete", function (e) {
         var link = $(this).attr("href");
         
         e.preventDefault();
         bootbox.confirm("Are you sure want to proceed?", function (result) {
         if (result) {
         var form = $('#form-delete');
         form.attr('action',link);
         form.submit();
         
         //                document.location.href = link;
         }
         });
         });*/

        @if (in_array('calendar', $assets))
        $(function () {
        var date = new Date();
                var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
                $('#calendar').fullCalendar({
        header: {
        left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
        },
                buttonText: {
                today: 'today',
                        month: 'month',
                        week: 'week',
                        day: 'day'
                },
                events:{!!  $EVENTS or "[]" !!}
        });
        });
        @endif
</script>

@section('js_footer')
@show

</body>
</html>
