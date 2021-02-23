@extends('layouts.master')

@section('content')
    @component('components.crud-form.index',[
                    'title' => 'Item/Component Aging Report',
                    'tableId' => 'item-aging-report-table'])

        @slot('tableContent')
            <th>Current Position</th>
            <th>Part Number</th>
            <th>Serial Number</th>
            <th>Item Name</th>
            <th>Alias Name</th>
            <th>Operational Start Date</th>
            <th>Initial Status</th>
            <th>In-Period Aging</th>
            <th>Current Status</th>
            <th>Expired Date</th>
            {{-- <th>Action</th> --}}
        @endslot
    @endcomponent

    @include('ppc::components.item-aging-report._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush