@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Aircraft Flight & Maintenance Log Datalist'])
    @endcomponent

    @component('components.approve-modal', ['name' => 'Aircraft Flight & Maintenance Log Datalist'])
    @endcomponent

    @include('flightoperations::pages.afmlog.modal')

    @component('components.crud-form.index',[
                    'title' => 'Aircraft Flight & Maintenance Log Datalist',
                    'tableId' => 'afmlog-table'])

        @slot('createButton')
            @can('create', Modules\FlightOperations\Entities\AfmLog::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot

        @slot('tableContent')
            <th>Aircraft Type</th>
            <th>Aircraft S/N</th>
            <th>Aircraft Register</th>
            <th>Transaction Date</th>
            <th>AFML Page Number</th>
            <th>Total Flight Hour</th>
            <th>Total Block Hour</th>
            <th>Total Flight Cycle</th>
            <th>Total Event</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('flightoperations::components.afmlog._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush