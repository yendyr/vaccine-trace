@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/supplychain/item';
    var tableId = '#item-table';
    var inputFormId = '#inputForm';

    $('#item-table thead tr').clone(true).appendTo('#item-table thead');
    $('#item-table thead tr:eq(1) th').each( function (i) {
        if ($(this).text() != 'Action') {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search" class="form-control" />');
    
            $('input', this).on('keypress', function (e) {
                if(e.which == 13) {
                    if (datatableObject1.column(i).search() !== this.value) {
                        datatableObject1
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                }
            });
        }
        else {
            $(this).html('&nbsp;');
        }
    });

    var datatableObject = $(tableId).DataTable({
        orderCellsTop: true,
        pageLength: 50,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('supplychain.item.index') }}",
        },
        columns: [
            { data: 'code', defaultContent: '-'  },
            { data: 'name', defaultContent: '-' },
            { data: 'model', defaultContent: '-' },
            { data: 'type', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'category.name', defaultContent: '-' },
            { data: 'unit.name', defaultContent: '-' },
            { data: 'manufacturer.name', defaultContent: '-' },
            { data: 'reorder_stock_level', defaultContent: '-' },
            { data: 'status', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            // { data: 'updater_name', defaultContent: '-' },
            // { data: 'updated_at', defaultContent: '-' },
            { data: 'action', orderable: false },
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
        $('#model').val(data.model);
        $('#type').val(data.type);
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