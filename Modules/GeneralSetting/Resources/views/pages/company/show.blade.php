@extends('layouts.master')

@section('content')
    @include('generalsetting::pages.company.contact.modal')
    @include('generalsetting::pages.company.address.modal')
    @include('generalsetting::pages.company.bank.modal')
    @include('generalsetting::pages.company.accounting-setting.modal')

    @include('components.delete-modal', 
                                ['deleteModalId' => 'deleteModalAddress',
                                'deleteFormId' => 'deleteFormAddress',
                                'deleteModalButtonId' => 'deleteModalButtonAddress'])

    @include('components.delete-modal', 
                                ['deleteModalId' => 'deleteModalBank',
                                'deleteFormId' => 'deleteFormBank',
                                'deleteModalButtonId' => 'deleteModalButtonBank'])

    @include('components.delete-modal', 
                                ['deleteModalId' => 'deleteModalContact',
                                'deleteFormId' => 'deleteFormContact',
                                'deleteModalButtonId' => 'deleteModalButtonContact'])

    <div class="row m-b m-t">
        <div class="col-md-5">
            <div class="profile-image">
                <label for="logo-input" style="cursor:pointer;" data-toggle="tooltip" title="Change Company Logo">
                    @if($Company->logo)
                        <img src="{{ URL::asset('uploads/company/' . $Company->id . '/logo/' . $Company->logo) }}" class="m-b-md m-t-xs" alt="profile" id="companyLogo">
                    @else
                        <img src="{{ URL::asset('assets/default-company-logo.jpg') }}" class="m-b-md m-t-xs" alt="profile" id="companyLogo">
                    @endif
                </label>

                <input onchange="getCompanyLogo(this)" style="display: none;" id="logo-input" type="file" name="logo-input" data-id="{{ $Company->id }}"/>
            </div>
            <div class="profile-info">
                <h2 class="no-margins">
                    <strong>{{ $Company->name ?? '' }}</strong>
                </h2>
                Code: {{ $Company->code ?? '' }}
                <div class="row m-t">
                    <div class="col-md-12">
                        {{ $Company->description ?? '' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            NPWP:
            <h2 class="no-margins">{{ $Company->npwp_number ?? '' }}</h2>

            <div class="row m-t">
                <div class="col-md-12">
                    Recognized as:&nbsp;
                    @if($Company->is_customer == 1)
                    <label class="label label-success">
                        Customer
                    </label>
                    @endif
                    @if($Company->is_supplier == 1)
                    <label class="label label-primary">
                        Supplier
                    </label>
                    @endif
                    @if($Company->is_manufacturer == 1)
                    <label class="label label-warning">
                        Manufacturer
                    </label>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            GST Number
            <h2 class="no-margins">{{ $Company->gst_number ?? '' }}</h2>

            <div class="row m-t">
                <div class="col-md-12">
                    Company Status:&nbsp;
                    @if($Company->status == 1)
                        <label class="label label-success">
                            Active
                        </label>
                    @else
                        <label class="label label-danger">
                            Inactive
                        </label>
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
                            <i class="fa fa-phone fa-2x text-warning"></i>&nbsp;Contacts
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;" id="tab-address"> 
                            <i class="fa fa-map-marker fa-2x text-warning"></i>&nbsp;Addresses
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-3" style="min-height: 50px;" id="tab-account"> 
                            <i class="fa fa-cc-mastercard fa-2x text-warning"></i>&nbsp;Bank Accounts
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-4" style="min-height: 50px;" id="tab-account"> 
                            <i class="fa fa-tags fa-2x text-warning"></i>&nbsp;Accounting Setting
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                <div class="col">
                                @can('update', Modules\GeneralSetting\Entities\Company::class)                
                                    <button type="button" id="createNewButtonContact" class="btn btn-primary btn-lg">
                                        <i class="fa fa-plus-circle"></i>&nbsp;Create New
                                    </button>   
                                @endcan
                                </div>
                            </div>
                            <div class="row">
                                @include('generalsetting::pages.company.contact.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                <div class="col">
                                @can('update', Modules\GeneralSetting\Entities\Company::class)                
                                    <button type="button" id="createNewButtonAddress" class="btn btn-primary btn-lg">
                                        <i class="fa fa-plus-circle"></i>&nbsp;Create New
                                    </button>   
                                @endcan
                                </div>
                            </div>
                            <div class="row">
                                @include('generalsetting::pages.company.address.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                <div class="col">
                                @can('update', Modules\GeneralSetting\Entities\Company::class)                
                                    <button type="button" id="createNewButtonBank" class="btn btn-primary btn-lg">
                                        <i class="fa fa-plus-circle"></i>&nbsp;Create New
                                    </button>   
                                @endcan
                                </div>
                            </div>
                            <div class="row">
                                @include('generalsetting::pages.company.bank.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('generalsetting::pages.company.accounting-setting.content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('generalsetting::components.company.contact._script')
@include('generalsetting::components.company.address._script')
@include('generalsetting::components.company.bank._script')
@include('generalsetting::components.company.accounting-setting._script')
@include('generalsetting::components.company._logo_upload_script')

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