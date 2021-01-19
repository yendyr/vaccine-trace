@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function () {
        // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
        var actionUrl = '/generalsetting/company/';
        var inputModalId = '#inputModalAccounting';
        var modalTitleId = '#modalTitleAccounting';
        var saveButtonId = '#saveButtonAccounting';
        var inputFormId = '#inputFormAccounting';
        var editButtonClass = '.editButtonAccounting';
        // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //




        $('.account_receivable_coa_id').select2({
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
        
        $('.sales_discount_coa_id').select2({
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

        $('.account_payable_coa_id').select2({
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

        $('.purchase_discount_coa_id').select2({
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




        // ----------------- "EDIT" BUTTON SCRIPT ------------- //
        $(editButtonClass).click(function (e) {
            $(modalTitleId).html("Edit Setting");
            $(inputFormId).trigger("reset");
            
            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo(inputFormId);

            var id = $(this).data('id');
            
            $(inputFormId).attr('action', actionUrl + id);
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