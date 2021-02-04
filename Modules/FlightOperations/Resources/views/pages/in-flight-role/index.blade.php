@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'In-Flight Role Datalist'])
    @endcomponent

    @include('flightoperations::pages.in-flight-role.modal')

    @component('components.crud-form.index',[
                    'title' => 'In-Flight Role Datalist',
                    'tableId' => 'in-flight-role-table'])

        @slot('tableContent')
            <th>Code</th>
            <th>Role Name</th>
            <th>Role Name Alias</th>
            <th>Description/Remark</th>
            <th>Authorize as In-Flight Role</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('flightoperations::components.in-flight-role._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush