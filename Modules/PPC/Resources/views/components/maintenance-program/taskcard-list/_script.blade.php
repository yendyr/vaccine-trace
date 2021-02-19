@push('footer-scripts')
<script src="{{ URL::asset('theme/js/plugins/dualListbox/jquery.bootstrap-duallistbox.min.js') }}"></script>

<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/maintenance-program-detail';
    var saveButtonId = '#saveButtonDetail';
    var inputFormId = '#inputFormDetail';
    var editButtonClass = '.editButtonDetail';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //





    $('.aircraft_type_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose A/C Type',
        allowClear: true,
        ajax: {
            url: "/ppc/maintenance-program-detail/dual_list_box",
            dataType: 'json',
        },
    });

    


    



    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    $(editButtonClass).click(function (e) {
        $(modalTitleId).html("Edit Aircraft Configuration");
        
        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
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

                setTimeout(location.reload.bind(location), 2000);
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $(saveButtonId). prop('disabled', false);
            }
        }); 
    });
    // ----------------- END "SUBMIT FORM" BUTTON SCRIPT ------------- //
});
</script>
@endpush