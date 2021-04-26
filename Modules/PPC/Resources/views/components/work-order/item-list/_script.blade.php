@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/maintenance-program-detail';
    var tableId = '#item-table';
    var inputFormId = '#inputForm';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //

    $('#work-order-table thead tr').clone(true).appendTo('#work-order-table thead');
    $('#work-order-table thead tr:eq(1) th').each( function (i) {
        if ($(this).text() != 'Action') {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search" class="form-control" />');
    
            $('input', this).on('keypress', function (e) {
                if(e.which == 13) {
                    if (datatableObject.column(i).search() !== this.value) {
                        datatableObject
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                }
            });
        }
        else {
            $(this).html('&nbsp;');
        }
    });
    
    var datatableObject = $(tableId).DataTable({
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
            { title: 'Code', data: 'item.code', name: 'item.code', defaultContent: '-' },
            { title: 'Item Name', data: 'item.name', name: 'item.name', defaultContent: '-' },
            { title: 'Unit', data: 'unit.name', name: 'unit.name', defaultContent: '-' },
            { title: 'Category', data: 'category.name', name: 'category.name', defaultContent: '-' },
            { title: 'Remark', data: 'description', name: 'description', defaultContent: '-' },
        ]
    });
});
</script>
@endpush