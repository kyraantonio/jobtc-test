<ul class="company-list-group list-group">
    @foreach($user_companies as $user_company)
    <li id="company-{{$user_company->id}}" class="list-group-item">
        <div class="row">
            <div class="col-md-9">
                <a id="employee-toggle-{{$user_company->id}}" class="toggle-employees" data-toggle="collapse" href="#employee-toggle-collapse-{{$user_company->id}}">
                    <i class="pull-left fa fa-chevron-down" aria-hidden="true"></i>
                    {{$user_company->name}}
                </a>
            </div>
            <div class="pull-right">
                <a href="#" class="drag-handle">
                    <i class="fa fa-arrows"></i>
                </a>
                <a href="#" class="unassign-company hidden">
                    <i class="fa fa-times"></i>
                    <input class="company_id" type="hidden" value="{{$user_company->id}}"/>
                    <input class="project_id" type="hidden" value=""/>
                </a>
            </div>
        </div>
        <div class="row">
            <div id="employee-toggle-collapse-{{$user_company->id}}" class="employee-list collapse">

            </div>
        </div>
    </li>
    @endforeach
</ul>
{!!$user_companies->render()!!}