@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/supplychain/stock-monitoring';
    var tableId = '#stock-monitoring-table';
    var inputFormId = '#inputForm';

    $('#stock-monitoring-table thead tr').clone(true).appendTo('#stock-monitoring-table thead');
    $('#stock-monitoring-table thead tr:eq(1) th').each( function (i) {
        if ($(this).text() != 'Action') {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search" class="form-control" />');
    
            $('input', this).on('keypress', function (e) {
                if(e.which == 13) {
                    if (datatableObject1.column(i).search() !== this.value) {
                        datatableObject1
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

    var groupColumn = 0;

    var datatableObject = $(tableId).DataTable({
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
                        '<tr class="group" style="text-align: left;"><td colspan="13">Warehouse Location: <b>' + group + '</b></td></tr>'
                    );
                    last = group;
                }
            });
        },
        pageLength: 50,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('supplychain.stock-monitoring.index') }}",
        },
        columns: [
            { data: 'warehouse', defaultContent: '-' },
            { data: 'detailed_item_location', defaultContent: '-' },
            { data: 'item.code', defaultContent: '-' },
            { data: 'item.name', defaultContent: '-' },
            { data: 'serial_number', defaultContent: '-' },
            { data: 'alias_name', defaultContent: '-' },
            { data: 'quantity', defaultContent: '-' },
            { data: 'used_quantity', defaultContent: '-' },
            { data: 'loaned_quantity', defaultContent: '-' },
            { data: 'reserved_quantity', defaultContent: '-' },
            { data: 'available_quantity',
                "render": function ( data, type, row, meta ) {
                    if (row.available_quantity > 0) {
                        return "<span class='label label-success'>" + row.available_quantity + '</span>';
                    }
                    else {
                        return "<span class='label label-danger'>" + row.available_quantity + '</span>';
                    } 
                }},
            { data: 'item.unit.name', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'parent', defaultContent: '-' },
        ]
    });
});
</script>
@endpush