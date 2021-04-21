<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
    {{-- @component('components.approve-modal', ['name' => 'Maintenance Program Datalist'])
    @endcomponent --}}

        @component('components.crud-form.index',[
                        'title' => 'Available Master Task Card for this Aircraft Type',
                        'tableId' => 'taskcard-table'])

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