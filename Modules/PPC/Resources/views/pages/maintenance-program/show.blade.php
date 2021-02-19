@extends('layouts.master')

@section('content')
    <div class="row m-b m-t">
        <div class="col-md-1">
            <img src="{{ URL::asset('assets/maintenance-program.png') }}" style="width: 100%; height: auto;">
        </div>
        <div class="col-md-2 m-l-xl">            
            <h2 class="m-t-none font-bold">{{ $MaintenanceProgram->name ?? '' }}</h2>
            <p class="m-t-none m-b-none font-normal">{{ $MaintenanceProgram->code ?? '' }}</p>
            <p class="m-t-none">{{ $MaintenanceProgram->description ?? '' }}</p>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Aircraft Type:</p>
            <h2 class="m-t-none font-bold">{{ $MaintenanceProgram->aircraft_type->name ?? '' }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-contact"> 
                            <i class="fa fa-align-left fa-2x text-warning"></i>&nbsp;Task Card/Inspection List Reference (MPD)
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;" id="tab-address"> 
                            <i class="fa fa-list-ol fa-2x text-warning"></i>&nbsp;Current Maintenance Program
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body" style="min-height: 600px;">
                            <div class="row m-b">
                                @include('ppc::pages.maintenance-program.taskcard-list.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body" style="min-height: 600px;">
                            <div class="row m-b">
                                @include('ppc::pages.maintenance-program.maintenance-program-detail.content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('header-scripts')
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