@extends('layouts.master')

@section('content')

    @component('components.crud-form.index',[
                    'title' => 'Owned Aircraft Datalist',
                    'tableId' => 'maintenance-status-report'])

        @slot('tableContent')
            <th>Aircraft Type Name</th>
            <th>Aircraft Serial Number</th>
            <th>Aircraft Registration</th>
            <th>Manufactured Date</th>
            <th>Received Date</th>
            <th>Remark</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('ppc::components.maintenance-status-report._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush