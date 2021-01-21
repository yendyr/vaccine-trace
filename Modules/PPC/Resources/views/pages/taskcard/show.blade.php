@extends('layouts.master')

@section('content')
    @include('ppc::pages.taskcard.control-parameter.modal')

    <div class="row m-b m-t">
        <div class="col-md-5">
            <div class="profile-image">
                <label for="logo-input" style="cursor:pointer;" data-toggle="tooltip" title="Change Taskcard File">
                    @if($Taskcard->logo)
                        <img src="{{ URL::asset('uploads/company/' . $Taskcard->id . '/logo/' . $Taskcard->logo) }}" class="m-b-md m-t-xs" alt="profile" id="companyLogo">
                    @else
                        <img src="{{ URL::asset('assets/default-file-image.png') }}" class="m-b-md m-t-xs" alt="profile" id="companyLogo">
                    @endif
                </label>

                <input onchange="getTaskcardLogo(this)" style="display: none;" id="logo-input" type="file" name="logo-input" data-id="{{ $Taskcard->id }}"/>
            </div>
            <div class="profile-info">
                <h2 style="margin-top: 0;">
                    <strong class="m-b">{{ $Taskcard->title ?? 'Task Card MPD Number' }}</strong>
                </h2>
                <div>Task Card Group: <strong class="text-info">{{ $Taskcard->taskcard_group->name ?? '' }}</strong></div>
                <div>Task Card Type: <strong class="text-info">{{ $Taskcard->taskcard_type->name ?? '' }}</strong></div>
            </div>
        </div>
        <div class="col-md-3">
            <div>MPD Number: <strong class="text-info">{{ $Taskcard->mpd_number ?? '' }}</strong></div>
            <div>Local Task Card Number: <strong class="text-info">{{ $Taskcard->company_number ?? '-' }}</strong></div>
            <div>ATA: <strong class="text-info">{{ $Taskcard->ata ?? '-' }}</strong></div>
            <div>Version: <strong class="text-info">{{ $Taskcard->version ?? '-' }}</strong></div>
            <div>Revision: <strong class="text-info">{{ $Taskcard->revision ?? '-' }}</strong></div>
            <div>Effectivity: <strong class="text-info">{{ $Taskcard->effectivity ?? '-' }}</strong></div>
            
        </div>
        <div class="col-md-4">
            <div>Work Area: <strong class="text-info">{{ $Taskcard->taskcard_workarea->name ?? '-' }}</strong></div>
            <div>Source: <strong class="text-info">{{ $Taskcard->source ?? '-' }}</strong></div>
            <div>Reference: <strong class="text-info">{{ $Taskcard->reference ?? '-' }}</strong></div>
            <div>Scheduled Priority: <strong class="text-info">{{ $Taskcard->scheduled_priority ?? '-' }}</strong></div>
            <div>Recurrence: <strong class="text-info">{{ $Taskcard->recurrence ?? '-' }}</strong></div>
            <div>Status: <strong>
                @if($Taskcard->status == 1)
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
        <div class="col-md-5">
            Aircraft Type Applicability:&nbsp;
            @include('ppc::pages.taskcard.aircraft-type-detail.item')
        </div>
        <div class="col-md-7" style="padding-left: 0;">
            <div class="col">
                Access:&nbsp;
                @include('ppc::pages.taskcard.access-detail.item')
                &nbsp;&nbsp;&nbsp;&nbsp;Zone:&nbsp;
                @include('ppc::pages.taskcard.zone-detail.item')
                &nbsp;&nbsp;&nbsp;&nbsp;Work Area:&nbsp;
                <label class="label label-info">{{ $Taskcard->taskcard_workarea->name ?? '' }}</label>
            </div>
            <div class="col">
                Document Library:&nbsp;
                @include('ppc::pages.taskcard.document-library-detail.item')
            </div>
            <div class="col">
                Affected Manual:&nbsp;
                @include('ppc::pages.taskcard.affected-manual-detail.item')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <div class="tabs-left">
                    <ul class="nav nav-tabs" id="myTab">
                        <li>
                            <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 75px;" id="tab-contact"> 
                                <i class="fa fa-refresh fa-2x fa-fw"></i>&nbsp;Control Parameter (Interval)
                            </a>
                        </li>
                        <li>
                            <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 75px;" id="tab-address"> 
                                <i class="fa fa-edit fa-2x fa-fw"></i>&nbsp;Instructions and Tasks
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    <div class="col text-info">
                                        <i class="fa fa-info-circle"></i>
                                        Interval Control Method: <strong>{{ $Taskcard->interval_control_method ?? '' }}</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    @include('ppc::pages.taskcard.control-parameter.item')
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    <div class="col">
                                    @can('update', Modules\PPC\Entities\Taskcard::class)                
                                        <button type="button" id="createNewButtonInstruction" class="btn btn-primary btn-lg">
                                            <i class="fa fa-plus-circle"></i>&nbsp;Create New
                                        </button>   
                                    @endcan
                                    </div>
                                </div>
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('ppc::components.taskcard.control-parameter._script')

@push('footer-scripts')
<script>
    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>
@endpush