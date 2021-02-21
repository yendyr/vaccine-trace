<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'ID Card Datalist'])
    @endcomponent

    @include('humanresources::pages.employee.idcard.modal')

    @component('components.crud-form.index',[
                    'title' => 'ID Card Datalist',
                    'tableId' => 'idcard-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\IdCard::class)
                <button type="button" id="create-idcard" class="btn btn-block btn-primary">
                    <strong><i class="fa fa-plus"></i></strong>
                </button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>Employee ID</th>
            <th>ID card type</th>
            <th>ID card no.</th>
            <th>ID card date</th>
            <th>ID card exp date</th>
            <th>Status</th>
            <th>Action</th>
        @endslot
    @endcomponent
</div>

@include('humanresources::components.idcard._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
