@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = "{{route('ppc.work-order.work-package.taskcard.index', ['work_package' => $work_package->id, 'work_order' => $work_order->id])}}";
    var actionUrlUseAll = "{{route('ppc.work-order.work-package.use-all-taskcard', ['work_package' => $work_package->id, 'work_order' => $work_order->id])}}";
    var tableId = '#taskcard-table';
    var tableId2 = '#maintenance-program-table';
    var inputFormId = '#inputForm';
    var useButtonClass = '.useBtn';
    var useButtonAllClass = '.useBtnAll';
    var saveButtonModalTextId = '#saveButtonModalText';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //


    $('#taskcard-table thead tr').clone(true).appendTo('#taskcard-table thead');
    $('#taskcard-table thead tr:eq(1) th').each( function (i) {
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

    var groupColumn = 10;

    var datatableObject = $(tableId).DataTable({
        columnDefs: [{
            visible: false, 
            targets: groupColumn }
        ],
        order: [[ groupColumn, 'asc' ]],
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
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
        orderCellsTop: true,
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-5x fa-fw text-success"></i>'
        },
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/taskcard/?aircraft_type_id=" + "{{ $work_order?->aircraft?->aircraft_type?->id }}" + "&create_maintenance_program=true",
        },
        columns: [
            {   title: 'MPD Number', data: 'mpd_number', 
                    "render": function ( data, type, row, meta ) {
                    return '<a target="_blank" href="/ppc/taskcard/' + row.id + '">' + row.mpd_number + '</a>'; }},
            {   title: 'Title', data: 'title', defaultContent: '-' },
            {   title: 'Group', data: 'group_structure', defaultContent: '-' },
            {   title: 'Tag', data: 'tag', defaultContent: '-' },
            {   title: 'Type', data: 'taskcard_type.name', defaultContent: '-' },
            {   title: 'Instruction/Task Total', data: 'instruction_count',
                    "render": function ( data, type, row, meta ) {
                    return '<label class="label label-success">' + row.instruction_count + '</label>'; } },
            {   title: 'Manhours Total', data: 'manhours_total',
                    "render": function ( data, type, row, meta ) {
                    return '<label class="label label-success">' + row.manhours_total + '</label>'; } },
            {   title: 'Aircraft Type', data: 'aircraft_type_name', defaultContent: '-' },
            {   title: 'Skill', data: 'skills', defaultContent: '-' },
            {   title: 'Threshold', data: 'threshold_interval', defaultContent: '-' },
            {   title: 'Repeat', data: 'repeat_interval', defaultContent: '-' },
            {   title: 'Created At', data: 'created_at', defaultContent: '-' },
            {   title: 'Action', data: 'action', orderable: false,
                "render": function ( data, type, row, meta ) {
                    if("{{ $is_approved ?? 0 }}" == "0") {
                        return data;
                    }else{
                        return '<p class="text-muted font-italic">Already Approved</p>';
                    }
                }
            }
        ]
    });

    $('#taskcard-table tbody').on( 'click', 'tr.group', function () {
        var currentOrder = datatableObject.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            datatableObject.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            datatableObject.order( [ groupColumn, 'asc' ] ).draw();
        }
    });









    $('#maintenance-program-table thead tr').clone(true).appendTo('#maintenance-program-table thead');
    $('#maintenance-program-table thead tr:eq(1) th').each( function (i) {
        if ($(this).text() != 'Action') {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search" class="form-control" />');
    
            $('input', this).on('keypress', function (e) {
                if(e.which == 13) {
                    if (datatableObject2.column(i).search() !== this.value) {
                        datatableObject2
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

    var groupColumn2 = 9;

    var datatableObject2 = $(tableId2).DataTable({
        columnDefs: [{
            visible: false, 
            targets: groupColumn2 }
        ],
        order: [[ groupColumn2, 'asc' ]],
        drawCallback: function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn2, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
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
            url: "/ppc/work-order/{{$work_order->id}}/work-package/{{$work_package->id}}/taskcard",
        },
        columns: [
            {   title: 'MPD Number', data: 'taskcard_number', name: 'taskcard.mpd_number',},
            {   title: 'Title', data: 'taskcard.title', name: 'Title' },
            {   title: 'Group', data: 'group_structure', name: 'Group' },
            {   title: 'Tag', data: 'tag', defaultContent: '-' },
            {   title: 'Type', data: 'taskcard.taskcard_type.name', name: 'Task Type' },
            {   title: 'Instruction/Task Total', data: 'instruction_count',
                    "render": function ( data, type, row, meta ) {
                    return '<label class="label label-success">' + row.instruction_count + '</label>'; } },
            {   title: 'Manhours Total', data: 'manhours_total',
                    "render": function ( data, type, row, meta ) {
                    return '<label class="label label-success">' + row.manhours_total + '</label>'; } },
            {   title: 'Skill', data: 'skills', name: 'Skill' },
            {   title: 'Threshold', data: 'threshold_interval', name: 'Threshold' },
            {   title: 'Repeat', data: 'repeat_interval', name: 'Repeat' },
            {   title: 'Remark', data: 'description', name: 'Remark' },
            {   title: 'Created At', data: 'created_at', name: 'Created At' },
            {   title: 'Action', data: 'action', name: 'Action', orderable: false },
        ]
    });

    


    



    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    datatableObject2.on('click', '.editBtn', function () {
        $('#modalTitle').html("Edit Remark");
        $(inputFormId).trigger("reset");

        $("input[value='post']").remove();   

        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject2.row(tr).data();
        $(inputFormId).attr('action', actionUrl + '/' + data.id);

        if( $("input[name=_method]").length == 0 ){
            $('<input>').attr({
                type: 'hidden',
                name: '_method',
                value: 'patch'
            }).prependTo(inputFormId);
        } else {
            $("input[name=_method]").val('patch');
        }

        // $('#code').val(data.code);
        // $('#name').val(data.name);
        $('#taskcard_info').html(data.taskcard.mpd_number + ' | ' + data.taskcard.title + ' | ' + data.group_structure + ' | ' + data.taskcard.taskcard_type.name);
        $('#description').val(data.description);

        $('#saveBtn').val("edit");
        $(saveButtonModalTextId).html("Save Changes");
        $('#inputModal').modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //









    // ----------------- "USE" BUTTON SCRIPT ------------- //
    datatableObject.on('click', useButtonClass, function () {
        $('#modalTitle').html("Use Task Card");

        $("input[value='patch']").remove();
        $(inputFormId).trigger("reset"); 

        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
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

        // $('#code').val(data.code);
        // $('#name').val(data.name);
        $('#taskcard_info').html(data.mpd_number + ' | ' + data.title + ' | ' + data.group_structure + ' | ' + data.taskcard_type.name);
        $('#description').val('');
        $('#taskcard_id').val(data.id);

        $('#saveBtn').val("use");
        $(saveButtonModalTextId).html("Use this Task Card");
        $('#inputModal').modal('show');
    });
    // ----------------- END "USE" BUTTON SCRIPT ------------- //


    // ----------------- "USE ALL" BUTTON SCRIPT ------------- //
    $(useButtonAllClass).on('click', function () {
        $('#modalTitle').html("Use Task All Card");

        $("input[value='patch']").remove();
        $(inputFormId).trigger("reset"); 

        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
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

        $('#description').val('');

        $('#saveBtn').val("use");
        $(saveButtonModalTextId).html("Use All Task Card");
        $('#inputModal').modal('show');
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
                $('#inputModal').modal('hide');
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

    function numberAnimation(dom, value) {
        $('.'+dom).animate({
            Counter: $(this).text()
        }, {
            duration: 1000,
            easing: 'swing',
            step: function (now) {
                $(this).text(value);
            }
        });
    }

    deleteButtonProcess (datatableObject2, tableId2, actionUrl);
});
</script>
@endpush