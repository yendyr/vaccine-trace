@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/gate/user';
    var tableId = '#user-table';
    var inputFormId = '#inputForm';
    var userId;

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('gate.user.index')}}",
        },
        columns: [
            { data: 'username', defaultContent: '-' },
            { data: 'name', defaultContent: '-' },
            { data: 'email', defaultContent: '-' },
            { data: 'role.role_name', defaultContent: '-' },
            { data: 'employee.fullname', defaultContent: '-' },
            { data: 'company.name', defaultContent: '-' },
            { data: 'status', defaultContent: '-' },
            { data: 'action', orderable: false },
            { data: 'password', visible: false },
        ],
    });




    $('.company_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose a Company',
        ajax: {
            url: "{{route('generalsetting.company.select2.company')}}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });
    
    $('.select2_role').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose a Role',
        ajax: {
            url: "{{route('gate.user.select2.role')}}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.employee_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose an Employee',
        ajax: {
            url: "{{ route('hr.employee.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    
    

    // --------------------- "CREATE" BUTTON SCRIPT ----------------------- //
    $('#create').click(function () {
        showCreateModal ('Create New User', inputFormId, actionUrl);
    });
    // --------------------- END "CREATE" BUTTON SCRIPT ----------------------- //





    datatableObject.on('click', '.editBtn', function () {
        $(inputFormId).trigger("reset");
        $('#modalTitle').html("Edit User");
        userId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        $('#fusername').val(data.username);
        $('#fname').val(data.name);
        $('#femail').val(data.email);
        $('#fpassword').val(data.password);
        $(".select2_role").val(null).trigger('change');
        $('#frole').append('<option value="' + data.role_id + '" selected>' + data.role.role_name + '</option>');

        $(".employee_id").val(null).trigger('change');
        if (data.employee != null){
            $('#employee_id').append('<option value="' + data.employee_id + '" selected>' + data.employee.fullname + '</option>');
        } 

        $(".company_id").val(null).trigger('change');
        if (data.company_id != null){
            $('#company_id').append('<option value="' + data.company_id + '" selected>' + data.company.name + '</option>');
        } 

        if (data.status == '<label class="label label-success">Active</label>') {
            $('#status').prop('checked', true);
        }
        else {
            $('#status').prop('checked', false);
        }

        $('#saveBtn').val("edit-user");
        $(inputFormId).attr('action', '/gate/user/' + data.id);

        $('div[class^="invalid-feedback-"]').html('');  //hide all alert with pre-string invalid-feedback
        $('#inputModal').modal('show');
    });



    

    // --------------------- "SUBMIT" BUTTON SCRIPT ----------------------- //
    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId); 
    });
    // --------------------- END "SUBMIT" BUTTON SCRIPT ----------------------- //





    // --------------------- "DELETE" BUTTON SCRIPT ----------------------- //
    deleteButtonProcess (datatableObject, tableId, actionUrl);
    // --------------------- END "DELETE" BUTTON SCRIPT ----------------------- //





    $('#fpassword').pwstrength({
    ui: { showVerdictsInsideProgressBar: true }
    });
});
</script>
@endpush