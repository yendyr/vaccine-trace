@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Warehouse Datalist'])
    @endcomponent

    @include('supplychain::pages.warehouse.modal')

    @component('components.crud-form.index',[
                    'title' => 'Warehouse Datalist',
                    'tableId' => 'warehouse-table'])

        @slot('createButton')
            @can('create', Modules\SupplyChain\Entities\Warehouse::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Code</th>
            <th>Warehouse Name</th>
            <th>Description/Remark</th>
            <th>Status</th>
            <th>Recognized as Aircraft</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('supplychain::components.warehouse._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush