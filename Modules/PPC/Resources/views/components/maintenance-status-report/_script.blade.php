@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var tableId = '#maintenance-status-report';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/aircraft-configuration/?maintenance_status_report=true",
        },
        columns: [
            { data: 'aircraft_type.name', "render": function ( data, type, row, meta ) {
                            return '<a href="maintenance-status-report/' + row.id + '">' + row.aircraft_type.name + '</a>'; } },
            { data: 'serial_number', "render": function ( data, type, row, meta ) {
                            return '<a href="maintenance-status-report/' + row.id + '">' + row.serial_number + '</a>'; } },
            { data: 'registration_number', "render": function ( data, type, row, meta ) {
                            return '<a href="maintenance-status-report/' + row.id + '">' + row.registration_number + '</a>'; } },
            { data: 'manufactured_date', defaultContent: '-' },
            { data: 'received_date', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'status', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'updater_name', defaultContent: '-' },
            { data: 'updated_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });
});
</script>
@endpush