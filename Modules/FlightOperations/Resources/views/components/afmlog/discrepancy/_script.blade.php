@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/flightoperations/afml-detail-discrepancy';
    var tableId = '#afml-detail-discrepancy';
    var createButtonId = '#createButtonDiscrepancy';
    var inputModalId = '#inputModalDiscrepancy';
    var inputFormId = '#inputFormDiscrepancy';
    var modalTitleId = '#modalTitleDiscrepancy';
    var saveButtonId = '#saveButtonDiscrepancy';
    var deleteModalId = '#deleteModalDiscrepancy';
    var deleteFormId = '#deleteFormDiscrepancy';
    var deleteModalButtonId = '#deleteModalButtonDiscrepancy';
    var deleteButtonClass = '.deleteButtonDiscrepancy';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: actionUrl + "/?id=" + $('#afm_log_id').val(),
        },
        columns: [
            { data: 'code', defaultContent: '-' },
            { data: 'title', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'rectification_code', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });


        
    




    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $(createButtonId).click(function () {
        showCreateModalDynamic (inputModalId, modalTitleId, 'Add New Discrepancy', saveButtonId, inputFormId, actionUrl, );
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //






    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        $(modalTitleId).html("Edit Discrepancy");
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

        $('#title').val(data.title);
        $('#description').val(data.description);

        $(saveButtonId).val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $(inputModalId).modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //





    // ----------------- "SUBMIT" BUTTON  SCRIPT ------------- //
    $(inputFormId).on('submit', function (event) {
        submitButtonProcessDynamic (tableId, inputFormId, inputModalId); 
    });
    // ----------------- END "SUBMIT" BUTTON  SCRIPT ------------- //






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