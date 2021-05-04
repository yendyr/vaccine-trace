@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/maintenance-program-detail';
    var tableId = '#item-table';
    var tableId2 = '#maintenance-program-table';
    var inputFormId = '#inputForm';
    var showButtonClass = '.viewItemBtn';
    var inputModalId = '#showItemModal';
    var modalItemTitleId = '#showItemModalTitle'
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //

    var MaterialTooldatatableObject = $(tableId).DataTable({
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
        },
        pageLength: 50,
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-5x fa-fw text-success"></i>'
        },
        orderCellsTop: true,
        serverSide: false,
        deferRender: true,
        // scrollY: 200,
        scrollCollapse: true,
        scroller: true,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('ppc.work-order.work-package.item.index', ['work_order' => $work_order->id, 'work_package' => $work_package->id]) }}",
        },
        columns: [
            { title: 'MPD Number', data: 'taskcard_number', name: 'taskcard_number', defaultContent: '-' },
            { title: 'Code', data: 'item_number', name: 'item.code', defaultContent: '-' },
            { title: 'Item Name', data: 'item.name', name: 'item.name', defaultContent: '-' },
            { title: 'Quantity', data: 'quantity', name: 'quantity', defaultContent: '-' },
            { title: 'Unit', data: 'unit.name', name: 'unit.name', defaultContent: '-' },
            { title: 'Category', data: 'category.name', name: 'category.name', defaultContent: '-' },
            { title: 'Remark', data: 'description', name: 'description', defaultContent: '-' },
        ]
    });

     // ----------------- "EDIT" BUTTON SCRIPT ------------- //
     $(tableId).on('click', '.viewItemBtn', function (e) {
        $(modalItemTitleId).html("Material/Tool Information");
        let tr = $(this).closest('tr');
        let rowData = MaterialTooldatatableObject.row( tr ).data();
        let item_json = JSON.parse(rowData.item_json);
        let unit_json = JSON.parse(rowData.unit_json);

        $('#code').val(item_json.code);
        $('#name').val(item_json.name);
        $('#model').val(item_json.model);
        $('#type').val(item_json.type);
        $('#description').val(item_json.description);
        $('#primary_unit').val(unit_json.name);
        $('#reorder_stock_level').val(item_json.reorder_stock_level);
        $('#status').val(item_json.status);
        
        if(item_json.category) {
            $('#category').val(item_json.category.name);
        }else{
        $('#category').val(null);
        }

        if(item_json.manufacturer){
            $('#manufacturer').val(item_json.manufacturer.name);
        }else{
            $('#manufacturer').val(null);
        }


        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $(inputModalId).modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //

    $(tableId2).on('draw.dt', function () {
        if( typeof(MaterialTooldatatableObject) != 'undefined' ) {
            MaterialTooldatatableObject.ajax.reload();
        }
    });
});
</script>
@endpush