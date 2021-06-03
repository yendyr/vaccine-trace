@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/purchase-requisition/outstanding';
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
                        '<tr class="group" style="text-align: left;"><td colspan="14">Purchase Request Code: <b>' + group + '</b></td></tr>'
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
        ajax: {
            url: "/procurement/purchase-requisition/outstanding/?with_use_button=true",
        },
        columns: [
            { data: 'purchase_requisition.code', defaultContent: "-" },
            { data: 'item.code' },
            { data: 'item.name' },
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
            { data: 'parent', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            // { data: 'created_at', visible: false },
            { data: 'purchase_order_status' },
            { data: 'action' },
        ],
    });    


    

    // ----------------- "USE" BUTTON SCRIPT ------------- //
    datatableObject.on('click', useButtonClass, function () {
        $('#modalTitle').html("Use this Item");

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
        $('#item_stock_id').val(data.id);
        $('#available_quantity').val(data.available_quantity);
        $('#unit').val(data.item.unit.name);

        $('#outbound_quantity').attr('max', data.available_quantity);
        $('#outbound_unit').val(data.item.unit.name);

        $('#serial_number').val(data.serial_number);
        $('#alias_name').val(data.alias_name);
        $('#description').val(data.description);
        $('#detailed_item_location').val(data.detailed_item_location);
        // $('#parent').val(data.parent);

        if(data.available_quantity == 1 && data.serial_number != null) {
            $('#outbound_quantity').val(1);
        }

        $('#saveBtn').val("use");
        $(saveButtonModalTextId).html("Use this Item");
        $('#inputModal').modal('show');
    });
    // ----------------- END "USE" BUTTON SCRIPT ------------- //






    
    var datatableObject2 = $(tableId2).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        order: [ 11, "desc" ],
        ajax: {
            url: "/supplychain/mutation-outbound-detail/?id=" + "null",
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

        $('#item').val(data.item_stock.item.code + ' | ' + data.item_stock.item.name);
        $('#item_stock_id').val(data.item_stock_id);

        var showAvailableQty = data.item_stock.available_quantity + data.outbound_quantity;
        $('#available_quantity').val(showAvailableQty);
        $('#unit').val(data.item_stock.item.unit.name);

        $('#outbound_quantity').attr('max', showAvailableQty);
        $('#outbound_unit').val(data.item_stock.item.unit.name);

        $('#serial_number').val(data.item_stock.serial_number);
        $('#alias_name').val(data.item_stock.alias_name);
        $('#description').val(data.item_stock.description);
        $('#detailed_item_location').val(data.item_stock.detailed_item_location);
        // $('#parent').val(data.parent);

        if(showAvailableQty == 1 && data.item_stock.serial_number != null) {
            $('#outbound_quantity').val(1);
        }
        else {
            $('#outbound_quantity').val(data.outbound_quantity);
        }

        $('#outbound_remark').val(data.description);

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
});
</script>
@endpush