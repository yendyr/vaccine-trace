@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/ppc/taskcard-group/';
        var tableId = '#taskcard-group-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('ppc.taskcard-group.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code'  },
                { data: 'name', name: 'Task Card Group Name' },
                { data: 'taskcard_group.name', name: 'Parent Group Name', defaultContent: '-' },
                { data: 'description', name: 'Description/Remark' },
                { data: 'status', name: 'Status' },
                { data: 'creator_name', name: 'Created By' },
                { data: 'created_at', name: 'Created At' },
                { data: 'updater_name', name: 'Last Updated By' },
                { data: 'updated_at', name: 'Last Updated At' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        $('.select2_parent_name').select2({
                theme: 'bootstrap4',
                placeholder: 'Choose Parent',
                allowClear: true,
                ajax: {
                    url: "{{ route('ppc.taskcard-group.select2.parent') }}",
                    dataType: 'json',
                },
                dropdownParent: $('#inputModal')
            });

        $('#create').click(function () {
            showCreateModal ('Create New Task Card Group', inputFormId, actionUrl);
            $(".select2_parent_name").val(null).trigger('change');
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Task Card Group");
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
            $('#description').val(data.description);  
            $(".select2_parent_name").val(null).trigger('change');
                if (data.taskcard_group == null){
                    $('#select2_parent_name').append('<option value="' + data.parent_id + '" selected></option>');
                } else {
                    $('#select2_parent_name').append('<option value="' + data.parent_id + '" selected>' + data.taskcard_group.name + '</option>');
                }              
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