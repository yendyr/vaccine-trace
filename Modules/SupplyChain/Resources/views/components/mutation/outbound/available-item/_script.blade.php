@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/supplychain/mutation-outbound-detail';
    var tableId = '#available-item-table';
    var inputFormId = '#inputForm';
    var useButtonClass = '.useBtn';
    var saveButtonModalTextId = '#saveButtonModalText';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/supplychain/stock-monitoring/?warehouse_id=" + "{{ $MutationOutbound->warehouse_origin }}" + "&with_use_button=true",
        },
        columns: [
            // { data: 'warehouse' },
            { data: 'detailed_item_location', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'item.code' },
            { data: 'item.name' },
            { data: 'serial_number', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'alias_name', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'used_quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'loaned_quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'reserved_quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
            { data: 'available_quantity', defaultContent: "<span class='text-muted font-italic'>Not Set</span>" },
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
        $('#available_quantity').val(data.available_quantity);
        $('#unit').val(data.item.unit.name);

        $('#outbound_quantity').attr('max', data.available_quantity);
        $('#outbound_unit').val(data.item.unit.name);

        $('#serial_number').val(data.serial_number);
        $('#alias_name').val(data.alias_name);
        $('#description').val(data.description);
        $('#detailed_item_location').val(data.detailed_item_location);
        $('#parent').val(data.parent);

        $('#saveBtn').val("use");
        $(saveButtonModalTextId).html("Use this Item");
        $('#inputModal').modal('show');
    });
    // ----------------- END "USE" BUTTON SCRIPT ------------- //






    // $('.item_id').select2({
    //     theme: 'bootstrap4',
    //     placeholder: 'Choose Item',
    //     minimumInputLength: 3,
    //     minimumResultsForSearch: 10,
    //     allowClear: true,
    //     ajax: {
    //         url: "{{ route('supplychain.item.select2') }}",
    //         dataType: 'json',
    //     },
    //     dropdownParent: $('#inputModal')
    // });
        
    // $('.parent_coding').select2({
    //     theme: 'bootstrap4',
    //     placeholder: 'Choose Parent Item',
    //     minimumInputLength: 2,
    //     minimumResultsForSearch: 10,
    //     allowClear: true,
    //     ajax: {
    //         url: "{{ route('supplychain.mutation-outbound-detail.select2') }}",
    //         dataType: 'json',
    //         data: function (params) {
    //             var getHeaderId = { 
    //                 term: params.term,
    //                 stock_mutation_id: $('#stock_mutation_id').val(),
    //             }
    //             return getHeaderId;
    //         }
    //     },
    //     dropdownParent: $('#inputModal')
    // });






    // // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    // $('#create').click(function () {
    //     showCreateModal ('Add New Item/Component', inputFormId, actionUrl);
    // });
    // // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //






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