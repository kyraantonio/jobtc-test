<div id="position-{{$position->id}}" class="col-md-6">
    <div  class="box box-default">
        <div class="box-container">
            <div class="box-header" data-toggle="collapse" data-target="#position-collapse-{{$position->id}}">
                <h3 class="box-title">{{$position->name}}</h3>
            </div>
            <div class="box-body">
                <div id="position-collapse-{{$position->id}}" class="box-content collapse">
                    <div class="row">
                        <div class="col-md-12">
                            @include('roles.partials._positionpermissions')
                        </div>
                        <div class="position_options pull-right">
                            @if(Auth::user('user')->can('delete.positions') && $module_permissions->where('slug','delete.positions')->count() === 1)
                            <a href="#" class="btn-delete btn-shadow btn delete-position">
                                <i class="fa fa-times"></i> 
                                Delete
                            </a>
                            @endif
                            @if(Auth::user('user')->can('edit.positions') && $module_permissions->where('slug','edit.positions')->count() === 1)
                            <a href="#" class="btn-edit btn-shadow btn edit-position" data-toggle="modal" data-target="#edit_project_form">
                                <i class="fa fa-pencil" aria-hidden="true"></i> 
                                Edit
                            </a>
                            @endif
                            <input class="position_id" type="hidden" value="{{$position->id}}"/>
                            <input class="company_id" type="hidden" value="{{$company_id}}"/>
                        </div>
                    </div>
                </div><!--Box Container-->
            </div>
        </div>
    </div>
</div>