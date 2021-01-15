@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        var actionUrl = "/accounting/item-category/";
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
                { data: 'sales_coa.name', name: 'Sales COA', defaultContent: '-' },
                { data: 'inventory_coa.name', name: 'Inventory COA', defaultContent: '-' },
                { data: 'cost_coa.name', name: 'Cost COA', defaultContent: '-' },
                { data: 'inventory_adjustment_coa.name', name: 'Inventory Adjustment COA', defaultContent: '-' },
                { data: 'status', name: 'Status' },
                { data: 'creator_name', name: 'Created By' },
                { data: 'created_at', name: 'Created At' },
                { data: 'updater_name', name: 'Last Updated By' },
                { data: 'updated_at', name: 'Last Updated At' },
                { data: 'action', name: 'Action', orderable: false },
            ]
        });

        $('.sales_coa_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Sales COA',
            allowClear: true,
            ajax: {
                url: "{{ route('accounting.chart-of-account.select2.child') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.inventory_coa_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Inventory COA',
            allowClear: true,
            ajax: {
                url: "{{ route('accounting.chart-of-account.select2.child') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.cost_coa_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Cost COA',
            allowClear: true,
            ajax: {
                url: "{{ route('accounting.chart-of-account.select2.child') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        $('.inventory_adjustment_coa_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Inventory Adj. COA',
            allowClear: true,
            ajax: {
                url: "{{ route('accounting.chart-of-account.select2.child') }}",
                dataType: 'json',
            },
            dropdownParent: $('#inputModal')
        });

        datatableObject.on('click', '.editBtn', function () {
            $('#modalTitle').html("Edit Item Category COA");
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

            $(".sales_coa_id").val(null).trigger('change');
            if (data.sales_coa != null){
                $('#sales_coa_id').append('<option value="' + data.sales_coa_id + '" selected>' + data.sales_coa.name + '</option>');
            } 

            $(".inventory_coa_id").val(null).trigger('change');
            if (data.inventory_coa != null){
                $('#inventory_coa_id').append('<option value="' + data.inventory_coa_id + '" selected>' + data.inventory_coa.name + '</option>');
            } 

            $(".cost_coa_id").val(null).trigger('change');
            if (data.cost_coa != null){
                $('#cost_coa_id').append('<option value="' + data.cost_coa_id + '" selected>' + data.cost_coa.name + '</option>');
            } 

            $(".inventory_adjustment_coa_id").val(null).trigger('change');
            if (data.inventory_adjustment_coa != null){
                $('#inventory_adjustment_coa_id').append('<option value="' + data.inventory_adjustment_coa_id + '" selected>' + data.inventory_adjustment_coa.name + '</option>');
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