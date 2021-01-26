@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/taskcard-detail-item';
    var tableId = '#taskcard-detail-item';
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



    $('.item_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Item',
        minimumInputLength: 3,
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.item.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });



    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $(createNewButtonId).click(function () {
        showCreateModalDynamic (inputModalId, modalTitleId, 'Add New Item', saveButtonId, inputFormId, actionUrl);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //



    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    $(editButtonClass).click(function (e) {
        $(modalTitleId).html("Edit Item");
        $(inputFormId).trigger("reset");
        
        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        var id = $(this).data('id');
        $.get(actionUrl + '/' + id, function (data) {
            $('.id').val(id);
            $('.label').val(data.label);
            $('.name').val(data.name);
            $('#email').val(data.email);
            $('#mobile_number').val(data.mobile_number);
            $('#office_number').val(data.office_number);
            $('#fax_number').val(data.fax_number);
            $('#other_number').val(data.other_number);
            $('#website').val(data.website);               
            if (data.status == '1') {
                $('#status').prop('checked', true);
            }
            else {
                $('#status').prop('checked', false);
            }

            $(inputFormId).attr('action', actionUrl + '/' + id);
        });

        $(saveButtonId).val("edit");
        $('[class^="invalid-feedback-"]').html('');
        $(inputModalId).modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //



    // ----------------- "SUBMIT FORM" BUTTON SCRIPT ------------- //
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
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $(saveButtonId).prop('disabled', false);
            }
        }); 

        setTimeout(location.reload.bind(location), 2000);
    });
    // ----------------- END "SUBMIT FORM" BUTTON SCRIPT ------------- //



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
                }
            },
            complete: function(data) {
                $(deleteModalButtonId).text('Delete');
                $(deleteModalId).modal('hide');
                $(deleteModalButtonId).prop('disabled', false);
            }
        });

        setTimeout(location.reload.bind(location), 2000);
    });
    // ----------------- END "DELETE" BUTTON  SCRIPT ------------- //
});
</script>
@endpush