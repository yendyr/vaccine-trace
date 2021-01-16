@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/generalsetting/company-contact/';
        var tableId = '#company-contact-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('generalsetting.company-contact.index') }}",
            },
            columns: [
                { data: 'label', name: 'Label', defaultContent: '-' },
                { data: 'name', name: 'Name', defaultContent: '-' },
                { data: 'email', name: 'Email', defaultContent: '-' },
                { data: 'mobile_number', name: 'Mobile Number', defaultContent: '-' },
                { data: 'office_number', name: 'Office Number', defaultContent: '-' },
                { data: 'fax_number', name: 'Fax Number', defaultContent: '-' },
                { data: 'other_number', name: 'Other Number', defaultContent: '-' },
                { data: 'website', name: 'Website', defaultContent: '-' },
                { data: 'status', name: 'Status', defaultContent: '-' },
                { data: 'creator_name', name: 'Created By', defaultContent: '-' },
                { data: 'created_at', name: 'Created At', defaultContent: '-' },
                { data: 'updater_name', name: 'Last Updated By', defaultContent: '-' },
                { data: 'updated_at', name: 'Last Updated At', defaultContent: '-' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        $('#create').click(function () {
            showCreateModal ('Create New Contact', inputFormId, actionUrl);
        });

        $('.editBtn').click(function () {
            $('#modalTitle').html("Edit Contact");
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

            $('#company_id').val(data.company_id);
            $('#label').val(data.label);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#mobile_number').val(data.mobile_number);
            $('#office_number').val(data.office_number);
            $('#fax_number').val(data.fax_number);
            $('#other_number').val(data.other_number);
            $('#website').val(data.website);               
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

        // datatableObject.on('click', '.editBtn', function () {
            
        // });

        $(inputFormId).on('submit', function (event) {
            submitButtonProcess (tableId, inputFormId); 
        });

        deleteButtonProcess (datatableObject, tableId, actionUrl);
    });
</script>
@endpush