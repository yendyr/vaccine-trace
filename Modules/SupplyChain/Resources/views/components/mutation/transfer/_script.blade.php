@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/supplychain/mutation-transfer';
    var tableId = '#mutation-transfer-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('supplychain.mutation-transfer.index') }}",
        },
        columns: [
            { data: 'code', "render": function ( data, type, row, meta ) {
                            return '<a href="mutation-transfer/' + row.id + '">' + row.code + '</a>'; } },
            { data: 'transaction_date', "render": function ( data, type, row, meta ) {
                            return '<a href="mutation-transfer/' + row.id + '">' + row.transaction_date + '</a>'; } },
            { data: 'origin.name', "render": function ( data, type, row, meta ) {
                            return '<a href="mutation-transfer/' + row.id + '">' + row.origin.code + ' | ' + row.origin.name + '</a>'; } },
            { data: 'destination.name', "render": function ( data, type, row, meta ) {
                            return '<a href="mutation-transfer/' + row.id + '">' + row.destination.code + ' | ' + row.destination.name + '</a>'; } },
            { data: 'description', defaultContent: '-' },
            { data: 'reference', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'updater_name', defaultContent: '-' },
            { data: 'updated_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });






    $('.warehouse_origin').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Warehouse Origin',
        allowClear: true,
        ajax: {
            url: "{{ route('supplychain.warehouse.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
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
        showCreateModal ('Create New Mutation Transfer', inputFormId, actionUrl);
    });






    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit Mutation Transfer");
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
        
        $(".warehouse_origin").val(null).trigger('change');
        if (data.warehouse_origin != null) {
            $('#warehouse_origin').append('<option value="' + data.warehouse_origin + '" selected>' + data.origin.code + ' | ' + data.origin.name + '</option>');
        }

        $(".warehouse_destination").val(null).trigger('change');
        if (data.warehouse_destination != null) {
            $('#warehouse_destination').append('<option value="' + data.warehouse_destination + '" selected>' + data.destination.code + ' | ' + data.destination.name + '</option>');
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
                    window.location.href = "mutation-transfer/" + data.id;
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