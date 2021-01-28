@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/taskcard-detail-item';
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
        $('#item_id').empty().trigger('change');
        $('#taskcard_detail_instruction_id').val($(this).data('taskcard_detail_instruction_id'));

        showCreateModalDynamic (inputModalId, modalTitleId, 'Add New Item', saveButtonId, inputFormId, actionUrl);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //






    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    $(editButtonClass).click(function (e) {
        $('#item_id').empty().trigger('change');
        $(modalTitleId).html("Edit Item Requirement");
        
        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        var id = $(this).data('id');
        $.get(actionUrl + '/' + id, function (data) {
            if (data.item != null) {
                $('#item_id').append('<option value="' + data.item_id + '" selected>' + data.item.code + ' | ' + data.item.name + '</option>');
                $('#item_id').trigger('change');
            }
            $('#quantity').val(data.quantity);
            $('#description').val(data.description);

            $(saveButtonId).val("edit");
            $('[class^="invalid-feedback-"]').html('');
            $(inputModalId).modal('show');
        });
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //




    // ----------------- "SUBMIT" BUTTON SCRIPT ------------- //
    $(inputFormId).on('submit', function (event) {
        event.preventDefault();
        let url_action = $(inputFormId).attr('action');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content")
            },
            url: url_action,
            method: "POST",
            data: $(inputFormId).serialize(),
            dataType: 'json',
            beforeSend:function(){
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'start' );
                $('[class^="invalid-feedback-"]').html('');
                $(saveButtonId).prop('disabled', true);
            },
            error: function(data){
                let errors = data.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (index, value) {
                        $('div.invalid-feedback-'+index).html(value);
                    })
                }
            },
            success: function (data) {
                if (data.success) {
                    generateToast ('success', data.success);                            
                }
                $(inputModalId).modal('hide');

                setTimeout(location.reload.bind(location), 2000);
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $(saveButtonId). prop('disabled', false);
            }
        }); 
        
    });
    // ----------------- END "SUBMIT" BUTTON SCRIPT ------------- //




    // ----------------- "DELETE" BUTTON  SCRIPT ------------- //
    $(deleteButtonClass).click(function () {
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

                    setTimeout(location.reload.bind(location), 2000);
                }
            },
            complete: function(data) {
                $(deleteModalButtonId).text('Delete');
                $(deleteModalId).modal('hide');
                $(deleteModalButtonId).prop('disabled', false);
            }
        });
    });
    // ----------------- END "DELETE" BUTTON  SCRIPT ------------- //
});
</script>
@endpush