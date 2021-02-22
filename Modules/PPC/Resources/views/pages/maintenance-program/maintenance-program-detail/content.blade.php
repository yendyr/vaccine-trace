<div class="col-md-12 m-t-md fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Maintenance Program Datalist'])
    @endcomponent

    @component('components.crud-form.index',[
                    'title' => "Selected Maintenance Program's Task Card",
                    'tableId' => 'maintenance-program-table'])

        @slot('tableContent')
            <th>MPD Number</th>
            <th>Title</th>
            <th>Group</th>
            <th>Type</th>
            <th>Instruction/Task Total</th>
            <th>Manhours Total</th>
            <th>Skill</th>
            <th>Threshold</th>
            <th>Repeat</th>
            <th>Remark</th>
            <th>Created At</th>
            <th>Action</th>
        @endslot
    @endcomponent
</div>