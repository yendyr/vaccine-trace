@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/supplychain/mutation-inbound-detail';
    var tableId = '#mutation-inbound-detail-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        order: [ 17, "asc" ],
        ajax: {
            url: "/supplychain/mutation-inbound-detail/?id=" + "{{ $MutationInbound->id }}",
        },
        columns: [
            { data: 'purchase_order_data', defaultContent: '-' },
            { data: 'item.code', defaultContent: '-' },
            { data: 'item.name', defaultContent: '-' },
            { data: 'item.category.name', defaultContent: '-' },
            { data: 'serial_number', defaultContent: '-' },
            { data: 'parent', defaultContent: '-' },
            { data: 'quantity', 
                "render": function ( data, type, row, meta ) {
                    return "<span class='label label-primary'>" + row.quantity + '</span>'; 
                }},
            { data: 'item.unit.name', defaultContent: '-' },
            { data: 'alias_name', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'detailed_item_location', defaultContent: '-' },
            { data: 'highlighted', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.initial_flight_hour', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.initial_block_hour', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.initial_flight_cycle', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.initial_flight_event', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.initial_start_date', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.expired_date', defaultContent: '-' },
            // { data: 'status', name: 'Status' },
            // { data: 'qr_code', defaultContent: '-' },
            // { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });


    

    $('.item_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Item',
        minimumInputLength: 3,
        minimumResultsForSearch: 10,
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.item.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });
        
    $('.parent_coding').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Parent Item',
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.mutation-inbound-detail.select2') }}",
            dataType: 'json',
            data: function (params) {
                var getHeaderId = { 
                    term: params.term,
                    stock_mutation_id: "{{ $MutationInbound->id }}",
                }
                return getHeaderId;
            }
        },
        dropdownParent: $('#inputModal')
    });








    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $('#create').click(function () {
        showCreateModal ('Add New Item/Component', inputFormId, actionUrl);

        $("#item_id").prop('disabled', false);
        $('#serial_number').prop('disabled', false);
        $('.parent_coding').val(null).trigger('change');
        $('.parent_coding').prop('disabled', false);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //









    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        clearForm(inputFormId);

        $('#modalTitle').html("Edit Item/Component");
        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        $("input[value='post']").remove();

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        if (data.purchase_order_detail_id) {
            $("#item_id").prop('disabled', true);
            $("#quantity").prop('readonly', true);
            $('.parent_coding').prop('disabled', true);
        }
        else {
            $("#item_id").prop('disabled', false);
            $("#quantity").prop('readonly', false);
            $('.parent_coding').prop('disabled', false);
        }

        if (data.parent_coding) {
            $("#detailed_item_location").prop('readonly', true);
        }
        else {
            $("#detailed_item_location").prop('readonly', false);
        }

        $('#alias_name').val(data.alias_name);
        $('#quantity').val(data.quantity);
        $('#serial_number').val(data.serial_number);
        $('#description').val(data.description);
        $('#detailed_item_location').val(data.detailed_item_location);
        $('#initial_flight_hour').val(data.mutation_detail_initial_aging.initial_flight_hour);
        $('#initial_block_hour').val(data.mutation_detail_initial_aging.initial_block_hour);
        $('#initial_flight_cycle').val(data.mutation_detail_initial_aging.initial_flight_cycle);
        $('#initial_flight_event').val(data.mutation_detail_initial_aging.initial_flight_event);
        $('.initial_start_date').val(data.mutation_detail_initial_aging.initial_start_date);
        $('.expired_date').val(data.mutation_detail_initial_aging.expired_date);

        if (data.item != null) {
            $('#item_id').append('<option value="' + data.item_id + '" selected>' + data.item.code + ' | ' + data.item.name + '</option>');
        }

        if (data.item_group != null) {
            var alias_name = '-';
            var serial_number = '-';

            if(data.item_group.alias_name) {
                alias_name = data.item_group.alias_name;
            }
            if(data.item_group.serial_number) {
                serial_number = data.item_group.serial_number;
            }

            $('.parent_coding').append('<option value="' + data.parent_coding + '" selected>' + data.item_group.item.code + ' | ' + serial_number + ' | ' + data.item_group.item.name + ' | ' + alias_name + '</option>');
        }   

        if (data.highlighted == '<label class="label label-primary">Yes</label>') {
            $('#highlight').prop('checked', true);
        }
        else {
            $('#highlight').prop('checked', false);
        }

        if($('#quantity').val() > 1) {
            $('#serial_number').val(null);
            $('#serial_number').prop('disabled', true);
        }
        else {
            $('#serial_number').prop('disabled', false);
        }

        // if (data.status == '<label class="label label-success">Active</label>') {
        //     $('#status').prop('checked', true);
        // }
        // else {
        //     $('#status').prop('checked', false);
        // }

        $('#saveBtn').val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $('#inputModal').modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //









    // --------------------------- "SUBMIT" BUTTON SCRIPT ----------------------- //
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
                let l = $('.ladda-button-submit').ladda();
                l.ladda('start');
                $('[class^="invalid-feedback-"]').html('');
                $('#saveBtn').prop('disabled', true);
            },
            error: function(data) {
                let errors = data.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(index, value) {
                        $('div.invalid-feedback-' + index).html(value);
                    })
                }
            },
            success: function(data) {
                if (data.success) {
                    generateToast('success', data.success);
                } else if (data.error) {
                    swal.fire({
                        titleText: "Action Failed",
                        text: data.error,
                        icon: "error",
                    });
                }

                $('#inputModal').modal('hide');
                $('#mutation-inbound-detail-table').DataTable().ajax.reload();
                $('#outstanding-item-table').DataTable().ajax.reload();

                if (data.redirectUrl && data.success && targetTableId == null) {
                    setTimeout(function() {
                        window.location.href = data.redirectUrl;
                    }, 3000);    
                }
            },
            complete: function() {
                let l = $('.ladda-button-submit').ladda();
                l.ladda('stop');
                $('#saveBtn').prop('disabled', false);
            }
        });
    });
    // --------------------------- END "SUBMIT" BUTTON SCRIPT ----------------------- //









    // --------------------------- "DELETE" BUTTON SCRIPT ----------------------- //
    datatableObject.on('click', '.deleteBtn', function() {
        rowId = $(this).val();
        $('#deleteModal').modal('show');
        $('#delete-form').attr('action', actionUrl + '/' + rowId);
    });

    $('#delete-form').on('submit', function(e) {
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
            beforeSend: function() {
                let l = $('.ladda-button-submit').ladda();
                l.ladda('start');
                $('[class^="invalid-feedback-"]').html('');
                $('#delete-button').text('Deleting...');
                $('#delete-button').prop('disabled', true);
            },
            error: function(data) {
                if (data.error) {
                    generateToast('error', data.error);
                }
            },
            success: function(data) {
                if (data.success) {
                    generateToast('success', data.success);
                } else if (data.error) {
                    swal.fire({
                        titleText: "Action Failed",
                        text: data.error,
                        icon: "error",
                    });
                }

                $('#mutation-inbound-detail-table').DataTable().ajax.reload();
                $('#outstanding-item-table').DataTable().ajax.reload();
            },
            complete: function(data) {
                let l = $('.ladda-button-submit').ladda();
                l.ladda('stop');
                $('#delete-button').text('Delete');
                $('#deleteModal').modal('hide');
                $('#delete-button').prop('disabled', false);
                
                if (data.redirectUrl && data.success && targetTableId == null) {
                    setTimeout(function() {
                        window.location.href = data.redirectUrl;
                    }, 3000);    
                }
            }
        });
    });
    // --------------------------- END "DELETE" BUTTON SCRIPT ----------------------- //









    // -------------------- FRONT-END LEVEL VALIDATION ----------------------------- //
    $("#quantity").on('change', function () {
        if($('#quantity').val() > 1) {
            $('#serial_number').val(null);
            $('#serial_number').prop('disabled', true);
        }
        else {
            $('#serial_number').prop('disabled', false);
        }            
    });

    $(".parent_coding").on('change', function () {
        if($('.parent_coding').val() != null) {
            $('#detailed_item_location').val(null);
            $('#detailed_item_location').prop('disabled', true);
        }
        else {
            $('#detailed_item_location').prop('disabled', false);
        }            
    });
    // -------------------- END FRONT-END LEVEL VALIDATION ----------------------------- //
});
</script>
@endpush