@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
    $(document).ready(function() {
        // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
        var actionUrl = "{{route('ppc.work-order.work-package.taskcard.index', ['work_package' => $work_package->id, 'work_order' => $work_order->id])}}";
        var actionUrlUseAll = "{{route('ppc.work-order.work-package.aircraft-maintenance-program.use-all-taskcard', ['work_package' => $work_package->id, 'work_order' => $work_order->id])}}";
        var tableId2 = '#aircraft-maintenance-program-table';
        var inputFormId = '#inputUseAllForm';
        var useButtonClass = '.useBtn';
        var useButtonAllClass = '.useBtnAllMaintenanceProgram';
        var saveButtonModalTextId = '#saveButtonModalText';
        var modalId = '#inputUseAllMaintenanceProgramModal';
        // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //

        $('#aircraft-maintenance-program-table thead tr').clone(true).appendTo('#aircraft-maintenance-program-table thead');
        $('#aircraft-maintenance-program-table thead tr:eq(1) th').each(function(i) {
            if ($(this).text() != 'Action') {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search" class="form-control" />');

                $('input', this).on('keypress', function(e) {
                    if (e.which == 13) {
                        if (datatableObject2.column(i).search() !== this.value) {
                            datatableObject2
                                .column(i)
                                .search(this.value)
                                .draw();
                        }
                    }
                });
            } else {
                $(this).html('&nbsp;');
            }
        });

        var groupColumn2 = 9;

        var datatableObject2 = $(tableId2).DataTable({
            columnDefs: [{
                visible: false,
                targets: groupColumn2
            }],
            order: [
                [groupColumn2, 'asc']
            ],
            drawCallback: function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(groupColumn2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group" style="text-align: left;"><td colspan="13">Repeat Interval: <b>' + group + '</b></td></tr>'
                        );
                        last = group;
                    }
                });
            },
            pageLength: 50,
            orderCellsTop: true,
            processing: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-5x fa-fw text-success"></i>'
            },
            serverSide: false,
            searchDelay: 1500,
            ajax: {
                url: "/ppc/work-order/{{$work_order->id}}/aircraft-maintenance-program",
            },
            columns: [{
                    title: 'MPD Number',
                    data: 'taskcard.mpd_number',
                    "render": function(data, type, row, meta) {
                        return '<a target="_blank" href="/ppc/taskcard/' + row.id + '">' + row.taskcard.mpd_number + '</a>';
                    }
                },
                {
                    title: 'Title',
                    data: 'taskcard.title',
                    name: 'Title'
                },
                {
                    title: 'Group',
                    data: 'group_structure',
                    name: 'Group'
                },
                {
                    title: 'Tag',
                    data: 'tag',
                    defaultContent: '-'
                },
                {
                    title: 'Type',
                    data: 'taskcard.taskcard_type.name',
                    name: 'Task Type'
                },
                {
                    title: 'Instruction/Task Total',
                    data: 'instruction_count',
                    "render": function(data, type, row, meta) {
                        return '<label class="label label-success">' + row.instruction_count + '</label>';
                    }
                },
                {
                    title: 'Manhours Total',
                    data: 'manhours_total',
                    "render": function(data, type, row, meta) {
                        return '<label class="label label-success">' + row.manhours_total + '</label>';
                    }
                },
                {
                    title: 'Skill',
                    data: 'skills',
                    name: 'Skill'
                },
                {
                    title: 'Threshold',
                    data: 'threshold_interval',
                    name: 'Threshold'
                },
                {
                    title: 'Repeat',
                    data: 'repeat_interval',
                    name: 'Repeat'
                },
                {
                    title: 'Remark',
                    data: 'description',
                    name: 'Remark'
                },
                {
                    title: 'Created At',
                    data: 'created_at',
                    name: 'Created At'
                },
                {
                    title: 'Action',
                    data: 'action',
                    name: 'Action',
                    orderable: false
                },
            ]
        });


        // ----------------- "USE" BUTTON SCRIPT ------------- //
        datatableObject2.on('click', useButtonClass, function() {
            $('#modalTitle').html("Use Task Card");

            $("input[value='patch']").remove();
            $(inputFormId).trigger("reset");

            rowId = $(this).val();
            let tr = $(this).closest('tr');
            let data = datatableObject2.row(tr).data();
            $(inputFormId).attr('action', actionUrl);

            if( $("input[name=_method]").length == 0 ){
                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'post'
                }).prependTo(inputFormId);
            } else {
                $("input[name=_method]").val('post');
            } 

            $('#taskcard_info').html(data.taskcard.mpd_number + ' | ' + data.taskcard.title + ' | ' + data.group_structure + ' | ' + data.taskcard.taskcard_type.name);
            $('#description').val('');
            $('#taskcard_id').val(data.taskcard_id);

            $('#saveBtn').val("use");
            $(saveButtonModalTextId).html("Use this Task Card");
            $('#inputModal').modal('show');
        });
        // ----------------- END "USE" BUTTON SCRIPT ------------- //




        // ----------------- "USE ALL" BUTTON SCRIPT ------------- //
        $(useButtonAllClass).on('click', function() {
            $('#modalUseAllMaintenanceProgramTitle').html("Use Task All Card");

            $("input[value='patch']").remove();
            $(inputFormId).trigger("reset");

            $(inputFormId).attr('action', actionUrlUseAll);

            if( $("input[name=_method]").length == 0 ){
                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'post'
                }).prependTo(inputFormId);
            } else {
                $("input[name=_method]").val('post');
            } 

            $('#saveBtn').val("use");
            $(saveButtonModalTextId).html("Use All Task Card");
            $(modalId).modal('show');
        });
        // ----------------- END "USE ALL" BUTTON SCRIPT ------------- //




    // ----------------- "SUBMIT" BUTTON SCRIPT ------------- //
    $(inputFormId).on('submit', function (event) {
        event.preventDefault();
        let url_action = $(inputFormId).attr('action');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content")
            },
            url: url_action,
            method: "POST",
            data: $(inputFormId).serialize(),
            dataType: 'json',
            beforeSend: function() {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'start' );
                $('[class^="invalid-feedback-"]').html('');
                $('#saveBtn').prop('disabled', true);
            },
            error: function(data) {
                if (data.error) {
                    generateToast ('error', data.error);
                }
            },
            success: function (data) {
                $(modalId).modal('hide');
                if (data.success) {
                    generateToast ('success', data.success);  
                    $(tableId2).DataTable().ajax.reload();       
                    if(data.total_manhours) {
                        numberAnimation('total_manhours', data.total_manhours);                  
                        numberAnimation('total_manhours_with_performance_factor', data.total_manhours_with_performance_factor);    
                    }
                }
                else if (data.error) {
                    swal.fire({
                        titleText: "Action Failed",
                        text: data.error,
                        icon: "error",
                    }); 
                }
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $('#saveBtn'). prop('disabled', false);
            }
        }); 
    });
    // ----------------- END "SUBMIT" BUTTON SCRIPT ------------- //

        // ----------------- "SUBMIT" BUTTON SCRIPT ------------- //
        $(inputFormId).on('submit', function(event) {
            event.preventDefault();
            let url_action = $(inputFormId).attr('action');
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content")
                },
                url: url_action,
                method: "POST",
                data: $(inputFormId).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    let l = $('.ladda-button-submit').ladda();
                    l.ladda('start');
                    $('[class^="invalid-feedback-"]').html('');
                    $('#saveBtn').prop('disabled', true);
                },
                error: function(data) {
                    if (data.error) {
                        generateToast('error', data.error);
                    }
                },
                success: function(data) {
                    $('#inputModal').modal('hide');
                    if (data.success) {
                        generateToast('success', data.success);
                        $(tableId2).DataTable().ajax.reload();
                    } else if (data.error) {
                        swal.fire({
                            titleText: "Action Failed",
                            text: data.error,
                            icon: "error",
                        });
                    }
                },
                complete: function() {
                    let l = $('.ladda-button-submit').ladda();
                    l.ladda('stop');
                    $('#saveBtn').prop('disabled', false);
                }
            });
        });
        // ----------------- END "SUBMIT" BUTTON SCRIPT ------------- //
    });
</script>
@endpush