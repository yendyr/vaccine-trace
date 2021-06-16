@extends('layouts.master')

@section('content')
<div class="row m-b m-t">
    <div class="col d-flex align-items-start">
        <i class="fa fa-tasks fa-fw fa-5x text-danger"></i>
    </div>
    <div class="col">   
        <p  class="m-t-none m-b-none">Transaction Code:</p>         
        <p class="m-t-none font-bold">{{ $Journal->code ?? '' }}</p>
    </div>
    <div class="col">
        <p  class="m-t-none m-b-none">Transaction Date:</p>
        <p class="m-t-none font-bold">{{ Carbon\Carbon::parse($Journal->transaction_date)->format('Y-F-d') ?? '-' }}</p>
    </div>
    <div class="col">   
        <p  class="m-t-none m-b-none">Current Primary/Local Currency:</p>         
        <p class="m-t-none font-bold">{{ $Journal->current_primary_currency->code ?? '' }} | {{ $Journal->current_primary_currency->symbol ?? '' }} | {{ $Journal->current_primary_currency->name ?? '' }}</p>

        <p  class="m-t-none m-b-none">Transaction Currency:</p>         
        <p class="m-t-none font-bold">{{ $Journal->currency->code ?? '' }} | {{ $Journal->currency->symbol ?? '' }} | {{ $Journal->currency->name ?? '' }}</p>
    </div>
    <div class="col">   
        <p  class="m-t-none m-b-none">Exchange Rate:</p>         
        <p class="m-t-none font-bold">{{ number_format($Journal->exchange_rate, 2) ?? '' }}</p>
    </div>
    <div class="col">
        <p  class="m-t-none m-b-none">Remark:</p>
        <h3 class="m-t-none font-bold">{{ $Journal->description ?? '' }}</h3>
    </div>
</div>

<div class="row m-t">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs" id="myTab">
                <li>
                    <a class="nav-link d-flex align-items-center active" data-toggle="tab" href="#tab-1" style="min-height: 50px;" id="tab-address"> 
                        <i class="fa fa-list-ol fa-2x text-warning"></i>&nbsp;Ledger Detail
                    </a>
                </li>
                <li>
                    <a class="nav-link d-flex align-items-center" data-toggle="tab" href="#tab-2" style="min-height: 50px;" id="tab-address"> 
                        <i class="fa fa-check-circle fa-2x text-warning"></i>&nbsp;Approval Status
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body" style="min-height: 500px;">
                        <div class="row m-b">
                            @include('accounting::pages.journal.ledger.content')
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body" style="min-height: 500px;">
                        @include('accounting::pages.journal.approval-status.content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
    {{-- <style>
        thead input {
            width: 100%;
        }
        tr.group,
        tr.group:hover {
            background-color: #aaa !important;
        }
    </style> --}}
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