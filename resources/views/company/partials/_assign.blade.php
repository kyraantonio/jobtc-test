<div class="mini-space"></div>
<ul id="assign_tabs" class="nav nav-tabs">
    @if($module_permissions->where('slug','assign.projects')->count() === 1)
    <li class="active"><a class="assign_projects_tab" data-toggle="pill" href="#assign_projects">Assign Projects</a></li>
    @endif
    @if($module_permissions->where('slug','assign.jobs')->count() === 1)
    <li><a class="share_jobs_tab" data-toggle="pill" href="#share_jobs">Assign Jobs</a></li>
    @endif
    @if($module_permissions->where('slug','assign.tests')->count() === 1)
    <li><a class="assign_tests_tab" data-toggle="pill" href="#assign_tests">Assign Tests</a></li>
    @endif
    @if($module_permissions->where('slug','assign.positions')->count() === 1)
    <li><a class="assign_authority_levels_tab" data-toggle="pill" href="#assign_authority_levels">Assign Authority Levels</a></li>
    @endif
</ul>

<div class="tab-content">
    <div id="assign_projects" class="tab-pane fade in active">
        
    </div>

    <div id="share_jobs" class="tab-pane fade in">
        <!--Load the content with AJAX when the user clicks on tab-->
    </div>

    <div id="assign_tests" class="tab-pane fade in">
        <!--Load the content with AJAX when the user clicks on tab-->
    </div>

    <div id="assign_authority_levels" class="tab-pane fade in">
        <!--Load the content with AJAX when the user clicks on tab-->
    </div>
</div>