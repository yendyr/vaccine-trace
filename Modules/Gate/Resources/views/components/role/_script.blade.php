@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/gate/role';
        var tableId = '#role-table';
        var inputFormId = '#inputForm';
        var roleId;
        
        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('gate.role.index')}}",
            },
            columns: [
                { data: 'role_name', defaultContent: '-' },
                { data: 'status', defaultContent: '-' },
                { data: 'action', orderable: false },
            ]
        });




        // --------------------- "CREATE" BUTTON SCRIPT ----------------------- //
        $('#create').click(function () {
            showCreateModal ('Create New Role', inputFormId, actionUrl);
        });
        // --------------------- END "CREATE" BUTTON SCRIPT ----------------------- //





        datatableObject.on('click', '.editBtn', function () {
            $(inputFormId).trigger("reset");
            $('#modalTitle').html("Edit Role");
            roleId= $(this).val();
            let tr = $(this).closest('tr');
            let data = datatableObject.row(tr).data();

            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo(inputFormId);

            $('#frolename').val(data.role_name);
            $('#fstatus').find('option').removeAttr('selected');
            
            if (data.status == '<label class="label label-success">Active</label>') {
                $('#status').prop('checked', true);
            }
            else {
                $('#status').prop('checked', false);
            }

            $('#saveBtn').val("edit-role");
            $(inputFormId).attr('action', '/gate/role/' + data.id);

            $('[class^="invalid-feedback-"]').html('');  //delete html all alert with pre-string invalid-feedback
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
</script>
@endpush