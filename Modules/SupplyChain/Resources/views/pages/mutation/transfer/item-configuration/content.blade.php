<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Transfer Item/Component Datalist'])
    @endcomponent
    
    @component('components.crud-form.index',[
        'title' => 'Transfer Item/Component Datalist',
        'tableId' => 'mutation-transfer-detail-table'])

    @slot('tableContent')
        <th>Detailed Location</th>
        <th>Item Code/PN</th>
        <th>Item Name</th>
        <th>Serial Number</th>
        <th>Transfer Qty</th>
        <th>UoM</th>
        <th>Alias Name</th>
        <th>Item Remark</th>
        <th>Transfer Remark</th>
        <th>Parent Item</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@if($MutationTransfer->approvals()->count() > 0)
    @include('supplychain::components.mutation.transfer.item-configuration._script')
@endif