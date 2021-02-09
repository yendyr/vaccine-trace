@extends('layouts.master')

@section('content')
    <div class="row m-b m-t">
        <div class="col d-flex align-items-start">
            <img src="{{ URL::asset('assets/afml.png') }}" style="width: 50%; height: auto;">
        </div>
        <div class="col">   
            <p  class="m-t-none m-b-none">Transaction Date:</p>         
            <p class="m-t-none font-bold text-success">{{ Carbon\Carbon::parse($afml->transaction_date)->format('Y-F-d') ?? '-' }}</p>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Current Page:</p>
            <p class="m-t-none m-b-xs font-bold text-success">{{ $afml->page_number ?? '-' }}</p>

            <p  class="m-t-none m-b-none">Continuous from Page:</p>
            <p class="m-t-none font-bold text-success">{{ $afml->previous_page_number ?? '-' }}</p>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Aircraft Registration:</p>
            <p class="m-t-none m-b-xs font-bold text-success">{{ $afml->aircraft_configuration->registration_number ?? '-' }}</p>

            <p  class="m-t-none m-b-none">Aircraft Serial:</p>
            <p class="m-t-none font-bold text-success">{{ $afml->aircraft_configuration->serial_number ?? '-' }}</p>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Aircraft Type:</p>
            <p class="m-t-none m-b-xs font-bold text-success">{{ $afml->aircraft_configuration->aircraft_type->name ?? '-' }}</p>

            <p  class="m-t-none m-b-none">Aircraft Manufacturer:</p>
            <p class="m-t-none font-bold text-success">{{ $afml->aircraft_configuration->aircraft_type->manufacturer->name ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-0" style="min-height: 50px;" id="tab-contact"> 
                            <i class="fa fa-info-circle fa-2x text-warning"></i>&nbsp;Basic Aircraft Information
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-contact"> 
                            <i class="fa fa-sliders fa-2x text-warning"></i>&nbsp;Item/Component Configuration
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;" id="tab-address"> 
                            <i class="fa fa-list-ol fa-2x text-warning"></i>&nbsp;Item/Component Tree View
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-3" style="min-height: 50px;" id="tab-address"> 
                            <i class="fa fa-check-circle fa-2x text-warning"></i>&nbsp;Approval Status
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-0" class="tab-pane active">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                {{-- @include('ppc::pages.aircraft-configuration.aircraft-basic-information.content') --}}
                            </div>
                        </div>
                    </div>
                    <div id="tab-1" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                {{-- @include('ppc::pages.aircraft-configuration.item-configuration-content.content') --}}
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                <div class="col">
                                    <span class="text-info font-italic"><i class="fa fa-info-circle"></i>&nbsp;Refresh Page to See Tree Structure Changes After Add or Updating Data</span>
                                </div>
                            </div>
                            <div class="row m-b">
                                {{-- @include('ppc::pages.aircraft-configuration.tree-view-content.content') --}}
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            {{-- @include('ppc::pages.aircraft-configuration.approval-status.content') --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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