@extends('layouts.master')

@section('content')
    <div class="row m-b m-t">
        <div class="col-md-1">
            <img src="{{ URL::asset('assets/crank.png') }}" style="width: 100%; height: auto;">
        </div>
        <div class="col-md-6 p-l-md">            
            <h2 class="m-t-none font-bold">{{ $AircraftConfigurationTemplate->name ?? '' }}</h2>
            <p class="m-t-none m-b-none font-normal">{{ $AircraftConfigurationTemplate->code ?? '' }}</p>
            <p class="m-t-none">{{ $AircraftConfigurationTemplate->description ?? '' }}</p>
        </div>
        <div class="col-md-5">
            <p  class="m-t-none m-b-none">Aircraft Type:</p>
            <h2 class="m-t-none font-bold">{{ $AircraftConfigurationTemplate->aircraft_type->name ?? '' }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-contact"> 
                            <i class="fa fa-sliders fa-2x text-warning"></i>&nbsp;Item/Component Configuration
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;" id="tab-address"> 
                            <i class="fa fa-list-ol fa-2x text-warning"></i>&nbsp;Tree View
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('ppc::pages.aircraft-configuration-template.item-configuration.content')
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
                                @include('ppc::pages.aircraft-configuration-template.tree-view.content')
                            </div>
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