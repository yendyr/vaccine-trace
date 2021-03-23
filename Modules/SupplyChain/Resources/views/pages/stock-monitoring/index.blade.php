@extends('layouts.master')

@section('content')
    @component('components.crud-form.index',[
                    'title' => 'Stock Monitoring',
                    'tableId' => 'stock-monitoring-table'])

        @slot('tableContent')
            <th>Warehouse / Location</th>
            <th>Detailed Location</th>
            <th>Item Part Number</th>
            <th>Item Name</th>
            <th>Serial Number</th>
            <th>Alias Name</th>
            <th>Inbound Qty</th>
            <th>Used Qty</th>
            <th>Loaned Qty</th>
            <th>Reserved Qty</th>
            <th>Available Qty</th>
            <th>UoM</th>
            <th>Remark</th>
            <th>Parent Item</th>
        @endslot
    @endcomponent

    @include('supplychain::components.stock-monitoring._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush