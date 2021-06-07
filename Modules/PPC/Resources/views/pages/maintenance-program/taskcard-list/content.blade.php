<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
    {{-- @component('components.approve-modal', ['name' => 'Maintenance Program Datalist'])
    @endcomponent --}}

        @component('components.crud-form.index',[
                        'title' => 'Available Master Task Card for this Aircraft Type',
                        'tableId' => 'taskcard-table'])

            @slot('createButton')
                @can('update', $MaintenanceProgram)                
                    <button type="button" class="useBtnAll btn btn-sm btn-outline btn-success text-nowrap pr-2" data-toggle="tooltip" title="Use All" value="{{ $MaintenanceProgram->id }}">
                        <i class="fa fa-check-square-o"></i> Use All
                    </button>
                @endcan
            @endslot

            @slot('tableContent')
                <th>MPD Number</th>
                <th>Title</th>
                <th>Group</th>
                <th>Tag</th>
                <th>Type</th>
                <th>Instruction/Task Total</th>
                <th>Manhours Total</th>
                <th>Aircraft Type</th>
                <th>Skill</th>
                <th>Threshold</th>
                <th>Repeat</th>
                <th>Created At</th>
                <th>Action</th>
            @endslot
        @endcomponent

    @include('ppc::components.maintenance-program.taskcard-list._script')
</div>