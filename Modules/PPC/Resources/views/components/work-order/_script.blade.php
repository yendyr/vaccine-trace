@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/work-order';
    var tableId = '#work-order-table';
    var inputFormId = '#inputForm';

    $('#work-order-table thead tr').clone(true).appendTo('#work-order-table thead');
    $('#work-order-table thead tr:eq(1) th').each( function (i) {
        if ($(this).text() != 'Action') {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search" class="form-control" />');
    
            $('input', this).on('keypress', function (e) {
                if(e.which == 13) {
                    if (datatableObject.column(i).search() !== this.value) {
                        datatableObject
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                }
            });
        }
        else {
            $(this).html('&nbsp;');
        }
    });

    var groupColumn = 10;

    var datatableObject = $(tableId).DataTable({
        // dom: "<'toolbar'>frtip",
        columnDefs: [{
            visible: false, 
            targets: groupColumn }
        ],
        order: [[ groupColumn, 'asc' ]],
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group" style="text-align: left;"><td colspan="14">Repeat Interval: <b>' + group + '</b></td></tr>'
                    );
                    last = group;
                }
            });
        },
        pageLength: 50,
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-5x fa-fw text-success"></i>'
        },
        orderCellsTop: true,
        serverSide: false,
        deferRender: true,
        // scrollY: 200,
        scrollCollapse: true,
        scroller: true,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('ppc.work-order.index') }}",
        },
        columns: [
            {   title: 'Number', data: 'code', "render": function ( data, type, row, meta ) {
                    return '<a href="work-order/' + row.id + '">' + row.code + '</a>'; }},
            {   title: 'Title', data: 'title' },
            {   title: 'Status', data: 'status' },
            {   title: 'created_at', data: 'created_at' },
            {   title: 'Action', data: 'action', orderable: false },
        ]
    });

    $('#work-order-table tbody').on( 'click', 'tr.group', function () {
        var currentOrder = datatableObject.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            datatableObject.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            datatableObject.order( [ groupColumn, 'asc' ] ).draw();
        }
    });

    // $('div.toolbar').html("<div class='pretty p-icon p-round p-jelly' style='font-size: 11pt;'><input type='checkbox' class='form-control' id='groupByInterval' /><div class='state p-primary'><i class='icon fa fa-check'></i><label>Group by Interval/Repeat</label></div></div>");

    // $('#groupByInterval').change(function() {
    //     if(this.checked) {
    //         alert('Cek');
    //     }
    // });


    $('.aircraft_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Aircraft',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.work-order.select2.aircraft') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    $('.aircraft_id').on('select2:select', function(event) {
        let selectedOpt = $(this).text();
        let res = selectedOpt.split(" | ");
        $('#aircraft_serial_number').val(res[1]);
        $('#aircraft_registration_number').val(res[2]);
    });

    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $('#create').click(function () {
        clearForm();

        showCreateModal ('Create New Work Order', inputFormId, actionUrl);

        $('#compliance').val('Optional').trigger('change');
        $('#threshold_daily_unit').val('Year').trigger('change');
        $('#repeat_daily_unit').val('Year').trigger('change');
        $('#interval_control_method').val('Which One Comes First').trigger('change');
        $('#scheduled_priority').val('As Scheduled').trigger('change');
        $('#recurrence').val('As Required').trigger('change');
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //




    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        clearForm();
        $('#modalTitle').html("Edit Work Order");
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

        $('#compliance').val(data.compliance).trigger('change');

        $('#threshold_flight_hour').val(data.threshold_flight_hour);
        $('#threshold_flight_cycle').val(data.threshold_flight_cycle);
        $('#threshold_daily').val(data.threshold_daily);
        $('#threshold_daily_unit').val(data.threshold_daily_unit).trigger('change');
        $('.threshold_date').val(data.threshold_date);

        $('#repeat_flight_hour').val(data.repeat_flight_hour);
        $('#repeat_flight_cycle').val(data.repeat_flight_cycle);
        $('#repeat_daily').val(data.repeat_daily);
        $('#repeat_daily_unit').val(data.repeat_daily_unit).trigger('change');
        $('.repeat_date').val(data.repeat_date);

        $('#interval_control_method').val(data.interval_control_method).trigger('change');

        $('#company_number').val(data.company_number);
        $('#ata').val(data.ata);
        $('#issued_date').val(data.issued_date);
        $('#version').val(data.version);
        $('#revision').val(data.revision);
        $('#effectivity').val(data.effectivity);
        $('#source').val(data.source);
        $('#reference').val(data.reference);
        $('#file_attachment').val(data.file_attachment);

        $('#scheduled_priority').val(data.scheduled_priority).trigger('change');

        $('#recurrence').val(data.recurrence).trigger('change');

        if (data.work-order_group != null) {
            $('#work-order_group_id').append('<option value="' + data.work-order_group_id + '" selected>' + data.work-order_group.name + '</option>');
        }   

        if (data.work-order_type != null) {
            $('#work-order_type_id').append('<option value="' + data.work-order_type_id + '" selected>' + data.work-order_type.name + '</option>');
        }

        if (data.work-order_workarea != null) {
            $('#work-order_workarea_id').append('<option value="' + data.work-order_workarea_id + '" selected>' + data.work-order_workarea.name + '</option>');
        }

        $("#aircraft_type_id").val('').trigger('change');
        if (data.aircraft_types != null) {
            $.each(data.aircraft_types, function(index, value) {
                var option = new Option(data.aircraft_types[index].name, data.aircraft_types[index].id, true, true);
                $("#aircraft_type_id").append(option);
            });
        }

        $("#affected_item_id").val('').trigger('change');
        if (data.affected_items != null) {
            $.each(data.affected_items, function(index, value) {
                var option = new Option(data.affected_items[index].code + ' | ' + data.affected_items[index].name, data.affected_items[index].id, true, true);
                $("#affected_item_id").append(option);
            });
        }

        $("#tag_id").val('').trigger('change');
        if (data.tags != null) {
            $.each(data.tags, function(index, value) {
                var option = new Option(data.tags[index].name, data.tags[index].id, true, true);
                $("#tag_id").append(option);
            });
        }

        // $("#interval_group_id").val('').trigger('change');
        // if (data.interval_groups != null) {
        //     $.each(data.interval_groups, function(index, value) {
        //         var option = new Option(data.interval_groups[index].name, data.interval_groups[index].id, true, true);
        //         $("#interval_group_id").append(option);
        //     });
        // }

        $("#work-order_access_id").val('').trigger('change');
        if (data.accesses != null) {
            $.each(data.accesses, function(index, value) {
                var option = new Option(data.accesses[index].name, data.accesses[index].id, true, true);
                $("#work-order_access_id").append(option);
            });
        }

        $("#work-order_zone_id").val('').trigger('change');
        if (data.zones != null) {
            $.each(data.zones, function(index, value) {
                var option = new Option(data.zones[index].name, data.zones[index].id, true, true);
                $("#work-order_zone_id").append(option);
            });
        }

        $("#work-order_document_library_id").val('').trigger('change');
        if (data.document_libraries != null) {
            $.each(data.document_libraries, function(index, value) {
                var option = new Option(data.document_libraries[index].name, data.document_libraries[index].id, true, true);
                $("#work-order_document_library_id").append(option);
            });
        }

        $("#work-order_affected_manual_id").val('').trigger('change');
        if (data.affected_manuals != null) {
            $.each(data.affected_manuals, function(index, value) {
                var option = new Option(data.affected_manuals[index].name, data.affected_manuals[index].id, true, true);
                $("#work-order_affected_manual_id").append(option);
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
        $('#work-order_group_id').val(null).trigger("change");
        $('#work-order_type_id').val(null).trigger("change");
        $('#work-order_workarea_id').val(null).trigger("change");
        $('#aircraft_type_id').empty().trigger("change");
        $('#affected_item_id').empty().trigger("change");
        $('#interval_group_id').empty().trigger("change");
        $('#work-order_access_id').empty().trigger("change");
        $('#work-order_zone_id').empty().trigger("change");
        $('#work-order_document_library_id').empty().trigger("change");
        $('#work-order_affected_manual_id').empty().trigger("change");
    }
});
</script>
@endpush