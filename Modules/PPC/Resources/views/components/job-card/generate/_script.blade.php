@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var generateActionUrl = '/ppc/work-order';
    var tableId = '#generate-job-card-table';
    var inputFormId = '#inputForm';

    var datatableObject = $(tableId).DataTable({
        // dom: "<'toolbar'>frtip",
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
        },
        pageLength: 50,
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-5x fa-fw text-success"></i>'
        },
        orderCellsTop: true,
        serverSide: true,
        deferRender: true,
        // scrollY: 200,
        scrollCollapse: true,
        scroller: true,
        searchDelay: 1500,
        ajax: {
            url: "{{ route('ppc.job-card.generate') }}",
        },
        columns: [
            { title: 'Work Order Number', data: 'code', name: 'code', defaultContent: '-' },
            { title: 'Title', data: 'name', name: 'name', defaultContent: '-' },
            { title: 'Status', data: 'status', name: 'status', defaultContent: '-' },
            { title: 'Created At', data: 'created_at', name: 'created_at', defaultContent: '-' },
            { title: 'Action', data: 'action', orderable: false },
        ]
    });

    $('#generate-job-card-table tbody').on( 'click', 'tr.group', function () {
        var currentOrder = datatableObject.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            datatableObject.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            datatableObject.order( [ groupColumn, 'asc' ] ).draw();
        }
    });

    generateButtonProcess (datatableObject, tableId, generateActionUrl);
});
</script>
@endpush