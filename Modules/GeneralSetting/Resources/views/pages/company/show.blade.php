@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Company Datalist'])
    @endcomponent
    {{-- @include('generalsetting::pages.company.modal')
    @include('generalsetting::components.company._script') --}}

    @include('generalsetting::pages.company.contact.modal')

    <div class="row m-b m-t">
        <div class="col-md-5">
            <div class="profile-image">
                <img src="{{ URL::asset('uploads/user/img/avatar.png') }}" class="rounded-circle circle-border m-b-md" alt="profile">
            </div>
            <div class="profile-info">
                <h2 class="no-margins">
                    {{ $Company->name ?? '' }}
                </h2>
                Code: <strong>{{ $Company->code ?? '' }}</strong>
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
                            <a class="nav-link active" data-toggle="tab" href="#tab-1"> 
                                <i class="fa fa-phone"></i>&nbsp;Contacts
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" data-toggle="tab" href="#tab-2"> 
                                <i class="fa fa-building"></i>&nbsp;Addresses
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" data-toggle="tab" href="#tab-3"> 
                                <i class="fa fa-money"></i>&nbsp;Bank Accounts
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content ">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="row m-b">
                                    <div class="col">
                                    @can('create', Modules\GeneralSetting\Entities\CompanyDetailContact::class)                
                                        <button type="button" id="create" class="btn btn-primary btn-lg">
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
                            <div class="panel-body">
                                <strong>Donec quam felis</strong>

                                <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among the stalks, and grow familiar with the countless indescribable forms of the insects
                                    and flies, then I feel the presence of the Almighty, who formed us in his own image, and the breath </p>

                                <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                                    sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet.</p>
                            </div>
                        </div>

                        <div id="tab-3" class="tab-pane">
                            <div class="panel-body">
                                <strong>Lorem ipsum dolor sit amet, consectetuer adipiscing</strong>

                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of
                                    existence in this spot, which was created for the bliss of souls like mine.</p>

                                <p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at
                                    the present moment; and yet I feel that I never was a greater artist than now. When.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('generalsetting::components.company.contact._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush