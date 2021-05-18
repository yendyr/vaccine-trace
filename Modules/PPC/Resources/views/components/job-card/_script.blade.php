@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    var actionUrl = '/ppc/job-card';
    var tableId = '#job-card-table';
    var inputFormId = '#inputForm';

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
            url: "{{ route('ppc.job-card.index') }}",
        },
        columns: [
            { title: 'Job Card Number', data: 'jobcard_number', name: 'code', defaultContent: '-' },
            { title: 'MPD Number', data: 'mpd_number', name: 'taskcard_json', defaultContent: '-' },
            { title: 'Title', data: 'taskcard.title', name: 'Title' },
            { title: 'Group', data: 'group_structure', name: 'Group' },
            { title: 'Tag', data: 'tag', defaultContent: '-' },
            { title: 'Type', data: 'taskcard.taskcard_type.name', name: 'Task Type' },
            { title: 'Instruction/Task Total', data: 'instruction_count', "render": function(data, type, row, meta) {
                    return '<label class="label label-success">' + row.instruction_count + '</label>';
                }
            },
            { title: 'Manhours Total', data: 'manhours_total', "render": function(data, type, row, meta) {
                    return '<label class="label label-success">' + row.manhours_total + '</label>';
                }
            },
            { title: 'Actual Manhours Total', data: 'manhours_total', "render": function(data, type, row, meta) {
                    return '<label class="label label-success">' + row.manhours_total + '</label>';
                }
            },
            { title: 'Skill', data: 'skills', name: 'Skill' },
            { title: 'Threshold', data: 'threshold_interval', name: 'Threshold' },
            { title: 'Repeat', data: 'repeat_interval', name: 'Repeat' },
            { title: 'Remark', data: 'description', name: 'Remark' },
            { title: 'Created At', data: 'created_at', name: 'Created At' },
            { title: 'Action', data: 'action', name: 'Action', orderable: false },
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