@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/generalsetting/company/';
        var tableId = '#company-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('generalsetting.company.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code', defaultContent: '-' },
                { data: 'name', name: 'Name', defaultContent: '-' },
                { data: 'gst_number', name: 'GST Number', defaultContent: '-' },
                { data: 'npwp_number', name: 'NPWP', defaultContent: '-' },
                { data: 'description', name: 'Description/Remark', defaultContent: '-' },
                { data: 'status', name: 'Status', defaultContent: '-' },
                { data: 'creator_name', name: 'Created By', defaultContent: '-' },
                { data: 'created_at', name: 'Created At', defaultContent: '-' },
                { data: 'updater_name', name: 'Last Updated By', defaultContent: '-' },
                { data: 'updated_at', name: 'Last Updated At', defaultContent: '-' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        $('#create').click(function () {
            showCreateModal ('Create New Company', inputFormId, actionUrl);
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Company");
            $(inputFormId).trigger("reset");                
            rowId= $(this).val();
            let tr = $(this).closest('tr');
            let data = datatableObject.row(tr).data();
            $(inputFormId).attr('action', actionUrl + data.id);

            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo('#inputForm');

            $('#iso').val(data.iso);
            $('#iso3').val(data.iso3);
            $('#name').val(data.name);
            $('#nice_name').val(data.nicename);
            $('#num_code').val(data.numcode);
            $('#phone_code').val(data.phonecode);
            $('#description').val(data.description);                
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

        $(inputFormId).on('submit', function (event) {
            submitButtonProcess (tableId, inputFormId); 
        });

        deleteButtonProcess (datatableObject, tableId, actionUrl);
    });
</script>
@endpush