<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> PO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
        @page {
            margin: 1cm 1cm;
        }

        html,body{
            padding: 0;
            margin: 0;
            font-size: 11px;
        }

        body{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; !important;
            margin-top: 5cm;
            margin-bottom: 2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0.8cm;
            font-size: 9px;
            margin-bottom: 0px;
        }
        /* ul li{
            display: inline-block;
        } */

        table{
            border-collapse: collapse;
        }

        .helveticaFont {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; !important;
        }
        .courierNewFont{
            font-family: "Courier New", Courier, monospace;
        }

        #bodyHead{
            top:40px;
            left: 36px;
            position: absolute;
            color:black;
        }

        #content1{
            left: 36px;
            margin: 0px 36px;
        }

        #content2{
            margin-top:24px;
            margin-left:18px;
            margin-right:18px;
        }

        #content4{
            margin:32px 36px 18px;
        }

    </style>
</head>
<body>
    <header>
        <div id="bodyHead">
            <table style='font-size: 12px;'>
                <tr>
                    <td style="vertical-align: center; text-align: left; padding-top: 12px;">
                        <img src="{{$company->logo}}" alt="" style="max-height: 75px">
                    </td>
                    <td valign="top" class="courierNewFont">
                        <div style="margin-left: 16px">
                            <div class="pb-1 helveticaFont" style="font-size: 13px;">FROM:</div>
                            <b>{{strtoupper($company->name)}}</b>
                            @if(isset($companyAddress))
                                <br><b>{{$companyAddress->street}}</b>
                                <br><b>{{$companyAddress->city}} - {{$companyAddress->post_code}}</b>
                                <br><b>{{$companyAddress->city}} {{$companyAddress->province}} {{$companyAddress->post_code}}</b>
                                <br><b>{{$companyAddress->country->nice_name}}</b>
                            @else
                                <br><b>-</b>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="container border-top border-3 pt-1">
            <table width="100%">
                <tr>
                    <td width="80%" valign="top" class="courierNewFont">
                        <span style="font-size: 10px">Created By:</span>
                        <b>{{$purchaseOrder->creator->name}}; {{$purchaseOrder->created_at->format('d-m-Y') ?? '-' }}</b> &nbsp;&nbsp;&nbsp;
                        <span style="font-size: 10px">Printed By:</span>
                        <b>{{\Illuminate\Support\Facades\Auth::user()->name}}; {{ date('d-m-Y H:i:s') }}</b>
                    </td>
                    <td width="10%" valign="top"></td>
{{--                    <td width="10%" valign="top" align="right">Page 1/1</td>--}}
                </tr>
            </table>
        </div>
    </footer>

    <div id="content1">
        <table width="100%">
            <tr>
                <td width="36%" class="border-top border-bottom" style="font-size: 13px;">
                    <span>TO:</span>
                </td>
                <td width="24%" valign="top">
                </td>
                <td width="40%" class="border-top border-bottom" style="font-size: 16px; text-align: center;">
                    <span>PURCHASE ORDER</span>
                </td>
            </tr>
            <tr>
                @php
                    if (isset($purchaseOrder->supplier->addresses[0]))
                        $toAddress = $purchaseOrder->supplier->addresses[0];
                @endphp
                <td width="36%" class="py-0 my-0 courierNewFont" style="font-size: 13px;">
                    @if(isset($toAddress))
                        <br><b>{{strtoupper($purchaseOrder->supplier->name)}}</b>
                        <br><b>{{$toAddress->street}}</b>
                        <br><b>{{$toAddress->city}} - {{$toAddress->post_code}}</b>
                        <br><b>{{$toAddress->city}} {{$toAddress->province}} {{$toAddress->post_code}}</b>
                        <br><b>{{$toAddress->country->nice_name}}</b>
                    @else
                        <span class="text-center"><b>-</b></span>
                    @endif
                </td>
                <td width="24%">
                </td>
                <td width="40%" style="font-size: 13px;">
                    <table>
                        <tr>
                            <td width="40%">Number</td>
                            <td width="60%" class="courierNewFont" style="font-weight: bolder; padding-left: 8px">:  {{$purchaseOrder->code}}</td>
                        </tr>
                        <tr>
                            <td width="40%">Date</td>
                            <td width="60%" class="courierNewFont" style="font-weight: bolder; padding-left: 8px">:  {{$purchaseOrder->transaction_date}}</td>
                        </tr>
                        <tr>
                            <td width="40%">Currency</td>
                            <td width="60%" class="courierNewFont" style="font-weight: bolder; padding-left: 8px">:  {{$purchaseOrder->currency->code}}</td>
                        </tr>
                        <tr>
                            <td width="40%">Rate</td>
                            <td width="60%" class="courierNewFont" style="font-weight: bolder; padding-left: 8px">:  {{$purchaseOrder->exchange_rate}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div id="content2">
        <div class="container">
            <table width="100%" class="table courierNewFont" cellpadding="3" page-break-inside: auto;>
                <thead>
                    <tr style="background-color: #0C112E; color: whitesmoke">
                        <th valign="top" class="text-center" width="10%">Item Code</th>
                        <th valign="top" class="text-center" width="15%">Item Name</th>
                        <th valign="top" class="text-center" width="7%">Qty</th>
                        <th valign="top" class="text-center" width="20%">Remark</th>
                        <th valign="top" class="text-center" width="20%">Price</th>
                        <th valign="top" class="text-center" width="8%">Tax(%)</th>
                        <th valign="top" class="text-center" width="20%">Price After Tax</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                    @endphp
                    @foreach($details as $detail)
                        <tr>
                            <td valign="top" align="left">
                                {{$detail->purchase_requisition_detail->item->code}}
                            </td>
                            <td valign="top" align="left">
                                {{$detail->purchase_requisition_detail->item->name}}
                            </td>
                            <td valign="top" align="center">
                                {{$detail->order_quantity}}
                            </td>
                            <td valign="top" align="left">
                                {{$detail->description}}
                            </td>
                            <td valign="top" align="right">
                                {{number_format($detail->each_price_before_vat,2,",",".")}}
                            </td>
                            <td valign="top" align="right">
                                {{($detail->vat * 100)}}
                            </td>
                            <td valign="top" align="right">
                                @php
                                    $result = (($detail->order_quantity * $detail->each_price_before_vat) * $detail->vat) + ($detail->order_quantity * $detail->each_price_before_vat)
                                @endphp
                                {{number_format($result,2,",",".")}}
                            </td>
                        </tr>
                        @php
                            $grandTotal += (($detail->order_quantity * $detail->each_price_before_vat) * $detail->vat) + ($detail->order_quantity * $detail->each_price_before_vat);
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="content4" class="border-top border-3">
        <div class="container mt-2">
            <table width="100%">
                <tr>
                    <td width="55%" style="font-size: 11px" class="courierNewFont">
                        <div class="mb-2 mt-1">
                            <span>
                                <b>Remark :</b>
                            </span>
                            <br>
                            <span>
                                <b>{!! $purchaseOrder->description !!}</b>
                            </span>
                        </div>
                        <div class="mb-2">
                            <span>
                                <b>Term And Condition :</b>
                            </span>
                            <br>
                            <span>
                                {!! $purchaseOrder->term_and_condition !!}</span>
                            </span>
                        </div>
                        <div class="mb-2">
                            <span>
                                <b>Shipping Address :</b>
                            </span>
                            <br>
                            <span>
                                {!! $purchaseOrder->shipping_address !!}</span>
                            </span>
                        </div>
                    </td>
                    <td width="10%"></td>
                    <td width="15%" valign="top" style="font-size: 12px"><b>Grand Total</b></td>
                    <td width="25%" valign="top" class="courierNewFont" align="right" style="font-size: 12px">
                        {{number_format($grandTotal,2,",",".")}}
                    </td>
                </tr>
            </table>
        </div>
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="60%"></td>
                    <td width="30%" style="font-size: 12px">
                        <div class="text-center mb-4" style="height: 60px">
                            Approved By
                        </div>
                        <div class="text-center border-bottom border-2">
                            <span class="font-weight-bold courierNewFont">
                                <b>{{ isset($employee->name) ? $employee->name : \Illuminate\Support\Facades\Auth::user()->name }}</b>
                            </span>
                        </div>
                        <div class="text-center">
                            <span class="font-weight-bold courierNewFont">
                                <b>{{$purchaseOrder->approvals->first()->created_at ?? 'Not Yet Approved'}}</b>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
            $size = 7;
            $font = $fontMetrics->getFont("helvetica");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = $pdf->get_width() - (($pdf->get_width() - $width) / 8);
            $y = $pdf->get_height() - 16;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>
