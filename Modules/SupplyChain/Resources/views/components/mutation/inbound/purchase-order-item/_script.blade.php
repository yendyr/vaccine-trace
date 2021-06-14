@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/supplychain/mutation-inbound-detail';
    var tableId = '#outstanding-item-table';
    var useButtonClass = '.useBtn';

    $('#outstanding-item-table thead tr').clone(true).appendTo('#outstanding-item-table thead');
    $('#outstanding-item-table thead tr:eq(1) th').each( function (i) {
        if ($(this).text() != 'Action') {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search" class="form-control" />');
    
            $('input', this).on('keypress', function (e) {
                if(e.which == 13) {
                    if (datatableObject1.column(i).search() !== this.value) {
                        datatableObject1
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
    var datatableObject1 = $(tableId).DataTable({
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
                        '<tr class="group" style="text-align: left;"><td colspan="13">Purchase Order Transaction Code: <b>' + group + '</b></td></tr>'
                    );
                    last = group;
                }
            });
        },
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        // order: [ 13, "desc" ],
        orderCellsTop: true,
        ajax: {
            url: "/procurement/purchase-order/outstanding/?supplier_id=" + "{{ $MutationInbound->supplier_id }}",
        },
        columns: [
            { data: 'purchase_order_data' },
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
            { data: 'description', defaultContent: '-' },
            { data: 'required_delivery_date', defaultContent: '-' },
            { data: 'goods_received_status', defaultContent: '-' },
            // { data: 'created_at', defaultContent: '-', visible: false },
            { data: 'action', orderable: false },
        ],
    });    







    

    // ---------------------- "USE" BUTTON SCRIPT ------------------ //
    datatableObject1.on('click', useButtonClass, function () {
        $('#modalTitle').html("Receive this Item");

        $("input[value='patch']").remove();
        $('#inputForm').trigger("reset"); 

        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject1.row(tr).data();
        $('#inputForm').attr('action', actionUrl);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'post'
        }).prependTo('#inputForm');

        $('#purchase_order_detail_id').val(data.id);

        $("#item_id").prop('disabled', true);
        $('#item_id').append('<option value="' + data.purchase_requisition_detail.item_id + '" selected>' + data.purchase_requisition_detail.item.code + ' | ' + data.purchase_requisition_detail.item.name + '</option>');
        
        $('#quantity').attr('max', (data.order_quantity - (data.prepared_to_grn_quantity + data.processed_to_grn_quantity)));
        $('#quantity').val(1);

        $('#serial_number').prop('disabled', false);

        $('.parent_coding').val(null).trigger('change');
        $('.parent_coding').prop('disabled', true);

        $('#saveBtn').val("use");
        $('#inputModal').modal('show');
    });
    // ---------------------- END "USE" BUTTON SCRIPT ------------------ //












    function calculate_total_price () {
        var decimaltax = $("#vat").val() / 100;
        var totalprice = ($("#each_price_before_vat").val() * $("#order_quantity").val()) * decimaltax + ($("#each_price_before_vat").val() * $("#order_quantity").val());

        $("#total_price").val(formatNumber(totalprice));
    }

    $('#each_price_before_vat').on('input', function (e) {
        calculate_total_price ();
    });

    $('#vat').on('input', function (e) {
        calculate_total_price ();
    });

    $('#order_quantity').on('input', function (e) {
        calculate_total_price ();
    });
});
</script>
@endpush