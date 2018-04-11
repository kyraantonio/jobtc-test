<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        {{--*/ $breadcrumbs = \App\Helpers\Helper::getBreadcrumbs(); $lastElement = end($breadcrumbs); /*--}}
        <title>
            @foreach($breadcrumbs as $title => $url)
            @if($lastElement !== $url)
            {{$title}} -
            @else
            {{$title}}
            @endif
            @endforeach
        </title>

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta http-equiv="Expires" content="Tue, 01 Jan 1995 12:12:12 GMT">
        {!!  HTML::style('assets/material-dashboard/BS4/assets/css/material-dashboard.min.css')  !!}
        <!-- {!!  HTML::style('assets/css/bootstrap.css')  !!} -->
        <!-- {!!  HTML::style('assets/css/font-awesome.min.css')  !!} -->
        {!!  HTML::style('assets/css/ionicons.min.css')  !!}
        {!!  HTML::style('assets/css/jquery-ui.min.css')  !!}
        <!-- {!!  HTML::style('assets/custom.css')  !!} -->
        <!-- {!! HTML::style('assets/css/AdminLTE.css')  !!} -->
        <!-- {!!  HTML::style('assets/css/app.css')  !!} -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
        
        <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
        <!--For Screensharing Extension-->
        <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/eciifjfhlbmnofcnnjhodcbjnfhjcelp">
        
        
        @if(in_array('table',$assets))
        {!!  HTML::style('assets/css/datatables/dataTables.bootstrap.css')  !!}
        {!!  HTML::style('assets/css/datatables/dataTables.tableTools.css')  !!}
        {!!  HTML::style('assets/css/datatables/dataTables.colVis.css')  !!}
        {!!  HTML::style('assets/css/datatables/dataTables.colReorder.css')  !!}
        @endif

        @if(in_array('calendar',$assets))
        {!!  HTML::style('assets/css/fullcalendar.css')  !!}
        {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
        @endif

        @if(in_array('select',$assets))
        {!!  HTML::style('assets/css/bootstrap-select.css') !!}
        @endif

        @if(in_array('magicSuggest',$assets))
        {!!  HTML::style('assets/css/magicsuggest-min.css') !!}
        @endif

        {!!  HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') !!}

        <!--Page Specific css-->
        @if(in_array('companies',$assets))
        
        {!!  HTML::style('assets/js/OrgChart/dist/css/jquery.orgchart.css')  !!}
        {!!  HTML::style('assets/css/page/companies.css')  !!}
        
        @endif

        @if(in_array('jobs',$assets))
        {!!  HTML::style('assets/css/jquery.tag-editor.css')  !!}
        {!!  HTML::style('assets/bootstrap-dialog/src/css/bootstrap-dialog.css')  !!}
        {!!  HTML::style('assets/css/page/jobs.css')  !!}
        @endif

        @if(in_array('applicants',$assets))
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.1.1/ekko-lightbox.css">
        {!!  HTML::style('assets/css/jquery.tag-editor.css')  !!}
        {!!  HTML::style('assets/css/page/applicants.css')  !!}
        @endif

        @if(in_array('discussions',$assets) || in_array('discussions-room',$assets))
        {!!  HTML::style('assets/css/jquery.tag-editor.css')  !!}
        {!!  HTML::style('assets/css/jquery.gridly.css')  !!}
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.1.1/ekko-lightbox.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        {!!  HTML::style('assets/css/page/discussions.css')  !!}
        @endif
        
        @if(in_array('users',$assets))
        {!!  HTML::style('assets/css/jquery.tag-editor.css')  !!}
        {!!  HTML::style('assets/css/page/users.css')  !!}
        @endif


        @if(in_array('profiles',$assets))
        {!!  HTML::style('assets/css/page/profiles.css')  !!}
        @endif

        @if(in_array('quizzes',$assets))
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.7.3/summernote.css">
        {!!  HTML::style('assets/css/page/quizzes.css')  !!}
        @endif

        @if(in_array('tags',$assets))
        {!!  HTML::style('assets/css/bootstrap-tagsinput.css')  !!}
        @endif

        @if(in_array('slider',$assets))
        {!!  HTML::style('assets/css/jquery.nstSlider.css')  !!}
        @endif

        @if(in_array('assign',$assets))
        {!!  HTML::style('assets/css/page/assign.css')  !!}
        @endif

        @if(in_array('dashboard',$assets))
        {!!  HTML::style('assets/css/page/dashboard.css')  !!}
        @endif

        @if(in_array('projects',$assets))
        {!!  HTML::style('assets/css/page/projects.css')  !!}
        @endif

        @if(in_array('briefcases',$assets))
        {!!  HTML::style('assets/css/page/briefcases.css')  !!}
        @endif

        @if(in_array('tasks',$assets))
        {!!  HTML::style('assets/css/page/tasks.css')  !!}
        @endif
        
        @if(in_array('payroll',$assets))
        {!!  HTML::style('assets/css/page/payroll.css')  !!}
        @endif
        
        {!!  HTML::style('assets/css/page/search.css')  !!}


        <!--Multi-navigation css-->
        {!!  HTML::style('assets/css/menu.css')  !!}

        {!! HTML::script('assets/js/jquery.min.js') !!}
        {!! HTML::script('assets/js/jquery-ui.min.js') !!}
        {!! HTML::script('assets/js/bootstrap.min.js') !!}
        {!! HTML::script('assets/js/jquery.validate.min.js') !!}
        {!! HTML::script('assets/js/AdminLTE/app.js')  !!}
        {!!  HTML::script('assets/js/bootbox.js')  !!}
        {!!  HTML::script('assets/js/moment.min.js')  !!}

        <!--DLMenu js-->
        {!! HTML::script('assets/js/modernizr.custom.js') !!}
        {!! HTML::script('assets/js/jquery.dlmenu.js') !!}

        {!!  HTML::style('assets/css/fileinput.css')  !!}
        {!!  HTML::script('assets/js/fileinput.min.js')  !!}
        <script> var public_path = "{{ URL::to('/') }}/";</script>
    </head>
