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

    // var groupColumn = 0;

    var datatableObject = $(tableId).DataTable({
        // dom: 'Bfrtip',
        // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        orderCellsTop: true,
        // columnDefs: [{
        //     visible: false,
        //     targets: groupColumn }
        // ],
        // order: [[ groupColumn, 'asc' ]],
        // drawCallback: function ( settings ) {
        //     var api = this.api();
        //     var rows = api.rows( {page:'current'} ).nodes();
        //     var last=null;

        //     api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
        //         if ( last !== group ) {
        //             $(rows).eq( i ).before(
        //                 '<tr class="group" style="text-align: left;"><td colspan="14">Warehouse Location: <b>' + group + '</b></td></tr>'
        //             );
        //             last = group;
        //         }
        //     });
        // },
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
            // { data: 'uuid', visible: false },
            { data: 'code', defaultContent: '-' },
            { data: 'name', defaultContent: '-' },
            { data: 'beginning_debit',
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.beginning_debit);
                }},
            { data: 'beginning_credit',
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.beginning_credit);
                }},
            { data: 'in_period_debit',
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.in_period_debit);
                }},
            { data: 'in_period_credit',
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.in_period_credit);
                }},
            { data: 'ending_debit',
                "render": function ( data, type, row, meta ) {
                    return '<strong>' + formatNumber((row.beginning_debit + row.in_period_debit)) + '</strong>';
                }},
            { data: 'ending_credit',
                "render": function ( data, type, row, meta ) {
                    return '<strong>' + formatNumber((row.beginning_credit + row.in_period_credit)) + '</strong>';
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
        return x1 + x2;
    }
});
</script>
@endpush
