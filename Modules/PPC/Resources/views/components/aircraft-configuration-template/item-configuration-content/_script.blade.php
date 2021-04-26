@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/configuration-template-detail';
    var tableId = '#configuration-template-detail';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/configuration-template-detail/?id=" + $('#aircraft_configuration_template_id').val(),
        },
        columns: [
            { data: 'item.code', defaultContent: '-' },
            { data: 'item.name', defaultContent: '-' },
            { data: 'alias_name', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'parent', defaultContent: '-' },
            { data: 'status', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });


    

    $('.item_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Item',
        minimumInputLength: 3,
        minimumResultsForSearch: 10,
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.item.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });
        
    $('.parent_coding').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Parent Item',
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.configuration-template-detail.select2') }}",
            dataType: 'json',
            data: function (params) {
                var getHeaderId = { 
                    term: params.term,
                    aircraft_configuration_template_id: $('#aircraft_configuration_template_id').val(),
                }
                return getHeaderId;
            }
        },
        dropdownParent: $('#inputModal')
    });




    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $('#create').click(function () {
        clearForm(inputFormId);
        showCreateModal ('Add New Item/Component', inputFormId, actionUrl);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //




    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        clearForm(inputFormId);

        $('#modalTitle').html("Edit Item/Component");
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

        $('#alias_name').val(data.alias_name);
        $('#description').val(data.description);

        if (data.item != null) {
            $('#item_id').append('<option value="' + data.item_id + '" selected>' + data.item.code + ' | ' + data.item.name + '</option>');
        }

        if (data.item_group != null) {
            var alias_name = '-';
            if(data.item_group.alias_name) {
                alias_name = data.item_group.alias_name;
            }
            $('.parent_coding').append('<option value="' + data.parent_coding + '" selected>' + data.item_group.item.code + ' | ' + data.item_group.item.name + ' | ' + alias_name + '</option>');
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
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //




    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId); 
    });

    deleteButtonProcess (datatableObject, tableId, actionUrl);

});
</script>
@endpush