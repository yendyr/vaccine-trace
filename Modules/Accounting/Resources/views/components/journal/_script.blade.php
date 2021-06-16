@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/accounting/journal';
    var tableId = '#journal-table';
    var inputFormId = '#inputForm';

    $('#journal-table thead tr').clone(true).appendTo('#journal-table thead');
    $('#journal-table thead tr:eq(1) th').each( function (i) {
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
        searchDelay: 1500,
        pageLength: 50,
        processing: true,
        serverSide: false,
        orderCellsTop: true,
        order: [ 10, "desc" ],
        ajax: {
            url: "{{ route('accounting.journal.index') }}",
        },
        columns: [
            { data: 'code', defaultContent: '-' },
            { data: 'transaction_date', defaultContent: '-' },
            { data: 'type', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'current_primary_currency.code', defaultContent: '-' },
            { data: 'currency.code', defaultContent: '-' },
            { data: 'exchange_rate',
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.exchange_rate);
                }},
            { data: 'total_amount', 
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.total_amount);
                }},
            { data: 'reference', defaultContent: '-' },
            // { data: 'status', defaultContent: '-' },
            { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            // { data: 'updater_name', defaultContent: '-' },
            // { data: 'updated_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });











    $('.current_primary_currency_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Currency',
        allowClear: false,
        ajax: {
            url: "{{ route('generalsetting.currency.select2.primary') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModal)
    });

    $('.currency_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Currency',
        allowClear: false,
        ajax: {
            url: "{{ route('generalsetting.currency.select2') }}",
            dataType: 'json',
        },
        dropdownParent: $(inputModal)
    });












    $('#create').click(function () {
        showCreateModal ('Create New Journal', inputFormId, actionUrl);
    });













    datatableObject.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit Journal");
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
        $('#exchange_rate').val(data.exchange_rate);
        $('#description').val(data.description);

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
        $(".info-chart_of_account_class_id").html('');
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
                    window.location.href = "journal/" + data.id;
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






    function exchange_rate_validation () {
        if ($('.current_primary_currency_id').val() == $('.currency_id').val()) {
            $("#exchange_rate").val(1);
            $('#exchange_rate').attr('readonly', true);
        }
        else {
            $('#exchange_rate').attr('readonly', false);
        }
    }

    $('.current_primary_currency_id').on('change', function (e) {
        exchange_rate_validation ();
    });

    $('.currency_id').on('change', function (e) {
        exchange_rate_validation ();
    });
});
</script>
@endpush