<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Available Item in Warehouse'])
    @endcomponent

    @include('supplychain::pages.mutation.outbound.available-item.modal')
    
    @component('components.crud-form.index',[
        'title' => 'Available Item in Warehouse',
        'tableId' => 'available-item-table'])

    {{-- @if($MutationOutbound->approvals()->count() == 0)
        @slot('createButton')
            @can('create', Modules\SupplyChain\Entities\StockMutation::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Add Item
                </button>   
            @endcan
        @endslot    
    @endif --}}

    @slot('tableContent')
        <th>Warehouse / Location</th>
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
        <th>Parent Item/Group Name</th>
    @endslot
    @endcomponent
</div>

@include('supplychain::components.mutation.outbound.available-item._script')