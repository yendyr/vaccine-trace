@extends('layouts.master')

@section('content')
    <div class="row m-b m-t">
        <div class="col-md-2 d-flex align-items-start">
            <img src="{{ URL::asset('assets/afml.png') }}" style="width: 60%; height: auto;">
        </div>
        <div class="col">   
            <p  class="m-t-none m-b-none">Transaction Date:</p>         
            <p class="m-t-none m-b-xs font-bold text-success">{{ Carbon\Carbon::parse($afmlog->transaction_date)->format('Y-F-d') ?? '-' }}</p>

            <p  class="m-t-none m-b-none">Last Inspection:</p>         
            <p class="m-t-none m-b-xs font-bold text-success">{{ Carbon\Carbon::parse($afmlog->last_inspection)->format('Y-F-d') ?? '-' }}</p>

            <p  class="m-t-none m-b-none">Next Inspection:</p>         
            <p class="m-t-none m-b-xs font-bold text-success">{{ Carbon\Carbon::parse($afmlog->next_inspection)->format('Y-F-d') ?? '-' }}</p>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Current Page:</p>
            <p class="m-t-none m-b-xs font-bold text-success">{{ $afmlog->page_number ?? '-' }}</p>

            <p  class="m-t-none m-b-none">Continuous from Page:</p>
            <p class="m-t-none font-bold text-success">{{ $afmlog->previous_page_number ?? '-' }}</p>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Aircraft Registration:</p>
            <p class="m-t-none m-b-xs font-bold text-success">{{ $afmlog->aircraft_configuration->registration_number ?? '-' }}</p>

            <p  class="m-t-none m-b-none">Aircraft Serial:</p>
            <p class="m-t-none font-bold text-success">{{ $afmlog->aircraft_configuration->serial_number ?? '-' }}</p>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Aircraft Type:</p>
            <p class="m-t-none m-b-xs font-bold text-success">{{ $afmlog->aircraft_configuration->aircraft_type->name ?? '-' }}</p>

            <p  class="m-t-none m-b-none">Aircraft Manufacturer:</p>
            <p class="m-t-none font-bold text-success">{{ $afmlog->aircraft_configuration->aircraft_type->manufacturer->name ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-0" style="min-height: 50px;"> 
                            <i class="fa fa-users text-warning"></i>&nbsp;Crew
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-1" style="min-height: 50px;"> 
                            <i class="fa fa-stack-overflow text-warning"></i>&nbsp;Journal
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;"> 
                            <i class="fa fa-stack-exchange text-warning"></i>&nbsp;Manifest
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-3" style="min-height: 50px;"> 
                            <i class="fa fa-chain-broken text-warning"></i>&nbsp;Discrepancy
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-4" style="min-height: 50px;"> 
                            <i class="fa fa-wrench text-warning"></i>&nbsp;Rectification
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-5" style="min-height: 50px;" role="tab"> 
                            <i class="fa fa-unsorted text-warning"></i>&nbsp;Item Change
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-6" style="min-height: 50px;"> 
                            <i class="fa fa-exclamation-circle text-warning"></i>&nbsp;MEL
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-7" style="min-height: 50px;"> 
                            <i class="fa fa-exchange text-warning"></i>&nbsp;Defered Item
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-8" style="min-height: 50px;"> 
                            <i class="fa fa-history text-warning"></i>&nbsp;Pre/Post Check
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="tab-0" class="tab-pane active">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('flightoperations::pages.afmlog.crew.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-1" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('flightoperations::pages.afmlog.journal.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('flightoperations::pages.afmlog.manifest.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('flightoperations::pages.afmlog.discrepancy.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('flightoperations::pages.afmlog.rectification.content')
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

    @include('layouts.includes._header-datatable-script')
@endpush

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
@include('layouts.includes._footer-datatable-script')
@endpush