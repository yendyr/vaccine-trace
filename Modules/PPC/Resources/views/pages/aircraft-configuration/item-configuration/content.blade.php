<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Item/Component Datalist'])
    @endcomponent

    @include('ppc::pages.aircraft-configuration.item-configuration.modal')
    
    @component('components.crud-form.index',[
        'title' => 'Item/Component Datalist',
        'tableId' => 'configuration-detail'])

    @if($AircraftConfiguration->approvals()->count() == 0)
        @slot('createButton')
            @can('create', Modules\PPC\Entities\AircraftConfiguration::class)                
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
        <th>Alias Name</th>
        <th>Description/Remark</th>
        <th>Highlighted Item</th>
        <th>Parent Item/Group PN</th>
        <th>Parent Item/Group Name & Alias</th>
        <th>Initial FH</th>
        <th>Initial FC</th>
        <th>Initial Start Date</th>
        <th>Status</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('ppc::components.aircraft-configuration.item-configuration-content._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush