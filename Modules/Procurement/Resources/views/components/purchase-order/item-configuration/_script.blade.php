@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    $('#purchase-order-detail-table thead tr').clone(true).appendTo('#purchase-order-detail-table thead');
    $('#purchase-order-detail-table thead tr:eq(1) th').each( function (i) {
        if ($(this).text() != 'Action') {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search" class="form-control" />');
    
            $('input', this).on('keypress', function (e) {
                if(e.which == 13) {
                    if (datatableObject2.column(i).search() !== this.value) {
                        datatableObject2
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

    var groupColumn = 0;

    var datatableObject2 = $('#purchase-order-detail-table').DataTable({
        orderCellsTop: true,
        columnDefs: [{
            visible: false, 
            targets: groupColumn }
        ],
        order: [[ groupColumn, 'asc' ]],
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group" style="text-align: left;"><td colspan="14">Reference Purchase Request Transaction Code: <b>' + group + '</b></td></tr>'
                    );
                    last = group;
                }
            });
        },
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 13 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            // pageTotal = api
            //     .column( 12, { page: 'current'} )
            //     .data()
            //     .reduce( function (a, b) {
            //         return intVal(a) + intVal(b);
            //     }, 0 );
 
            // Update footer
            $( api.column( 13 ).footer() ).html(
                formatNumber(total)
            );
        },
        pageLength: 50,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        order: [ 14, "desc" ],
        ajax: {
            url: "/procurement/purchase-order-detail/?purchase_order_id=" + "{{ $PurchaseOrder->id }}",
        },
        columns: [
            { data: 'purchase_requisition_data' },
            { data: 'purchase_requisition_detail.item.code', defaultContent: '-' },
            { data: 'purchase_requisition_detail.item.name', defaultContent: '-' },
            { data: 'purchase_requisition_detail.item.category.name', defaultContent: '-' },
            { data: 'parent', defaultContent: '-' },
            { data: 'purchase_requisition_detail.request_quantity', defaultContent: '-' },
            { data: 'available_stock',
                "render": function ( data, type, row, meta ) {
                    if (row.available_stock > 0) {
                        return "<span class='label label-success'>" + row.available_stock + '</span>';
                    }
                    else {
                        return "<span class='label label-danger'>" + row.available_stock + '</span>';
                    } 
                }},
            { data: 'order_quantity',
                "render": function ( data, type, row, meta ) {
                    return "<span class='label label-primary'>" + row.order_quantity + '</span>';
                }},
            { data: 'purchase_requisition_detail.item.unit.name', defaultContent: '-' },
            // { data: 'purchase_requisition.description', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'required_delivery_date', defaultContent: '-' },
            { data: 'each_price_before_vat', 
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.each_price_before_vat);
                }},
            { data: 'vat', 
                "render": function ( data, type, row, meta ) {
                    return (row.vat * 100) + ' %';
                }},
            { data: 'price_after_vat', 
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.price_after_vat);
                }},
            { data: 'created_at', defaultContent: '-', visible: false },
            { data: 'action', orderable: false },
        ]
    });
});
</script>
@endpush