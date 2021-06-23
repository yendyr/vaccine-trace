@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/accounting/general-ledger';
    var tableId = '#general-ledger-table';
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




    var groupColumn = 0;
    var datatableObject = $(tableId).DataTable({
        // columnDefs: [{
        //     visible: false,
        //     targets: groupColumn }
        // ],
        // drawCallback: function ( settings ) {
        //     var api = this.api();
        //     var rows = api.rows( {page:'current'} ).nodes();
        //     var last=null;

        //     api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
        //         if ( last !== group ) {
        //             $(rows).eq( i ).before(
        //                 '<tr class="group"><td colspan="9" class="text-left">COA Class: <b>' + group + '</b></td></tr>'
        //             );
        //             last = group;
        //         }
        //     });
        // },
        order: [ 3, 'asc' ],
        pageLength: 200,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('accounting.general-ledger.index') }}",
            data: function(d){
                d.start_date = start_date;
                d.end_date = end_date;
            }
        },
        columns: [
            { data: 'type' },
            { data: 'journal.code', defaultContent: '-', orderable: false },
            { data: 'transaction_reference_code', defaultContent: '-', orderable: false },
            { data: 'journal.transaction_date', defaultContent: '-', orderable: false },
            { data: 'debit', orderable: false, class: 'text-right',
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.debit);
                }},
            { data: 'credit', orderable: false, class: 'text-right',
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.credit);
                }},
            { data: 'balance', orderable: false, class: 'text-right',
                "render": function ( data, type, row, meta ) {
                    return formatNumber(row.balance);
                }},
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
});
</script>
@endpush
