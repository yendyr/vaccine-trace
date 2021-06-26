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
        }

        body{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; !important;
            margin-top: 3cm;
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
            top:32px;
            left: 36px;
            position: absolute;
            color:black;
        }

        .contentTitle{
            font-size: 24px;
            text-align: center;
            margin-top: 8px;
            margin-bottom: 20px;
            /*display: table;*/
        }
        .contentTitle .barcode{
            float: right;
            /*display:table-cell;*/
            /*vertical-align:middle;*/
        }

        #mainContent{
            margin-top:18px;
            margin-left:18px;
            margin-right:18px;
        }

        #content2{
            margin:24px 36px 18px;
        }

    </style>
</head>
<body>
    <header>
        <div id="bodyHead">
            <table style='font-size: 12px;'>
                <tr>
                    <td style="vertical-align: center; text-align: left; padding-top: 8px;">
                        <img src="{{$company->logo}}" alt="" style="max-height: 60px">
                    </td>
                    <td valign="top">
                        <div class="courierNewFont" style="margin-left: 16px; font-size: 10.72px">
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
                    <td width="80%" valign="top" class="courierNewFont" style="font-size: 10.72px">
                        <span style="font-size: 10px">Created By:</span>
                        <b>{{$purchaseRequisition->creator->name}}; {{$purchaseRequisition->created_at->format('d-m-Y') ?? '-' }}</b> &nbsp;&nbsp;&nbsp;
                        <span style="font-size: 10px">Printed By:</span>
                        <b>{{\Illuminate\Support\Facades\Auth::user()->name}}; {{ date('d-m-Y H:i:s') }}</b>
                    </td>
                    <td width="10%" valign="top"></td>
{{--                    <td width="10%" valign="top" align="right">Page 1/1</td>--}}
                </tr>
            </table>
        </div>
    </footer>

    <div id="mainContent" class="border-bottom border-3">
        <div class="container">
            <div class="contentTitle">
                <span style="padding-left: 4px">PURCHASE REQUEST</span>
                <span class="barcode">
                    <img src="data:image/png;base64, {!! $qrcode !!}" alt="" style="height: 60px; width: 60px">
                </span>
            </div>
            <table width="100%">
                <tr style="font-size: 16px">
                    <td width="50%">
                        Date : <span class="courierNewFont"><b>{{Carbon\Carbon::parse($purchaseRequisition->transaction_date)->format('Y-F-d') ?? '-'}}</b></span>
                    </td>
                    <td align="right" width="50%">
                        Number : <span class="courierNewFont"><b>{{$purchaseRequisition->code ?? '-'}}</b></span>
                    </td>
                </tr>
            </table>
            <table width="100%" class="table" cellpadding="3" page-break-inside: auto;>
                <thead>
                    <tr style="background-color: #0C112E; color: white; font-size: 16px">
                        <td valign="top" class="text-center" width="10%">Item Code</td>
                        <td valign="top" class="text-center" width="15%">Item Name</td>
                        <td valign="top" class="text-center" width="15%">Parent Item</td>
                        <td valign="top" class="text-center" width="7%">Qty</td>
                        <td valign="top" class="text-center" width="8%">Unit</td>
                        <td valign="top" class="text-center" width="20%">Remark</td>
                    </tr>
                </thead>
                <tbody class="courierNewFont">
                    @foreach($details as $detail)
                        <tr style="font-size: 13.28px">
                            <td valign="top" align="left">
                                {{$detail->item->code}}
                            </td>
                            <td valign="top" align="left">
                                {{$detail->item->name}}
                            </td>
                            <td valign="top" align="left">
                                @if(isset($detail->item_group))
                                    {{$detail->item_group->item->name}}
                                @else
                                    <span class='text-muted font-italic'>Not Set</span>
                                @endif
                            </td>
                            <td valign="top" align="center">
                                {{$detail->request_quantity}}
                            </td>
                            <td valign="top" align="center">
                                {{$detail->item->unit->name}}
                            </td>
                            <td valign="top" align="left">
                                {{$detail->description}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="content2" class="mt-1">
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="55%">
                        <div class="mb-2 mt-1">
                            <span style="font-size: 16px">
                                Remark :
                            </span>
                            <br>
                            <span class="courierNewFont" style="font-size: 13.28px">
                                <b>{!! $purchaseRequisition->description !!}</b>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="60%"></td>
                    <td width="30%" style="font-size: 12px">
                        <div class="text-center mb-4" style="font-size: 16px; height: 66px">
                            Approved By
                        </div>
                        <div class="text-center border-bottom border-2">
                            <span class="courierNewFont" style="font-size: 13.28px">
                                <b>{{ isset($employee->name) ? $employee->name : \Illuminate\Support\Facades\Auth::user()->name }}</b>
                            </span>
                        </div>
                        <div class="text-center">
                            <span class="font-weight-bold courierNewFont" style="font-size: 13.28px">
                                <b>{{$purchaseRequisition->approvals->first()->created_at ?? 'Not Yet Approved'}}</b>
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
