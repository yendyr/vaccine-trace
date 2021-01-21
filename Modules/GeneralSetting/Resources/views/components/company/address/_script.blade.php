@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
        var actionUrl = '/generalsetting/company-detail-address';
        var createNewButtonId = '#createNewButtonAddress';
        var inputModalId = '#inputModalAddress';
        var modalTitleId = '#modalTitleAddress';
        var saveButtonId = '#saveButtonAddress';
        var inputFormId = '#inputFormAddress';
        var editButtonClass = '.editButtonAddress';
        var deleteButtonClass = '.deleteButtonAddress';
        var deleteModalId = '#deleteModalAddress';
        var deleteFormId = '#deleteFormAddress';
        var deleteModalButtonId = '#deleteModalButtonAddress';
        // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //


        $('.country_id').select2({
                theme: 'bootstrap4',
                placeholder: 'Choose Country',
                allowClear: true,
                // minimumInputLength: 2,
                minimumResultsForSearch: 10,
                ajax: {
                    url: "{{ route('generalsetting.country.select2') }}",
                    dataType: 'json',
                },
                dropdownParent: $(inputModalId)
            });



        // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
        $(createNewButtonId).click(function () {
            showCreateModalDynamic (inputModalId, modalTitleId, 'Create New Address', saveButtonId, inputFormId, actionUrl);
        });
        // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //



        // ----------------- "EDIT" BUTTON SCRIPT ------------- //
        $(editButtonClass).click(function (e) {
            $(modalTitleId).html("Edit Address");
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
                $('.name').val(data.name);
                $('#street').val(data.street);
                $('#city').val(data.city);
                $('#province').val(data.province);
                
                $(".country_id").val(null).trigger('change');
                if (data.country != null) {
                    $('.country_id').append('<option value="' + data.country_id + '" selected>' + data.country.nice_name + '</option>');
                }

                $('#post_code').val(data.post_code);
                $('#latitude').val(data.latitude);
                $('#longitude').val(data.longitude);
                              
                if (data.status == '1') {
                    $('.status').prop('checked', true);
                }
                else {
                    $('.status').prop('checked', false);
                }

                $(inputFormId).attr('action', actionUrl + '/' + id);
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