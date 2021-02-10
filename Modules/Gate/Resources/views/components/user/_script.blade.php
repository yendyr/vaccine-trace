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
                { data: 'username', name: 'username' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'role.role_name', name: 'role.role_name' },
                { data: 'company.name', name: 'company.name',
                    defaultContent: "<p class='text-muted'>none</p>" },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false },
                { data: 'password', name: 'password', visible: false },
            ],
        });




        // $('.select2_company').select2({
        //     theme: 'bootstrap4',
        //     placeholder: 'Choose a Company',
        //     ajax: {
        //         url: "{{route('generalsetting.company.select2.company')}}",
        //         dataType: 'json',
        //     },
        //     dropdownParent: $('#inputModal')
        // });
        
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
                url: "{{ route('humanresources.employee.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        
        

        // --------------------- "CREATE" BUTTON SCRIPT ----------------------- //
        $('#create').click(function () {
            showCreateModal ('Create New User', inputFormId, actionUrl);
        });
        // --------------------- END "CREATE" BUTTON SCRIPT ----------------------- //





        table.on('click', '.editBtn', function () {
            $(inputFormId).trigger("reset");
            $('#modalTitle').html("Edit User");
            userId= $(this).val();
            let tr = $(this).closest('tr');
            let data = table.row(tr).data();
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

            // $(".select2_company").val(null).trigger('change');
            // if (data.company == null){
            //     $('#fcompany').append('<option value="' + data.company_id + '" selected></option>');
            // } 
            // else {
            //     $('#fcompany').append('<option value="' + data.company_id + '" selected>' + data.company.name + '</option>');
            // }

            $(".employee_id").val(null).trigger('change');
            if (data.employee != null){
                $('#employee_id').append('<option value="' + data.employee_id + '" selected>' + data.employee.name + '</option>');
            } 

            $('#fstatus').find('option').removeAttr('selected');
            if (data.status == '<p class="text-success">Active</p>'){
                $('#fstatus').find('option[value="1"]').attr('selected', '');
            }else{
                $('#fstatus').find('option[value="0"]').attr('selected', '');
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



    });

    $('#fpassword').pwstrength({
        ui: { showVerdictsInsideProgressBar: true }
    });
</script>
@endpush