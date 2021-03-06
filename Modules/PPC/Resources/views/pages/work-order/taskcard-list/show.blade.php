@extends('layouts.master')

@section('content')
<div class="row m-b m-t">
    <div class="col-md-5">
        <div class="profile-image">
            @if($taskcard->taskcard_json->file_attachment)
            <a target="_blank" href="{{ URL::asset('uploads/company/' . $taskcard->taskcard_json->owned_by . '/taskcard/' . $taskcard->taskcard_json->file_attachment) }}">
                <img src="{{ URL::asset('assets/default-pdf-image.png') }}" class="m-t-xs" id="fileTaskcard">
            </a>

            <span class="m-l-sm font-italic"><small><label class="label label-primary" for="taskcardFile" style="cursor:pointer;" data-toggle="tooltip" title="Upload New Task Card Attachment File">Replace File</label></small></span>
            @else
            <img src="{{ URL::asset('assets/default-file-image.png') }}" class="m-t-xs" id="fileTaskcard">

            <span class="font-italic"><small><label class="label label-primary" for="taskcardFile" style="cursor:pointer;" data-toggle="tooltip" title="Upload New Task Card Attachment File">Attach New File</label></small></span>
            @endif

            <input onchange="getTaskcardFile(this)" style="display: none;" id="taskcardFile" type="file" name="taskcardFile" data-id="{{ $taskcard->taskcard_json->id }}" accept="application/pdf" />
        </div>
        <div class="profile-info">
            <h2 class="m-t-none m-b-none">
                <strong>{{ $taskcard->taskcard_json->title ?? 'Task Card Title' }}</strong>
            </h2>
            <h2 class="text-success m-t-none"><strong>{{ $taskcard->taskcard_json->mpd_number ?? '' }}</strong></h2>
            <div>Task Card Group: <strong class="text-success">{{ $taskcard->taskcard_group_json->first()->name ?? '' }}</strong></div>
            <div>Task Card Type: <strong class="text-success">{{ $taskcard->taskcard_type_json->name ?? '' }}</strong></div>
            <div>Task Card Compliance: <strong class="text-success">{{ $taskcard->taskcard_json->compliance ?? '' }}</strong></div>
        </div>
    </div>
    <div class="col-md-3">
        <div>MPD Number: <strong class="text-success">{{ $taskcard->taskcard_json->mpd_number ?? '' }}</strong></div>
        <div>Local Task Card Number: <strong class="text-success">{{ $taskcard->taskcard_json->company_number ?? '-' }}</strong></div>
        <div>ATA: <strong class="text-success">{{ $taskcard->taskcard_json->ata ?? '-' }}</strong></div>
        <div>Version: <strong class="text-success">{{ $taskcard->taskcard_json->version ?? '-' }}</strong></div>
        <div>Revision: <strong class="text-success">{{ $taskcard->taskcard_json->revision ?? '-' }}</strong></div>
        <div>Effectivity: <strong class="text-success">{{ $taskcard->taskcard_json->effectivity ?? '-' }}</strong></div>

    </div>
    <div class="col-md-4">
        <div>Issued Date: <strong class="text-success">{{ Carbon\Carbon::parse($taskcard->taskcard_json->issued_date)->format('Y-F-d') ?? '-' }}</strong></div>
        <div>Work Area: <strong class="text-success">{{ $taskcard->taskcard_workarea_json->name ?? '-' }}</strong></div>
        <div>Source: <strong class="text-success">{{ $taskcard->taskcard_json->source ?? '-' }}</strong></div>
        <div>Reference: <strong class="text-success">{{ $taskcard->taskcard_json->reference ?? '-' }}</strong></div>
        <div>Scheduled Priority: <strong class="text-success">{{ $taskcard->taskcard_json->scheduled_priority ?? '-' }}</strong></div>
        <div>Recurrence: <strong class="text-success">{{ $taskcard->taskcard_json->recurrence ?? '-' }}</strong></div>
        <div>Status: <strong>
                @if($taskcard->taskcard_json->status == 1)
                <label class="label label-success">
                    Active
                </label>
                @else
                <label class="label label-danger">
                    Inactive
                </label>
                @endif
            </strong>
        </div>
    </div>
</div>

<div class="row m-b">
    <div class="col-lg-4">
        Aircraft Type Applicability:
        @if ( !empty($taskcard->aircraft_types_json) )
        <p class="m-b-xs">
            @foreach ($taskcard->aircraft_types_json as $aircraft_type)
            <label class="label label-success">{{ $aircraft_type->name }}</label>
            @endforeach
        </p>
        @else
        <label class="label label-info">-</label>
        @endif

        Affected Item/Component Part Number:
        @if ( !empty($taskcard->affected_items_json) )
        <p class="m-b-xs">
            @foreach ($taskcard->affected_items_json as $affected_item)
            <label class="label label-success">{{ $affected_item->code }} | {{ $affected_item->name }}</label>
            @endforeach
        </p>
        @else
        <p class="m-b-xs">
            <label class="text-success">-</label>
        </p>
        @endif

        Tag:
        @if ( !empty($taskcard->tags_json) )
        <p class="m-b-xs">
            @foreach ($taskcard->tags_json as $tag)
            <label class="label label-warning">{{ $tag->name }}</label>
            @endforeach
        </p>
        @else
        <p class="m-b-xs">
            <label class="text-success">-</label>
        </p>
        @endif
    </div>
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-5">
                Access:
                @if ( !empty($taskcard->accesses_json) )
                <p class="m-b-xs">
                    @foreach ($taskcard->accesses_json as $access)
                    <label class="label label-info">{{ $access->name }}</label>
                    @endforeach
                </p>
                @else
                <p class="m-b-xs">
                    <label class="text-success">-</label>
                </p>
                @endif
            </div>
            <div class="col-lg-7">
                Zone:
                @if ( !empty($taskcard->zones_json) )
                <p class="m-b-xs">
                    @foreach ($taskcard->zones_json as $zone)
                    <label class="label label-warning">{{ $zone->name }}</label>
                    @endforeach
                </p>
                @else
                <p class="m-b-xs">
                    <label class="text-success">-</label>
                </p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                Document Library:
                @if ( !empty($taskcard->document_libraries_json) )
                <p class="m-b-xs">
                    @foreach ($taskcard->document_libraries_json as $document_library)
                    <label class="label label-danger">{{ $document_library->name }}</label>
                    @endforeach
                </p>
                @else
                <p class="m-b-xs">
                    <label class="text-success">-</label>
                </p>
                @endif
            </div>
            <div class="col-lg-7">
                Affected Manual:
                @if ( !empty($taskcard->affected_manuals_json) )
                <p class="m-b-xs">
                    @foreach ($taskcard->affected_manuals_json as $affected_manual)
                    <label class="label label-primary">{{ $affected_manual->name ?? '' }}</label>
                    @endforeach
                </p>
                @else
                <p class="m-b-xs">
                    <label class="text-success">-</label>
                </p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs" id="myTab">
                <li>
                    <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-contact">
                        <i class="fa fa-refresh fa-2x text-warning"></i>&nbsp;Control Parameter (Interval)
                    </a>
                </li>
                <li>
                    <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;" id="tab-address">
                        <i class="fa fa-edit fa-2x text-warning"></i>&nbsp;Instructions and Tasks
                    </a>
                </li>
                <li>
                    <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-3" style="min-height: 50px;" id="tab-address"> 
                        <i class="fa fa-list-ol fa-2x text-warning"></i>&nbsp;Instructions and Tasks's Tree View
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body" style="min-height: 500px;">
                        <div class="row m-b">
                            <div class="col text-info">
                                <i class="fa fa-info-circle"></i>
                                Interval Control Method: <strong>{{ $taskcard->taskcard_json->interval_control_method ?? '' }}</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 fadeIn" style="animation-duration: 1.5s">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        Threshold
                                    </div>
                                    <div class="panel-body" style="margin: 0px; width: 100%; padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-9 m-b m-l-n">
                                                <div class="col">After Flight Hour (FH):</div>
                                                <div class="col m-b">
                                                    <h3>{{ $taskcard->taskcard_json->threshold_flight_hour ?? '-' }} FH</h3>
                                                </div>
                                                <div class="col">After Flight Cycle (FC):</div>
                                                <div class="col m-b">
                                                    <h3>{{ $taskcard->taskcard_json->threshold_flight_cycle ?? '-' }} FC</h3>
                                                </div>
                                                <div class="col">After Daily Basis:</div>
                                                <div class="col m-b">
                                                    <h3>{{ $taskcard->taskcard_json->threshold_daily ?? '-' }} {{ $taskcard->taskcard_json->threshold_daily_unit ?? '' }}(s)</h3>
                                                </div>
                                                <div class="col">After Exact Calendar Date:</div>
                                                <div class="col m-b">
                                                    <h3>
                                                        @if($taskcard->taskcard_json->threshold_date)
                                                        {{ Carbon\Carbon::parse($taskcard->taskcard_json->threshold_date)->format('Y-F-d') }}
                                                        @else
                                                        -
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="col-md-3 m-b">
                                                <i class="text-danger fa fa-sign-in fa-5x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 fadeIn" style="animation-duration: 1.5s">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        Repeat
                                    </div>
                                    <div class="panel-body" style="margin: 0px; width: 100%; padding-bottom: 0;">
                                        <div class="row">
                                            <div class="col-md-9 m-b m-l-n">
                                                <div class="col">After Flight Hour (FH):</div>
                                                <div class="col m-b">
                                                    <h3>{{ $taskcard->taskcard_json->repeat_flight_hour ?? '-' }} FH</h3>
                                                </div>
                                                <div class="col">After Flight Cycle (FC):</div>
                                                <div class="col m-b">
                                                    <h3>{{ $taskcard->taskcard_json->repeat_flight_cycle ?? '-' }} FC</h3>
                                                </div>
                                                <div class="col">After Daily Basis:</div>
                                                <div class="col m-b">
                                                    <h3>{{ $taskcard->taskcard_json->repeat_daily ?? '-' }} {{ $taskcard->taskcard_json->repeat_daily_unit ?? '' }}(s)</h3>
                                                </div>
                                                <div class="col">After Exact Calendar Date:</div>
                                                <div class="col m-b">
                                                    <h3>
                                                        @if($taskcard->taskcard_json->repeat_date)
                                                        {{ Carbon\Carbon::parse($taskcard->taskcard_json->repeat_date)->format('Y-F-d') }}
                                                        @else
                                                        -
                                                        @endif
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="col-md-3 m-b">
                                                <i class="text-danger fa fa-refresh fa-5x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body" style="min-height: 500px;">
                        <div class="row m-b">
                            <div class="col">

                            </div>
                        </div>
                        <div class="row">
                            @if ( !empty($taskcard->details) )
                            @foreach ($taskcard->details->sortBy('sequence') as $instruction_key => $instruction_detail)
                            <div class="col-md-12 fadeIn" style="animation-duration: 1.5s">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-md-3">
                                                Instruction Sequence: <label class="label label-danger m-b-none">{{ $instruction_detail->sequence ?? '-' }}</label>
                                            </div>
                                            <div class="col">
                                                Task Code: <label class="label label-danger m-b-none">{{ $instruction_detail->instruction_code ?? '-' }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="margin: 0px; width: 100%;">
                                        <div class="row">
                                            <div class="col-md-3 p-xs border">Work Area: <p class="m-b-xs"><strong>{{ $instruction_detail->taskcard_workarea->name ?? '-' }}</strong></p>
                                            </div>
                                            <div class="col-md-3 p-xs border">Manhours Estimation: <p class="m-b-xs"><strong>{{ $instruction_detail->manhours_estimation ?? '-' }}</strong></p>
                                            </div>
                                            <div class="col-md-3 p-xs border">Performance Factor: <p class="m-b-xs"><strong>{{ $instruction_detail->performance_factor ?? '-' }}</strong></p>
                                            </div>
                                            <div class="col-md-3 p-xs border">Minimum Engineering Level: <p class="m-b-xs"><strong>{{ $instruction_detail->engineering_level->name ?? '-' }}</strong></p>
                                            </div>
                                            <div class="col-md-3 p-xs border">Manpower Quantity: <p class="m-b-xs"><strong>{{ $instruction_detail->manpower_quantity ?? '-' }}</strong></p>
                                            </div>
                                            <div class="col-md-3 p-xs border">Task Release Level: <p class="m-b-xs"><strong>{{ $instruction_detail->task_release_level->name ?? '-' }}</strong></p>
                                            </div>
                                            <div class="col-md-6 p-xs border">Skill Requirement:
                                                @if ( !empty($instruction_detail->skills) )
                                                <p class="m-b-xs">
                                                    @foreach ($instruction_detail->skills as $skill)
                                                    <label class="label label-success m-b-none">{{ $skill->name }}</label>
                                                    @endforeach
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 p-xs">
                                                <div class="ibox full-height">
                                                    <div class="ibox-title">
                                                        <h4 class="text-center">Instruction/Task</h4>
                                                        <div class="ibox-tools">
                                                            <a class="collapse-link">
                                                                <i class="fa fa-chevron-up"></i>
                                                            </a>
                                                            <a class="fullscreen-link">
                                                                <i class="fa fa-expand"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content">
                                                        @if ($instruction_detail->instruction)
                                                        {!! $instruction_detail->instruction !!}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 p-xs">
                                                <div class="ibox full-height">
                                                    <div class="ibox-title">
                                                        <h4 class="text-center">Item Requirement</h4>
                                                        <div class="ibox-tools">
                                                            <a class="collapse-link">
                                                                <i class="fa fa-chevron-up"></i>
                                                            </a>
                                                            <a class="fullscreen-link">
                                                                <i class="fa fa-expand"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <div class="table-responsive" style="font-size: 9pt;">
                                                            <table id="{{ $instruction_detail->id ?? '-' }}" class="perInstructionItem table table-hover table-striped text-center" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="font-weight: normal;">Code</th>
                                                                        <th style="font-weight: normal;">Item Name</th>
                                                                        <th style="font-weight: normal;">Qty</th>
                                                                        <th style="font-weight: normal;">Unit</th>
                                                                        <th style="font-weight: normal;">Category</th>
                                                                        <th style="font-weight: normal;">Remark</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if ( !empty($instruction_detail->items) )
                                                                    @foreach ($instruction_detail->items as $item_detail)
                                                                    <tr>
                                                                        <td>{{ $item_detail->item->code ?? '' }}</td>
                                                                        <td>{{ $item_detail->item->name ?? '' }}</td>
                                                                        <td>{{ $item_detail->quantity ?? '' }}</td>
                                                                        <td>{{ $item_detail->unit->name ?? '' }}</td>
                                                                        <td>{{ $item_detail->category->name ?? '' }}</td>
                                                                        <td>{{ $item_detail->description ?? '' }}</td>
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
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="col-md-12 m-t-xl">
                                <p class="font-italic text-center m-t-xl">No Data Found</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div id="tab-3" class="tab-pane">
                    <div class="panel-body" style="min-height: 500px;">
                        <div class="row m-b">
                            <div class="col">
                                <span class="text-info font-italic"><i class="fa fa-info-circle"></i>&nbsp;Refresh Page to See Tree Structure Changes After Add or Updating Data</span>
                            </div>
                        </div>
                        <div class="row m-b">
                            @include('ppc::pages.work-order.tree-view.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('header-scripts')
<style>
    .select2-container.select2-container--default.select2-container--open {
        z-index: 9999999 !important;
    }

    .select2 {
        width: 100% !important;
    }
</style>
@endpush

@push('footer-scripts')
<script>
    $(document).ready(function() {
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>
@endpush