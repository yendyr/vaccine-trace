@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/supplychain/mutation-inbound';
    var tableId = '#mutation-inbound-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        order: [ 7, "desc" ],
        ajax: {
            url: "{{ route('supplychain.mutation-inbound.index') }}",
        },
        columns: [
            { data: 'code', "render": function ( data, type, row, meta ) {
                            return '<a href="mutation-inbound/' + row.id + '">' + row.code + '</a>'; } },
            { data: 'transaction_date', "render": function ( data, type, row, meta ) {
                            return '<a href="mutation-inbound/' + row.id + '">' + row.transaction_date + '</a>'; } },
            { data: 'destination.name', "render": function ( data, type, row, meta ) {
                            return '<a href="mutation-inbound/' + row.id + '">' + row.destination.code + ' | ' + row.destination.name + '</a>'; } },
            { data: 'supplier.name', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'reference', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            // { data: 'updater_name', defaultContent: '-' },
            // { data: 'updated_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });







    $('.supplier_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Supplier',
        allowClear: true,
        ajax: {
            url: "{{ route('generalsetting.company.select2.supplier') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModal)
    });

    $('.warehouse_destination').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Warehouse Destination',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.warehouse.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });

    







    $('#create').click(function () {
        showCreateModal ('Create New Mutation Inbound', inputFormId, actionUrl);
    });






    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit Mutation Inbound");
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
        $('.transaction_date').val(data.transaction_date);
        $('#description').val(data.description);
        
        $(".warehouse_destination").val(null).trigger('change');
        if (data.warehouse_destination != null) {
            $('#warehouse_destination').append('<option value="' + data.warehouse_destination + '" selected>' + data.destination.code + ' | ' + data.destination.name + '</option>');
        }

        $(".supplier_id").val(null).trigger('change');
        if (data.supplier_id != null) {
            $('.supplier_id').append('<option value="' + data.supplier_id + '" selected>' + data.supplier.name + '</option>');
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

                    $('#inputModal').modal('hide');
                    $(targetTableId).DataTable().ajax.reload();

                    setTimeout(function () {
                        window.location.href = "mutation-inbound/" + data.id;
                    }, 2000);                           
                }
                else if (data.error) {
                    $('#inputModal').modal('hide');
                    swal.fire({
                        titleText: "Action Failed",
                        text: data.error,
                        icon: "error",
                    });
                }
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