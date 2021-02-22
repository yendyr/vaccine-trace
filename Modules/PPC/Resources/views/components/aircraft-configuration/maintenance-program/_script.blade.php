@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/maintenance-program-detail';
    var tableId2 = '#maintenance-program-table';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //



    var datatableObject2 = $(tableId2).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/maintenance-program-detail/?maintenance_program_id=" + "{{ $AircraftConfiguration->maintenance_program_id }}",
        },
        columns: [
            { data: 'taskcard.mpd_number', 
                    "render": function ( data, type, row, meta ) {
                    return '<a target="_blank" href="/ppc/taskcard/' + row.id + '">' + row.taskcard.mpd_number + '</a>'; }},
            { data: 'taskcard.title', name: 'Title' },
            { data: 'group_structure', name: 'Group' },
            { data: 'taskcard.taskcard_type.name', name: 'Task Type' },
            { data: 'instruction_count', name: 'Instruction/Task Total' },
            { data: 'manhours_total', name: 'Manhours Total' },
            { data: 'skills', name: 'Skill' },
            { data: 'threshold_interval', name: 'Threshold' },
            { data: 'repeat_interval', name: 'Repeat' },
            { data: 'description', name: 'Remark' },
            { data: 'created_at', name: 'Created At' },
            // { data: 'action', name: 'Action', orderable: false },
        ]
    });

});
</script>
@endpush