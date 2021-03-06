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
                { data: 'code', defaultContent: '-' },
                { data: 'role_name', defaultContent: '-' },
                { data: 'role_name_alias', defaultContent: '-' },
                { data: 'description', defaultContent: '-' },
                { data: 'is_in_flight_role', defaultContent: '-' },
                { data: 'status', defaultContent: '-' },
                { data: 'creator_name', defaultContent: '-' },
                { data: 'created_at', defaultContent: '-' },
                { data: 'updater_name', defaultContent: '-' },
                { data: 'updated_at', defaultContent: '-' },
                { data: 'action', orderable: false },
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

            if (data.is_in_flight_role == '<label class="label label-primary">Yes</label>') {
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