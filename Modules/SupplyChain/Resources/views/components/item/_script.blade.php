@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = '/supplychain/item';
        var tableId = '#item-table';
        var inputFormId = '#inputForm';

        var datatableObject = $(tableId).DataTable({
            pageLength: 25,
            processing: true,
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "{{ route('supplychain.item.index') }}",
            },
            columns: [
                { data: 'code', name: 'Code'  },
                { data: 'name', name: 'Item Name' },
                { data: 'model', name: 'Model' },
                { data: 'type', name: 'Type' },
                { data: 'description', name: 'Description/Remark' },
                { data: 'category.name', name: 'Category' },
                { data: 'unit.name', name: 'Unit' },
                { data: 'manufacturer.name', name: 'Manufacturer', defaultContent: '-' },
                { data: 'reorder_stock_level', name: 'Reorder Stock Level' },
                { data: 'status', name: 'Status' },
                { data: 'creator_name', name: 'Created By' },
                { data: 'created_at', name: 'Created At' },
                { data: 'updater_name', name: 'Last Updated By' },
                { data: 'updated_at', name: 'Last Updated At' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        $('.category_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Category',
            allowClear: true,
            ajax: {
                url: "{{ route('supplychain.item-category.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.primary_unit_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Primary Unit',
            allowClear: true,
            ajax: {
                url: "{{ route('supplychain.unit.select2') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.manufacturer_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Company',
            allowClear: true,
            ajax: {
                url: "{{ route('generalsetting.company.select2.manufacturer') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });


        $('#create').click(function () {
            showCreateModal ('Create New Item', inputFormId, actionUrl);

            $(".category_id").val(null).trigger('change');
            $(".primary_unit_id").val(null).trigger('change');
            $(".manufacturer_id").val(null).trigger('change');
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Item");
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
            $('#model').val(data.name);
            $('#type').val(data.name);
            $('#description').val(data.description); 
            $('#reorder_stock_level').val(data.reorder_stock_level); 
            $(".category_id").val(null).trigger('change');
            if (data.category != null){
                $('#category_id').append('<option value="' + data.category_id + '" selected>' + data.category.name + '</option>');
            } 

            $(".primary_unit_id").val(null).trigger('change');
            if (data.unit != null){
                $('#primary_unit_id').append('<option value="' + data.primary_unit_id + '" selected>' + data.unit.name + '</option>');
            } 

            $(".manufacturer_id").val(null).trigger('change');
            if (data.manufacturer != null){
                $('#manufacturer_id').append('<option value="' + data.manufacturer_id + '" selected>' + data.manufacturer.name + '</option>');
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