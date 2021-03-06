<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JOB CARD - {{ $job_card->code ?? null }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
        @page {
            margin: 1cm 1cm;
        }

        html,
        body {
            padding: 0;
            margin: 0;
            font-size: 11px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
             !important;
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

        table {
            margin-top: 10px;
            border-collapse: collapse;
        }

        .helveticaFont {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; !important;
        }

        .courierNewFont {
            font-family: "Courier New", Courier, monospace;
        }

        .td-border {
            border: 1px solid black;
        }

        .border-top{
            border-top: 1px solid black;
        }

        .border-bottom{
            border-bottom: 1px solid black;
        }

        .border-left{
            border-left: 1px solid black;
        }
        
        .border-right{
            border-right: 1px solid black;
        }

        #bodyHead {
            top: 40px;
            left: 36px;
            position: absolute;
            color: black;
        }

        #content {
            left: 36px;
            margin: 0px 36px;
        }
    </style>
</head>

<body>
    <header>
        <div id="bodyHead">
            <table style='font-size: 12px;' width="90%">
                <tr>
                    <td style="vertical-align: center; text-align: left;" width=30%>
                        <img src="{{ URL::asset('/Logo-Web.png') }}" alt="" style="max-height: 100px;">
                    </td>
                    <td valign="top" class="courierNewFont" width=70%>
                        <div style="margin-left: 16px">
                            <b>PT. SARANA MENDULANG ARTA</b> <br>
                            <b>Jl. Pluit Karang Cantik Blok B4 No. 29</b> <br>
                            <b>Penjaringan, Jakarta Utara - 14450</b> <br>
                            <b>Jakart DKI Jakarta 14450</b>
                            <b>Indonesia</b>
                        </div>
                    </td>
                    <td style="text-align:right;" width=30%>
                        <span class="barcode">
                            <img src="data:image/png;base64, {!! $qrcode !!}" alt="" style="height: 60px; width: 60px">
                        </span>
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
                        <b>{{ $job_card->creator->name}}; {{ $job_card->created_at->format('d-m-Y') ?? '-'  ?? null }}</b> &nbsp;&nbsp;&nbsp;
                        <span style="font-size: 10px">Printed By:</span>
                        <b>{{ $print_by ?? '-' }}; {{ date('d-m-Y H:i:s')  ?? null }}</b>
                    </td>
                    <td width="10%" valign="top"></td>
                </tr>
            </table>
        </div>
    </footer>

    <div id="content">
        <table width="100%">
            <tr>
                <td width="100%" colspan="3" align="center" valign="top" style="font-size:30px;">
                    <b>MAINTENANCE TASKCARD</b>
                </td>
            </tr>
            <tr>
                <td width="33%">
                    <span>Task Card No. : </span> <b class="courierNewFont">{{ $job_card->taskcard_json->code ?? '-' }}</b>
                </td>
                <td width="33%">
                    <span>Company Task Card No. : </span> <b class="courierNewFont">{{ $job_card->taskcard_json->company_number ?? '-' }}</b>
                </td>
                <td width="33%">
                    <span>Job Card No. : </span> <b class="courierNewFont"> {{ $job_card->code ?? '-' }}</b>
                </td>
            </tr>
        </table>
        <table width="100%" style="border: 1px solid black;">
            <tr>
                <td width="33%" style="border: 1px solid black;">
                    <span>Task Card Group</span> <b class="courierNewFont">: {{ $job_card->taskcard_group_json->first()->name ?? '' }} </b> <br>
                    <span>Task Card Type</span> <b class="courierNewFont">: {{ $job_card->taskcard_type_json->name ?? '' }} </b> <br>
                    <span>Task Card Compliance</span> <b class="courierNewFont">: {{ $job_card->taskcard_json->compliance ?? '' }} </b> <br>
                    <span>ATA</span> <b class="courierNewFont">: {{ $job_card->taskcard_json->ata ?? '-' }} </b> <br>
                    <span>Version</span> <b class="courierNewFont">: {{ $job_card->taskcard_json->version ?? '-' }} </b> <br>
                    <span>Revision</span> <b class="courierNewFont">: {{ $job_card->taskcard_json->revision ?? '-' }} </b> <br>
                </td>
                <td width="33%" style="text-align: center;border: 1px solid black;" valign="top">
                    <span>Task Card Title</span> <br>
                    <b class="courierNewFont"> {{ $job_card->taskcard_json->title ?? 'Task Card Title' }} </b>
                </td>
                <td width="33%" style="border: 1px solid black;" valign="top">
                    <span>Effectivity</span> <b class="courierNewFont">: {{ $job_card->taskcard_json->effectivity ?? '-' }} </b> <br>
                    <span>Source</span> <b class="courierNewFont">: {{ $job_card->taskcard_json->source ?? '-' }} </b> <br>
                    <span>Reference</span> <b class="courierNewFont">: {{ $job_card->taskcard_json->reference ?? '-' }} </b> <br>
                    <span>Scheduled Priority</span> <b class="courierNewFont">: {{ $job_card->taskcard_json->scheduled_priority ?? '-' }} </b> <br>
                    <span>Recurrence</span> <b class="courierNewFont">: {{ $job_card->taskcard_json->recurrence ?? '-' }} </b> <br>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="33%" valign="top">
                    <span>Aircraft Type Applicability</span> <b class="courierNewFont">: {{ $ac_type_applicability ?? '-' }} </b> <br>
                    <span>Affected Item/Component Part Number</span> <b class="courierNewFont">: {{ $affected_items ?? '-' }} </b> <br>
                    <span>Access</span> <b class="courierNewFont">: {{ $accesses ?? '-' }} </b> <br>
                    <span>Zone</span> <b class="courierNewFont">: {{ $zones ?? '-' }} </b> <br>
                    <span>Interval Control Method</span> <b class="courierNewFont">: {{ $job_card->taskcard_json->interval_control_method ?? '' }} </b> <br>
                </td>
                <td width="33%">
                    <span>Document Library</span> <b class="courierNewFont">: {{ $document_libraries ?? '-' }} </b> <br>
                    <span>Affected Manual</span> <b class="courierNewFont">: {{ $affected_manuals ?? '-' }} </b> <br>
                    <span>Tag</span> <b class="courierNewFont">: {{ $tags ?? '-' }} </b> <br>
                    <span>Work Area</span> <b class="courierNewFont">: {{ $work_areas ?? '-' }} </b> <br>
                    <span>Threshold</span> <b class="courierNewFont">: {{ $threshold ?? '-' }} </b> <br>
                    <span>Repeat</span> <b class="courierNewFont">: {{ $repeat ?? '-' }} </b> <br>
                </td>
            </tr>
        </table>
        <table width="100%" style="border-top: 1px solid black">
            <tr>
                <td colspan="2" width="50%">
                    <span>Aircraft Registration</span> <b class="courierNewFont">: {{ 'PK-NYT' }} </b> <br>
                </td>
                <td colspan="2" width="50%">
                    <span>Aircraft Serial Number</span> <b class="courierNewFont">: {{ '6543' }} </b> <br>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <span>Work Order No./Title</span> <b class="courierNewFont">: {{ '6543' }} </b> <br>
                </td>
            </tr>
            <tr>
                <td width="25%">
                    <span>Manhours Estimation Summary</span> <b class="courierNewFont">: {{ '6543' }} </b> <br>
                </td>
                <td width="25%">
                    <span>Manhours Actual Summary</span> <b class="courierNewFont">: {{ '6543' }} </b> <br>
                </td>
                <td width="25%">
                    <span>Manpower Estimation Summary</span> <b class="courierNewFont">: {{ '6543' }} </b> <br>
                </td>
                <td width="25%">
                    <span>Manpower Actual Summary</span> <b class="courierNewFont">: {{ '6543' }} </b> <br>
                </td>
            </tr>
        </table>

        @foreach($instructions as $instructionRow)
        <table width="100%" style="border: 1px solid black">
            <thead>
                <tr style="background-color:black; color: white;">
                    <th width="50%"> 
                        <span>Task Code </span> <b class="courierNewFont">: {{ $instructionRow->origin_instruction[0]->code ?? '-' }} </b>
                    </th>
                    <th width="50%" style="text-align:right;"> 
                        <span>Instruction Sequence </span> <b class="courierNewFont">: {{ $instructionRow->sequence ?? '-' }} </b>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="td-border" width="50%">
                        <span>Work Area </span> <b class="courierNewFont">: {{ $instructionRow->taskcard_workarea->name ?? '-' }} </b>
                    </td>
                    <td class="td-border" width="50%">
                        <span>Skill </span> <b class="courierNewFont">: 
                        @if ( !empty(json_decode($instructionRow->skills_json)) )
                           {{ collect(json_decode($instructionRow->skills_json))->pluck('name')->join(', ') }}
                        @endif
                        </b>
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="border: 1px solid black; border-top: none; margin-top: 0cm;">
            
            <tbody>
                <tr>
                    <td class="td-border" width="33%">
                        <span>Performance Factor </span> <b class="courierNewFont">: {{ $instructionRow->performance_factor ?? '-' }} </b>
                    </td>
                    <td class="td-border" width="33%">
                        <span>Minimum Engineering Level </span> <b class="courierNewFont">: {{ $instructionRow->engineering_level->name ?? '-' }} </b>
                    </td>
                    <td class="td-border" width="33%">
                        <span>Task Release Level </span> <b class="courierNewFont">: {{ $instructionRow->task_release_level->last()->name ?? '-' }} </b>
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="border: 1px solid black; border-top: none; margin-top: 0cm;">
            <tbody>
                <tr>
                    <td class="td-border" width="80%">
                        <span>Job Instruction </span>
                    </td>
                    <td class="td-border" width="10%" style="text-align: center;">
                        <span>MECH</span>
                    </td>
                    <td class="td-border" width="10%" style="text-align: center;">
                        <span>INSP</span>
                    </td>
                </tr>
                <tr>
                    <td class="td-border" width="80%">
                    @if ($instructionRow->instruction)
                        <b class="courierNewFont">{!! $instructionRow->instruction !!}</b>
                    @endif

                    <br>
                    <span>Item Requirement(s):</span>
                    @if ( $instructionRow->items()->count() > 0 )
                    <table style="border-top:1px solid black;" style="width:100%">
                        <thead>
                            <tr style="border-top:1px solid black;">
                                <th style="font-weight: normal;">Code/Part Number</th>
                                <th style="font-weight: normal;">Item Name</th>
                                <th style="font-weight: normal;">Qty</th>
                                <th style="font-weight: normal;">Unit</th>
                                <th style="font-weight: normal;">Category</th>
                                <th style="font-weight: normal;">Remark</th>
                            </tr>
                        </thead>
                        <tbody style="border-top:1px solid black;">
                                @foreach ($instructionRow->items as $item_detail)
                                <tr>
                                    <td>{{ $item_detail->item->code ?? '' }}</td>
                                    <td>{{ $item_detail->item->name ?? '' }}</td>
                                    <td>{{ $item_detail->quantity ?? '' }}</td>
                                    <td>{{ $item_detail->unit->name ?? '' }}</td>
                                    <td>{{ $item_detail->category->name ?? '' }}</td>
                                    <td>{{ $item_detail->description ?? '' }}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    @else
                    <div style="text-align:center" >
                        <b><i>- NONE -</i></b>
                    </div>
                    @endif
                    <br>
                    <div style="text-align:center; border-top:1px solid black;" >
                        <b><i>- End Of Task -</i></b>
                    </div>
                    </td>
                    <td class="td-border" width="10%">
                    </td>
                    <td class="td-border" width="10%">
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="border: 1px solid black; border-top: none; margin-top: 0cm;">
            <tbody>
                <tr>
                    <td width="25%">
                        <span>Manhours Estimation</span><b class="courierNewFont">: {{ $instructionRow->manhours_estimation ?? '-' }}</b>
                    </td>
                    <td width="25%">
                        <span>Manhours Actual</span><b class="courierNewFont">: {{ $instructionRow->actual_manhour ?? '-' }}</b>
                    </td>
                    <td width="25%">
                        <span>Manpower Estimation</span><b class="courierNewFont">: {{ $instructionRow->manpower_quantity ?? '-' }}</b>
                    </td>
                    <td width="25%">
                        <span>Manpower Actual</span><b class="courierNewFont">: {{ $instructionRow->manpower_quantity ?? '-' }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- TO DO IF INSTRUCTION HAS SUB-TASKS -->
        @if( $instructionRow->subTasks()->count() > 0 )
            @foreach($instructionRow->subTasks as $subTask)
            <div style="margin-left: 6cm;">
                <table width="100%" style="border: 1px solid black">
                    <thead>
                        <tr style="background-color:black; color: white;">
                            <th width="50%"> 
                                <span>Task Code </span> <b class="courierNewFont">: {{ $subTask->origin_instruction[0]->code ?? '-' }} </b>
                            </th>
                            <th width="50%" style="text-align:right;"> 
                                <span>Instruction Sequence </span> <b class="courierNewFont">: {{ $subTask->sequence ?? '-' }} </b>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td-border" width="50%">
                                <span>Work Area </span> <b class="courierNewFont">: {{ $subTask->taskcard_workarea->name ?? '-' }} </b>
                            </td>
                            <td class="td-border" width="50%">
                                <span>Skill </span> <b class="courierNewFont">: 
                                @if ( !empty(json_decode($subTask->skills_json)) )
                                {{ collect(json_decode($subTask->skills_json))->pluck('name')->join(', ') }}
                                @endif
                                </b>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" style="border: 1px solid black; border-top: none; margin-top: 0cm;">
                    
                    <tbody>
                        <tr>
                            <td class="td-border" width="33%">
                                <span>Performance Factor </span> <b class="courierNewFont">: {{ $subTask->performance_factor ?? '-' }} </b>
                            </td>
                            <td class="td-border" width="33%">
                                <span>Minimum Engineering Level </span> <b class="courierNewFont">: {{ $subTask->engineering_level->name ?? '-' }} </b>
                            </td>
                            <td class="td-border" width="33%">
                                <span>Task Release Level </span> <b class="courierNewFont">: {{ $subTask->task_release_level->last()->name ?? '-' }} </b>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" style="border: 1px solid black; border-top: none; margin-top: 0cm;">
                    <tbody>
                        <tr>
                            <td class="td-border" width="80%">
                                <span>Job Instruction </span>
                            </td>
                            <td class="td-border" width="10%" style="text-align: center;">
                                <span>MECH</span>
                            </td>
                            <td class="td-border" width="10%" style="text-align: center;">
                                <span>INSP</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-border" width="80%">
                            @if ($subTask->instruction)
                                <b class="courierNewFont">{!! $subTask->instruction !!}</b>
                            @endif

                            <br>
                            <span>Item Requirement(s):</span>
                            @if ( $subTask->items()->count() > 0 )
                            <table style="border-top:1px solid black;" style="width:100%">
                                <thead>
                                    <tr style="border-top:1px solid black;">
                                        <th style="font-weight: normal;">Code/Part Number</th>
                                        <th style="font-weight: normal;">Item Name</th>
                                        <th style="font-weight: normal;">Qty</th>
                                        <th style="font-weight: normal;">Unit</th>
                                        <th style="font-weight: normal;">Category</th>
                                        <th style="font-weight: normal;">Remark</th>
                                    </tr>
                                </thead>
                                <tbody style="border-top:1px solid black;">
                                        @foreach ($subTask->items as $item_detail)
                                        <tr>
                                            <td>{{ $item_detail->item->code ?? '' }}</td>
                                            <td>{{ $item_detail->item->name ?? '' }}</td>
                                            <td>{{ $item_detail->quantity ?? '' }}</td>
                                            <td>{{ $item_detail->unit->name ?? '' }}</td>
                                            <td>{{ $item_detail->category->name ?? '' }}</td>
                                            <td>{{ $item_detail->description ?? '' }}</td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                            @else
                            <div style="text-align:center" >
                                <b><i>- NONE -</i></b>
                            </div>
                            @endif
                            <br>
                            <div style="text-align:center; border-top:1px solid black;" >
                                <b><i>- End Of Task -</i></b>
                            </div>
                            </td>
                            <td class="td-border" width="10%">
                            </td>
                            <td class="td-border" width="10%">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" style="border: 1px solid black; border-top: none; margin-top: 0cm;">
                    <tbody>
                        <tr>
                            <td width="25%">
                                <span>Manhours Estimation</span><b class="courierNewFont">: {{ $subTask->manhours_estimation ?? '-' }}</b>
                            </td>
                            <td width="25%">
                                <span>Manhours Actual</span><b class="courierNewFont">: {{ $subTask->actual_manhour ?? '-' }}</b>
                            </td>
                            <td width="25%">
                                <span>Manpower Estimation</span><b class="courierNewFont">: {{ $subTask->manpower_quantity ?? '-' }}</b>
                            </td>
                            <td width="25%">
                                <span>Manpower Actual</span><b class="courierNewFont">: {{ $subTask->manpower_quantity ?? '-' }}</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endforeach
            @if( $subTask->subTasks()->count() > 0)
                @foreach( $subTask->subTasks as $subTaskChildRow)
                    <div style="margin-left: 3cm;">
                        <table width="100%" style="border: 1px solid black">
                            <thead>
                                <tr style="background-color:black; color: white;">
                                    <th width="50%"> 
                                        <span>Task Code </span> <b class="courierNewFont">: {{ $subTaskChildRow->origin_instruction[0]->code ?? '-' }} </b>
                                    </th>
                                    <th width="50%" style="text-align:right;"> 
                                        <span>Instruction Sequence </span> <b class="courierNewFont">: {{ $subTaskChildRow->sequence ?? '-' }} </b>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="td-border" width="50%">
                                        <span>Work Area </span> <b class="courierNewFont">: {{ $subTaskChildRow->taskcard_workarea->name ?? '-' }} </b>
                                    </td>
                                    <td class="td-border" width="50%">
                                        <span>Skill </span> <b class="courierNewFont">: 
                                        @if ( !empty(json_decode($subTaskChildRow->skills_json)) )
                                        {{ collect(json_decode($subTaskChildRow->skills_json))->pluck('name')->join(', ') }}
                                        @endif
                                        </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" style="border: 1px solid black; border-top: none; margin-top: 0cm;">
                            
                            <tbody>
                                <tr>
                                    <td class="td-border" width="33%">
                                        <span>Performance Factor </span> <b class="courierNewFont">: {{ $subTaskChildRow->performance_factor ?? '-' }} </b>
                                    </td>
                                    <td class="td-border" width="33%">
                                        <span>Minimum Engineering Level </span> <b class="courierNewFont">: {{ $subTaskChildRow->engineering_level->name ?? '-' }} </b>
                                    </td>
                                    <td class="td-border" width="33%">
                                        <span>Task Release Level </span> <b class="courierNewFont">: {{ $subTaskChildRow->task_release_level->last()->name ?? '-' }} </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" style="border: 1px solid black; border-top: none; margin-top: 0cm;">
                            <tbody>
                                <tr>
                                    <td class="td-border" width="80%">
                                        <span>Job Instruction </span>
                                    </td>
                                    <td class="td-border" width="10%" style="text-align: center;">
                                        <span>MECH</span>
                                    </td>
                                    <td class="td-border" width="10%" style="text-align: center;">
                                        <span>INSP</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-border" width="80%">
                                    @if ($subTaskChildRow->instruction)
                                        <b class="courierNewFont">{!! $subTaskChildRow->instruction !!}</b>
                                    @endif

                                    <br>
                                    <span>Item Requirement(s):</span>
                                    @if ( $subTaskChildRow->items()->count() > 0 )
                                    <table style="border-top:1px solid black;" style="width:100%">
                                        <thead>
                                            <tr style="border-top:1px solid black;">
                                                <th style="font-weight: normal;">Code/Part Number</th>
                                                <th style="font-weight: normal;">Item Name</th>
                                                <th style="font-weight: normal;">Qty</th>
                                                <th style="font-weight: normal;">Unit</th>
                                                <th style="font-weight: normal;">Category</th>
                                                <th style="font-weight: normal;">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody style="border-top:1px solid black;">
                                                @foreach ($subTask->items as $item_detail)
                                                <tr>
                                                    <td>{{ $item_detail->item->code ?? '' }}</td>
                                                    <td>{{ $item_detail->item->name ?? '' }}</td>
                                                    <td>{{ $item_detail->quantity ?? '' }}</td>
                                                    <td>{{ $item_detail->unit->name ?? '' }}</td>
                                                    <td>{{ $item_detail->category->name ?? '' }}</td>
                                                    <td>{{ $item_detail->description ?? '' }}</td>
                                                </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <div style="text-align:center" >
                                        <b><i>- NONE -</i></b>
                                    </div>
                                    @endif
                                    <br>
                                    <div style="text-align:center; border-top:1px solid black;" >
                                        <b><i>- End Of Task -</i></b>
                                    </div>
                                    </td>
                                    <td class="td-border" width="10%">
                                    </td>
                                    <td class="td-border" width="10%">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" style="border: 1px solid black; border-top: none; margin-top: 0cm;">
                            <tbody>
                                <tr>
                                    <td width="25%">
                                        <span>Manhours Estimation</span><b class="courierNewFont">: {{ $subTask->manhours_estimation ?? '-' }}</b>
                                    </td>
                                    <td width="25%">
                                        <span>Manhours Actual</span><b class="courierNewFont">: {{ $subTask->actual_manhour ?? '-' }}</b>
                                    </td>
                                    <td width="25%">
                                        <span>Manpower Estimation</span><b class="courierNewFont">: {{ $subTask->manpower_quantity ?? '-' }}</b>
                                    </td>
                                    <td width="25%">
                                        <span>Manpower Actual</span><b class="courierNewFont">: {{ $subTask->manpower_quantity ?? '-' }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
        @endif
        @endforeach
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
