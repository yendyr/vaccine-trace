@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/work-order/{{$work_order?->id}}/work-package';
    var tableId = '#work-package-table';
    var inputFormId = '#inputWorkPackageForm';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //


    $('#taskcard-table thead tr').clone(true).appendTo('#taskcard-table thead');
    $('#taskcard-table thead tr:eq(1) th').each( function (i) {
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
        orderCellsTop: true,
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-5x fa-fw text-success"></i>'
        },
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/work-order/{{$work_order->id}}/work-package",
        },
        columns: [
            { title: 'Work Package Number', data: 'number', name: 'number', defaultContent: '-' },
            { title: 'Title', data: 'name', name: 'name', defaultContent: '-' },
            { title: 'Total Manhours', data: 'total_manhours', name: 'total_manhours', defaultContent: '-' },
            { title: 'Performance Factor', data: 'performance_factor', name: 'performance_factor', defaultContent: '-' },
            { title: 'Created At', data: 'created_at', name: 'created_at', defaultContent: '-' },
            { title: 'Action', data: 'action', name: 'action', orderable: false },
        ]
    });

    $('#taskcard-table tbody').on( 'click', 'tr.group', function () {
        var currentOrder = datatableObject.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            datatableObject.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            datatableObject.order( [ groupColumn, 'asc' ] ).draw();
        }
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
                    window.location.href = actionUrl+ "/" + data.id;
                }, 2000);
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $('#saveBtn'). prop('disabled', false);
            }
        }); 
    });

    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $('#create').click(function () {
        clearForm();
        $('#work_order_id').val('{{$work_order?->id}}');
        showCreateModal ('Create New Work Package', inputFormId, actionUrl);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //


    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        clearForm();
        $('#modalTitle').html("Edit Work Package");
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
            }).prependTo(inputFormId);
        } else {
            $("input[name=_method]").val('patch');
        }

        $.each(data, function(index, data) {
            let elementID = '#'+index;
            $(inputFormId).find(elementID).val(data);
        });

        $('#saveBtn').val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $('#inputModal').modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //


    deleteButtonProcess (datatableObject, tableId, actionUrl);

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
    }

});
</script>
@endpush