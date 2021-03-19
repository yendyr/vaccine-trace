<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Item/Component Datalist'])
    @endcomponent

    @include('supplychain::pages.mutation.outbound.item-configuration.modal')
    
    @component('components.crud-form.index',[
        'title' => 'Item/Component Datalist',
        'tableId' => 'mutation-outbound-detail-table'])

    @if($MutationOutbound->approvals()->count() == 0)
        @slot('createButton')
            @can('create', Modules\SupplyChain\Entities\StockMutation::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Add Item
                </button>   
            @endcan
        @endslot    
    @endif

    @slot('tableContent')
        <th>Item Code/PN</th>
        <th>Item Name</th>
        <th>Serial Number</th>
        <th>Qty</th>
        <th>UoM</th>
        <th>Alias Name</th>
        <th>Remark</th>
        <th>Detailed Location</th>
        <th>Highlighted Item</th>
        <th>Parent Item/Group PN</th>
        <th>Parent Item/Group Name & Alias</th>
        <th>Initial FH</th>
        <th>Initial Block Hour</th>
        <th>Initial FC</th>
        <th>Initial Flight Event</th>
        <th>Initial Start Date</th>
        <th>Expired Date</th>
        {{-- <th>Status</th> --}}
        <th>Created By</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('supplychain::components.mutation.outbound.item-configuration._script')