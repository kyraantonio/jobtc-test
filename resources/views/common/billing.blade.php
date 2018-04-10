<div class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                {{ $site_settings->company_name }}
                <small class="pull-right">Invoice Date {{ date("d M Y",strtotime($billing->issue_date)) }}</small>
            </h2>
        </div>
    </div>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>{{ $site_settings->company_name }}</strong><br/>
                {{ $site_settings->contact_person }}<br/>
                {{ $site_settings->address }}<br/>
                {{ $site_settings->city }}
                {{ $site_settings->state }}<br/>
                {{ $site_settings->country }}
                {{ $site_settings->zipcode }}<br/>
            </address>
        </div>
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong>{{ $client->company_name }}</strong><br/>
                {{ $client->contact_person }}<br/>
                {{ $client->address }}<br/>
                {{ $client->city }}
                {{ $client->state }}<br/>
                {{ $client->country }}
                {{ $client->zipcode }}<br/>
                {{ $client->email }}<br/>
                {{ $client->phone }}
            </address>
        </div>
        <div class="col-sm-4 invoice-col">
            <b>Invoice {{ $billing->ref_no }} </b><br/>
            <br/>
            <b>Payment Due:</b> {{ date("d M Y",strtotime($billing->issue_date)) }}
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>SNo</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Cost</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                <?php $SNo = $total = $grandTotal = 0; ?>
                @if($items!='')
                    @foreach($items as $item)
                        <?php $SNo++; $total += round($item->item_quantity * $item->unit_price, 2); ?>
                        <tr>
                            <td>{{ $SNo }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->item_description }}</td>
                            <td>{{ round($item->item_quantity,2) }}</td>
                            <td>{{ $billing->currency }} {{ round($item->unit_price,2) }}</td>
                            <td>{{ $billing->currency }} {{ round($item->item_quantity*$item->unit_price,2) }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                {{ $billing->notes }}
            </p>
        </div>
        <?php
        $grandTotal = round($total + (($total - ($total * $billing->discount / 100)) * $billing->tax / 100), 2);
        $balance = $grandTotal - $payment;
        ?>
        <div class="col-xs-6">
            <p class="lead">Amount Due {{ date("d M Y",strtotime($billing->issue_date)) }}</p>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>{{ $billing->currency }} {{ $total }}</td>
                    </tr>
                    @if($billing->discount>0)
                        <tr>
                            <th>Discount</th>
                            <td>{{ round($billing->discount,2) }} %</td>
                        </tr>
                    @endif
                    <tr>
                        <th>Tax:</th>
                        <td>{{ round($billing->tax,2) }} %</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>{{ $billing->currency }} {{ $grandTotal }}</td>
                    </tr>
                    @if($payment>0)
                        <tr>
                            <th>Paid:</th>
                            <td>{{ $billing->currency }} {{ round($payment,2) }}</td>
                        </tr>
                    @endif
                    @if($balance>0)
                        <tr>
                            <th>Balance:</th>
                            <td>{{ $billing->currency }} {{ round($balance,2) }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="row no-print">
        <div class="col-xs-12">
            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
</div>
	