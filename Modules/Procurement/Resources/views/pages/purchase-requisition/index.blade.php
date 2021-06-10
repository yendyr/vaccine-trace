@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Purchase Requisition Datalist'])
    @endcomponent

    @component('components.approve-modal', ['name' => 'Purchase Requisition Datalist'])
    @endcomponent

    @include('procurement::pages.purchase-requisition.modal')

    @component('components.crud-form.index',[
                    'title' => 'Purchase Requisition Datalist',
                    'tableId' => 'purchase-requisition-table'])

        @slot('createButton')
            @can('create', Modules\Procurement\Entities\PurchaseRequisition::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Transaction Code</th>
            <th>Transaction Date</th>
            <th>Remark</th>
            <th>Transaction Reference</th>
            <th>Created By</th>
            <th>Created At</th>
            {{-- <th>Last Updated By</th>
            <th>Last Updated At</th> --}}
            <th>Action</th>
        @endslot
    @endcomponent

    @include('procurement::components.purchase-requisition._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush