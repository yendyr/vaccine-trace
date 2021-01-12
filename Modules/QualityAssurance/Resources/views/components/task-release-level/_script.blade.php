@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/qualityassurance/task-release-level/';
        var tableId = '#task-release-level-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('qualityassurance.task-release-level.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code'  },
                { data: 'name', name: 'Task Release Level Name' },
                { data: 'sequence_level', name: 'Sequence Level' },
                { data: 'engineering_level.name', name: 'Authorized Engineering Level' },
                { data: 'description', name: 'Description/Remark' },
                { data: 'status', name: 'Status' },
                { data: 'creator_name', name: 'Created By' },
                { data: 'created_at', name: 'Created At' },
                { data: 'updater_name', name: 'Last Updated By' },
                { data: 'updated_at', name: 'Last Updated At' },
                { data: 'action', name: 'Action', orderable: false },
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
            $(inputFormId).attr('action', actionUrl + data.id);

            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo('#inputForm');

            $('#code').val(data.code);
            $('#name').val(data.name);
            $('#sequence_level').val(data.sequence_level);
            $(".authorized_engineering_level").val(null).trigger('change');
                if (data.taskcard_group == null){
                    $('#authorized_engineering_level').append('<option value="' + data.authorized_engineering_level + '" selected></option>');
                } else {
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