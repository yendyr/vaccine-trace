@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
        var actionUrl = '/ppc/work-order/update-control-parameter';
        var inputModalId = '#inputModalInterval';
        var modalTitleId = '#modalTitleInterval';
        var saveButtonId = '#saveButtonInterval';
        var inputFormId = '#inputFormInterval';
        var editButtonClass = '.editButtonInterval';
        // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //




        $('.threshold_daily_unit').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose',
            minimumResultsForSearch: -1,
            dropdownParent: $(inputModalId)
        });
        
        $('.repeat_daily_unit').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose',
            minimumResultsForSearch: -1,
            dropdownParent: $(inputModalId)
        });

        $('.interval_control_method').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose',
            minimumResultsForSearch: -1,
            dropdownParent: $(inputModalId)
        });

        




        // ----------------- "EDIT" BUTTON SCRIPT ------------- //
        $(editButtonClass).click(function (e) {
            $(modalTitleId).html("Edit Control Parameter Setting");
            $(inputFormId).trigger("reset");
            
            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo(inputFormId);

            $('<input>').attr({
                type: 'hidden',
                name: 'updateControlParameterOnly',
                value: 'true'
            }).prependTo(inputFormId);

            var id = $(this).data('id');
            
            $(inputFormId).attr('action', actionUrl + '/' + id);
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
    });
</script>
@endpush