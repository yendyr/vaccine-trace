<div class="col fadeIn" style="animation-duration: 1.5s">
    
    @component('components.crud-form.index',[
        'title' => 'Outstanding Item from Purchase Order',
        'tableId' => 'outstanding-item-table'])

    @slot('tableContent')
        <th>PO Code</th>
        <th>PR Transaction Code</th>
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
        {{-- <th>Status</th> --}}
        {{-- <th>Created At</th> --}}
        <th>Receiving/Inbound Status</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('supplychain::components.mutation.inbound.purchase-order-item._script')

@push('header-scripts')
<style>
    thead input {
        width: 100%;
    }
    tr.group,
    tr.group:hover {
        background-color: #aaa !important;
    }
</style>
@endpush