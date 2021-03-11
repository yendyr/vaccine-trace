<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Workhour Attendance Datalist'])
    @endcomponent

    @component('components.crud-form.index',[
                    'title' => 'Workhour Attendance Datalist',
                    'tableId' => 'whour-attendance-table'])

        @slot('tableContent')
            <th>Employee ID</th>
            <th>Work date</th>
            <th>Attendance type</th>
            <th>Time Start</th>
            <th>Date Start</th>
            <th>Time finish</th>
            <th>Date Finish</th>
            <th>Validatedon</th>
            <th>Processedon</th>
            <th>Round Date Start</th>
            <th>Round Time Start</th>
            <th>Round Date Finish</th>
            <th>Round Time Finish</th>
            <th>Status</th>
        @endslot
    @endcomponent
</div>

@include('humanresources::components.workhour-attendance._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
