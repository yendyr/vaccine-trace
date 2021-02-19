@include('components.toast.script-generate')
@include('components.crud-form.basic-script-submit')

@push('footer-scripts')
<script>
$(document).ready(function () {
    // ----------------- BINDING FORNT-END INPUT SCRIPT ------------- //
    var actionUrl = '/ppc/maintenance-program-detail';
    var tableId = '#taskcard-table';
    var tableId2 = '#maintenance-program-table';
    var inputFormId = '#inputForm';
    var useButtonClass = '.useBtn';
    var saveButtonModalTextId = '#saveButtonModalText';
    // ----------------- END BINDING FORNT-END INPUT SCRIPT ------------- //



    var datatableObject = $(tableId).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/taskcard/?aircraft_type_id=" + "{{ $MaintenanceProgram->aircraft_type->id }}" + "&create_maintenance_program=true",
        },
        columns: [
            { data: 'mpd_number', 
                    "render": function ( data, type, row, meta ) {
                    return '<a target="_blank" href="/ppc/taskcard/' + row.id + '">' + row.mpd_number + '</a>'; }},
            { data: 'title', name: 'Title' },
            { data: 'group_structure', name: 'Group' },
            { data: 'taskcard_type.name', name: 'Task Type' },
            { data: 'instruction_count', name: 'Instruction/Task Total' },
            { data: 'manhours_total', name: 'Manhours Total' },
            { data: 'aircraft_type_name', name: 'Aircraft Type' },
            { data: 'skills', name: 'Skill' },
            { data: 'created_at', name: 'Created At' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });

    var datatableObject2 = $(tableId2).DataTable({
        pageLength: 25,
        processing: true,
        serverSide: false,
        searchDelay: 1500,
        ajax: {
            url: "/ppc/maintenance-program-detail/?maintenance_program_id=" + "{{ $MaintenanceProgram->id }}",
        },
        columns: [
            { data: 'taskcard.mpd_number', 
                    "render": function ( data, type, row, meta ) {
                    return '<a target="_blank" href="/ppc/taskcard/' + row.id + '">' + row.taskcard.mpd_number + '</a>'; }},
            { data: 'taskcard.title', name: 'Title' },
            { data: 'group_structure', name: 'Group' },
            { data: 'taskcard.taskcard_type.name', name: 'Task Type' },
            { data: 'instruction_count', name: 'Instruction/Task Total' },
            { data: 'manhours_total', name: 'Manhours Total' },
            { data: 'description', name: 'Remark' },
            { data: 'skills', name: 'Skill' },
            { data: 'created_at', name: 'Created At' },
            { data: 'action', name: 'Action', orderable: false },
        ]
    });

    


    



    // ----------------- "EDIT" BUTTON SCRIPT ------------- //
    $(useButtonClass).click(function (e) {
        $(useModalTitleId).html("Edit Aircraft Configuration");
        
        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'patch'
        }).prependTo(inputFormId);

        var id = $(this).data('id');
        $(inputFormId).attr('action', actionUrl + '/' + id);

        $(saveButtonId).val("edit");
        $('[class^="invalid-feedback-"]').html('');  // clearing validation
        $(inputModalId).modal('show');
    });
    // ----------------- END "EDIT" BUTTON SCRIPT ------------- //







    // ----------------- "USE" BUTTON SCRIPT ------------- //
    datatableObject.on('click', useButtonClass, function () {
        $('#modalTitle').html("Use Task Card");
        $(inputFormId).trigger("reset"); 

        rowId= $(this).val();
        let tr = $(this).closest('tr');
        let data = datatableObject.row(tr).data();
        $(inputFormId).attr('action', actionUrl);

        $('<input>').attr({
            type: 'hidden',
            name: '_method',
            value: 'post'
        }).prependTo(inputFormId);

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
            beforeSend:function(){
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'start' );
                $('[class^="invalid-feedback-"]').html('');
                $('#saveBtn').prop('disabled', true);
            },
            error: function(data){
                let errors = data.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (index, value) {
                        $('div.invalid-feedback-'+index).html(value);
                    })
                }
            },
            success: function (data) {
                if (data.success) {
                    generateToast ('success', data.success);                            
                }
                $('#inputModal').modal('hide');
                // $(targetTableId).DataTable().ajax.reload();
            },
            complete: function () {
                let l = $( '.ladda-button-submit' ).ladda();
                l.ladda( 'stop' );
                $('#saveBtn'). prop('disabled', false);
            }
        }); 
    });
});
</script>
@endpush