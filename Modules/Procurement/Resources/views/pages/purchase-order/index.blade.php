@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Purchase Order Datalist'])
    @endcomponent

    @component('components.approve-modal', ['name' => 'Purchase Order Datalist'])
    @endcomponent

    @include('procurement::pages.purchase-order.modal')

    @component('components.crud-form.index',[
                    'title' => 'Purchase Order Datalist',
                    'tableId' => 'purchase-order-table'])

        @slot('createButton')
            @can('create', Modules\Procurement\Entities\PurchaseOrder::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Transaction Code</th>
            <th>Transaction Date</th>
            <th>Supplier</th>
            <th>Supplier's Reference</th>
            <th>Remark</th>
            <th>Current Primary Currency</th>
            <th>Currency</th>
            <th>Exchange Rate</th>
            <th>Transaction Reference</th>
            <th>Total Before Tax</th>
            <th>Total After Tax</th>
            <th>Created By</th>
            <th>Created At</th>
            {{-- <th>Last Updated By</th>
            <th>Last Updated At</th> --}}
            <th>Action</th>
        @endslot
    @endcomponent

    @include('procurement::components.purchase-order._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush