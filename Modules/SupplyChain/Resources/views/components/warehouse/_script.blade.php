@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/supplychain/warehouse';
        var tableId = '#warehouse-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('supplychain.warehouse.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code'  },
                { data: 'name', name: 'Warehouse Name' },
                { data: 'description', name: 'Description/Remark' },
                { data: 'status', name: 'Status' },
                { data: 'creator_name', name: 'Created By' },
                { data: 'created_at', name: 'Created At' },
                { data: 'updater_name', name: 'Last Updated By' },
                { data: 'updated_at', name: 'Last Updated At' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        $('#create').click(function () {
            showCreateModal ('Create New Warehouse', inputFormId, actionUrl);
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Warehouse");
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
            $('#name').val(data.name);
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