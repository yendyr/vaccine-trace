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

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: actionUrl + "/?id=" + $('#afm_logs_id').val(),
        },
        columns: [
            { data: 'route_from.name', defaultContent: '-' },
            { data: 'route_to.name', defaultContent: '-' },
            { data: 'block_off', defaultContent: '-' },
            { data: 'take_off', defaultContent: '-' },
            { data: 'landing', defaultContent: '-' },
            { data: 'block_on', defaultContent: '-' },
            { data: 'sub_total_flight_hour', defaultContent: '-' },
            { data: 'sub_total_block_hour', defaultContent: '-' },
            { data: 'sub_total_cycle', defaultContent: '-' },
            { data: 'sub_total_event', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });


    


    $('.block_off').clockpicker({
        autoclose: true,
        donetext: 'Done',
    });
    $('.take_off').clockpicker({
        autoclose: true,
        donetext: 'Done',
    });
    $('.landing').clockpicker({
        autoclose: true,
        donetext: 'Done',
    });
    $('.block_on').clockpicker({
        autoclose: true,
        donetext: 'Done',
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
        $('#total_event').val(data.total_event);
        $('#description').val(data.description);

        if (data.route_from != null) {
            $('#route_from').append('<option value="' + data.route_from + '" selected>' + data.route_from.iata_code + ' | ' + data.route_from.name + '</option>');
        }

        if (data.route_to != null) {
            $('#route_to').append('<option value="' + data.route_to + '" selected>' + data.route_to.iata_code + ' | ' + data.route_to.name + '</option>');
        }   

        $(saveButtonId).val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $(inputModalId).modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //




    $(inputFormId).on('submit', function (event) {
        submitButtonProcessDynamic (tableId, inputFormId, inputModalId); 
    });




    deleteButtonProcess (datatableObject, tableId, actionUrl);



    
});
</script>
@endpush