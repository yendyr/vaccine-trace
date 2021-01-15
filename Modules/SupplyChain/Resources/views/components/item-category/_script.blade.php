@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/supplychain/item-category/';
        var tableId = '#item-category-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('supplychain.item-category.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code'  },
                { data: 'name', name: 'Item Category Name' },
                { data: 'description', name: 'Description/Remark' },
                { data: 'status', name: 'Status' },
                { data: 'creator_name', name: 'Created By' },
                { data: 'created_at', name: 'Created At' },
                { data: 'updater_name', name: 'Last Updated By' },
                { data: 'updated_at', name: 'Last Updated At' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        // $('.unit_class_id').select2({
        //     theme: 'bootstrap4',
        //     placeholder: 'Choose Unit Class',
        //     allowClear: true,
        //     ajax: {
        //         url: "{{ route('supplychain.unit-class.select2') }}",
        //         dataType: 'json',
        //     },
        //     dropdownParent: $('#inputModal')
        // });

        $('#create').click(function () {
            showCreateModal ('Create New Unit', inputFormId, actionUrl);
            // $(".unit_class_id").val(null).trigger('change');
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Unit");
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
            $(".unit_class_id").val(null).trigger('change');
                if (data.unit_class == null){
                    $('#unit_class_id').append('<option value="' + data.unit_class_id + '" selected></option>');
                } else {
                    $('#unit_class_id').append('<option value="' + data.unit_class_id + '" selected>' + data.unit_class.name + '</option>');
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