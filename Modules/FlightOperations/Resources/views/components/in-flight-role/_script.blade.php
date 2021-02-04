@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = "/flightoperations/in-flight-role";
        var tableId = '#in-flight-role-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('gate.role.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code', defaultContent: '-' },
                { data: 'role_name', name: 'Role Name' },
                { data: 'role_name_alias', name: 'Role Name Alias', defaultContent: '-' },
                { data: 'description', name: 'Description/Remark', defaultContent: '-' },
                { data: 'is_in_flight_role', name: 'Authorize as In-Flight Role' },
                { data: 'status', name: 'Status' },
                { data: 'creator_name', name: 'Created By' },
                { data: 'created_at', name: 'Created At' },
                { data: 'updater_name', name: 'Last Updated By' },
                { data: 'updated_at', name: 'Last Updated At' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Item COA");
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

            $('#code').val(data.code);
            $('#role_name').val(data.role_name);
            $('#role_name_alias').val(data.role_name_alias);
            $('#description').val(data.description); 

            if (data.is_in_flight_role == '<label class="label label-success">Yes</label>') {
                $('#is_in_flight_role').prop('checked', true);
            }
            else {
                $('#is_in_flight_role').prop('checked', false);
            }

            $('#saveBtn').val("edit");
            $('[class^="invalid-feedback-"]').html('');  // clearing validation
            $('#inputModal').modal('show');
        });

        $(inputFormId).on('submit', function (event) {
            submitButtonProcess (tableId, inputFormId); 
        });
    });
</script>
@endpush