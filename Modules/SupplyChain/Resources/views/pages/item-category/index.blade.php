@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Item Category Datalist'])
    @endcomponent

    @include('supplychain::pages.item-category.modal')

    @component('components.crud-form.index',[
                    'title' => 'Item Category Datalist',
                    'tableId' => 'item-category-table'])

        @slot('createButton')
            @can('create', Modules\SupplyChain\Entities\ItemCategory::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Code</th>
            <th>Category Name</th>
            <th>Description/Remark</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    <span class="text-info font-italic">
        <i class="fa fa-info-circle"></i>
        &nbsp;after adding new item category, you have to wait for accounting department before item category activated and can be used in transaction
    </span>

    @include('supplychain::components.item-category._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush