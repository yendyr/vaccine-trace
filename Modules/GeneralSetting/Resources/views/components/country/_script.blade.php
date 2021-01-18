@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/generalsetting/country/';
        var tableId = '#country-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('generalsetting.country.index') }}",
            },
            columns: [
                { data: 'iso', name: 'ISO', defaultContent: '-' },
                { data: 'iso_3', name: 'ISO-3', defaultContent: '-' },
                { data: 'name', name: 'Name', defaultContent: '-' },
                { data: 'nice_name', name: 'Nice Name', defaultContent: '-' },
                { data: 'num_code', name: 'Num. Code', defaultContent: '-' },
                { data: 'phone_code', name: 'Phone Code', defaultContent: '-' },
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
            showCreateModal ('Create New Country', inputFormId, actionUrl);
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Country");
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
            $('#iso_3').val(data.iso3);
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