@extends('layouts.master')

@section('content')
    @include('generalsetting::pages.company.contact.modal')
    @include('generalsetting::pages.company.address.modal')

    <div class="row m-b m-t">
        <div class="col-md-5">
            <div class="profile-image">
                <img src="{{ URL::asset('uploads/user/img/avatar.png') }}" class="rounded-circle circle-border m-b-md" alt="profile">
            </div>
            <div class="profile-info">
                <h2 class="no-margins">
                    {{ $Company->name ?? '' }}
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
                <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <li>
                            <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 75px;" id="tab-contact"> 
                                <i class="fa fa-phone fa-2x fa-fw"></i>&nbsp;Contacts
                            </a>
                        </li>
                        <li>
                            <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 75px;" id="tab-address"> 
                                <i class="fa fa-building fa-2x fa-fw"></i>&nbsp;Addresses
                            </a>
                        </li>
                        <li>
                            <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-3" style="min-height: 75px;" id="tab-account"> 
                                <i class="fa fa-money fa-2x fa-fw"></i>&nbsp;Bank Accounts
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
                                    @include('generalsetting::pages.company.contact.item')
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
                                    @include('generalsetting::pages.company.address.item')
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane">
                            <div class="panel-body" style="min-height: 500px;">
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

@include('generalsetting::components.company.contact._script')
@include('generalsetting::components.company.address._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush