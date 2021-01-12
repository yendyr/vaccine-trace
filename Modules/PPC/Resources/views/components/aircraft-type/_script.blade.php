@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/ppc/aircraft-type/';
        var tableId = '#aircraft-type-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('ppc.aircraft-type.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code'  },
                { data: 'name', name: 'Aircraft Type Name' },
                { data: 'manufacturer.name', name: 'Manufacturer', defaultContent: '-' },
                { data: 'description', name: 'Description/Remark' },
                { data: 'status', name: 'Status' },
                { data: 'creator_name', name: 'Created By' },
                { data: 'created_at', name: 'Created At' },
                { data: 'updater_name', name: 'Last Updated By' },
                { data: 'updated_at', name: 'Last Updated At' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        $('.manufacturer_id').select2({
                theme: 'bootstrap4',
                placeholder: 'Choose Manufacturer',
                allowClear: true,
                ajax: {
                    url: "{{ route('generalsetting.company.select2'.manufacturer) }}",
                    dataType: 'json',
                },
                dropdownParent: $('#inputModal')
            });

        $('#create').click(function () {
            showCreateModal ('Create New Aircraft Type', inputFormId, actionUrl);
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Aircraft Type");
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
            $(".manufacturer_id").val(null).trigger('change');
                if (data.manufacturer == null){
                    $('#manufacturer_id').append('<option value="' + data.manufacturer_id + '" selected></option>');
                } else {
                    $('#manufacturer_id').append('<option value="' + data.manufacturer_id + '" selected>' + data.manufacturer.name + '</option>');
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