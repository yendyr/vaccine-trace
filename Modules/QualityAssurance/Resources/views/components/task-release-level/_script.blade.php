@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/qualityassurance/task-release-level';
        var tableId = '#task-release-level-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('qualityassurance.task-release-level.index') }}",
            },
            columns: [
                { data: 'code', defaultContent: '-' },
                { data: 'name', defaultContent: '-' },
                { data: 'sequence_level', defaultContent: '-' },
                { data: 'engineering_level.name', defaultContent: '-' },
                { data: 'description', defaultContent: '-' },
                { data: 'status', defaultContent: '-' },
                { data: 'creator_name', defaultContent: '-' },
                { data: 'created_at', defaultContent: '-' },
                { data: 'updater_name', defaultContent: '-' },
                { data: 'updated_at', defaultContent: '-' },
                { data: 'action', orderable: false },
            ]
        });

        $('.authorized_engineering_level').select2({
                theme: 'bootstrap4',
                placeholder: 'Choose Level',
                allowClear: true,
                ajax: {
                    url: "{{ route('qualityassurance.engineering-level.select2') }}",
                    dataType: 'json',
                },
                dropdownParent: $('#inputModal')
            });

        $('#create').click(function () {
            showCreateModal ('Create New Task Release Level', inputFormId, actionUrl);
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Task Release Level");
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
            $(".authorized_engineering_level").val(null).trigger('change');
            if (data.authorized_engineering_level != null) {
                $('#authorized_engineering_level').append('<option value="' + data.authorized_engineering_level + '" selected>' + data.authorized_engineering_level.name + '</option>');
            }
             
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