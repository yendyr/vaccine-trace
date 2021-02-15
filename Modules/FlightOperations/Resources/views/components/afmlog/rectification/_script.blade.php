@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/flightoperations/afml-detail-rectification';
    var tableId = '#afml-detail-rectification';
    var createButtonId = '#createButtonRectification';
    var inputModalId = '#inputModalRectification';
    var inputFormId = '#inputFormRectification';
    var modalTitleId = '#modalTitleRectification';
    var saveButtonId = '#saveButtonRectification';
    var deleteModalId = '#deleteModalRectification';
    var deleteFormId = '#deleteFormRectification';
    var deleteModalButtonId = '#deleteModalButtonRectification';
    var deleteButtonClass = '.deleteButtonRectification';

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
            { data: 'afml_detail_discrepancy_id', defaultContent: '-' },
            { data: 'title', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'employee.fullname', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });






    $('.afml_detail_discrepancy_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Discrepancy',
        allowClear: true,
        ajax: {
            url: "{{ route('flightoperations.afml.discrepancy.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.performed_by').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Person',
        allowClear: true,
        ajax: {
            url: "{{ route('hr.employee.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });





    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $(createButtonId).click(function () {
        showCreateModalDynamic (inputModalId, modalTitleId, 'Add New Rectification', saveButtonId, inputFormId, actionUrl, );
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //






    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        $(modalTitleId).html("Edit Rectification");
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

        if (data.afml_detail_discrepancy != null) {
            $('#afml_detail_discrepancy_id').append('<option value="' + data.afml_detail_discrepancy_id + '" selected>' + data.afml_detail_discrepancy.code + ' | ' + data.afml_detail_discrepancy.title + '</option>');
        }

        if (data.employee != null) {
            $('#performed_by').append('<option value="' + data.performed_by + '" selected>' + data.employee.fullname + '</option>');
        }

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