<div  class="row">
    <div class="col-md-6">
        <table class="table">
            <thead>
                <tr>
                    <th><span>Additions</span></th>
                    <th><span>Value</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($payroll_columns->where('column_type','additions') as $column)
                <tr>
                    <td>{{$column->column_name}}</td>
                    <td>{{$column->default_value}}</td>
                    <td>
                        <div class="column-options">
                            <button class="btn btn-edit edit-column"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</button>
                            <button class="btn btn-delete delete-column"><i class="fa fa-times"></i>&nbsp;Delete</button>
                            <input class="column_id" type="hidden" value="{{$column->id}}"/>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table">
            <thead>
                <tr>
                    <th><span>Deductions</span></th>
                    <th><span>Value</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($payroll_columns->where('column_type','deductions') as $column)
                <tr>
                    <td>{{$column->column_name}}</td>
                    <td>{{$column->default_value}}</td>
                    <td>
                        <div class="column-options">
                            <button class="btn btn-edit edit-column"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</button>
                            <button class="btn btn-delete delete-column"><i class="fa fa-times"></i>&nbsp;Delete</button>
                            <input class="column_id" type="hidden" value="{{$column->id}}"/>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
