@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = "/flightoperations/afml";
    var tableId = '#afml-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('flightoperations.afml.index') }}",
        },
        columns: [
            { data: 'aircraft_type_name', defaultContent: '-',
                            'render': function ( data, type, row, meta ) {
                                return '<a href="afml/' + row.id + '">' + row.aircraft_type_name + '</a>';
                            }},
            { data: 'aircraft_configuration.serial_number', defaultContent: '-',
                            'render': function ( data, type, row, meta ) {
                                return '<a href="afml/' + row.id + '">' + row.aircraft_configuration.serial_number + '</a>';
                            }},
            { data: 'aircraft_configuration.registration_number', defaultContent: '-',
                            'render': function ( data, type, row, meta ) {
                                return '<a href="afml/' + row.id + '">' + row.aircraft_configuration.registration_number + '</a>';
                            }},
            { data: 'transaction_date', defaultContent: '-',
                            'render': function ( data, type, row, meta ) {
                                return '<a href="afml/' + row.id + '">' + row.transaction_date + '</a>';
                            }},
            { data: 'page_number', defaultContent: '-',
                            'render': function ( data, type, row, meta ) {
                                return '<a href="afml/' + row.id + '">' + row.page_number + '</a>';
                            }},
            { data: 'status', name: 'Status' },
            { data: 'creator_name' },
            { data: 'created_at' },
            { data: 'updater_name' },
            { data: 'updated_at' },
            { data: 'action', orderable: false },
        ]
    });


    

    $('.aircraft_configuration_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Aircraft',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.aircraft-configuration.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.pre_flight_check_nearest_airport_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Airport',
        allowClear: true,
        ajax: {
            url: "{{ route('generalsetting.airport.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.pre_flight_check_compressor_wash').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Answer',
        minimumResultsForSearch: Infinity,
        allowClear: false,
        dropdownParent: $('#inputModal')
    });

    $('.pre_flight_check_person_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Person',
        allowClear: true,
        ajax: {
            url: "{{ route('hr.employee.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.post_flight_check_nearest_airport_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Airport',
        allowClear: true,
        ajax: {
            url: "{{ route('generalsetting.airport.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.post_flight_check_compressor_wash').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Answer',
        minimumResultsForSearch: Infinity,
        allowClear: false,
        dropdownParent: $('#inputModal')
    });

    $('.post_flight_check_person_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Person',
        allowClear: true,
        ajax: {
            url: "{{ route('hr.employee.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });






    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $('#create').click(function () {
        showCreateModal ('Create New Aircraft Flight & Maintenance Log', inputFormId, actionUrl);
        $('#pre_flight_check_compressor_wash').select2("val", "");
        $('#post_flight_check_compressor_wash').select2("val", "");
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //




    

    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit Item COA");
        $(inputFormId).trigger("reset");                
        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo('#inputForm');

        $('#page_number').val(data.page_number);
        $('#previous_page_number').val(data.previous_page_number);
        $('.transaction_date').val(data.transaction_date);
        $('#aircraft_configuration_id').val(data.aircraft_configuration_id); 
        $('.last_inspection').val(data.last_inspection); 
        $('.next_inspection').val(data.next_inspection); 

        $('.pre_flight_check_date').val(data.pre_flight_check_date); 
        $('#pre_flight_check_place').val(data.pre_flight_check_place); 
        $('#pre_flight_check_person_id').val(data.pre_flight_check_person_id); 

        $('.post_flight_check_date').val(data.post_flight_check_date); 
        $('#post_flight_check_place').val(data.post_flight_check_place); 
        $('#post_flight_check_person_id').val(data.post_flight_check_person_id); 

        if (data.aircraft_configuration != null) {
            $('#aircraft_configuration_id').append('<option value="' + data.aircraft_configuration_id + '" selected>' + data.aircraft_configuration.registration_number + ' | ' + data.aircraft_configuration.serial_number + ' | ' + data.aircraft_type_name + '</option>');
        }

        if (data.pre_flight_check_nearest_airport != null) {
            $('#pre_flight_check_nearest_airport_id').append('<option value="' + data.pre_flight_check_nearest_airport_id + '" selected>' + data.pre_flight_check_nearest_airport.iata_code + ' | ' + data.pre_flight_check_nearest_airport.name + '</option>');
        }

        if (data.pre_flight_check_person != null) {
            $('#pre_flight_check_person_id').append('<option value="' + data.pre_flight_check_person_id + '" selected>' + data.pre_flight_check_person.fullname + '</option>');
        }

        if (data.pre_flight_check_compressor_wash != null) {
            $('#pre_flight_check_compressor_wash').val(data.pre_flight_check_compressor_wash).trigger('change');
        }

        if (data.post_flight_check_nearest_airport != null) {
            $('#post_flight_check_nearest_airport_id').append('<option value="' + data.post_flight_check_nearest_airport_id + '" selected>' + data.post_flight_check_nearest_airport.iata_code + ' | ' + data.post_flight_check_nearest_airport.name + '</option>');
        }

        if (data.post_flight_check_person != null) {
            $('#post_flight_check_person_id').append('<option value="' + data.post_flight_check_person_id + '" selected>' + data.post_flight_check_person.fullname + '</option>');
        }

        if (data.post_flight_check_compressor_wash != null) {
            $('#post_flight_check_compressor_wash').val(data.post_flight_check_compressor_wash).trigger('change');
        }

        $('#saveBtn').val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $('#inputModal').modal('show');
    });







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
                $('#saveBtn').prop('disabled', true);
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

                    setTimeout(function () {
                        window.location.href = "afml/" + data.id;
                    }, 2000);                          
                }
                else if (data.error) {
                    swal.fire({
                        titleText: "Action Failed",
                        text: data.error,
                        icon: "error",
                    });                          
                }

                $('#inputModal').modal('hide');
                $(targetTableId).DataTable().ajax.reload();
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $('#saveBtn'). prop('disabled', false);
            }
        }); 
    });

    deleteButtonProcess (datatableObject, tableId, actionUrl);
});
</script>
@endpush