@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/qualityassurance/engineering-level';
        var tableId = '#engineering-level-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('qualityassurance.engineering-level.index') }}",
            },
            columns: [
                { data: 'code', defaultContent: '-' },
                { data: 'name', defaultContent: '-' },
                { data: 'sequence_level', defaultContent: '-' },
                { data: 'description', defaultContent: '-' },
                { data: 'status', defaultContent: '-' },
                { data: 'creator_name', defaultContent: '-' },
                { data: 'created_at', defaultContent: '-' },
                { data: 'updater_name', defaultContent: '-' },
                { data: 'updated_at', defaultContent: '-' },
                { data: 'action', orderable: false },
            ]
        });

        $('#create').click(function () {
            showCreateModal ('Create New Engineering Level', inputFormId, actionUrl);
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Engineering Level");
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
            $('#sequence_level').val(data.sequence_level);
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