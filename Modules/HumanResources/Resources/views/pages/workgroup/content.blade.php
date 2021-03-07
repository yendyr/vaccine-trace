<div class="col fadeIn" style="animation-duration: 1.5s">
        @component('components.delete-modal', ['name' => 'Working Group Datalist'])
        @endcomponent

        @include('humanresources::pages.workgroup.workgoup-modal')

        @component('components.crud-form.index',[
                        'title' => 'Working Group Datalist',
                        'tableId' => 'workgroup-table'])

            @slot('createButton')
                    @can('create', \Modules\HumanResources\Entities\WorkingGroup::class)
                        <button type="button" id="create-wg" class="btn btn-info btn-lg">
                            <i class="fa fa-plus-square"></i> Add New Work Group
                        </button>
                    @endcan
            @endslot

            @slot('tableContent')
                <th>Work Group</th>
                <th>Work Name</th>
                <th>Shift Status</th>
                <th>Shift Rolling</th>
                <th>Range Rolling</th>
                <th>Round Time</th>
                <th>Work Finger</th>
                <th>Rest Finger</th>
                <th>Remark</th>
                <th>Status</th>
                <th></th>
            @endslot
        @endcomponent
</div>

@include('humanresources::components.workgroup._script')

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
