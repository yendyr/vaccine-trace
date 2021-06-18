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
            font-family: 'Segoe UI', "Courier New", sans-serif;
            margin-top: 4.5cm;
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
            height: 0.7cm;
            font-size: 9px;
            margin-bottom: 0px;
        }
        /* ul li{
            display: inline-block;
        } */

        table{
            border-collapse: collapse;
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
<body style='font-family: "Courier New", Courier, monospace'>
    <header>
        <div id="bodyHead">
            <table width="80%" style='font-size: 12px;'>
                <tr>
                    <td width="80%">
                        <table width="100%">
                            <tr>
                                <td width="50%" style="vertical-align: center; text-align: center; padding-top: 12px;">
                                    <img src="{{$company->logo}}" alt="" style="max-height: 75px">
                                </td>
                                <td width="50%" valign="top">
                                    <div class="pb-1" style="font-size: 13px;">FROM:</div>
                                    <b>{{strtoupper($company->name)}}</b>
                                    <br>{{$companyAddress->street}}
                                    <br>{{$companyAddress->city}} - {{$companyAddress->post_code}}
                                    <br>{{$companyAddress->city}} {{$companyAddress->province}} {{$companyAddress->post_code}}
                                    <br>{{$companyAddress->country->nice_name}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="80%" valign="top">Created By: {{$purchaseOrder->creator->name}}; {{$purchaseOrder->created_at->format('d-m-Y') ?? '-' }} &nbsp;&nbsp;&nbsp; Printed By: {{\Illuminate\Support\Facades\Auth::user()->name}}; {{ date('d-m-Y H:i:s') }}</span> </td>
                    <td width="10%" valign="top"></td>
{{--                    <td width="10%" valign="top" align="right">Page 1/1</td>--}}
                </tr>
            </table>
        </div>
    </footer>

    <div id="content1">
        <table width="100%">
            <tr>
                <td width="33%" class="border-top border-bottom" style="font-size: 13px;">
                    <span>TO:</span>
                </td>
                <td width="24%" valign="top">
                </td>
                <td width="33%" class="border-top border-bottom" style="font-size: 16px; text-align: center;">
                    <span><b>PURCHASE ORDER:</b></span>
                </td>
            </tr>
            <tr>
                @php
                    $toAddress = $purchaseOrder->supplier->addresses[0];
                @endphp
                <td width="33%" class="py-0" style="font-size: 13px;">
                    <span><br><b>{{strtoupper($purchaseOrder->supplier->name)}}</b></span>
                    <span><br>{{$toAddress->street}}</span>
                    <span><br>{{$toAddress->city}} - {{$toAddress->post_code}}</span>
                    <span><br>{{$toAddress->city}} {{$toAddress->province}} {{$toAddress->post_code}}</span>
                    <span><br>{{$toAddress->country->nice_name}}</span>
                </td>
                <td width="34%">
                </td>
                <td width="33%" style="font-size: 13px;">
                    <table>
                        <tr>
                            <td width="40%">Number</td>
                            <td width="15%">:</td>
                            <td width="45%">{{$purchaseOrder->code}}</td>
                        </tr>
                        <tr>
                            <td width="40%">Date</td>
                            <td width="15%">:</td>
                            <td width="45%">{{$purchaseOrder->transaction_date}}</td>
                        </tr>
                        <tr>
                            <td width="40%">Currency</td>
                            <td width="15%">:</td>
                            <td width="45%">{{$purchaseOrder->currency->code}}</td>
                        </tr>
                        <tr>
                            <td width="40%">Rate</td>
                            <td width="15%">:</td>
                            <td width="45%">{{$purchaseOrder->exchange_rate}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div id="content2">
        <div class="container">
            <table width="100%" class="table" cellpadding="3" page-break-inside: auto;>
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
                    <td width="55%" style="font-size: 11px">
                        <div class="mb-2 mt-1">
                            <span>
                                <b>Remark :</b>
                            </span>
                            <br>
                            <span>
                                {!! $purchaseOrder->description !!}
                            </span>
                        </div>
                        <div class="mb-2">
                            <span>
                                <b>Term And Condition :</b>
                            </span>
                            <br>
                            <span>
                                {!! $purchaseOrder->term_and_condition !!}
                            </span>
                        </div>
                        <div class="mb-2">
                            <span>
                                <b>Shipping Address :</b>
                            </span>
                            <br>
                            <span>
                                {!! $purchaseOrder->shipping_address !!}
                            </span>
                        </div>
                    </td>
                    <td width="10%"></td>
                    <td width="15%" valign="top" style="font-size: 12px"><b>Grand Total</b></td>
                    <td width="25%" valign="top" style="font-size: 12px" align="right">{{number_format($grandTotal,2,",",".")}}</td>
                </tr>
            </table>
        </div>
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="60%"></td>
                    <td width="30%" style="font-size: 12px">
                        <div class="text-center mb-4" style="height: 60px">
                            <b>Approved By</b>
                        </div>
                        <div class="text-center border-bottom border-2">
                            <span>{{ isset($employee->name) ? $employee->name : \Illuminate\Support\Facades\Auth::user()->name }}</span>
                        </div>
                        <div class="text-center">
                            <span>
                                {{$purchaseOrder->approvals->first()->created_at ?? 'Not Yet Approved'}}
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
            $font = $fontMetrics->getFont("Courier New");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = $pdf->get_width() - (($pdf->get_width() - $width) / 8) - 10;
            $y = $pdf->get_height() - 18;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>
