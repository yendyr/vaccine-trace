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
            { data: 'current_position' },
            { data: 'item.code' },
            { data: 'serial_number', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'item.name' },
            { data: 'alias_name', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'item_stock_initial_aging.initial_start_date', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'initial_status' },
            { data: 'in_period_aging' },
            { data: 'current_status' },
            { data: 'month_since_start', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'expired_date', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
        ]
    });
});
</script>
@endpush