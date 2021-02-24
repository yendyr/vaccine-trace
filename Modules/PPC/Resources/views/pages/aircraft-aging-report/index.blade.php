@extends('layouts.master')

@section('content')
    @component('components.crud-form.index',[
                    'title' => 'Aircraft Aging Report',
                    'tableId' => 'aircraft-aging-report-table'])

        @slot('tableContent')
            <th>Manufacturer</th>
            <th>Type</th>
            <th>Registration</th>
            <th>Serial Number</th>
            <th>Remark</th>
            <th>Operational Start Date</th>
            <th>Initial Status</th>
            <th>In-Period Aging</th>
            <th>Current Status</th>
            <th>Month Since Start</th>
        @endslot
    @endcomponent

    @include('ppc::components.aircraft-aging-report._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush