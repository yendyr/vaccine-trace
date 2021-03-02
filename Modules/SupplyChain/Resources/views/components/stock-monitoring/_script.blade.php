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
            { data: 'warehouse' },
            { data: 'detailed_item_location', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'item.code' },
            { data: 'item.name' },
            { data: 'serial_number', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'alias_name', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'used_quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'loaned_quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'description', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'parent', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
        ]
    });
});
</script>
@endpush