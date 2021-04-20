<div class="col fadeIn" style="animation-duration: 1.5s">
    @if($AircraftConfiguration->maintenance_program_id)
        @component('components.crud-form.index',[
                        'title' => "Selected Maintenance Program's Task Card",
                        'tableId' => 'maintenance-program-table'])

            @slot('tableContent')
                <th>MPD Number</th>
                <th>Title</th>
                <th>Group</th>
                <th>Tag</th>
                <th>Type</th>
                <th>Instruction/Task Total</th>
                <th>Manhours Total</th>
                <th>Skill</th>
                <th>Threshold</th>
                <th>Repeat</th>
                <th>Remark</th>
                <th>Created At</th>
            @endslot
        @endcomponent

        @include('ppc::components.aircraft-configuration.maintenance-program._script')
    @else
        <span class="text-info font-italic"><i class="fa fa-info-circle"></i>&nbsp;No Maintenance Program Selected</span>
    @endif
</div>

@push('header-scripts')
    <style>
        thead input {
            width: 100%;
        }
        tr.group,
        tr.group:hover {
            background-color: #aaa !important;
        }
    </style>
@endpush