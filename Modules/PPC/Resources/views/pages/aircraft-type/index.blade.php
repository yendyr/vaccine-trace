@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Aircraft Type Datalist'])
    @endcomponent

    @include('ppc::pages.aircraft-type.modal')

    @component('components.crud-form.index',[
                    'title' => 'Aircraft Type Datalist',
                    'tableId' => 'aircraft-type-table'])

        @slot('createButton')
            @can('create', Modules\PPC\Entities\AircraftType::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Code</th>
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

    @include('ppc::components.aircraft-type._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush