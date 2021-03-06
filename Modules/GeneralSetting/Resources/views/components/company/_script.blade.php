@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/generalsetting/company';
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
                { data: 'code', defaultContent: '-' },
                { data: 'name', 
                        "render": function ( data, type, row, meta ) {
                        return '<a href="company/' + row.id + '">' + row.name + '</a>';
                        } },
                { data: 'gst_number', defaultContent: '-' },
                { data: 'npwp_number', defaultContent: '-' },
                { data: 'description', defaultContent: '-' },
                { data: 'is_customer', defaultContent: '-' },
                { data: 'is_supplier', defaultContent: '-' },
                { data: 'is_manufacturer', defaultContent: '-' },
                { data: 'status', defaultContent: '-' },
                { data: 'creator_name', defaultContent: '-' },
                { data: 'created_at', defaultContent: '-' },
                { data: 'updater_name', defaultContent: '-' },
                { data: 'updated_at', defaultContent: '-' },
                { data: 'action', orderable: false },
            ]
        });



        // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
        $('#create').click(function () {
            showCreateModal ('Create New Company', inputFormId, actionUrl);
        });
        // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //



        // ----------------- "EDIT" BUTTON SCRIPT ------------- //
        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Company");
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
            $('[class^="invalid-feedback-"]').html('');
            $('#inputModal').modal('show');
        });
        // ----------------- END "EDIT" BUTTON SCRIPT ------------- //



        // ----------------- "SUBMIT FORM" BUTTON SCRIPT ------------- //
        $(inputFormId).on('submit', function (event) {
            submitButtonProcess (tableId, inputFormId); 
        });
        // ----------------- END "SUBMIT FORM" BUTTON SCRIPT ------------- //



        // ----------------- "DELETE" BUTTON  SCRIPT ------------- //
        deleteButtonProcess (datatableObject, tableId, actionUrl);
        // ----------------- END "DELETE" BUTTON  SCRIPT ------------- //


        
    });
</script>
@endpush