@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/aircraft-configuration';
    var tableId = '#aircraft-configuration';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('ppc.aircraft-configuration.index') }}",
        },
        columns: [
            { data: 'aircraft_type.name', "render": function ( data, type, row, meta ) {
                            return '<a href="aircraft-configuration/' + row.id + '">' + row.aircraft_type.name + '</a>'; } },
            { data: 'serial_number', "render": function ( data, type, row, meta ) {
                            return '<a href="aircraft-configuration/' + row.id + '">' + row.serial_number + '</a>'; } },
            { data: 'registration_number', "render": function ( data, type, row, meta ) {
                            return '<a href="aircraft-configuration/' + row.id + '">' + row.registration_number + '</a>'; } },
            { data: 'manufactured_date', name: 'Manufactured Date' },
            { data: 'received_date', name: 'Received Date' },
            { data: 'description', name: 'Description/Remark' },
            { data: 'status', name: 'Status' },
            { data: 'creator_name', name: 'Created By' },
            { data: 'created_at', name: 'Created At' },
            { data: 'updater_name', name: 'Last Updated By' },
            { data: 'updated_at', name: 'Last Updated At' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });






    $('.aircraft_type_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose A/C Type',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.aircraft-type.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
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
        dropdownParent: $('#inputModal')
    });

    $('.duplicated_from').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Source Template',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.aircraft-configuration-template.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.max_takeoff_weight_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.max_landing_weight_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.max_zero_fuel_weight_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.fuel_capacity_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.basic_empty_weight_unit_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Unit',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.unit.select2.mass') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });







    $('#create').click(function () {
        $('#duplicated_from').show();
        showCreateModal ('Create New Aircraft Configuration', inputFormId, actionUrl);
    });






    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit Aircraft Configuration");
        $('#duplicated_from').hide();
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

        $('#description').val(data.description);
        $('#registration_number').val(data.registration_number);
        $('#serial_number').val(data.serial_number);
        $('.manufactured_date').val(data.manufactured_date);
        $('.received_date').val(data.received_date);

        $('#max_takeoff_weight').val(data.max_takeoff_weight);
        $('#max_landing_weight').val(data.max_landing_weight);
        $('#max_zero_fuel_weight').val(data.max_zero_fuel_weight);
        $('#fuel_capacity').val(data.fuel_capacity);
        $('#basic_empty_weight').val(data.basic_empty_weight);

        $('#initial_flight_hour').val(data.initial_flight_hour);
        $('#initial_block_hour').val(data.initial_block_hour);
        $('#initial_flight_cycle').val(data.initial_flight_cycle);
        $('#initial_flight_event').val(data.initial_flight_event);
        $('.initial_start_date').val(data.initial_start_date.split(' ')[0]);

        $(".aircraft_type_id").val(null).trigger('change');
        if (data.aircraft_type != null) {
            $('#aircraft_type_id').append('<option value="' + data.aircraft_type_id + '" selected>' + data.aircraft_type.name + '</option>');
        }

        $(".maintenance_program_id").val(null).trigger('change');
        if (data.maintenance_program != null) {
            $('#maintenance_program_id').append('<option value="' + data.maintenance_program_id + '" selected>' + data.maintenance_program.code + ' | ' + data.maintenance_program.name + '</option>');
        }

        $(".max_takeoff_weight_unit_id").val(null).trigger('change');
        if (data.max_takeoff_weight_unit != null) {
            $('#max_takeoff_weight_unit_id').append('<option value="' + data.max_takeoff_weight_unit_id + '" selected>' + data.max_takeoff_weight_unit.name + '</option>');
        }

        $(".max_landing_weight_unit_id").val(null).trigger('change');
        if (data.max_landing_weight_unit != null) {
            $('#max_landing_weight_unit_id').append('<option value="' + data.max_landing_weight_unit_id + '" selected>' + data.max_landing_weight_unit.name + '</option>');
        }

        $(".max_zero_fuel_weight_unit_id").val(null).trigger('change');
        if (data.max_zero_fuel_weight_unit != null) {
            $('#max_zero_fuel_weight_unit_id').append('<option value="' + data.max_zero_fuel_weight_unit_id + '" selected>' + data.max_zero_fuel_weight_unit.name + '</option>');
        }

        $(".fuel_capacity_unit_id").val(null).trigger('change');
        if (data.fuel_capacity_unit != null) {
            $('#fuel_capacity_unit_id').append('<option value="' + data.fuel_capacity_unit_id + '" selected>' + data.fuel_capacity_unit.name + '</option>');
        }

        $(".basic_empty_weight_unit_id").val(null).trigger('change');
        if (data.basic_empty_weight_unit != null) {
            $('#basic_empty_weight_unit_id').append('<option value="' + data.basic_empty_weight_unit_id + '" selected>' + data.basic_empty_weight_unit.name + '</option>');
        }
               
        if (data.status == '<label class="label label-success">Active</label>') {
            $('#status').prop('checked', true);
        }
        else {
            $('#status').prop('checked', false);
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
                }
                $('#inputModal').modal('hide');
                $(targetTableId).DataTable().ajax.reload();

                setTimeout(function () {
                    window.location.href = "aircraft-configuration/" + data.id;
                }, 2000);
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $('#saveBtn'). prop('disabled', false);
            }
        }); 
    });

    deleteButtonProcess (datatableObject, tableId, actionUrl);

    approveButtonProcess (datatableObject, tableId, actionUrl);
});
</script>
@endpush