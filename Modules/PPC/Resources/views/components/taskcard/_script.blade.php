@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/taskcard';
    var tableId = '#taskcard-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('ppc.taskcard.index') }}",
        },
        columns: [
            { data: 'mpd_number', 
                    "render": function ( data, type, row, meta ) {
                    return '<a href="taskcard/' + row.id + '">' + row.mpd_number + '</a>'; }},
            { data: 'title', name: 'Title' },
            { data: 'taskcard_group.name', name: 'Group' },
            { data: 'taskcard_type.name', name: 'Task Type' },
            { data: 'aircraft_type_name', name: 'Aircraft Type' },
            { data: 'skills', name: 'Skill' },
            { data: 'creator_name', name: 'Created By' },
            { data: 'created_at', name: 'Created At' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });


    

    $('.taskcard_group_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Group',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.taskcard-group.select2.child') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });
        
    $('.taskcard_type_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Type',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.taskcard-type.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.aircraft_type_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Type',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.aircraft-type.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.threshold_daily_unit').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose',
        allowClear: false,
        minimumResultsForSearch: -1,
        dropdownParent: $('#inputModal')
    });

    $('.repeat_daily_unit').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose',
        allowClear: false,
        minimumResultsForSearch: -1,
        dropdownParent: $('#inputModal')
    });

    $('.interval_control_method').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Interval Control Method',
        allowClear: false,
        minimumResultsForSearch: -1,
        dropdownParent: $('#inputModal')
    });

    $('.taskcard_workarea_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Work Area',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.taskcard-workarea.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.taskcard_access_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Access',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.taskcard-access.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.taskcard_zone_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Zone',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.taskcard-zone.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.taskcard_document_library_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Document',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.taskcard-document-library.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.taskcard_affected_manual_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Manual',
        allowClear: true,
        ajax: {
            url: "{{ route('qualityassurance.document-type.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.scheduled_priority').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Scheduled',
        minimumResultsForSearch: -1,
        allowClear: false,
        dropdownParent: $('#inputModal')
    });

    $('.recurrence').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Recurrence',
        minimumResultsForSearch: -1,
        allowClear: false,
        dropdownParent: $('#inputModal')
    });



    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $('#create').click(function () {
        clearForm();
        showCreateModal ('Create New Task Card', inputFormId, actionUrl);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //




    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        clearForm();
        $('#modalTitle').html("Edit Task Card");
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

        $('#mpd_number').val(data.mpd_number);
        $('#title').val(data.title);
        $('#threshold_flight_hour').val(data.threshold_flight_hour);
        $('#threshold_flight_cycle').val(data.threshold_flight_cycle);
        $('#threshold_daily').val(data.threshold_daily);
        $('#threshold_daily_unit').val(data.threshold_daily_unit);

        $('#threshold_daily_unit').append('<option value="' + data.threshold_daily_unit + '" selected>' + data.threshold_daily_unit + '</option>');

        $('#threshold_date').val(data.threshold_date);

        $('#repeat_flight_hour').val(data.repeat_flight_hour);
        $('#repeat_flight_cycle').val(data.repeat_flight_cycle);
        $('#repeat_daily').val(data.repeat_daily);

        $('#repeat_daily_unit').append('<option value="' + data.repeat_daily_unit + '" selected>' + data.repeat_daily_unit + '</option>');

        $('#repeat_date').val(data.repeat_date);

        $('#interval_control_method').append('<option value="' + data.interval_control_method + '" selected>' + data.interval_control_method + '</option>');

        $('#company_number').val(data.company_number);
        $('#ata').val(data.ata);
        $('#version').val(data.version);
        $('#revision').val(data.revision);
        $('#effectivity').val(data.effectivity);
        $('#source').val(data.source);
        $('#reference').val(data.reference);
        $('#file_attachment').val(data.file_attachment);

        $('#scheduled_priority').append('<option value="' + data.interval_control_method + '" selected>' + data.scheduled_priority + '</option>');

        $('#recurrence').append('<option value="' + data.recurrence + '" selected>' + data.recurrence + '</option>');

        if (data.taskcard_group != null) {
            $('#taskcard_group_id').append('<option value="' + data.taskcard_group_id + '" selected>' + data.taskcard_group.name + '</option>');
        }   

        if (data.taskcard_type != null) {
            $('#taskcard_type_id').append('<option value="' + data.taskcard_type_id + '" selected>' + data.taskcard_type.name + '</option>');
        }

        if (data.taskcard_workarea != null) {
            $('#taskcard_workarea_id').append('<option value="' + data.taskcard_workarea_id + '" selected>' + data.taskcard_workarea.name + '</option>');
        }

        $("#aircraft_type_id").val('').trigger('change');
        if (data.aircraft_types != null) {
            $.each(data.aircraft_types, function(index, value) {
                var option = new Option(data.aircraft_types[index].name, data.aircraft_types[index].id, true, true);
                $("#aircraft_type_id").append(option);
            });
        }

        $("#taskcard_access_id").val('').trigger('change');
        if (data.accesses != null) {
            $.each(data.accesses, function(index, value) {
                var option = new Option(data.accesses[index].name, data.accesses[index].id, true, true);
                $("#taskcard_access_id").append(option);
            });
        }

        $("#taskcard_zone_id").val('').trigger('change');
        if (data.zones != null) {
            $.each(data.zones, function(index, value) {
                var option = new Option(data.zones[index].name, data.zones[index].id, true, true);
                $("#taskcard_zone_id").append(option);
            });
        }

        $("#taskcard_document_library_id").val('').trigger('change');
        if (data.document_libraries != null) {
            $.each(data.document_libraries, function(index, value) {
                var option = new Option(data.document_libraries[index].name, data.document_libraries[index].id, true, true);
                $("#taskcard_document_library_id").append(option);
            });
        }

        $("#taskcard_affected_manual_id").val('').trigger('change');
        if (data.affected_manuals != null) {
            $.each(data.affected_manuals, function(index, value) {
                var option = new Option(data.affected_manuals[index].name, data.affected_manuals[index].id, true, true);
                $("#taskcard_affected_manual_id").append(option);
            });
        }

        // if (data.status == '<label class="label label-success">Active</label>') {
        //     $('#status').prop('checked', true);
        // }
        // else {
        //     $('#status').prop('checked', false);
        // }

        $('#saveBtn').val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $('#inputModal').modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //




    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId); 
    });

    deleteButtonProcess (datatableObject, tableId, actionUrl);

    function clearForm()
    {
        $('#taskcard_group_id').val(null).trigger("change");
        $('#taskcard_type_id').val(null).trigger("change");
        $('#taskcard_workarea_id').val(null).trigger("change");
        $('#aircraft_type_id').empty().trigger("change");
        $('#taskcard_access_id').empty().trigger("change");
        $('#taskcard_zone_id').empty().trigger("change");
        $('#taskcard_document_library_id').empty().trigger("change");
        $('#taskcard_affected_manual_id').empty().trigger("change");
    }
});
</script>
@endpush