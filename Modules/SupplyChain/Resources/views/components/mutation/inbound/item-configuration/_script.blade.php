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
        ajax: {
            url: "/supplychain/mutation-inbound-detail/?id=" + "{{ $MutationInbound->id }}",
        },
        columns: [
            { data: 'item.code' },
            { data: 'item.name' },
            { data: 'serial_number', defaultContent: '-' },
            { data: 'quantity' },
            { data: 'item.unit.name' },
            { data: 'alias_name', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'detailed_item_location', defaultContent: '-' },
            { data: 'highlighted', defaultContent: '-' },
            { data: 'parent_item_code', name: 'Parent Item/Group PN', defaultContent: '-' },
            { data: 'parent_item_name', name: 'Parent Item/Group Name & Alias', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.initial_flight_hour', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.initial_block_hour', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.initial_flight_cycle', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.initial_flight_event', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.initial_start_date', defaultContent: '-' },
            { data: 'mutation_detail_initial_aging.expired_date', defaultContent: '-' },
            // { data: 'status', name: 'Status' },
            { data: 'creator_name', name: 'Created By' },
            { data: 'created_at', name: 'Created At' },
            { data: 'action', name: 'Action', orderable: false },
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

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo('#inputForm');

        $('#alias_name').val(data.alias_name);
        $('#quantity').val(data.quantity);
        $('#serial_number').val(data.serial_number);
        $('#description').val(data.description);
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
            $('.parent_coding').append('<option value="' + data.parent_coding + '" selected>' + data.parent_item_code + ' | ' + data.parent_item_name + '</option>');
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




    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId); 
    });




    deleteButtonProcess (datatableObject, tableId, actionUrl);



    
    $("#quantity").on('change', function () {
        if($('#quantity').val() > 1) {
            $('#serial_number').val(null);
            $('#serial_number').prop('disabled', true);
        }
        else {
            $('#serial_number').prop('disabled', false);
        }            
    });
});
</script>
@endpush