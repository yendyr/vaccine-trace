@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/taskcard-tag';
    var tableId = '#taskcard-tag-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('ppc.taskcard-tag.index') }}",
        },
        columns: [
            { data: 'code', defaultContent: '-' },
            { data: 'name', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            // { data: 'threshold_interval', name: 'Threshold' },
            // { data: 'repeat_interval', name: 'Repeat' },
            // { data: 'interval_control_method', name: 'Method' },
            { data: 'status', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'updater_name', defaultContent: '-' },
            { data: 'updated_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });





    // $('.threshold_daily_unit').select2({
    //     theme: 'bootstrap4',
    //     placeholder: 'Choose',
    //     allowClear: false,
    //     minimumResultsForSearch: -1,
    //     dropdownParent: $('#inputModal')
    // });

    // $('.repeat_daily_unit').select2({
    //     theme: 'bootstrap4',
    //     placeholder: 'Choose',
    //     allowClear: false,
    //     minimumResultsForSearch: -1,
    //     dropdownParent: $('#inputModal')
    // });

    // $('.interval_control_method').select2({
    //     theme: 'bootstrap4',
    //     placeholder: 'Choose Interval Control Method',
    //     allowClear: false,
    //     minimumResultsForSearch: -1,
    //     dropdownParent: $('#inputModal')
    // });

    

    
    

    $('#create').click(function () {
        showCreateModal ('Create New Task Card Tag', inputFormId, actionUrl);

        // $('#threshold_daily_unit').val('Year').trigger('change');
        // $('#repeat_daily_unit').val('Year').trigger('change');
        // $('#interval_control_method').val('Which One Comes First').trigger('change');
    });





    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit Task Card Tag");
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

        $('#code').val(data.code);
        $('#name').val(data.name);
        $('#description').val(data.description);  

        // $('#threshold_flight_hour').val(data.threshold_flight_hour);
        // $('#threshold_flight_cycle').val(data.threshold_flight_cycle);
        // $('#threshold_daily').val(data.threshold_daily);
        // $('#threshold_daily_unit').val(data.threshold_daily_unit).trigger('change');
        // $('.threshold_date').val(data.threshold_date);

        // $('#repeat_flight_hour').val(data.repeat_flight_hour);
        // $('#repeat_flight_cycle').val(data.repeat_flight_cycle);
        // $('#repeat_daily').val(data.repeat_daily);
        // $('#repeat_daily_unit').val(data.repeat_daily_unit).trigger('change');
        // $('.repeat_date').val(data.repeat_date);

        // $('#interval_control_method').val(data.interval_control_method).trigger('change');
        
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
        submitButtonProcess (tableId, inputFormId);
    });



    

    deleteButtonProcess (datatableObject, tableId, actionUrl);
});
</script>
@endpush