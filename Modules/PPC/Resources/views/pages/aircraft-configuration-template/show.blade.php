@extends('layouts.master')

@section('content')
    <div class="row m-b m-t">
        <div class="col-md-1">
            <i class="fa fa-paper-plane fa-5x fa-fw text-success"></i>
        </div>
        <div class="col-md-6">            
            <h2 class="m-t-none font-bold">{{ $AircraftConfigurationTemplate->name ?? '' }}</h2>
            <h3 class="m-t-none font-normal">{{ $AircraftConfigurationTemplate->code ?? '' }}</h3>
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
                                <div class="col text-info">
                                    <i class="fa fa-info-circle"></i>
                                    Interval Control Method: <strong>{{ $Taskcard->interval_control_method ?? '' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                <div class="col">
                                    WIP
                                </div>
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