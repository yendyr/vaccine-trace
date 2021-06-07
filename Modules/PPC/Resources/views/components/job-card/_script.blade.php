@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/job-card';
    var tableId = '#job-card-table';
    var inputFormId = '#inputForm';
    var groupColumn = 11;

    $('#job-card-table thead tr').clone(true).appendTo('#job-card-table thead');
    $('#job-card-table thead tr:eq(1) th').each( function (i) {
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
        // dom: "<'toolbar'>frtip",
        columnDefs: [{
            visible: false, 
            targets: groupColumn }
        ],
        order: [[ groupColumn, 'asc' ]],
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last = null;

            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group" style="text-align: left;"><td colspan="14">Repeat Interval: <b>' + group + '</b></td></tr>'
                    );
                    last = group;
                }
            });
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
            url: "{{ route('ppc.job-card.index') }}",
        },
        columns: [
            { title: 'Job Card Number', data: 'jobcard_number', name: 'code', defaultContent: '-' },
            { title: 'MPD Number', data: 'mpd_number', name: 'taskcard_json', defaultContent: '-' },
            { title: 'Title', data: 'taskcard.title', name: 'taskcard_json' },
            { title: 'Group', data: 'group_structure', name: 'taskcard_group_json' },
            { title: 'Tag', data: 'tag', name:'tags_json', defaultContent: '-' },
            { title: 'Type', data: 'taskcard.taskcard_type.name', name: 'taskcard_type_json' },
            { title: 'Instruction/Task Total', data: 'instruction_count', name: 'instruction_count', "render": function(data, type, row, meta) {
                    return '<label class="label label-success">' + row.instruction_count + '</label>';
                }
            },
            { title: 'Manhours Total', data: 'manhours_total', name: 'manhours_total', searchable:false, "render": function(data, type, row, meta) {
                    return '<label class="label label-success">' + row.manhours_total + '</label>';
                }
            },
            { title: 'Actual Manhours Total', data: 'actual_manhour', name: 'actual_manhour', searchable:false, "render": function(data, type, row, meta) {
                    return '<label class="label label-success">' + row.actual_manhour + '</label>';
                }
            },
            { title: 'Skill', data: 'skills', name: 'skills'},
            { title: 'Status', data: 'transaction_status_label', name: 'transaction_status' },
            { title: 'Threshold', data: 'threshold_interval', name: 'taskcard_json'},
            { title: 'Repeat', data: 'repeat_interval', name: 'taskcard_json'},
            { title: 'Remark', data: 'description', name: 'description' },
            { title: 'Created At', data: 'created_at', name: 'created_at', searchable:false },
            { title: 'Action', data: 'action', name: 'Action', orderable: false, searchable:false },
        ]
    });

    var workOrderSelect = $('.work_order_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Choose Work Order',
        allowClear: true,
        ajax: {
            url: "{{ route('ppc.work-order.select2') }}",
            dataType: 'json',
        }
    });

    workOrderSelect.on('change', function(event) {
        var work_order_id = $(this).val();
        var reloadUrl = "{{ route('ppc.job-card.index') }}?work_order_id="+work_order_id;
        datatableObject.ajax.url(reloadUrl).load();
    });
});
</script>
@endpush