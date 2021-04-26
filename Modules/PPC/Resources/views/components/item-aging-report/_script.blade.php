@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/item-aging-report';
    var tableId = '#item-aging-report-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('ppc.item-aging-report.index') }}",
        },
        columns: [
            { data: 'current_position', defaultContent: '-' },
            { data: 'item.code', defaultContent: '-' },
            { data: 'serial_number', defaultContent: '-' },
            { data: 'item.name', defaultContent: '-' },
            { data: 'alias_name', defaultContent: '-' },
            { data: 'item_stock_initial_aging.initial_start_date', defaultContent: '-' },
            { data: 'initial_status', defaultContent: '-' },
            { data: 'in_period_aging', defaultContent: '-' },
            { data: 'current_status', defaultContent: '-' },
            { data: 'month_since_start', defaultContent: '-' },
            { data: 'expired_date', defaultContent: '-' },
        ]
    });
});
</script>
@endpush