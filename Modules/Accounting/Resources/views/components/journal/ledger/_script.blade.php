@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/accounting/journal-detail';
    var tableId = '#journal-detail-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            totalDebit = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            totalCredit = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            // pageTotal = api
            //     .column( 12, { page: 'current'} )
            //     .data()
            //     .reduce( function (a, b) {
            //         return intVal(a) + intVal(b);
            //     }, 0 );
 
            // Update footer
            $( api.column( 2 ).footer() ).html(
                formatNumber(totalDebit)
            );
            $( api.column( 3 ).footer() ).html(
                formatNumber(totalCredit)
            );
        },
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        order: [ 5, "asc" ],
        ajax: {
            url: "/accounting/journal-detail/?journal_id=" + "{{ $Journal->id }}",
        },
        columns: [
            { data: 'coa.code', defaultContent: '-' },
            { data: 'coa.name', defaultContent: '-' },
            { data: 'debit', 
                "render": function ( data, type, row, meta ) {
                    if (row.debit != null) {
                        return formatNumber(row.debit);
                    }
                    else {
                        return '-';
                    }
                }},
            { data: 'credit',
                "render": function ( data, type, row, meta ) {
                    if (row.credit != null) {
                        return formatNumber(row.credit);
                    }
                    else {
                        return '-';
                    }
                }},
            { data: 'description', defaultContent: '-' },
            // { data: 'status', name: 'Status' },
            // { data: 'creator_name', defaultContent: '-' },
            { data: 'created_at', defaultContent: '-' },
            { data: 'action', orderable: false },
        ]
    });





    

    $('.coa_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose COA',
        allowClear: true,
        ajax: {
            url: "{{ route('accounting.chart-of-account.select2.child') }}",
            dataType: 'json',
        },
        dropdownParent: $('#inputModal')
    });








    // ----------------- "CREATE NEW" BUTTON SCRIPT ------------- //
    $('#create').click(function () {
        showCreateModal ('Add New Ledger Detail', inputFormId, actionUrl);
    });
    // ----------------- END "CREATE NEW" BUTTON SCRIPT ------------- //









    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject.on('click', '.editBtn', function () {
        clearForm(inputFormId);

        $('#modalTitle').html("Edit Ledger");
        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo('#inputForm');

        $('#debit').val(data.debit);
        $('#credit').val(data.credit);
        $('#description').val(data.description); 

        $(".coa_id").val(null).trigger('change');
        if (data.coa_id != null){
            $('#coa_id').append('<option value="' + data.coa_id + '" selected>' + data.coa.code + ' | ' + data.coa.name + '</option>');
        } 

        $('#saveBtn').val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $('#inputModal').modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //






    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId); 
    });






    deleteButtonProcess (datatableObject, tableId, actionUrl);






    
    $('#debit').on('input', function (e) {
        $('#credit').val(null);
    });

    $('#credit').on('input', function (e) {
        $('#debit').val(null);
    });
});
</script>
@endpush