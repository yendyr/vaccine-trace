<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Item/Component Datalist'])
    @endcomponent

    @include('ppc::pages.aircraft-configuration-template.item-configuration-content.modal')
    
    @component('components.crud-form.index',[
        'title' => 'Item/Component Datalist',
        'tableId' => 'configuration-template-detail'])

    @slot('createButton')
        @can('create', Modules\PPC\Entities\AircraftConfigurationTemplate::class)                
            <button type="button" id="create" class="btn btn-primary btn-lg">
                <i class="fa fa-plus-circle"></i>&nbsp;Add Item
            </button>   
        @endcan
    @endslot    

    @slot('tableContent')
        <th>Item Code/PN</th>
        <th>Item Name</th>
        <th>Alias Name</th>
        <th>Description/Remark</th>
        <th>Parent Item/Group PN</th>
        <th>Parent Item/Group Name</th>
        <th>Status</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('ppc::components.aircraft-configuration-template.item-configuration-content._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush