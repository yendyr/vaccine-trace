@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/accounting/trial-balance';
    var tableId = '#trial-balance-table';
    var start_date = '1970-01-01';
    var end_date = '9999-12-31';

    $('#input_range').daterangepicker({
        locale: {
            format: "YYYY-MMMM-DD",
            separator: " to ",
        },
    });

    $('#input_range').on('apply.daterangepicker', function(ev, picker) {
        start_date = picker.startDate.format('YYYY-MM-DD');
        end_date = picker.endDate.format('YYYY-MM-DD');
        $(tableId).DataTable().ajax.reload();
    });

    // $('#trial-balance-table thead tr').clone(true).appendTo('#trial-balance-table thead');
    // $('#trial-balance-table thead tr:eq(1) th').each( function (i) {
    //     if ($(this).text() != 'Action') {
    //         var title = $(this).text();
    //         $(this).html('<input type="text" placeholder="Search" class="form-control" />');

    //         $('input', this).on('keypress', function (e) {
    //             if(e.which == 13) {
    //                 if (datatableObject.column(i).search() !== this.value) {
    //                     datatableObject
    //                         .column(i)
    //                         .search( this.value )
    //                         .draw();
    //                 }
    //             }
    //         });
    //     }
    //     else {
    //         $(this).html('&nbsp;');
    //     }
    // });

    var groupColumn = 0;
    var datatableObject = $(tableId).DataTable({
        // dom: 'Bfrtip',
        // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        // orderCellsTop: true,
        columnDefs: [{
            visible: false,
            targets: groupColumn }
        ],
        order: [[ groupColumn, 'asc' ], [ 1, 'asc' ]],
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            // var endingBalanceDebit = rows
            //         .data()
            //         .pluck(7)
            //         .reduce( function (a, b) {
            //             if (!b) {
            //                 return a + 0;
            //             }
            //             else {
            //                 return a + b.replace(/\D/g, "");
            //             }
            //         }, 0);

            // var endingBalanceCredit = rows
            //         .data()
            //         .pluck(8)
            //         .reduce( function (a, b) {
            //             if (!b) {
            //                 return a + 0;
            //             }
            //             else {
            //                 return a + b.replace(/\D/g, "");
            //             }
            //         }, 0);

            // var totalEndingBalanceClass = endingBalanceDebit - endingBalanceCredit;

            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="9" class="text-left">COA Class: <b>' + group + '</b></td></tr>'
                    );
                    last = group;
                }
            });
        },
        pageLength: 200,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('accounting.trial-balance.index') }}",
            data: function(d){
                d.start_date = start_date;
                d.end_date = end_date;
            }
        },
        columns: [
            { data: 'chart_of_account_class.name' },
            { data: 'code', defaultContent: '-', orderable: false },
            { data: 'coa_name', defaultContent: '-', orderable: false, class: 'text-left' },
            { data: 'beginning_debit', orderable: false, class: 'text-right',
                "render": function ( data, type, row, meta ) {
                    if (row.beginning_debit != '&nbsp;') {
                        return formatNumber(row.beginning_debit);
                    }
                    else {
                        return row.beginning_debit;
                    }
                }},
            { data: 'beginning_credit', orderable: false, class: 'text-right',
                "render": function ( data, type, row, meta ) {
                    if (row.beginning_credit != '&nbsp;') {
                        return formatNumber(row.beginning_credit);
                    }
                    else {
                        return row.beginning_credit;
                    }
                }},
            { data: 'in_period_debit', orderable: false, class: 'text-right',
                "render": function ( data, type, row, meta ) {
                    if (row.in_period_debit != '&nbsp;') {
                        return formatNumber(row.in_period_debit);
                    }
                    else {
                        return row.in_period_debit;
                    }
                }},
            { data: 'in_period_credit', orderable: false, class: 'text-right',
                "render": function ( data, type, row, meta ) {
                    if (row.in_period_credit != '&nbsp;') {
                        return formatNumber(row.in_period_credit);
                    }
                    else {
                        return row.in_period_credit;
                    }
                }},
            { data: 'ending_debit', orderable: false, class: 'text-right',
                "render": function ( data, type, row, meta ) {
                    if (row.beginning_debit != '&nbsp;') {
                        return formatNumber((row.beginning_debit + row.in_period_debit));
                    }
                    else {
                        return row.beginning_debit;
                    }
                }},
            { data: 'ending_credit', orderable: false, class: 'text-right',
                "render": function ( data, type, row, meta ) {
                    if (row.beginning_debit != '&nbsp;') {
                        return formatNumber((row.beginning_credit + row.in_period_credit));
                    }
                    else {
                        return row.beginning_debit;
                    }
                }},
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
});
</script>
@endpush
