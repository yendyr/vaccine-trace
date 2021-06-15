@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Item Category Datalist'])
    @endcomponent

    @include('accounting::pages.item-category.modal')

    @component('components.crud-form.index',[
                    'title' => 'Item Category Datalist',
                    'tableId' => 'item-category-table'])

        {{-- @slot('createButton')
            @can('create', Modules\SupplyChain\Entities\ItemCategory::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot     --}}

        @slot('tableContent')
            <th>Code</th>
            <th>Category Name</th>
            <th>Description/Remark</th>
            <th>Item Type</th>
            <th>Sales COA</th>
            <th>Inventory COA</th>
            <th>Cost COA</th>
            <th>Inventory Adj. COA</th>
            <th>Work in Progress COA</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            {{-- <th>Last Updated By</th>
            <th>Last Updated At</th> --}}
            <th>Action</th>
        @endslot
    @endcomponent

    @include('accounting::components.item-category._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush