<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Outbound Item/Component Datalist'])
    @endcomponent
    
    @component('components.crud-form.index',[
        'title' => 'Outbound Item/Component Datalist',
        'tableId' => 'mutation-outbound-detail-table'])

    @slot('tableContent')
        <th>Detailed Location</th>
        <th>Item Code/PN</th>
        <th>Item Name</th>
        <th>Serial Number</th>
        <th>Outbound Qty</th>
        <th>UoM</th>
        <th>Alias Name</th>
        <th>Item Remark</th>
        <th>Outbound Remark</th>
        <th>Parent Item</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@if($MutationOutbound->approvals()->count() > 0)
    @include('supplychain::components.mutation.outbound.item-configuration._script')
@endif