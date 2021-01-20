@extends('layouts.master')

@section('content')
    {{-- @include('generalsetting::pages.company.contact.modal')
    @include('generalsetting::pages.company.address.modal')
    @include('generalsetting::pages.company.bank.modal')
    @include('generalsetting::pages.company.accounting-setting.modal') --}}

    <div class="row m-t">
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
            {{-- <div>Effectivity: <strong>{{ $Taskcard->effectivity ?? '-' }}</strong></div>
            <div>Work Area: <strong>{{ $Taskcard->taskcard_workarea->name ?? '-' }}</strong></div> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            Aircraft Type Applicability:&nbsp;
            @include('ppc::pages.taskcard.aircraft-type-detail.item')
        </div>
    </div>

    <div class="row m-b">
        <div class="col-md-6">
            Access:&nbsp;
            @include('ppc::pages.taskcard.access-detail.item')
        </div>
        <div class="col-md-6">
            Zone:&nbsp;
            @include('ppc::pages.taskcard.zone-detail.item')
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
                                <i class="fa fa-map-marker fa-2x fa-fw"></i>&nbsp;Addresses
                            </a>
                        </li>
                        <li>
                            <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-3" style="min-height: 75px;" id="tab-account"> 
                                <i class="fa fa-cc-mastercard fa-2x fa-fw"></i>&nbsp;Bank Accounts
                            </a>
                        </li>
                        <li>
                            <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-4" style="min-height: 75px;" id="tab-account"> 
                                <i class="fa fa-tags fa-2x fa-fw"></i>&nbsp;Accounting Setting
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    {{-- <div class="col">
                                    @can('update', Modules\GeneralSetting\Entities\Taskcard::class)                
                                        <button type="button" id="createNewButtonContact" class="btn btn-primary btn-lg">
                                            <i class="fa fa-plus-circle"></i>&nbsp;Create New
                                        </button>   
                                    @endcan
                                    </div> --}}
                                </div>
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    {{-- <div class="col">
                                    @can('update', Modules\GeneralSetting\Entities\Taskcard::class)                
                                        <button type="button" id="createNewButtonAddress" class="btn btn-primary btn-lg">
                                            <i class="fa fa-plus-circle"></i>&nbsp;Create New
                                        </button>   
                                    @endcan
                                    </div> --}}
                                </div>
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    {{-- <div class="col">
                                    @can('update', Modules\GeneralSetting\Entities\Taskcard::class)                
                                        <button type="button" id="createNewButtonBank" class="btn btn-primary btn-lg">
                                            <i class="fa fa-plus-circle"></i>&nbsp;Create New
                                        </button>   
                                    @endcan
                                    </div> --}}
                                </div>
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                        <div id="tab-4" class="tab-pane">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @include('generalsetting::components.company.contact._script')
@include('generalsetting::components.company.address._script')
@include('generalsetting::components.company.bank._script')
@include('generalsetting::components.company.accounting-setting._script')
@include('generalsetting::components.company._logo_upload_script') --}}

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