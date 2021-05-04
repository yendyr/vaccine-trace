@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = "{{ route('ppc.work-order.work-package.item-requirements-summary', ['work_package' => $work_package->id, 'work_order' => $work_order->id]) }}";
    var tableId = '#work-package-items-table';
    var tableId2 = '#maintenance-program-table';
    var inputFormId = '#inputForm';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //

    var summaryMaterialTooldatatableObject = $(tableId).DataTable({
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
            { title: 'Taskcard No.', data: 'taskcard_number', name: 'taskcard_json', defaultContent: '-' },
            { title: 'Part Number', data: 'item_number', name: 'item_json', defaultContent: '-' },
            { title: 'Item Name', data: 'item_json.name', name: 'item_json', defaultContent: '-' },
            { title: 'Quantity', data: 'quantity', name: 'quantity', defaultContent: '-' },
            { title: 'Unit', data: 'unit_json.name', name: 'unit_json', defaultContent: '-' },
            { title: 'Remark', data: 'description', name: 'description', defaultContent: '-' },
        ]
    });

    $(tableId2).on('draw.dt', function () {
        if( typeof(summaryMaterialTooldatatableObject) != 'undefined' ) {
            summaryMaterialTooldatatableObject.ajax.reload();
        }

    });
});
</script>
@endpush