<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Employee Datalist'])
    @endcomponent

    @include('humanresources::pages.employee.modal')

    @component('components.crud-form.index',[
                    'title' => 'Employees Datalist',
                    'tableId' => 'employee-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\Employee::class)
                <button type="button" id="create-employee" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-square"></i> New Employee
                </button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>photo</th>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Company</th>
            <th>Place of birth</th>
            <th>Date of birth</th>
            <th>Gender</th>
            <th>Religion</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Bloodtype</th>
            <th>Marital status</th>
            <th>Emp date</th>
            <th>Cessation date</th>
            <th>Probation</th>
            <th>Cessation code</th>
            <th>Recruit by</th>
            <th>Employee type</th>
            <th>Workgroup</th>
            <th>Site</th>
            <th>Access group</th>
            <th>Achievement group</th>
            <th>Org code</th>
            <th>Org. level</th>
            <th>Title</th>
            <th>Jobtitle</th>
            <th>Job group</th>
            <th>Cost code</th>
            <th>Remark</th>
            <th>Status</th>
            <th></th>
        @endslot
    @endcomponent
</div>

@include('humanresources::components.employee._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
