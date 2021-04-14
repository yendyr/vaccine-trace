<div class="col fadeIn" style="animation-duration: 1.5s">
    
    @component('components.crud-form.index',[
        'title' => 'Available Item in this Warehouse',
        'tableId' => 'available-item-table'])

    @slot('tableContent')
        {{-- <th>Warehouse / Location</th> --}}
        <th>Detailed Location</th>
        <th>Item Part Number</th>
        <th>Item Name</th>
        <th>Serial Number</th>
        <th>Alias Name</th>
        <th>Inbound Qty</th>
        <th>Used Qty</th>
        <th>Loaned Qty</th>
        <th>Reserved Qty</th>
        <th>Available Qty</th>
        <th>UoM</th>
        <th>Remark</th>
        <th>Parent Item</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('supplychain::components.mutation.outbound.available-item._script')