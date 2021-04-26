@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/supplychain/mutation-transfer-detail';
    var tableId = '#available-item-table';
    var tableId2 = '#mutation-transfer-detail-table';
    var inputFormId = '#inputForm';
    var useButtonClass = '.useBtn';
    var saveButtonModalTextId = '#saveButtonModalText';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/supplychain/stock-monitoring/?warehouse_id=" + "{{ $MutationTransfer->warehouse_origin }}" + "&with_use_button=true",
        },
        columns: [
            // { data: 'warehouse' },
            { data: 'detailed_item_location', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'item.code', defaultContent: '-' },
            { data: 'item.name', defaultContent: '-' },
            { data: 'serial_number', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'alias_name', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'used_quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'loaned_quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'reserved_quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'available_quantity',
                "render": function ( data, type, row, meta ) {
                    if (row.available_quantity > 0) {
                        return "<span class='label label-success'>" + row.available_quantity + '</span>';
                    }
                    else {
                        return "<span class='label label-danger'>" + row.available_quantity + '</span>';
                    } 
                }},
            { data: 'item.unit.name', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'description', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'parent', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'action' },
        ]
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

        $('#transfer_quantity').attr('max', data.available_quantity);
        $('#transfer_unit').val(data.item.unit.name);

        $('#serial_number').val(data.serial_number);
        $('#alias_name').val(data.alias_name);
        $('#description').val(data.description);
        $('#detailed_item_location').val(data.detailed_item_location);
        // $('#parent').val(data.parent);

        if(data.available_quantity == 1 && data.serial_number != null) {
            $('#transfer_quantity').val(1);
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
        ajax: {
            url: "/supplychain/mutation-transfer-detail/?id=" + "{{ $MutationTransfer->id }}",
        },
        columns: [
            { data: 'item_stock.detailed_item_location', defaultContent: '-' },
            { data: 'item_stock.item.code', defaultContent: '-' },
            { data: 'item_stock.item.name', defaultContent: '-' },
            { data: 'item_stock.serial_number', defaultContent: '-' },
            { data: 'transfer_quantity',
                "render": function ( data, type, row, meta ) {
                    return "<span class='label label-primary'>" + row.transfer_quantity + '</span>';
                }},
            { data: 'item_stock.item.unit.name', defaultContent: '-' },
            { data: 'item_stock.alias_name', defaultContent: '-' },
            { data: 'item_stock.description', defaultContent: '-' },
            { data: 'transfer_detailed_item_location', defaultContent: '-' },
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

        var showAvailableQty = data.item_stock.available_quantity + data.transfer_quantity;
        $('#available_quantity').val(showAvailableQty);
        $('#unit').val(data.item_stock.item.unit.name);

        $('#transfer_quantity').attr('max', showAvailableQty);
        $('#transfer_unit').val(data.item_stock.item.unit.name);

        $('#serial_number').val(data.item_stock.serial_number);
        $('#alias_name').val(data.item_stock.alias_name);
        $('#description').val(data.item_stock.description);
        $('#detailed_item_location').val(data.item_stock.detailed_item_location);
        // $('#parent').val(data.parent);

        if(showAvailableQty == 1 && data.item_stock.serial_number != null) {
            $('#transfer_quantity').val(1);
        }
        else {
            $('#transfer_quantity').val(data.transfer_quantity);
        }

        $('#transfer_detailed_item_location').val(data.transfer_detailed_item_location);
        $('#transfer_remark').val(data.description);

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