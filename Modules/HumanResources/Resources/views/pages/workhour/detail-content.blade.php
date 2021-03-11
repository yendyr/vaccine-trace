<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Workhour Detail Datalist'])
    @endcomponent

    @component('components.crud-form.index',[
                    'title' => 'Workhour Detail Datalist',
                    'tableId' => 'whour-detail-table'])

        @slot('tableContent')
            <th>Employee ID</th>
            <th>Work date</th>
            <th>Attendance type</th>
            <th>Date Start</th>
            <th>Time Start</th>
            <th>Date Finish</th>
            <th>Time finish</th>
            <th>Processedon</th>
            <th>Main Attendance</th>
            <th>Calc Date Start</th>
            <th>Calc Time Start</th>
            <th>Calc Date Finish</th>
            <th>Calc Time Finish</th>
            <th>Status</th>
        @endslot
    @endcomponent
</div>

@include('humanresources::components.workhour-detail._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
