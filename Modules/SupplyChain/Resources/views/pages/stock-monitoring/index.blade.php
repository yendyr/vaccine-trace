@extends('layouts.master')

@section('content')
    @component('components.crud-form.index',[
                    'title' => 'Stock Monitoring',
                    'tableId' => 'stock-monitoring-table'])

        @slot('tableContent')
            <th>Warehouse</th>
            <th>Detailed Location</th>
            <th>Item Part Number</th>
            <th>Item Name</th>
            <th>Serial Number</th>
            <th>Alias Name</th>
            <th>Qty</th>
            <th>Used Qty</th>
            <th>Loaned Qty</th>
            <th>Remark</th>
            <th>Parent Item/Group Name</th>
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