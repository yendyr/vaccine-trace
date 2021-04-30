@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = "{{ route('ppc.work-order.item-requirements-summary', ['work_order' => $work_order->id]) }}";
    var tableId = '#work-order-items-table';
    var inputFormId = '#inputForm';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //

    var datatableObject = $(tableId).DataTable({
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
        },
        pageLength: 50,
        orderCellsTop: true,
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-5x fa-fw text-success"></i>'
        },
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: actionUrl,
        },
        columns: [
            { title: 'Taskcard No.', data: 'name', name: 'name', defaultContent: '-' },
            { title: 'Part Number', data: 'item.code', name: 'item.code', defaultContent: '-' },
            { title: 'Item Name', data: 'item.name', name: 'item.name', defaultContent: '-' },
            { title: 'Quantity', data: 'quantity', name: 'quantity', defaultContent: '-' },
            { title: 'Unit', data: 'unit.name', name: 'unit.name', defaultContent: '-' },
            { title: 'Remark', data: 'description', name: 'description', defaultContent: '-' },
        ]
    });
});
</script>
@endpush