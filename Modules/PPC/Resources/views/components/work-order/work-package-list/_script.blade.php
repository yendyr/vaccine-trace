@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/work-order/{{$work_order?->id}}/work-package';
    var tableId = '#work-package-table';
    var inputFormId = '#inputForm';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //


    $('#taskcard-table thead tr').clone(true).appendTo('#taskcard-table thead');
    $('#taskcard-table thead tr:eq(1) th').each( function (i) {
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
        orderCellsTop: true,
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-5x fa-fw text-success"></i>'
        },
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/work-order/{{$work_order->id}}/work-package",
        },
        columns: [
            { title: 'Work Package Number', data: 'number', name: 'code' },
            { title: 'Title', data: 'title', name: 'title' },
            { title: 'Total Manhours', data: 'total_manhours', name: 'total_manhours' },
            { title: 'Performance Factor', data: 'performance_factor', name: 'performance_factor' },
            { title: 'Created At', data: 'created_at', name: 'created_at' },
            { title: 'Action', data: 'action', name: 'Action', orderable: false },
        ]
    });

    $('#taskcard-table tbody').on( 'click', 'tr.group', function () {
        var currentOrder = datatableObject.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            datatableObject.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            datatableObject.order( [ groupColumn, 'asc' ] ).draw();
        }
    });

    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId); 
    });

    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $('#create').click(function () {
        clearForm();
        $('#work_order_id').val('{{$work_order?->id}}');
        showCreateModal ('Create New Work Package', inputFormId, actionUrl);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //

    function clearForm()
    {
        $(inputFormId)
            .find("input,textarea")
            .val('')
            .end().
            find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end()
            .find("select")
            .val('')
            .trigger('change');
    }

});
</script>
@endpush