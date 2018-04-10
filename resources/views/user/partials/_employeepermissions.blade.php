<label class='center-block permissions-title'>User Permissions&nbsp;
    <a class="user-permissions-tooltip" href="#" data-toggle="tooltip" data-placement="top" title="Changes permissions for this user only. This will override position permissions">
        <i class="fa fa-question-circle" aria-hidden="true"></i>
    </a>
</label>
<ul class="position-permissions-list-group list-group">
    @foreach($modules as $module)
    <li class="list-group-item">
        <i class="pull-left fa fa-chevron-down" aria-hidden="true"></i>
        <a data-toggle="collapse" data-target="#permission-collapse-{{$position->id}}-{{$module->id}}-user">{{ $module->name}}</a>
        <div id="permission-collapse-{{$position->id}}-{{$module->id}}-user" class="collapse">
            <ul class="permission-list-group list-group">
                @foreach($permissions->where('description',$module->name) as $permission)
                <li class="permission-list-group-item list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <label>{{ $permission->name }}</label>
                        </div>
                        <div class="pull-right">
                            @if($permission_user->where('user_id',$user_id)->where('permission_id',$permission->id)->where('company_id',$company_id)->count() > 0)
                            <div id="permission-{{$permission->id}}" class="btn btn-default btn-shadow bg-green employee-permission">
                                <i class="fa fa-check" aria-hidden="true"></i> 
                                <input class="user_id" type="hidden" value="{{$user_id}}">
                                <input class="permission_id" type="hidden" value="{{$permission->id}}">
                                <input class="company_id" type="hidden" value="{{$company_id}}">
                            </div>
                            @else
                            <div id="permission-{{$permission->id}}" class="btn btn-default btn-shadow bg-gray employee-permission">
                                <i class="fa fa-plus" aria-hidden="true"></i>     
                                <input class="user_id" type="hidden" value="{{$user_id}}">
                                <input class="permission_id" type="hidden" value="{{$permission->id}}">
                                <input class="company_id" type="hidden" value="{{$company_id}}">
                            </div>
                            @endif
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </li>
    @endforeach
</ul>
<script>
$('.user-permissions-tooltip').tooltip();

function assignEmployeePermission(user_id,permission_id,company_id) {
     var url = public_path + 'assignEmployeePermission';

    var data = {
        'user_id': user_id,
        'permission_id': permission_id,
        'company_id': company_id
    };

    $.post(url, data);
}

function unassignEmployeePermission(user_id,permission_id,company_id) {
     var url = public_path + 'unassignEmployeePermission';

    var data = {
        'user_id': user_id,
        'permission_id': permission_id,
        'company_id': company_id
    };

    $.post(url, data);
}

$('.permission-list-group').on('click', '.employee-permission', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var user_id = $(this).children('.user_id').val();
        var permission_id = $(this).children('.permission_id').val();
        var company_id = $(this).children('.company_id').val();
        
        var assign_html = '<i class="fa fa-check" aria-hidden="true"></i>';
        assign_html += '<input class="user_id" type="hidden" value="' + user_id + '"/>';
        assign_html += '<input class="permission_id" type="hidden" value="' + permission_id + '"/>';
        assign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';
        
        var unassign_html = '<i class="fa fa-plus" aria-hidden="true"></i>';
        unassign_html += '<input class="user_id" type="hidden" value="' + user_id + '"/>';
        unassign_html += '<input class="permission_id" type="hidden" value="' + permission_id + '"/>';
        unassign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';
        

        /*Assign the Task List to this user*/
        if ($(this).hasClass('bg-gray')) {
            $(this).switchClass('bg-gray', 'bg-green', function () {
                $(this).html(assign_html);
                //shareToCompanyEmployee(user_id, company_id, job_id);
                assignEmployeePermission(user_id,permission_id,company_id);
            });
        }
        /*Unassign the Task List from this user*/
        if ($(this).hasClass('bg-green')) {
            $(this).switchClass('bg-green', 'bg-gray', function () {
                $(this).html(unassign_html);
                //unshareFromCompanyEmployee(user_id, company_id, job_id);
                unassignEmployeePermission(user_id,permission_id,company_id);
            });
        }
    });

</script>
