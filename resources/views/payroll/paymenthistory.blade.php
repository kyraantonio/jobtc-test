<div class="mini-space"></div>
<div class="payroll-container">
    @foreach($employees as $employee)
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#employee-payroll-{{$employee->id}}"><b>{{$employee->user->name}}</b></a>
                </h4>
            </div>
            <div id="employee-payroll-{{$employee->id}}" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="date-label">
                                    <h4 class="date-options">
                                        <span class="date-text">{{date('Y')}}</span>
                                        <input class="date" type="hidden" value="{{date('Y-m-d')}}">
                                        <input class="date_day" type="hidden" value="{{date('d')}}">
                                        <input class="date_week" type="hidden" value="{{date('W')}}">
                                        <input class="date_month" type="hidden" value="{{date('m')}}">
                                        <input class="date_year" type="hidden" value="{{date('Y')}}">
                                        <input class="date_today" type="hidden" value="{{date('Y-m-d')}}">
                                        <button class="btn btn-primary payment-history-filter-previous"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>&nbsp;Previous</button>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <span class="pay-period-span">
                                    @if($employee->rate->count() > 0)
                                    <b>Current Rate: </b> {{$employee->rate[0]->currency." ".$employee->rate[0]->rate_value}}
                                    @endif
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="pay-period-span">
                                    @if($employee->rate->count() > 0)
                                    <b>Current Rate Type: </b> {{title_case($employee->rate[0]->rate_type)}}
                                    @endif
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="pay-period-span">
                                    @if($employee->rate->count() > 0)
                                    <b>Current Pay Period: </b> {{title_case($employee->rate[0]->pay_period->period)}}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <table id="payroll-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Period</th>
                                <th>Regular Pay</th>
                                <th class="additions-header">Additions(+)</th>
                                <th class="deductions-header">Deductions(-)</th>
                                <th>Total Owed</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payroll_months as $month)
                            <tr>
                                <td>{{$month}}</td>
                                <td>
                                    
                                </td>
                                <td></td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
    @endforeach
</div>


<input class="company_id" type="hidden" value="{{$company_id}}">
