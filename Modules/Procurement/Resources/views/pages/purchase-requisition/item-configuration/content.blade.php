<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Item/Component Datalist'])
    @endcomponent

    @include('procurement::pages.purchase-requisition.item-configuration.modal')
    
    @component('components.crud-form.index',[
        'title' => 'Item/Component Datalist',
        'tableId' => 'purchase-requisition-detail-table'])

    @if($PurchaseRequisition->approvals()->count() == 0)
        @slot('createButton')
            @can('create', Modules\Procurement\Entities\PurchaseRequisition::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Add Item
                </button>   
            @endcan
        @endslot    
    @endif

    @slot('tableContent')
        <th>Item Code/PN</th>
        <th>Item Name</th>
        <th>Item Category</th>
        <th>Parent Item</th>
        <th>Request Qty</th>
        <th>In-Stock Qty</th>
        <th>UoM</th>
        <th>Remark</th>
        {{-- <th>Status</th> --}}
        {{-- <th>Created By</th> --}}
        <th>Created At</th>

        @if($PurchaseRequisition->approvals()->count() == 0)
            <th>Action</th>
        @else
            <th colspan="2">PO & GRN Status</th>
        @endif
    @endslot
    @endcomponent
</div>

@include('procurement::components.purchase-requisition.item-configuration._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush