@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Maintenance Program Datalist'])
    @endcomponent

    @component('components.approve-modal', ['name' => 'Maintenance Program Datalist'])
    @endcomponent

    @include('ppc::pages.maintenance-program.modal')

    @component('components.crud-form.index',[
                    'title' => 'Maintenance Program Datalist',
                    'tableId' => 'maintenance-program-table'])

        @slot('createButton')
            @can('create', Modules\PPC\Entities\MaintenanceProgram::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Code</th>
            <th>Aircraft Type Name</th>
            <th>Name</th>
            <th>Remark</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('ppc::components.maintenance-program._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush