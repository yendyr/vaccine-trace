@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/flightoperations/afml-detail-journal';
    var tableId = '#afml-detail-journal';
    var createButtonId = '#createButtonJournal';
    var inputModalId = '#inputModalJournal';
    var inputFormId = '#inputFormJournal';
    var modalTitleId = '#modalTitleJournal';
    var saveButtonId = '#saveButtonJournal';
    var deleteModalId = '#deleteModalJournal';
    var deleteFormId = '#deleteFormJournal';
    var deleteModalButtonId = '#deleteModalButtonJournal';
    var deleteButtonClass = '.deleteButtonJournal';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: actionUrl + "/?id=" + $('#afm_log_id').val(),
        },
        columns: [
            { data: 'from_airport.name', defaultContent: '-' },
            { data: 'to_airport.name', defaultContent: '-' },
            { data: 'block_off', defaultContent: '-' },
            { data: 'take_off', defaultContent: '-' },
            { data: 'landing', defaultContent: '-' },
            { data: 'block_on', defaultContent: '-' },
            { data: 'sub_total_flight_hour', "render": function ( data, type, row, meta ) {
                            return '<label class="label label-success">' + (row.sub_total_flight_hour).slice(0,-3) + '</label>'; } },
            { data: 'sub_total_block_hour', "render": function ( data, type, row, meta ) {
                            return '<label class="label label-success">' + (row.sub_total_block_hour).slice(0,-3) + '</label>'; } },
            { data: 'sub_total_cycle', "render": function ( data, type, row, meta ) {
                            return '<label class="label label-success">' + row.sub_total_cycle + '</label>'; } },
            { data: 'sub_total_event', "render": function ( data, type, row, meta ) {
                            return '<label class="label label-success">' + row.sub_total_event + '</label>'; } },
            { data: 'description', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });


    


    $('.block_off').clockpicker({
        autoclose: true,
        donetext: 'Done',
        twelvehour: false,
    });
    $('.take_off').clockpicker({
        autoclose: true,
        donetext: 'Done',
        twelvehour: false,
    });
    $('.landing').clockpicker({
        autoclose: true,
        donetext: 'Done',
        twelvehour: false,
    });
    $('.block_on').clockpicker({
        autoclose: true,
        donetext: 'Done',
        twelvehour: false,
    });

    $('.route_from').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Origin',
        allowClear: true,
        ajax: {
            url: "{{ route('generalsetting.airport.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.route_to').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Destination',
        allowClear: true,
        ajax: {
            url: "{{ route('generalsetting.airport.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

        
    




    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $(createButtonId).click(function () {
        showCreateModalDynamic (inputModalId, modalTitleId, 'Add New Journal', saveButtonId, inputFormId, actionUrl, );
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //






    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        $(modalTitleId).html("Edit Crew");
        $(inputFormId).trigger("reset");                
        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        $('#block_off').val(data.block_off);
        $('#take_off').val(data.take_off);
        $('#landing').val(data.landing);
        $('#block_on').val(data.block_on);
        $('#sub_total_event').val(data.sub_total_event);
        $('#journal_description').val(data.description);

        if (data.route_from != null) {
            $('#route_from').append('<option value="' + data.route_from + '" selected>' + data.from_airport.iata_code + ' | ' + data.from_airport.name + '</option>');
        }

        if (data.route_to != null) {
            $('#route_to').append('<option value="' + data.route_to + '" selected>' + data.to_airport.iata_code + ' | ' + data.to_airport.name + '</option>');
        }   

        $(saveButtonId).val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $(inputModalId).modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //





    // ----------------- "SUBMIT" BUTTON  SCRIPT ------------- //
    $(inputFormId).on('submit', function (event) {
        submitButtonProcessDynamic (tableId, inputFormId, inputModalId); 
        setTimeout(location.reload.bind(location), 2000);
    });
    // ----------------- END "SUBMIT" BUTTON  SCRIPT ------------- //






    // ----------------- "DELETE" BUTTON  SCRIPT ------------- //
    datatableObject.on('click', deleteButtonClass, function () {
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
                setTimeout(location.reload.bind(location), 2000);
            },
            complete: function(data) {
                $(deleteModalButtonId).text('Delete');
                $(deleteModalId).modal('hide');
                $(deleteModalButtonId).prop('disabled', false);
                $(tableId).DataTable().ajax.reload();
            }
        });
    });
    // ----------------- END "DELETE" BUTTON  SCRIPT ------------- //



    
});
</script>
@endpush