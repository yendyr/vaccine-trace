<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Working Hour Datalist'])
    @endcomponent

    @include('humanresources::pages.workhour.modal')

    @component('components.crud-form.index',[
                    'title' => 'Working Hour Datalist',
                    'tableId' => 'whour-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\WorkingHour::class)
{{--                <div id="form_result" role="alert"></div>--}}
                @if (request()->is('hr/working-hour/calculate'))
                    <button type="button" id="calculate-whour" class="btn btn-primary btn-lg">
                        <i class="fa fa-plus-square"></i> Calculate</button>
                @elseif(request()->is('hr/working-hour'))
                    <button type="button" id="create-whour" class="btn btn-info btn-lg">
                        <i class="fa fa-plus-square"></i> Generate</button>
                @endif
            @endcan
        @endslot

        @slot('tableContent')
            <th>Employee ID</th>
            <th>Work date</th>
            <th>Shift No.</th>
            <th>Workhour Start</th>
            <th>Workdate Start</th>
            <th>Workhour Finish</th>
            <th>Workdate Finish</th>
            <th>Rest Time Start</th>
            <th>Rest Date Start</th>
            <th>Rest Time Finish</th>
            <th>Rest Date Finish</th>
            <th>Standard Hours</th>
            <th>Minimum Hours</th>
            <th>Work Type</th>
            <th>Work Status</th>
            <th>Processedon</th>
            <th>Leave hours</th>
            <th>Attendance hours</th>
            <th>Over hours</th>
            <th>Attendance status</th>
            <th>Status</th>
            {{-- <th>Action</th>--}}
        @endslot
    @endcomponent
</div>

@include('humanresources::components.workhour._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
