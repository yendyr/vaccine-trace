<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Familiy Datalist'])
    @endcomponent

    @include('humanresources::pages.employee.family.modal')

    @component('components.crud-form.index',[
                    'title' => 'Familiy Datalist',
                    'tableId' => 'family-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\Family::class)
                <button type="button" id="create-idcard" class="btn btn-block btn-primary">
                    <strong><i class="fa fa-plus"></i></strong>
                </button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>Employee ID</th>
            <th>Family ID</th>
            <th>Relationship</th>
            <th>Full Name</th>
            <th>Place of birth</th>
            <th>Date of birth</th>
            <th>Gender</th>
            <th>Marital status</th>
            <th>Education level</th>
            <th>Education major</th>
            <th>Job</th>
            <th>Remark</th>
            <th>Status</th>
            <th>Action</th>
        @endslot
    @endcomponent
</div>

@include('humanresources::components.family._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
