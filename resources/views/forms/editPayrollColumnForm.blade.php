<div id="edit-payroll-column-form" class="row">
    <div class="col-md-4">
        <label>Column Name</label>
        <input class="form-control" name="column_name" value="{{$payroll_column->column_name}}" />
    </div>
    <div class="col-md-4">
        <label>Column Type</label>
        <select class="form-control" name="column_type">
            @if($payroll_column->column_type === 'additions')
            <option value="additions" selected="selected">Additions</option>
            @else
            <option value="additions">Additions</option>
            @endif
            @if($payroll_column->column_type === 'deductions')
            <option value="deductions" selected="selected">Deductions</option>
            @else
            <option value="deductions">Deductions</option>
            @endif
        </select>
    </div>
    <div class="col-md-4">
        <label>Default Value</label>
        <input class="form-control" name="default_value" value="{{$payroll_column->default_value}}" />
    </div>
</div>