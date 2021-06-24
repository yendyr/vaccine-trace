@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/accounting/general-ledger';
    var tableId = '#general-ledger-table';
    var inputFormId = '#inputForm';
    var start_date = '1970-01-01';
    var end_date = '9999-12-31';
    var coas = null;

    $('#input_range').daterangepicker({
        locale: {
            format: "YYYY-MMMM-DD",
            separator: "   to   ",
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    });

    $('.coas').select2({
        maximumSelectionLength: 3,
        theme: 'bootstrap4',
        placeholder: 'Choose COA',
        allowClear: true,
        ajax: {
            url: "{{ route('accounting.chart-of-account.select2.child') }}",
            dataType: 'json',
        },
    });

    $('#input_range').on('apply.daterangepicker', function(ev, picker) {
        start_date = picker.startDate.format('YYYY-MM-DD');
        end_date = picker.endDate.format('YYYY-MM-DD');

        $(tableId).DataTable().ajax.reload();
    });

    $('#coas').on("select2:select select2:unselect", function (e) {
        coas = $(this).val();;
    });




    var groupColumn = 0;
    var datatableObject = $(tableId).DataTable({
        columnDefs: [{
            visible: false,
            targets: groupColumn }
        ],
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="3" class="text-left">COA: ' + group + '</td></tr>'
                    );
                    last = group;
                }
            });
        },
        order: [[ 0, 'asc' ], [ 4, 'asc' ]],
        pageLength: 200,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('accounting.general-ledger.index') }}",
            data: function(d){
                d.start_date = start_date;
                d.end_date = end_date;
                d.coas = coas;
            }
        },
        columns: [
            { data: 'coa_title' },
            { data: 'type' },
            { data: 'journal.code', defaultContent: '-', orderable: false,
                "render": function ( data, type, row, meta ) {
                    return '<a href="journal/' + row.journal.id + '" target="_blank">' + row.journal.code + '</a>';
                }},
            { data: 'reference', defaultContent: '-', orderable: false },
            { data: 'journal.transaction_date', defaultContent: '-', orderable: false },
            { data: 'journal.currency.code', defaultContent: '-', orderable: false },
            { data: 'journal.exchange_rate', defaultContent: '-', orderable: false,
                "render": function ( data, type, row, meta ) {
                    if (row.journal.exchange_rate) {
                        return formatNumber(row.journal.exchange_rate);
                    }
                    else {
                        return '-';
                    }
                }},
            { data: 'debit', orderable: false, class: 'text-right text-nowrap',
                "render": function ( data, type, row, meta ) {
                    if (row.debit) {
                        return formatNumber(row.debit);
                    }
                    else {
                        return '-';
                    }
                }},
            { data: 'credit', orderable: false, class: 'text-right text-nowrap',
                "render": function ( data, type, row, meta ) {
                    if (row.credit) {
                        return formatNumber(row.credit);
                    }
                    else {
                        return '-';
                    }
                }},
            // { data: 'balance', orderable: false, class: 'text-right text-nowrap',
            //     "render": function ( data, type, row, meta ) {
            //         if (row.balance) {
            //             return formatNumber(row.balance);
            //         }
            //         else {
            //             return '-';
            //         }
            //     }},
            { data: 'journal.description', defaultContent: '-', orderable: false },
        ]
    });



    function formatNumber(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return 'Rp. ' + x1 + x2;
    }

    $(inputFormId).on('submit', function (event) {
        submitButtonProcess (tableId, inputFormId);
    });
});
</script>
@endpush
