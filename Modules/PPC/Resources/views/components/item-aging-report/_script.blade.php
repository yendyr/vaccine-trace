@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

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
            { data: 'item_stock.item.code' },
            { data: 'item_stock.serial_number', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'item_stock.item.name' },
            { data: 'item_stock.alias_name', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'item_stock.initial_start_date', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'initial_status' },
            { data: 'in_period_aging' },
            { data: 'current_status' },
            { data: 'expired_date', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
        ]
    });
});
</script>
@endpush