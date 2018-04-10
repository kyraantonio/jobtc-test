@extends('layouts.default')
@section('content')

    @role('admin')
        <div class="modal fade" id="add_billing" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                        <h4 class="modal-title">Add {{ studly_case($data['billing_type']) }}</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['route' => 'billing.store','class' => 'form-horizontal billing-form'])  !!}
                        @include('billing/partials/_form')
                        {!!  Form::close()  !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ajax" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                </div>
            </div>
        </div>
    @endrole

    <div class="col-md-12">
        <div class="box box-solid box-default">
            <div class="box-header">
                <h3 class="box-title">{{ studly_case($data['billing_type']) }} List </h3>
                <div class="box-tools pull-right">
                    @role('admin')
                        <a data-toggle="modal" href="#add_billing">
                            <button class="btn btn-sm"><i class="fa fa-plus-circle"></i> Add
                                New {{ studly_case($data['billing_type']) }}</button>
                        </a>
                    @endrole
                    <button class="btn btn-sm btn-transparent" data-widget="collapse"><i class="fa fa-chevron-up"></i></button>
                </div>
            </div>
            <div class="box-body">

                <?php $DATA = array();
                $QA = array();
                $billing_type = $data['billing_type'];
                foreach ($billings as $billing) {
                    $linkToEdit = "<a href=$billing_type/$billing->billing_id/edit data-toggle='modal' data-target='#ajax'> <i class='fa fa-edit'></i> </a>";
                    $linkToView = "<a href=$billing_type/$billing->billing_id><i class='fa fa-external-link'></i></a>";
                    $linkToDelete = "<a href=" . URL::to('/') . "/billing/$billing->billing_id/delete class='alert_delete'> <i class='fa fa-trash-o'></i> </a>";
                    $linkToPrint = "<a href=" . URL::to('/') . "/print/$billing_type/$billing->billing_id target=_blank> <i class='fa fa-print'></i> </a>";

                    if (Auth::user()->is('admin'))
                        $Option = "$linkToView <span class='hspacer'></span> $linkToPrint <span class='hspacer'></span> $linkToEdit <span class='hspacer'></span> $linkToDelete";
                    elseif (Auth::user()->is('client'))
                        $Option = "$linkToPrint";

                    $QA[] = array($billing->ref_no, isset($clients[$billing->client_id]) ? $clients[$billing->client_id] : '', date("d M Y", strtotime($billing->issue_date)), $Option);
                }

                    $cacheKey = 'billing.list.'. session()->getId();
                    Cache::put($cacheKey, $QA, 100);
                ?>
                <table class="table table-striped table-bordered table-hover datatableclass" id="billing_table">
                    <thead>
                    <tr>
                        <th>
                            Ref No
                        </th>
                        <th>
                            Company Name
                        </th>
                        <th>
                            Issue Date
                        </th>
                        <th>
                            Option
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
@stop