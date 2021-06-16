@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/accounting/journal';
    var tableId = '#journal-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        searchDelay: 1500,
        pageLength: 50,
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('accounting.journal.index') }}",
        },
        columns: [
            { data: 'code', defaultContent: '-' },
            { data: 'transaction_date', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'current_primary_currency.code', defaultContent: '-' },
            { data: 'currency.code', defaultContent: '-' },
            { data: 'exchange_rate', defaultContent: '-' },
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
        submitButtonProcess (tableId, inputFormId); 
    });












    deleteButtonProcess (datatableObject, tableId, actionUrl);
});
</script>
@endpush