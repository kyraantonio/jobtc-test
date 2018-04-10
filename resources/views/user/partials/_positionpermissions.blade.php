<label class='center-block permissions-title'>
    {{$position->name}} Permissions
    <a class="position-permissions-tooltip" href="#" data-toggle="tooltip" data-placement="top" title="Changing permissions here changes them for all with the position {{$position->name}}">
        <i class="fa fa-question-circle" aria-hidden="true"></i>
    </a>
</label>
<ul class="position-permissions-list-group list-group">
    @foreach($modules as $module)
    <li class="list-group-item">
        <i class="pull-left fa fa-chevron-down" aria-hidden="true"></i>
        <a data-toggle="collapse" data-target="#permission-collapse-{{$position->id}}-{{$module->id}}-position">{{ $module->name}}</a>
        <div id="permission-collapse-{{$position->id}}-{{$module->id}}-position" class="collapse">
            <ul class="permission-list-group list-group">
                @foreach($permissions->where('description',$module->name) as $permission)
                <li class="permission-list-group-item list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <label>{{ $permission->name }}</label>
                        </div>
                        <div class="pull-right">
                            @if($permission_role->where('role_id',$position->id)->where('permission_id',$permission->id)->where('company_id',$company_id)->count() > 0)
                            <div class="btn btn-default btn-shadow bg-green position-permission">
                                <i class="fa fa-check" aria-hidden="true"></i> 
                                <input class="role_id" type="hidden" value="{{$position->id}}">
                                <input class="permission_id" type="hidden" value="{{$permission->id}}">
                                <input class="company_id" type="hidden" value="{{$company_id}}">
                            </div>
                            @else
                            <div class="btn btn-default btn-shadow bg-gray position-permission">
                                <i class="fa fa-plus" aria-hidden="true"></i>     
                                <input class="role_id" type="hidden" value="{{$position->id}}">
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
$('.position-permissions-tooltip').tooltip();
    
function assignPositionPermission(role_id,permission_id,company_id) {
     var url = public_path + 'assignPositionPermission';

    var data = {
        'role_id': role_id,
        'permission_id': permission_id,
        'company_id': company_id
    };

    $.post(url, data);
}

function unassignPositionPermission(role_id,permission_id,company_id) {
     var url = public_path + 'unassignPositionPermission';

    var data = {
        'role_id': role_id,
        'permission_id': permission_id,
        'company_id': company_id
    };

    $.post(url, data);
}

$('.permission-list-group').on('click', '.position-permission', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var role_id = $(this).children('.role_id').val();
        var permission_id = $(this).children('.permission_id').val();
        var company_id = $(this).children('.company_id').val();
        
        var assign_html = '<i class="fa fa-check" aria-hidden="true"></i>';
        assign_html += '<input class="role_id" type="hidden" value="' + role_id + '"/>';
        assign_html += '<input class="permission_id" type="hidden" value="' + permission_id + '"/>';
        assign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';
        
        var unassign_html = '<i class="fa fa-plus" aria-hidden="true"></i>';
        unassign_html += '<input class="role_id" type="hidden" value="' + role_id + '"/>';
        unassign_html += '<input class="permission_id" type="hidden" value="' + permission_id + '"/>';
        unassign_html += '<input class="company_id" type="hidden" value="' + company_id + '"/>';
        

        /*Assign the Task List to this user*/
        if ($(this).hasClass('bg-gray')) {
            $(this).switchClass('bg-gray', 'bg-green', function () {
                $(this).html(assign_html);
                assignPositionPermission(role_id,permission_id,company_id);
            });
        }
        
        if($(this).hasClass('bg-gray') && $('#permission-'+permission_id).hasClass('bg-gray')) {
            $('#permission-'+permission_id).click();
        }
        
        /*Unassign the Task List from this user*/
        if ($(this).hasClass('bg-green')) {
            $(this).switchClass('bg-green', 'bg-gray', function () {
                $(this).html(unassign_html);
                unassignPositionPermission(role_id,permission_id,company_id);
            });
        }
        
        if($(this).hasClass('bg-green') && $('#permission-'+permission_id).hasClass('bg-green')) {
            $('#permission-'+permission_id).click();
        }
    });

</script>
    