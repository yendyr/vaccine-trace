<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Outbound Item/Component Datalist'])
    @endcomponent
    
    @component('components.crud-form.index',[
        'title' => "Purchase Order's Item/Component Datalist",
        'tableId' => 'purchase-order-detail-table'])

    @slot('tableContent')
        <th>PR Code</th>
        <th>Item Code/PN</th>
        <th>Item Name</th>
        <th>Item Category</th>
        <th>Parent Item</th>
        <th>Request Qty</th>
        <th>In-Stock Qty</th>
        <th>Purchase Order Qty</th>
        <th>UoM</th>
        <th>Remark</th>
        <th>Required Delivery Date</th>
        <th>@ Price Before Tax</th>
        <th>Tax</th>
        <th>Price After Tax</th>
        {{-- <th>Status</th> --}}
        <th>Created At</th>

        @if($PurchaseOrder->approvals()->count() == 0)
            <th>Action</th>
        @else
            <th>Receiving/Inbound Status</th>
        @endif
    @endslot

    @slot('tableFooter')
        <th colspan="13" style="text-align:right" class="text-danger">Total ({{ $PurchaseOrder->currency->code }}):</th>
        <th class="text-danger"></th>
    @endslot
    @endcomponent
</div>

@if($PurchaseOrder->approvals()->count() > 0)
    @include('procurement::components.purchase-order.item-configuration._script')
@endif