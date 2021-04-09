@extends('layouts.master')

@section('content')
@include('supplychain::pages.mutation.outbound.available-item.modal')
    <div class="row m-b m-t">
        <div class="col-md-2 d-flex align-items-start">
            <i class="fa fa-cloud-upload fa-fw fa-5x text-info"></i>
        </div>
        <div class="col">   
            <p  class="m-t-none m-b-none">Transaction Code:</p>         
            <h3 class="m-t-none font-bold">{{ $MutationOutbound->code ?? '' }}</h3>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Transaction Date:</p>
            <h3 class="m-t-none font-bold">{{ Carbon\Carbon::parse($MutationOutbound->transaction_date)->format('Y-F-d') ?? '-' }}</h3>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Warehouse Origin:</p>
            <h3 class="m-t-none font-bold">{{ $MutationOutbound->origin->code ?? '' }} | {{ $MutationOutbound->origin->name ?? '' }}</h3>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Remark:</p>
            <h3 class="m-t-none font-bold">{{ $MutationOutbound->description ?? '' }}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab">
                    @if($MutationOutbound->approvals()->count() == 0)
                        <li>
                            <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-0" style="min-height: 50px;" id="tab-contact"> 
                                <i class="fa fa-sliders fa-2x text-warning"></i>&nbsp;Available Item
                            </a>
                        </li>
                        <li>
                            <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-contact"> 
                                <i class="fa fa-sliders fa-2x text-warning"></i>&nbsp;Selected Item/Component Outbound
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-contact"> 
                                <i class="fa fa-sliders fa-2x text-warning"></i>&nbsp;Selected Item/Component Outbound
                            </a>
                        </li>
                    @endif
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;" id="tab-address"> 
                            <i class="fa fa-list-ol fa-2x text-warning"></i>&nbsp;Selected Item/Component Tree View
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-3" style="min-height: 50px;" id="tab-address"> 
                            <i class="fa fa-check-circle fa-2x text-warning"></i>&nbsp;Approval Status
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    @if($MutationOutbound->approvals()->count() == 0)
                        <div id="tab-0" class="tab-pane active">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    @include('supplychain::pages.mutation.outbound.available-item.content')
                                </div>
                            </div>
                        </div>
                        <div id="tab-1" class="tab-pane">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    @include('supplychain::pages.mutation.outbound.item-configuration.content')
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    @include('supplychain::pages.mutation.outbound.item-configuration.content')
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                <div class="col">
                                    <span class="text-info font-italic"><i class="fa fa-info-circle"></i>&nbsp;Refresh Page to See Tree Structure Changes After Add or Updating Data</span>
                                </div>
                            </div>
                            <div class="row m-b">
                                @include('supplychain::pages.mutation.outbound.tree-view.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            @include('supplychain::pages.mutation.outbound.approval-status.content')
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
    @include('layouts.includes._footer-datatable-script')
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