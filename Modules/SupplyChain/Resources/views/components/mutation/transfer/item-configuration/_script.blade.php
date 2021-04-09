@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // var actionUrl = '/supplychain/mutation-outbound-detail';
    // var tableId = '#mutation-outbound-detail-table';
    // var inputFormId = '#inputForm';

    






    // // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    // datatableObject.on('click', '.editBtn', function () {
    //     clearForm(inputFormId);

    //     $('#modalTitle').html("Edit Item/Component");
    //     rowId= $(this).val();
    //     let tr = $(this).closest('tr');
    //     let data = datatableObject.row(tr).data();
    //     $(inputFormId).attr('action', actionUrl + '/' + data.id);

    //     $('<input>').attr({
    //         type: 'hidden',
    //         name: '_method',
    //         value: 'patch'
    //     }).prependTo('#inputForm');

    //     $('#alias_name').val(data.alias_name);
    //     $('#quantity').val(data.quantity);
    //     $('#serial_number').val(data.serial_number);
    //     $('#description').val(data.description);
    //     $('#initial_flight_hour').val(data.mutation_detail_initial_aging.initial_flight_hour);
    //     $('#initial_block_hour').val(data.mutation_detail_initial_aging.initial_block_hour);
    //     $('#initial_flight_cycle').val(data.mutation_detail_initial_aging.initial_flight_cycle);
    //     $('#initial_flight_event').val(data.mutation_detail_initial_aging.initial_flight_event);
    //     $('.initial_start_date').val(data.mutation_detail_initial_aging.initial_start_date);
    //     $('.expired_date').val(data.mutation_detail_initial_aging.expired_date);

    //     if (data.item != null) {
    //         $('#item_id').append('<option value="' + data.item_id + '" selected>' + data.item.code + ' | ' + data.item.name + '</option>');
    //     }

    //     if (data.item_group != null) {
    //         $('.parent_coding').append('<option value="' + data.parent_coding + '" selected>' + data.parent_item_code + ' | ' + data.parent_item_name + '</option>');
    //     }   

    //     if (data.highlighted == '<label class="label label-primary">Yes</label>') {
    //         $('#highlight').prop('checked', true);
    //     }
    //     else {
    //         $('#highlight').prop('checked', false);
    //     }

    //     if($('#quantity').val() > 1) {
    //         $('#serial_number').val(null);
    //         $('#serial_number').prop('disabled', true);
    //     }
    //     else {
    //         $('#serial_number').prop('disabled', false);
    //     }

    //     // if (data.status == '<label class="label label-success">Active</label>') {
    //     //     $('#status').prop('checked', true);
    //     // }
    //     // else {
    //     //     $('#status').prop('checked', false);
    //     // }

    //     $('#saveBtn').val("edit");
    //     $('[class^="invalid-feedback-"]').html('');  // clearing validation
    //     $('#inputModal').modal('show');
    // });
    // // ----------------- END "EDIT" BUTTON SCRIPT ------------- //




    // $(inputFormId).on('submit', function (event) {
    //     submitButtonProcess (tableId, inputFormId); 
    // });




    // deleteButtonProcess (datatableObject, tableId, actionUrl);



    
    // $("#quantity").on('change', function () {
    //     if($('#quantity').val() > 1) {
    //         $('#serial_number').val(null);
    //         $('#serial_number').prop('disabled', true);
    //     }
    //     else {
    //         $('#serial_number').prop('disabled', false);
    //     }            
    // });
});
</script>
@endpush