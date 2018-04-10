@extends('layouts.default')
@section('content')
<!--div class="col-md-12">
    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title">Company List</h3>
            <div class="box-tools pull-right">
                <a data-toggle="modal" href="#add_client">
                    <button class="btn btn-shadow btn-submit btn-sm"><i class="fa fa-plus-circle"></i> Add New Company</button>
                </a>
                <button class="btn btn-sm btn-transparent" data-widget="collapse"><i class="fa fa-chevron-up"></i></button>
            </div>
        </div>
        <div class="box-body">
<?php
$DATA = array();
$QA = array();
foreach ($companies as $company) {
    $linkToEdit = "<a href='" . route('company.edit', $company->id) . "' data-toggle='modal' data-target='#client_edit'> <i class='fa fa-2x fa-edit'></i> </a>";
    $linkToView = "<a href='" . route('company.show', $company->id) . "' data-toggle='modal' data-target='#client_show'> <i class='fa fa-2x fa-external-link'></i> </a>";
    $linkToDelete = "<a href='" . route('company.destroy', $company->id) . "' class='alert_delete'> <i class='fa fa-2x fa-trash-o'></i> </a>";
    $Option = "$linkToView <span class=hspacer></span> $linkToEdit <span class=hspacer></span> $linkToDelete";
    $QA[] = array($company->name, $company->email, $company->address, $company->country, $Option);
}
$cacheKey = 'company.list.' . session()->getId();
Cache::put($cacheKey, $QA, 100);
?>
            <table class="table table-striped table-bordered table-hover datatableclass" id="client_table">
                <thead>
                <tr>
                    <th>
                        Company Name
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Address
                    </th>
                    <th>
                        Country
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div style="clear:both;"></div>
    </div>
</div-->
@stop
