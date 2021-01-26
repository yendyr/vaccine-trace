@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/taskcard-detail-item';
    var tableId = '.taskcard-detail-item';
    var createNewButtonId = '.createNewButtonItem';
    var inputModalId = '#inputModalItem';
    var modalTitleId = '#modalTitleItem';
    var saveButtonId = '#saveButtonItem';
    var inputFormId = '#inputFormItem';
    var editButtonClass = '.editButtonItem';
    var deleteButtonClass = '.deleteButtonItem';
    var deleteModalId = '#deleteModalItem';
    var deleteFormId = '#deleteFormItem';
    var deleteModalButtonId = '#deleteModalButtonItem';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('ppc.taskcard-detail-item.index') }}",
        },
        columns: [
            { data: 'item.code', name: 'Code' },
            { data: 'item.name', name: 'Item Name' },
            { data: 'quantity', name: 'Qty' },
            { data: 'unit.name', name: 'Unit' },
            { data: 'category.name', name: 'Category' },
            { data: 'description', name: 'Description' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });





    $('#item_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Item',
        minimumInputLength: 3,
        minimumResultsForSearch: 10,
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.item.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });



    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $(createNewButtonId).click(function () {
        $('#taskcard_detail_instruction_id').val($(this).data('taskcard_detail_instruction_id'));

        showCreateModalDynamic (inputModalId, modalTitleId, 'Add New Item', saveButtonId, inputFormId, actionUrl);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //





    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', editButtonClass, function () {
        $(modalTitleId).html("Edit Item Requirement");
        $(inputFormId).trigger("reset");                
        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        if (data.item != null) {
            $('#item_id').append('<option value="' + data.item_id + '" selected>' + data.item.code + ' | ' + data.item.name + '</option>');
        }
        $('#quantity').val(data.quantity);
        $('#description').val(data.description);

        $(saveButtonId).val("edit");
        $('[class^="invalid-feedback-"]').html('');
        $(inputModalId).modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //





    $(inputFormId).on('submit', function (event) {
        submitButtonProcessDynamic (tableId, inputFormId, inputModalId); 
    });




    // ----------------- "DELETE" BUTTON  SCRIPT ------------- //
    datatableObject.on('click', deleteButtonClass, function () {
        rowId = $(this).val();
        $(deleteModalId).modal('show');
        $(deleteFormId).attr('action', actionUrl + '/' + rowId);
    });

    $(deleteFormId).on('submit', function (e) {
        e.preventDefault();
        let url_action = $(this).attr('action');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content")
            },
            url: url_action,
            type: "DELETE",
            beforeSend:function(){
                $(deleteModalButtonId).text('Deleting...');
                $(deleteModalButtonId).prop('disabled', true);
            },
            error: function(data){
                if (data.error) {
                    generateToast ('error', data.error);
                }
            },
            success:function(data){
                if (data.success){
                    generateToast ('success', data.success);
                }
            },
            complete: function(data) {
                $(deleteModalButtonId).text('Delete');
                $(deleteModalId).modal('hide');
                $(deleteModalButtonId).prop('disabled', false);

                $(tableId).DataTable().ajax.reload();
            }
        });
    });
    // ----------------- END "DELETE" BUTTON  SCRIPT ------------- //
});
</script>
@endpush