<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Working Group Detail Datalist'])
    @endcomponent

    @include('humanresources::pages.workgroup.detail-modal')

    @component('components.crud-form.index',[
                    'title' => 'Working Group Detail Datalist',
                    'tableId' => 'workgroup-detail-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\WorkingGroupDetail::class)
                <button type="button" id="create-wg-detail" class="btn btn-primary btn-lg" style="margin-left: 10px;">
                    <i class="fa fa-plus-square"></i> Add New Work Group Detail
                </button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>WorkGroup</th>
            <th>Day Code</th>
            <th>Shift No.</th>
            <th>Workhour Start</th>
            <th>Workhour Finish</th>
            <th>Rest Time Start</th>
            <th>Rest Time Finish</th>
            <th>Standard Hours</th>
            <th>Minimum Hours</th>
            <th>Working Type</th>
            <th>Status</th>
            <th></th>
        @endslot
    @endcomponent
</div>

@include('humanresources::components.workgroup-detail._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush

