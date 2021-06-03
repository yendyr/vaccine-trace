@extends('layouts.master')

@section('content')
@include('procurement::pages.purchase-order.purchase-requisition-item.modal')
    <div class="row m-b m-t">
        <div class="col d-flex align-items-start">
            <i class="fa fa-shopping-bag fa-fw fa-5x text-info"></i>
        </div>
        <div class="col">   
            <p  class="m-t-none m-b-none">Transaction Code:</p>         
            <p class="m-t-none font-bold">{{ $PurchaseOrder->code ?? '' }}</p>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Transaction Date:</p>
            <p class="m-t-none font-bold">{{ Carbon\Carbon::parse($PurchaseOrder->transaction_date)->format('Y-F-d') ?? '-' }}</p>

            <p  class="m-t-none m-b-none">Valid Until Date:</p>
            <p class="m-t-none font-bold">{{ Carbon\Carbon::parse($PurchaseOrder->valid_until_date)->format('Y-F-d') ?? '-' }}</p>
        </div>
        <div class="col">
            <p  class="m-t-none m-b-none">Supplier:</p>         
            <p class="m-t-none font-bold">{{ $PurchaseOrder->supplier->name ?? '' }}</p>

            <p  class="m-t-none m-b-none">Supplier's Reference Document:</p>         
            <p class="m-t-none font-bold">{{ $PurchaseOrder->supplier_reference_document ?? '-' }}</p>
        </div>
        <div class="col">   
            <p  class="m-t-none m-b-none">Current Primary Currency:</p>         
            <p class="m-t-none font-bold">{{ $PurchaseOrder->current_primary_currency->code ?? '' }} | {{ $PurchaseOrder->current_primary_currency->symbol ?? '' }} | {{ $PurchaseOrder->current_primary_currency->name ?? '' }}</p>

            <p  class="m-t-none m-b-none">Transaction Currency:</p>         
            <p class="m-t-none font-bold">{{ $PurchaseOrder->currency->code ?? '' }} | {{ $PurchaseOrder->currency->symbol ?? '' }} | {{ $PurchaseOrder->currency->name ?? '' }}</p>
        </div>
        <div class="col">   
            <p  class="m-t-none m-b-none">Exchange Rate:</p>         
            <p class="m-t-none font-bold">{{ $PurchaseOrder->exchange_rate ?? '' }}</p>
        </div>
        {{-- <div class="col">
            <p  class="m-t-none m-b-none">Remark:</p>
            <h3 class="m-t-none font-bold">{{ $PurchaseRequisition->description ?? '' }}</h3>
        </div> --}}
    </div>

    <div class="row m-t">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-0" style="min-height: 50px;" id="tab-contact"> 
                            <i class="fa fa-info-circle fa-2x text-warning"></i>&nbsp;Basic Information
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-contact"> 
                            <i class="fa fa-sliders fa-2x text-warning"></i>&nbsp;Purchase Requisition
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;" id="tab-contact"> 
                            <i class="fa fa-sliders fa-2x text-warning"></i>&nbsp;Purchase Order's Item/Component
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-3" style="min-height: 50px;" id="tab-address"> 
                            <i class="fa fa-list-ol fa-2x text-warning"></i>&nbsp;Item/Component Tree View
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-4" style="min-height: 50px;" id="tab-address"> 
                            <i class="fa fa-check-circle fa-2x text-warning"></i>&nbsp;Approval Status
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-0" class="tab-pane active">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('procurement::pages.purchase-order.basic-information.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-1" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('procurement::pages.purchase-order.purchase-requisition-item.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                @include('procurement::pages.purchase-order.item-configuration.content')
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            <div class="row m-b">
                                <div class="col">
                                    <span class="text-info font-italic"><i class="fa fa-info-circle"></i>&nbsp;Refresh Page to See Tree Structure Changes After Add or Updating Data</span>
                                </div>
                            </div>
                            <div class="row m-b">
                                {{-- @include('procurement::pages.purchase-order.tree-view.content') --}}
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body" style="min-height: 500px;">
                            {{-- @include('procurement::pages.purchase-order.approval-status.content') --}}
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
    </style>
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