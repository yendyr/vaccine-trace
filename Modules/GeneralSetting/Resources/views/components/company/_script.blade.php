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
            searchDelay: 1500,
            ajax: {
                url: "{{ route('generalsetting.company.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code', defaultContent: '-' },
                { data: 'name', 
                        "render": function ( data, type, row, meta ) {
                        return '<a href="company/' + row.id + '">' + row.name + '</a>';
                        } },
                { data: 'gst_number', name: 'GST Number', defaultContent: '-' },
                { data: 'npwp_number', name: 'NPWP', defaultContent: '-' },
                { data: 'description', name: 'Description/Remark', defaultContent: '-' },
                { data: 'is_customer', name: 'As Customer', defaultContent: '-' },
                { data: 'is_supplier', name: 'As Supplier', defaultContent: '-' },
                { data: 'is_manufacturer', name: 'As Manufacturer', defaultContent: '-' },
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

            $('#code').val(data.code);
            $('#name').val(data.name);
            $('#gst_number').val(data.gst_number);
            $('#npwp_number').val(data.npwp_number);
            $('#description').val(data.description);                
            if (data.status == '<label class="label label-success">Active</label>') {
                $('#status').prop('checked', true);
            }
            else {
                $('#status').prop('checked', false);
            }
            if (data.is_customer == '<label class="label label-success">Yes</label>') {
                $('#is_customer').prop('checked', true);
            }
            else {
                $('#is_customer').prop('checked', false);
            }
            if (data.is_supplier == '<label class="label label-success">Yes</label>') {
                $('#is_supplier').prop('checked', true);
            }
            else {
                $('#is_supplier').prop('checked', false);
            }
            if (data.is_manufacturer == '<label class="label label-success">Yes</label>') {
                $('#is_manufacturer').prop('checked', true);
            }
            else {
                $('#is_manufacturer').prop('checked', false);
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