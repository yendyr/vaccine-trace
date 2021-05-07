@extends('layouts.master')

@section('content')

    @include('ppc::pages.work-order.taskcard-list.modal')

    @include('components.delete-modal', 
                    ['deleteModalId' => 'deleteModalInstruction',
                    'deleteFormId' => 'deleteFormInstruction',
                    'deleteModalButtonId' => 'deleteModalButtonInstruction'])
    
    @include('components.delete-modal', 
                    ['deleteModalId' => 'deleteModalItem',
                    'deleteFormId' => 'deleteFormItem',
                    'deleteModalButtonItem' => 'deleteModalButtonItem'])

    <div class="row m-b m-t">
        <div class="col-md-5">
            <div class="profile-info">
                <h2 class="m-t-none m-b-none">
                    <strong>{{ $work_package?->title ?? 'Work Package Title' }}</strong>
                </h2>
                <h2 class="text-success m-t-none"><strong>{{ $work_package?->code ?? '' }}</strong></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div>Work Package Description: <br><strong class="text-success">@if( !empty($work_package->description) ) {!! $work_package->description !!} @endif</strong></div>
        </div>
        <div class="col-md-4">
            <div>Performance Factor: <strong class="text-success performance_factor">{{ $work_package?->performance_factor ?? '-' }}</strong></div>
            <div>Total Manhours: <strong class="text-success total_manhours">{{ $work_package?->total_manhours ?? '-' }}</strong></div>
            <div>Total Manhours W/ Performance Factor: <strong class="text-success total_manhours_with_performance_factor"> @if( $work_package?->total_manhours && $work_package?->performance_factor) {{ number_format($work_package?->total_manhours * $work_package?->performance_factor, 2) }} @else - @endif</strong></div>
            <div>Status: <strong>
                @if($work_package?->status == 1)
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

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-taskcard" style="min-height: 50px;" > 
                            <i class="fa fa-align-left fa-2x text-warning"></i>&nbsp;Task Card/Inspection List Reference (MPD)
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-aircraft-maintenance-program" style="min-height: 50px;" > 
                            <i class="fa fa-list-ol fa-2x text-warning"></i>&nbsp;Aircraft Maintenance Program
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-current-maintenance-program" style="min-height: 50px;" > 
                            <i class="fa fa-list-ol fa-2x text-warning"></i>&nbsp;Current Maintenance Program
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-mat-tool-requirement" style="min-height: 50px;" > 
                            <i class="fa fa-wrench fa-2x text-warning"></i>&nbsp;Material &amp; Tool Requirements
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-summary" style="min-height: 50px;" > 
                            <i class="fa fa-tasks fa-2x text-warning"></i>&nbsp;Summary
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div id="tab-taskcard" class="tab-pane active">
                        <div class="panel-body" style="min-height: 600px;">
                            <div class="row m-b">
                                @include('ppc::pages.work-order.taskcard-list.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-aircraft-maintenance-program" class="tab-pane">
                        <div class="panel-body" style="min-height: 600px;">
                            <div class="row m-b">
                                @include('ppc::pages.work-order.aircraft-maintenance-program.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-current-maintenance-program" class="tab-pane">
                        <div class="panel-body" style="min-height: 600px;">
                            <div class="row m-b">
                                @include('ppc::pages.work-order.maintenance-program-detail.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-mat-tool-requirement" class="tab-pane">
                        <div class="panel-body" style="min-height: 600px;">
                            <div class="row m-b">
                                @include('ppc::pages.work-order.item-list.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-summary" class="tab-pane">
                        <div class="panel-body" style="min-height: 600px;">
                            <div class="row m-b">
                                @include('ppc::pages.work-order.work-package.summary')
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
    <style>
        thead input {
            width: 100%;
        }
        tr.group,
        tr.group:hover {
            background-color: #aaa !important;
        }
    .select2-container.select2-container--default.select2-container--open {
        z-index: 9999999 !important;
    }
    .select2 {
        width: 100% !important;
    }
</style>
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