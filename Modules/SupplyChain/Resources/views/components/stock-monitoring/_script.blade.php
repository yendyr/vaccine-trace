@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/supplychain/stock-monitoring';
    var tableId = '#stock-monitoring-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
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