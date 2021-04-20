@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/maintenance-program-detail';
    var tableId2 = '#maintenance-program-table';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //

    $('#maintenance-program-table thead tr').clone(true).appendTo('#maintenance-program-table thead');
    $('#maintenance-program-table thead tr:eq(1) th').each( function (i) {
        if ($(this).text() != 'Action') {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search" class="form-control" />');
    
            $('input', this).on('keypress', function (e) {
                if(e.which == 13) {
                    if (datatableObject.column(i).search() !== this.value) {
                        datatableObject
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                }
            });
        }
        else {
            $(this).html('&nbsp;');
        }
    });

    var groupColumn = 9;

    var datatableObject2 = $(tableId2).DataTable({
        columnDefs: [{
            visible: false, 
            targets: groupColumn }
        ],
        order: [[ groupColumn, 'asc' ]],
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group" style="text-align: left;"><td colspan="14">Repeat Interval: <b>' + group + '</b></td></tr>'
                    );
                    last = group;
                }
            });
        },
        pageLength: 50,
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-5x fa-fw text-success"></i>'
        },
        orderCellsTop: true,
        serverSide: false,
        deferRender: true,
        // scrollY: 200,
        scrollCollapse: true,
        scroller: true,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/maintenance-program-detail/?maintenance_program_id=" + "{{ $AircraftConfiguration->maintenance_program_id }}",
        },
        columns: [
            { data: 'taskcard.mpd_number', 
                    "render": function ( data, type, row, meta ) {
                    return '<a target="_blank" href="/ppc/taskcard/' + row.taskcard.id + '">' + row.taskcard.mpd_number + '</a>'; }},
            { data: 'taskcard.title', name: 'Title' },
            { data: 'group_structure', name: 'Group' },
            { data: 'tag', defaultContent: '-' },
            { data: 'taskcard.taskcard_type.name', name: 'Task Type' },
            { data: 'instruction_count',
                    "render": function ( data, type, row, meta ) {
                    return '<label class="label label-success">' + row.instruction_count + '</label>'; } },
            { data: 'manhours_total',
                    "render": function ( data, type, row, meta ) {
                    return '<label class="label label-success">' + row.manhours_total + '</label>'; } },
            { data: 'skills', name: 'Skill' },
            { data: 'threshold_interval', name: 'Threshold' },
            { data: 'repeat_interval' },
            { data: 'description', name: 'Remark' },
            { data: 'created_at', name: 'Created At' },
            // { data: 'action', name: 'Action', orderable: false },
        ]
    });

    $('#maintenance-program-table tbody').on( 'click', 'tr.group', function () {
        var currentOrder = datatableObject.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            datatableObject.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            datatableObject.order( [ groupColumn, 'asc' ] ).draw();
        }
    });

});
</script>
@endpush