@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/flightoperations/afml-detail-crew';
    var tableId = '#afml-detail-crew';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: actionUrl + "/?id=" + $('#afm_log_id').val(),
        },
        columns: [
            { data: 'employee.fullname', defaultContent: '-' },
            { data: 'in_flight_role.role_name', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            // { data: 'status', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });


    

    $('.employee_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Person',
        allowClear: true,
        ajax: {
            url: "{{ route('hr.employee.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.role_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose In-Flight Role',
        allowClear: true,
        ajax: {
            url: "{{ route('gate.role.select2.in-flight') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });
        
    




    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $('#create').click(function () {
        showCreateModal ('Add New Crew', inputFormId, actionUrl);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //






    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit Crew");
        $(inputFormId).trigger("reset");                
        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo('#inputForm');

        $('#crew_description').val(data.description);

        if (data.employee != null) {
            $('#employee_id').append('<option value="' + data.employee_id + '" selected>' + data.employee.fullname + '</option>');
        }

        if (data.in_flight_role != null) {
            if (data.in_flight_role.role_name_alias != null) {
                $('#role_id').append('<option value="' + data.role_id + '" selected>' + data.in_flight_role.role_name + ' | ' + data.in_flight_role.role_name_alias + '</option>');
            }
            else {
                $('#role_id').append('<option value="' + data.role_id + '" selected>' + data.in_flight_role.role_name + '</option>');
            }
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



    
});
</script>
@endpush