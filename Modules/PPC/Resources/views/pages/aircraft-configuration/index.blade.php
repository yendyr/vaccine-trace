@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Aircraft Configuration Datalist'])
    @endcomponent

    @component('components.approve-modal', ['name' => 'Aircraft Configuration Datalist'])
    @endcomponent

    @include('ppc::pages.aircraft-configuration.modal')

    @component('components.crud-form.index',[
                    'title' => 'Aircraft Configuration Datalist',
                    'tableId' => 'aircraft-configuration'])

        @slot('createButton')
            @can('create', Modules\PPC\Entities\AircraftConfiguration::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

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

    @include('ppc::components.aircraft-configuration._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush