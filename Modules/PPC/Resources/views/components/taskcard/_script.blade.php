@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/ppc/taskcard/';
        var tableId = '#taskcard-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('ppc.taskcard.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code'  },
                { data: 'name', name: 'Task Card Name' },
                { data: 'description', name: 'Description/Remark' },
                { data: 'status', name: 'Status' },
                { data: 'creator_name', name: 'Created By' },
                { data: 'created_at', name: 'Created At' },
                { data: 'updater_name', name: 'Last Updated By' },
                { data: 'updated_at', name: 'Last Updated At' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        $('.taskcard_group').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Group',
            allowClear: true,
            ajax: {
                url: "{{ route('ppc.taskcard-group.select2.child') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

            
        $('.taskcard_type').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Type',
            allowClear: true,
            ajax: {
                url: "{{ route('ppc.taskcard-type.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.aircraft_type').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Type',
            allowClear: true,
            ajax: {
                url: "{{ route('ppc.aircraft-type.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.work_area').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Work Area',
            allowClear: true,
            ajax: {
                url: "{{ route('ppc.taskcard-workarea.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.access').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Access',
            allowClear: true,
            ajax: {
                url: "{{ route('ppc.taskcard-access.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.zone').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Zone',
            allowClear: true,
            ajax: {
                url: "{{ route('ppc.taskcard-zone.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.document_library').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Document',
            allowClear: true,
            ajax: {
                url: "{{ route('ppc.taskcard-document-library.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.manual_affected').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Document',
            allowClear: true,
            ajax: {
                url: "{{ route('qualityassurance.document-type.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('#create').click(function () {
            showCreateModal ('Create New Task Card', inputFormId, actionUrl);
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Task Card");
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