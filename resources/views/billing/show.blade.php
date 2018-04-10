@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Detail</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Estimate</a></li>
                    @if($data['billing_type'] == 'invoice')
                        <li><a href="#tab_3" data-toggle="tab">Payment</a></li>
                    @endif
                    <li class="dropdown pull-right">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Dropdown <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                                       href="{{ url('billing/'.$billing->billing_type)}}">Back</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                                       href="{{ url('billing/'.$data['billing_type'].'/'.$billing->billing_id.'/edit') }}"
                                                       data-toggle='modal' data-target='#ajax'>Edit</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1"
                                                       href="{{ url('billing/'.$billing->billing_id.'/delete') }}">Delete</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-solid box-default">
                                    <div class="box-header">
                                        <h3 class="box-title">{{ studly_case($billing->billing_type) }} Ref
                                            # {{ $billing->ref_no }}</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Company Name
                                            </div>
                                            <div class="col-md-7 value">
                                                {{ $client->company_name }}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Issue Date:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{ date("d M Y",strtotime($billing->issue_date)) }}
                                            </div>
                                        </div>
                                        @if($data['billing_type']=="invoice")
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                    Due Date:
                                                </div>
                                                <div class="col-md-7 value">
                                                    {{ date("d M Y",strtotime($billing->due_date)) }}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                    Discount:
                                                </div>
                                                <div class="col-md-7 value">
                                                    {{ round($billing->discount,2) }} %
                                                </div>
                                            </div>
                                        @elseif($data['billing_type']=="estimate")
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                    Valid Till:
                                                </div>
                                                <div class="col-md-7 value">
                                                    {{ date("d M Y",strtotime($billing->valid_date)) }}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Tax:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{ round($billing->tax,2) }} %
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Currency:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{ $billing->currency }}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Notes:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{ $billing->notes }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @include('common.note',['note' => $note, 'belongs_to' => 'billing', 'unique_id' => $billing->billing_id])
                            </div>
                            <div class="col-md-6">
                                <div class="box box-solid box-default">
                                    <div class="box-header">
                                        <h3 class="box-title">Item List</h3>
                                    </div>
                                    <div class="box-body">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>
                                                    Item Name
                                                </th>
                                                <th>
                                                    Quantity
                                                </th>
                                                <th>
                                                    Unit Price
                                                </th>
                                                <th>
                                                    Total
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($items!='')
                                                @foreach($items as $item)
                                                    <tr>
                                                        <td>{{ $item->item_name }}</td>
                                                        <td>{{ round($item->item_quantity,2) }}</td>
                                                        <td>{{ $billing->currency }} {{ round($item->unit_price,2) }}</td>
                                                        <td>{{ round($item->item_quantity*$item->unit_price,2) }}</td>
                                                        <td>
                                                            {!! Form::open(array('route' => array('item.destroy', $item->item_id), 'method' => 'delete')) !!}
                                                            <button type="submit" class="btn btn-danger btn-xs"><i
                                                                        class="icon-trash"></i> Delete
                                                            </button>
                                                            {!!  Form::close()  !!}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>

                                        <br/>
                                        {!!  Form::open(['route' => 'item.store','class' => 'item-form']) !!}
                                        <div class="form-group">
                                            {!!  Form::input('text','item_name','',['class' => 'form-control',
                                            'placeholder' => 'Item Name']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!!  Form::input('number','item_quantity','',['class' => 'form-control',
                                            'placeholder' => 'Item Quantity', 'step' => '.01'])  !!}
                                        </div>
                                        <div class="form-group">
                                            {!!  Form::input('number','unit_price','',['class' => 'form-control',
                                            'placeholder' => 'Unit Price', 'step' => '.01']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!!  Form::textarea('item_description','',['size' => '30x3', 'class' =>
                                            'form-control', 'placeholder' => 'Item Description']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!!  Form::hidden('billing_id',$billing->billing_id) !!}
                                            {!! Form::hidden('billing_type',$billing->billing_type) !!}
                                            {!! Form::submit('Add',['class' => 'btn btn-edit btn-shadow'])  !!}
                                        </div>
                                        {!!  Form::close()  !!}

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="tab_2">
                        @include('common.billing',['billing' => $billing, 'client' => $client, 'items' => $items])
                    </div>

                    @if($data['billing_type'] == 'invoice')
                        <div class="tab-pane" id="tab_3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box box-solid box-default">
                                        <div class="box-header">
                                            <h3 class="box-title">Make Payment</h3>
                                        </div>
                                        <div class="box-body">
                                            {!! Form::open(['method' => 'POST','route' => ['payment.store'],'class' =>
                                            'payment-form'])  !!}
                                            <div class="form-body">
                                                <div class="form-group">
                                                    {!!  Form::input('number','payment_amount','',['class' =>
                                                    'form-control', 'placeholder' => 'Enter Amount', 'step' => '.01'])  !!}
                                                </div>
                                                <div class="form-group">
                                                    {!!  Form::textarea('payment_notes','',['size' => '30x3', 'class'
                                                    => 'form-control', 'placeholder' => 'Enter Description'])  !!}
                                                </div>
                                                <div class="form-group">
                                                    {!!  Form::input('text','payment_date','',['class' => 'form-control
                                                    form-control-inline input-medium date-picker', 'placeholder' => 'Enter Payment Date', 'data-inputmask' => "'alias': 'dd-mm-yyyy'", 'data-mask' => 'true'])  !!}
                                                </div>
                                                <div class="form-group">
                                                    {!!  Form::select('payment_type', ['cash' => 'Cash' ,'bank' =>
                                                    'Bank'], '', ['class' => 'form-control', 'placeholder' => 'Payment To'] )  !!}
                                                </div>
                                                <div class="form-group">
                                                    {!!  Form::submit('Add',['class' => 'btn btn-edit'])  !!}
                                                    {!!  Form::hidden('billing_id',$billing->billing_id)  !!}
                                                </div>
                                            </div>
                                            {!!  Form::close()  !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box box-solid box-default">
                                        <div class="box-header">
                                            <h3 class="box-title">Payment List</h3>
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        Receipt No
                                                    </th>
                                                    <th>
                                                        Amount
                                                    </th>
                                                    <th>
                                                        Date
                                                    </th>
                                                    <th>
                                                        Type
                                                    </th>
                                                    <th>
                                                        Note
                                                    </th>
                                                    <th>
                                                        Delete
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($payments!='')
                                                    @foreach($payments as $payment)
                                                        <tr>
                                                            <td>{{ $payment->payment_id }}</td>
                                                            <td>{{ round($payment->payment_amount,2) }}</td>
                                                            <td>{{ date("d M Y",strtotime($payment->payment_date)) }}</td>
                                                            <td>{{ studly_case($payment->payment_type) }}</td>
                                                            <td>{{ $payment->payment_notes }}</td>
                                                            <td>
                                                                {!!  Form::open(array('route' => array('payment
                                                                .destroy', $payment->payment_id), 'method' => 'delete'))  !!}
                                                                <button type="submit" class="btn btn-danger btn-xs"><i
                                                                            class="icon-trash"></i> Delete
                                                                </button>
                                                                {!! Form::close()  !!}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

@stop