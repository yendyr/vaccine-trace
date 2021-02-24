@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/aircraft-configuration';
    var inputModalId = '#inputModalAircraftConfiguration';
    var modalTitleId = '#modalTitleAircraftConfiguration';
    var saveButtonId = '#saveButtonAircraftConfiguration';
    var inputFormId = '#inputFormAircraftConfiguration';
    var editButtonClass = '.editButtonAircraftConfiguration';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //



    $('.aircraft_type_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose A/C Type',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.aircraft-type.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.maintenance_program_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Maintenance Program',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.maintenance-program.select2') }}",
            dataType: 'json',
            data: function (params) {
                var getHeaderId = { 
                    term: params.term,
                    aircraft_type_id: $('#aircraft_type_id').val(),
                }
                return getHeaderId;
            }
        },
        dropdownParent: $(inputModalId)
    });

    $('.max_takeoff_weight_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.max_landing_weight_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.max_zero_fuel_weight_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.fuel_capacity_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.basic_empty_weight_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
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
                if (data.error) {
                    generateToast ('error', data.error);
                }
            },
            success: function (data) {
                if (data.success) {
                    generateToast ('success', data.success);  
                    setTimeout(location.reload.bind(location), 2000);                          
                }
                else if (data.error) {
                    swal.fire({
                        titleText: "Action Failed",
                        text: data.error,
                        icon: "error",
                    });
                }
                $(inputModalId).modal('hide');
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