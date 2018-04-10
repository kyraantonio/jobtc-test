<div class="box box-solid box-success">
    <div class="box-header">
        <h3 class="box-title">Payroll</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-9">
                <?php

                ?>
            </div>
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">Company</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <?php
                            echo Form::select(
                                'company',
                                $company, '',
                                array('class' => 'company-dp form-control')
                            );
                            ?>
                        </div>
                        <strong>Total Employees:</strong><span class="employeeCount"></span>
                    </div>
                </div>
            </div>
        </div>
        {{--<table class="table table-hover">
            <thead>
                <tr class="table-header">
                    <th>Date</th>
                    <th>Task</th>
                    <th>Time</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>--}}
    </div>
    <div style="clear:both;"></div>
</div>

@section('js_footer')
@parent
<script>
    $(document).ready(function () {
        var company_dp = $('.company-dp');
        loadPayroll();
        company_dp.change(function(e){
            loadPayroll();
        });

        function loadPayroll(){
            var company_id = company_dp.val();
            $.ajax({
                url: '{{ URL::to('payrollJson') }}?company_id=' + company_id,
                success: function(payroll) {
                    console.log(payroll);
                    /*$('.table tbody').html('');
                    if(payroll.length > 0){
                        $.each(payroll, function(k, v){
                            var trContent =
                                '<tr>' +
                                    '<td>' + v.date + '</td>' +
                                    '<td>' + v.task_title + '</td>' +
                                    '<td>' + v.time + '</td>' +
                                    '<td>' + v.amount + '</td>' +
                                '</tr>';
                            $('.table tbody').append(trContent);
                        });
                    }*/
                }
            });
        }
    });
</script>
@stop