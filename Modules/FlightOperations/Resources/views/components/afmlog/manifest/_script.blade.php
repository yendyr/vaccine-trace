@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/flightoperations/afml-detail-manifest';
    var tableId = '#afml-detail-manifest';
    var createButtonId = '#createButtonManifest';
    var inputModalId = '#inputModalManifest';
    var inputFormId = '#inputFormManifest';
    var modalTitleId = '#modalTitleManifest';
    var saveButtonId = '#saveButtonManifest';
    var deleteModalId = '#deleteModalManifest';
    var deleteFormId = '#deleteFormManifest';
    var deleteModalButtonId = '#deleteModalButtonManifest';
    var deleteButtonClass = '.deleteButtonManifest';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: actionUrl + "/?id=" + $('#afm_log_id').val(),
        },
        columns: [
            { data: 'person', defaultContent: '-' },
            { data: 'pax', defaultContent: '-' },
            { data: 'cargo_weight', defaultContent: '-' },
            { data: 'cargo_weight_unit.name', defaultContent: '-' },
            { data: 'pcm_number', defaultContent: '-' },
            { data: 'cm_number', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });


    


    

    $('.cargo_weight_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

        
    




    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $(createButtonId).click(function () {
        showCreateModalDynamic (inputModalId, modalTitleId, 'Add New Manifest', saveButtonId, inputFormId, actionUrl, );
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //






    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        $(modalTitleId).html("Edit Manifest");
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

        $('#person').val(data.person);
        $('#pax').val(data.pax);
        $('#cargo_weight').val(data.cargo_weight);
        $('#pcm_number').val(data.pcm_number);
        $('#cm_number').val(data.cm_number);
        $('#manifest_description').val(data.description);

        if (data.cargo_weight_unit != null) {
            $('#cargo_weight_unit_id').append('<option value="' + data.cargo_weight_unit_id + '" selected>' + data.cargo_weight_unit.name + '</option>');
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