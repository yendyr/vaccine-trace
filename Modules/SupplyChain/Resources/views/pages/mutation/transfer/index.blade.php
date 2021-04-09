@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Inventory/Stock Transfer Datalist'])
    @endcomponent

    @component('components.approve-modal', ['name' => 'Inventory/Stock Transfer Datalist'])
    @endcomponent

    @include('supplychain::pages.mutation.transfer.modal')

    @component('components.crud-form.index',[
                    'title' => 'Inventory/Stock Transfer Datalist',
                    'tableId' => 'mutation-transfer-table'])

        @slot('createButton')
            @can('create', Modules\SupplyChain\Entities\StockMutation::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Transaction Code</th>
            <th>Transaction Date</th>
            <th>Warehouse Origin</th>
            <th>Warehouse Destination</th>
            <th>Remark</th>
            <th>Transaction Reference</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('supplychain::components.mutation.transfer._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush