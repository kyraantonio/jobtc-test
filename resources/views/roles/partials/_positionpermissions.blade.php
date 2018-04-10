<label class='center-block permissions-title'>Available Modules</label>
<ul class="position-permissions-list-group list-group">
    @foreach($modules as $module)
    <li class="list-group-item">
        <a data-toggle="collapse" data-target="#permission-collapse-{{$position->id}}-{{$module->id}}-position"><i class="pull-left fa fa-chevron-down" aria-hidden="true"></i> {{$module->name}}</a>
        <div id="permission-collapse-{{$position->id}}-{{$module->id}}-position" class="collapse">
            <ul class="permission-list-group list-group">
                @foreach($permissions->where('description',$module->name) as $permission)
                <li class="permission-list-group-item list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <label>{{$permission->name}}</label>
                        </div>
                        <div class="pull-right">
                            @if($permission_role->where('role_id',$position->id)->where('permission_id',$permission->id)->count() > 0)
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