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
    
    var datatableObject = $(tableId).DataTable({
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
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
            { title: 'Work Order Number', data: 'number', defaultContent: '-' },
            { title: 'Title', data: 'name', defaultContent: '-' },
            { title: 'Status', data: 'status', defaultContent: '-' },
            { title: 'Created At', data: 'created_at', defaultContent: '-' },
            { title: 'Action', data: 'action', defaultContent: '-', orderable: false },
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

        if( $("input[name=_method]").length == 0 ){
            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo('#inputForm');
        } else {
            $("input[name=_method]").val('patch');
        }         

        $('#mpd_number').val(data.mpd_number);
        $('#name').val(data.name);
        $('#code').val(data.code);
        $('#aircraft_serial_number').val(data.aircraft_serial_number);
        $('#aircraft_registration_number').val(data.aircraft_registration_number);
        $('#tsn').val(data.tsn);
        $('#tso').val(data.tso);
        $('#csn').val(data.csn);
        $('#cso').val(data.cso);
        $('#station').val(data.station);

        $("#description").summernote("code", data.description);
        $('#issued_date').val(data.created_at);

        $("#aircraft_id").val('').trigger('change');
        if (data.aircraft_id != null) {
            $('#aircraft_id').append('<option value="' + data.aircraft_id + '" selected>['+ data.aircraft.aircraft_type.code +'] ' + data.aircraft.aircraft_type.name + ' | ' + data.aircraft_serial_number + ' | ' + data.aircraft_registration_number +'</option>');
        }

        $('#saveBtn').val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $('#inputModal').modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //
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
                    window.location.href = "work-order/" + data.id;
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
    
    function clearForm()
    {
        $(inputFormId)
            .find("input,textarea")
            .val('')
            .end().
            find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end()
            .find("select")
            .val('')
            .trigger('change');

        $("#description").summernote("code", '');
    }
});
</script>
@endpush