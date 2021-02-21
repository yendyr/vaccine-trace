<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Education Datalist'])
    @endcomponent

    @include('humanresources::pages.employee.education.modal')

    @component('components.crud-form.index',[
                    'title' => 'Education Datalist',
                    'tableId' => 'education-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\Education::class)
                <button type="button" id="create-idcard" class="btn btn-block btn-primary">
                    <strong><i class="fa fa-plus"></i></strong>
                </button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>Employee ID</th>
            <th>Instantion Name</th>
            <th>Start periode</th>
            <th>Finish periode</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>
            <th>Majors</th>
            <th>Minors</th>
            <th>Education level</th>
            <th>Remark</th>
            <th>Status</th>
            <th>Action</th>
        @endslot
    @endcomponent
</div>

@include('humanresources::components.education._script')
@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush

