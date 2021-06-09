@extends('layouts.master')

@section('content')
    <div class="row m-b m-t">
        <div class="col-md-2 d-flex align-items-start">
            <i class="fa fa-cloud-download fa-fw fa-5x text-info"></i>
        </div>
        <div class="col">   
            <p  class="m-t-none m-b-none">Transaction Code:</p>         
            <h3 class="m-t-none font-bold">{{ $MutationInbound->code ?? '' }}</h3>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Transaction Date:</p>
            <h3 class="m-t-none font-bold">{{ Carbon\Carbon::parse($MutationInbound->transaction_date)->format('Y-F-d') ?? '-' }}</h3>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Warehouse Destination:</p>
            <h3 class="m-t-none font-bold">{{ $MutationInbound->destination->code ?? '' }} | {{ $MutationInbound->destination->name ?? '' }}</h3>
        </div>
        @if ($MutationInbound->supplier_id)
        <div class="col">
            <p  class="m-t-none m-b-none">Supplier:</p>
            <h3 class="m-t-none font-bold">{{ $MutationInbound->supplier->name ?? '' }}</h3>
        </div>
        @endif
        <div class="col">
            <p  class="m-t-none m-b-none">Remark:</p>
            <h3 class="m-t-none font-bold">{{ $MutationInbound->description ?? '' }}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab">

                    @if($MutationInbound->approvals()->count() == 0 && $MutationInbound->supplier_id)
                        <li>
                            <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-0" style="min-height: 50px;" id="tab-contact"> 
                                <i class="fa fa-shopping-cart fa-2x text-warning"></i>&nbsp;Purchase Order's Item/Component
                            </a>
                        </li>
                        <li>
                            <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-contact"> 
                                <i class="fa fa-sliders fa-2x text-warning"></i>&nbsp;Item/Component Inbound
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-contact"> 
                                <i class="fa fa-sliders fa-2x text-warning"></i>&nbsp;Item/Component Inbound
                            </a>
                        </li>
                    @endif

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

                    @if($MutationInbound->approvals()->count() == 0 && $MutationInbound->supplier_id)
                        <div id="tab-0" class="tab-pane active">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    @include('supplychain::pages.mutation.inbound.purchase-order-item.content')
                                </div>
                            </div>
                        </div>
                        <div id="tab-1" class="tab-pane">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    @include('supplychain::pages.mutation.inbound.item-configuration.content')
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body" style="min-height: 500px;">
                                <div class="row m-b">
                                    @include('supplychain::pages.mutation.inbound.item-configuration.content')
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
                                @include('supplychain::pages.mutation.inbound.tree-view.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            @include('supplychain::pages.mutation.inbound.approval-status.content')
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