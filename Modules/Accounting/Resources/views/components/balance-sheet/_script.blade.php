@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/accounting/balance-sheet';
    var tableId = '#balance-sheet-table';
    var start_date = '1970-01-01';
    var end_date = '9999-12-31';

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
        order: [ 1, 'asc' ],
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last = null;

            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="4" class="text-center"><b>' + group + '</b></td><</tr>'
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
            url: "{{ route('accounting.balance-sheet.index') }}",
            data: function(d){
                d.start_date = start_date;
                d.end_date = end_date;
            },
        },
        columns: [
            { data: 'coa_class' },
            { data: 'code', defaultContent: '-', orderable: false, class: 'text-left', width: '20%' },
            { data: 'coa_name', defaultContent: '-', orderable: false, class: 'text-left' },
            { data: 'in_period_balance', orderable: false, class: 'text-right',
                "render": function ( data, type, row, meta ) {
                    if (row.in_period_balance != '&nbsp;') {
                        return formatNumber(row.in_period_balance);
                    }
                    else {
                        return row.in_period_balance;
                    }
                }},
        ]
    });

    datatableObject.on('draw', function () {
        var json = datatableObject.ajax.json();
        $("#footer_calculated_return").html('In-Period Calculated Return: ' + formatNumber(json.in_period_return));
        $("#footer_total_liabilites_equity").html('In-Period Total Liabilities and Equity: ' + formatNumber(json.total_liabilites_equity));
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
