@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
        var actionUrl = '/generalsetting/company-detail-bank/';
        var createNewButtonId = '#createNewButtonBank';
        var inputModalId = '#inputModalBank';
        var modalTitleId = '#modalTitleBank';
        var saveButtonId = '#saveButtonBank';
        var inputFormId = '#inputFormBank';
        var editButtonClass = '.editButtonBank';
        var deleteButtonClass = '.deleteButtonBank';
        var deleteModalId = '#deleteModalBank';
        var deleteFormId = '#deleteFormBank';
        var deleteModalButtonId = '#deleteModalButtonBank';
        // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //




        $('.chart_of_account_id').select2({
                theme: 'bootstrap4',
                placeholder: 'Choose COA',
                allowClear: true,
                // minimumInputLength: 2,
                minimumResultsForSearch: 10,
                ajax: {
                    url: "{{ route('accounting.chart-of-account.select2.child') }}",
                    dataType: 'json',
                },
                dropdownParent: $(inputModalId)
            });



        // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
        $(createNewButtonId).click(function () {
            showCreateModalDynamic (inputModalId, modalTitleId, 'Create New Bank', saveButtonId, inputFormId, actionUrl);
        });
        // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //



        // ----------------- "EDIT" BUTTON SCRIPT ------------- //
        $(editButtonClass).click(function (e) {
            $(modalTitleId).html("Edit Bank");
            $(inputFormId).trigger("reset");
            
            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo(inputFormId);

            var id = $(this).data('id');
            $.get(actionUrl + id, function (data) {
                $('.id').val(id);
                $('.label').val(data.label);
                $('#bank_name').val(data.bank_name);
                $('#bank_branch').val(data.bank_branch);
                $('#account_holder_name').val(data.account_holder_name);
                $('#account_number').val(data.account_number);
                $('#swift_code').val(data.swift_code);
                $('#description').val(data.description);
                
                $(".chart_of_account_id").val(null).trigger('change');
                if (data.chart_of_account != null) {
                    $('.chart_of_account_id').append('<option value="' + data.chart_of_account_id + '" selected>' + data.chart_of_account_id.name + '</option>');
                }
                              
                if (data.status == '1') {
                    $('.status').prop('checked', true);
                }
                else {
                    $('.status').prop('checked', false);
                }

                $(inputFormId).attr('action', actionUrl + id);
            });

            $(saveButtonId).val("edit");
            $('[class^="invalid-feedback-"]').html('');  // clearing validation
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
                    $(saveButtonId). prop('disabled', false);
                }
            }); 

            setTimeout(location.reload.bind(location), 2000);
        });
        // ----------------- END "SUBMIT FORM" BUTTON SCRIPT ------------- //



        // ----------------- "DELETE" BUTTON  SCRIPT ------------- //
        $(deleteButtonClass).click(function () {
            rowId = $(this).val();
            $(deleteModalId).modal('show');
            $(deleteFormId).attr('action', actionUrl + rowId);
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
                    $(targetTableId).DataTable().ajax.reload();
                }
            });

            setTimeout(location.reload.bind(location), 2000);
        });
        // ----------------- END "DELETE" BUTTON  SCRIPT ------------- //
    });
</script>
@endpush