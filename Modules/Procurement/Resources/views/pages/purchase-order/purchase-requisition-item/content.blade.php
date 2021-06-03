<div class="col fadeIn" style="animation-duration: 1.5s">
    
    @component('components.crud-form.index',[
        'title' => 'Outstanding Item from Purchase Requisition',
        'tableId' => 'outstanding-item-table'])

    @slot('tableContent')
        <th>PR Code</th>
        <th>Item Code/PN</th>
        <th>Item Name</th>
        <th>Item Category</th>
        <th>Request Qty</th>
        <th>In-Stock Qty</th>
        <th>UoM</th>
        <th>Remark</th>
        <th>Parent Item</th>
        {{-- <th>Status</th> --}}
        {{-- <th>Created At</th> --}}
        <th>Purchase Order Status</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('procurement::components.purchase-order.purchase-requisition-item._script')