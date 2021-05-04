@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function() {
        // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
        var actionUrl = "{{ route('ppc.work-order.item-requirements-summary', ['work_order' => $work_order->id]) }}";
        var tableId = '#work-order-items-table';
        var inputFormId = '#inputForm';
        var inputModalId = '#showItemModal';
        var modalItemTitleId = '#showItemModalTitle'
        // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //

        var datatableObject = $(tableId).DataTable({
            drawCallback: function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
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

    // ----------------- "SHOW" BUTTON SCRIPT ------------- //
    $(tableId).on('click', '.viewItemBtn', function (e) {
        $(modalItemTitleId).html("Material/Tool Information");
        let tr = $(this).closest('tr');
        let rowData = datatableObject.row( tr ).data();

        $('#code').val(rowData.item_json.code);
        $('#name').val(rowData.item_json.name);
        $('#model').val(rowData.item_json.model);
        $('#type').val(rowData.item_json.type);
        $('#description').val(rowData.item_json.description);
        $('#primary_unit').val(rowData.unit_json.name);
        $('#reorder_stock_level').val(rowData.item_json.reorder_stock_level);
        $('#status').val(rowData.item_json.status);
        
        if(rowData.item_json.category) {
            $('#category').val(rowData.item_json.category.name);
        }else{
        $('#category').val(null);
        }

        if(rowData.item_json.manufacturer){
            $('#manufacturer').val(rowData.item_json.manufacturer.name);
        }else{
            $('#manufacturer').val(null);
        }


        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $(inputModalId).modal('show');
    });
    // ----------------- END "SHOW" BUTTON SCRIPT ------------- //
    });
</script>
@endpush