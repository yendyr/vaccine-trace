@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var datatableObject2 = $('#mutation-outbound-detail-table').DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/supplychain/mutation-outbound-detail/?id=" + "{{ $MutationOutbound->id }}",
        },
        columns: [
            { data: 'item_stock.detailed_item_location', defaultContent: '-' },
            { data: 'item_stock.item.code', defaultContent: '-' },
            { data: 'item_stock.item.name', defaultContent: '-' },
            { data: 'item_stock.serial_number', defaultContent: '-' },
            { data: 'outbound_quantity',
                "render": function ( data, type, row, meta ) {
                    return "<span class='label label-primary'>" + row.outbound_quantity + '</span>';
                }},
            { data: 'item_stock.item.unit.name', defaultContent: '-' },
            { data: 'item_stock.alias_name', defaultContent: '-' },
            { data: 'item_stock.description', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'parent', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });
});
</script>
@endpush