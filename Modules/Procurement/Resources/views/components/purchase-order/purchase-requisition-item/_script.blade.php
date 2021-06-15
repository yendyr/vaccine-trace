@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/procurement/purchase-order-detail';
    var tableId = '#outstanding-item-table';
    var tableId2 = '#purchase-order-detail-table';
    var inputFormId = '#inputForm';
    var useButtonClass = '.useBtn';
    var saveButtonModalTextId = '#saveButtonModalText';

    $('#outstanding-item-table thead tr').clone(true).appendTo('#outstanding-item-table thead');
    $('#outstanding-item-table thead tr:eq(1) th').each( function (i) {
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

    var groupColumn = 0;
    var datatableObject = $(tableId).DataTable({
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
                        '<tr class="group" style="text-align: left;"><td colspan="10">Purchase Request Transaction Code: <b>' + group + '</b></td></tr>'
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
            url: "/procurement/purchase-requisition/outstanding/?with_use_button=true&purchase_order_id=" + "{{ $PurchaseOrder->id }}",
        },
        columns: [
            { data: 'purchase_requisition_data' },
            { data: 'item.code' },
            { data: 'item.name' },
            { data: 'item.category.name' },
            { data: 'parent', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'request_quantity' },
            { data: 'available_stock',
                "render": function ( data, type, row, meta ) {
                    if (row.available_stock > 0) {
                        return "<span class='label label-success'>" + row.available_stock + '</span>';
                    }
                    else {
                        return "<span class='label label-danger'>" + row.available_stock + '</span>';
                    } 
                }},
            { data: 'item.unit.name' },
            { data: 'description', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            // { data: 'created_at', visible: false },
            { data: 'purchase_order_status' },
            { data: 'action' },
        ],
    });    




    

    // ----------------- "USE" BUTTON SCRIPT ------------- //
    datatableObject.on('click', useButtonClass, function () {
        $('#modalTitle').html("Use this to Purchase Order");

        $("input[value='patch']").remove();
        $(inputFormId).trigger("reset"); 

        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'post'
        }).prependTo(inputFormId);

        $('#item').val(data.item.code + ' | ' + data.item.name);
        $('#purchase_requisition_detail_id').val(data.id);
        $('#purchase_requisition_code').val(data.purchase_requisition.code);
        $('#request_quantity').val(data.request_quantity);
        $('#available_stock').val(data.available_stock);
        $('#prepared_to_po_quantity').val(data.prepared_to_po_quantity);
        $('#processed_to_po_quantity').val(data.processed_to_po_quantity);
        $('.unit').val(data.item.unit.name);

        $('#order_quantity').attr('max', (data.request_quantity - (data.prepared_to_po_quantity + data.processed_to_po_quantity)));
        $('#order_unit').val(data.item.unit.name);
        
        $('#description').val(data.description);

        $('#saveBtn').val("use");
        $(saveButtonModalTextId).html("Use this Item to Purchase Order");
        $('#inputModal').modal('show');
    });
    // ----------------- END "USE" BUTTON SCRIPT ------------- //






    
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

    var datatableObject2 = $(tableId2).DataTable({
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







    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject2.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit this Item");

        $("input[value='post']").remove();
        $(inputFormId).trigger("reset"); 

        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject2.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        if (data.purchase_requisition_detail.parent_coding) {
            $("#order_quantity").prop('readonly', true);
            $(".required_delivery_date").prop('disabled', true);
        }
        else {
            $("#order_quantity").prop('readonly', false);
            $(".required_delivery_date").prop('disabled', false);
        }

        $('#item').val(data.purchase_requisition_detail.item.code + ' | ' + data.purchase_requisition_detail.item.name);
        $('#purchase_requisition_detail_id').val(data.purchase_requisition_detail.id);
        $('#purchase_requisition_code').val(data.purchase_requisition_detail.purchase_requisition.code);
        $('#request_quantity').val(data.purchase_requisition_detail.request_quantity);
        $('#available_stock').val(data.available_stock);

        var temp_prepared_po = data.purchase_requisition_detail.prepared_to_po_quantity - data.order_quantity;
        var temp_processed_po = data.purchase_requisition_detail.processed_to_po_quantity;

        $('#prepared_to_po_quantity').val(temp_prepared_po);
        $('#processed_to_po_quantity').val(temp_processed_po);
        $('.unit').val(data.purchase_requisition_detail.item.unit.name);

        $('#order_quantity').attr('max', data.purchase_requisition_detail.request_quantity - (temp_prepared_po + temp_processed_po));
        $('#order_unit').val(data.purchase_requisition_detail.item.unit.name);
        
        $('#description').val(data.purchase_requisition_detail.description);

        $('#order_quantity').val(data.order_quantity);
        $('#order_remark').val(data.description);
        $('.required_delivery_date').val(data.required_delivery_date);
        $('#each_price_before_vat').val(data.each_price_before_vat);
        $('#vat').val(data.vat * 100);
        
        calculate_total_price ();

        $('#saveBtn').val("use");
        $(saveButtonModalTextId).html("Edit this Item");
        $('#inputModal').modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //








    // ----------------- "SUBMIT" BUTTON SCRIPT ------------- //
    $(inputFormId).on('submit', function (event) {
        event.preventDefault();
        let url_action = $(inputFormId).attr('action');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content")
            },
            url: url_action,
            method: "POST",
            data: $(inputFormId).serialize(),
            dataType: 'json',
            beforeSend: function() {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'start' );
                $('[class^="invalid-feedback-"]').html('');
                $('#saveBtn').prop('disabled', true);
            },
            error: function(data) {
                if (data.error) {
                    generateToast ('error', data.error);
                }
            },
            success: function (data) {
                $('#inputModal').modal('hide');
                if (data.success) {
                    generateToast ('success', data.success);  
                    $(tableId).DataTable().ajax.reload();                          
                    $(tableId2).DataTable().ajax.reload();                          
                }
                else if (data.error) {
                    swal.fire({
                        titleText: "Action Failed",
                        text: data.error,
                        icon: "error",
                    });   
                }
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $('#saveBtn'). prop('disabled', false);
            }
        }); 
    });
    // ----------------- END "SUBMIT" BUTTON SCRIPT ------------- //





    // ----------------- "DELETE" BUTTON SCRIPT ------------- //
    datatableObject2.on('click', '.deleteBtn', function () {
            rowId = $(this).val();
            $('#deleteModal').modal('show');
            $('#delete-form').attr('action', actionUrl + '/' + rowId);
        });

        $('#delete-form').on('submit', function (e) {
            e.preventDefault();
            let url_action = $(this).attr('action');
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content")
                },
                url: url_action,
                type: "DELETE",
                beforeSend:function(){
                    $('#delete-button').text('Deleting...');
                    $('#delete-button').prop('disabled', true);
                },
                error: function(data){
                    if (data.error) {
                        generateToast ('error', data.error);
                    }
                },
                success:function(data){
                    if (data.success){
                        generateToast ('success', data.success);
                    }
                    else if (data.error) {
                    swal.fire({
                        titleText: "Action Failed",
                        text: data.error,
                        icon: "error",
                    });
                }
                },
                complete: function(data) {
                    $('#delete-button').text('Delete');
                    $('#deleteModal').modal('hide');
                    $('#delete-button').prop('disabled', false);
                    $(tableId).DataTable().ajax.reload();
                    $(tableId2).DataTable().ajax.reload();
                }
            });
        });
    // ----------------- END "DELETE" BUTTON SCRIPT ------------- //








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