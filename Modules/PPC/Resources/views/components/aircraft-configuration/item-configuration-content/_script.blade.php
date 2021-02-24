@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/configuration-detail';
    var tableId = '#configuration-detail';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/configuration-detail/?id=" + $('#aircraft_configuration_id').val(),
        },
        columns: [
            { data: 'item.code', name: 'Item Code/PN' },
            { data: 'item.name', name: 'Item Name' },
            { data: 'serial_number', name: 'Serial Number' },
            { data: 'alias_name', name: 'Alias Name' },
            { data: 'description', name: 'Description/Remark' },
            { data: 'highlighted', name: 'Highlight Item' },
            { data: 'parent_item_code', name: 'Parent Item/Group PN', defaultContent: '-' },
            { data: 'parent_item_name', name: 'Parent Item/Group Name & Alias', defaultContent: '-' },
            { data: 'initial_flight_hour', name: 'Initial FH' },
            { data: 'initial_block_hour',  defaultContent: '-' },
            { data: 'initial_flight_cycle', name: 'Initial FC' },
            { data: 'initial_start_date', name: 'Initial Start Date' },
            { data: 'status', name: 'Status' },
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
            url: "{{ route('ppc.configuration-detail.select2') }}",
            dataType: 'json',
            data: function (params) {
                var getHeaderId = { 
                    term: params.term,
                    aircraft_configuration_id: $('#aircraft_configuration_id').val(),
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
        $('#serial_number').val(data.serial_number);
        $('#description').val(data.description);
        $('#initial_flight_hour').val(data.initial_flight_hour);
        $('#initial_block_hour').val(data.initial_block_hour);
        $('#initial_flight_cycle').val(data.initial_flight_cycle);
        $('#initial_flight_event').val(data.initial_flight_event);
        $('.initial_start_date').val(data.initial_start_date);

        if (data.item != null) {
            $('#item_id').append('<option value="' + data.item_id + '" selected>' + data.item.code + ' | ' + data.item.name + '</option>');
        }

        if (data.item_group != null) {
            $('.parent_coding').append('<option value="' + data.parent_coding + '" selected>' + data.parent_item_code + ' | ' + data.parent_item_name + '</option>');
        }   

        if (data.highlight == '<label class="label label-success">Yes</label>') {
            $('#highlight').prop('checked', true);
        }
        else {
            $('#highlight').prop('checked', false);
        }

        if (data.status == '<label class="label label-success">Active</label>') {
            $('#status').prop('checked', true);
        }
        else {
            $('#status').prop('checked', false);
        }

        $('#saveBtn').val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $('#inputModal').modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //




    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId); 
    });




    deleteButtonProcess (datatableObject, tableId, actionUrl);



    // ----------------- "APPROVE" BUTTON SCRIPT ------------- //
    $('.approveBtn').on('click', function () {
        rowId = $(this).val();
        $('#approve-form').trigger("reset");
        $('#approveModal').modal('show');
        $('#approve-form').attr('action', '/ppc/aircraft-configuration/' + rowId + '/approve');
    });

    $('#approve-form').on('submit', function (e) {
        e.preventDefault();
        let url_action = $(this).attr('action');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content")
            },
            url: url_action,
            type: "POST",
            data: $('#approve-form').serialize(),
            dataType: 'json',
            beforeSend:function(){
                $('#approve-button').text('Approving...');
                $('#approve-button').prop('disabled', true);
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
                setTimeout(location.reload.bind(location), 2000);
            },
            complete: function(data) {
                $('#approve-button').text('Approve');
                $('#approveModal').modal('hide');
                $('#approve-button').prop('disabled', false);
                $(targetTableId).DataTable().ajax.reload();
            }
        });
    });
    // ----------------- END "APPROVE" BUTTON SCRIPT ------------- //
});
</script>
@endpush