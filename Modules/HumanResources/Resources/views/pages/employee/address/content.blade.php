<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Address Datalist'])
    @endcomponent

    @include('humanresources::pages.employee.address.modal')

    @component('components.crud-form.index',[
                    'title' => 'Address Datalist',
                    'tableId' => 'address-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\Address::class)
                <button type="button" id="create-address" class="btn btn-block btn-primary">
                    <strong><i class="fa fa-plus"></i></strong>
                </button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>Employee ID</th>
            <th>Family ID</th>
            <th>Address ID</th>
            <th>Street</th>
            <th>Area</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>
            <th>Postcode</th>
            <th>Telephone</th>
            <th>Remark</th>
            <th>Status</th>
            <th>Action</th>
        @endslot
    @endcomponent
</div>

@include('humanresources::components.address._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush

