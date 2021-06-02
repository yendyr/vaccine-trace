@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/procurement/purchase-order';
    var tableId = '#purchase-order-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        order: [ 12, "desc" ],
        ajax: {
            url: "{{ route('procurement.purchase-order.index') }}",
        },
        columns: [
            { data: 'code', "render": function ( data, type, row, meta ) {
                            return '<a href="purchase-order/' + row.id + '">' + row.code + '</a>'; } },
            { data: 'transaction_date', "render": function ( data, type, row, meta ) {
                            return '<a href="purchase-order/' + row.id + '">' + row.transaction_date + '</a>'; } },
            { data: 'supplier.name', defaultContent: '-' },
            { data: 'supplier_reference_document', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'current_primary_currency.code', defaultContent: '-' },
            { data: 'currency.code', defaultContent: '-' },
            { data: 'exchange_rate', defaultContent: '-' },
            { data: 'reference', defaultContent: '-' },
            { data: 'total_before_vat', defaultContent: '-' },
            { data: 'total_after_vat', defaultContent: '-' },
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
        dropdownParent: $(inputModalId)
    });

    $('.current_primary_currency_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Currency',
        allowClear: false,
        ajax: {
            url: "{{ route('generalsetting.currency.select2.primary') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    $('.currency_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Currency',
        allowClear: true,
        ajax: {
            url: "{{ route('generalsetting.currency.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModalId)
    });

    







    $('#create').click(function () {
        showCreateModal ('Create New Purchase Order', inputFormId, actionUrl);
    });






    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit Purchase Order");
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
        $('.valid_until_date').val(data.valid_until_date);
        $('#supplier_reference_document').val(data.supplier_reference_document);
        $('#shipping_address').summernote("code", data.shipping_address);
        $('#description').summernote("code", data.description);
        $('#term_and_condition').summernote("code", data.term_and_condition);

        $(".supplier_id").val(null).trigger('change');
        if (data.supplier_id != null) {
            $('.supplier_id').append('<option value="' + data.supplier_id + '" selected>' + data.supplier.name + '</option>');
        }

        $(".current_primary_currency_id").val(null).trigger('change');
        if (data.current_primary_currency_id != null) {
            $('.current_primary_currency_id').append('<option value="' + data.current_primary_currency_id + '" selected>' + data.current_primary_currency.code + ' | ' + data.current_primary_currency.symbol + ' | ' + data.current_primary_currency.name + '</option>');
        }

        $(".currency_id").val(null).trigger('change');
        if (data.currency_id != null) {
            $('.currency_id').append('<option value="' + data.currency_id + '" selected>' + data.currency.code + ' | ' + data.currency.symbol + ' | ' + data.currency.name + '</option>');
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
                    window.location.href = "purchase-requisition/" + data.id;
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