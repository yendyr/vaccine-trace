@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Aircraft Configuration Template Datalist'])
    @endcomponent

    @include('ppc::pages.aircraft-configuration-template.modal')

    @component('components.crud-form.index',[
                    'title' => 'Aircraft Configuration Template Datalist',
                    'tableId' => 'aircraft-configuration-template'])

        @slot('createButton')
            @can('create', Modules\PPC\Entities\AircraftConfigurationTemplate::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Code</th>
            <th>Template Name</th>
            <th>Aircraft Type Name</th>
            <th>Description/Remark</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('ppc::components.aircraft-configuration-template._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush