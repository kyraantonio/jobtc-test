@extends('layouts.default')
@section('content')
<ul id="payroll-tabs" class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#work-history">Work History</a></li>
    <li><a id="payment-history-tab" data-toggle="tab" href="#payment-history">Payment History</a></li>
    <li><a id="payroll-settings-tab" data-toggle="tab" href="#payroll-settings">Payroll Settings</a></li>
</ul>
<div class="tab-content">
    <div id="work-history" class="tab-pane fade in active">
        <div class="mini-space"></div>
        <div class="row">
            <div class="col-md-3">
                <select id="filter" class="selectpicker hidden">
                    <option value="day">Per Day</option>
                    <option value="week">Per Week</option>
                    <option value="month">Per Month</option>
                    <option value="year">Per Year</option>
                </select>
            </div>
            <div class="col-md-9">
                <div class="date-label">
                    <h4 class="date-options">
                        <span class="date-text">{{date('M d, Y')}}</span>
                        <input class="date" type="hidden" value="{{date('Y-m-d')}}">
                        <input class="date_day" type="hidden" value="{{date('d')}}">
                        <input class="date_week" type="hidden" value="{{date('W')}}">
                        <input class="date_month" type="hidden" value="{{date('m')}}">
                        <input class="date_year" type="hidden" value="{{date('Y')}}">
                        <input class="date_today" type="hidden" value="{{date('Y-m-d')}}">
                        <button class="btn btn-primary filter-previous"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>&nbsp;Previous</button>
                    </h4>
                </div>
            </div>
        </div>
        <div id="payroll-table-container">
            @include('payroll.filter')
        </div>
    </div>
    <div id="payment-history" class="tab-pane fade in">
        
    </div>
    <div id="payroll-settings" class="tab-pane fade in">
        
    </div>
</div>
@stop